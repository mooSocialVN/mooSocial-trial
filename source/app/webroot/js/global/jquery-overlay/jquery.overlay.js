/*!
 * jQuery.textoverlay.js
 *
 * Repository: https://github.com/yuku-t/jquery-textoverlay
 * License:    MIT
 * Author:     Yuku Takahashi, Dang Thanh Nam
 */


(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === "object" && module.exports) {
        var $ = require('jquery');
        module.exports = factory($);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function (jQuery) {
    'use strict';

    /**
     * Get the styles of any element from property names.
     */
    var getStyles = (function () {
        var color;
        color = $('<div></div>').css(['color']).color;
        if (typeof color !== 'undefined') {
            return function ($el, properties) {
                return $el.css(properties);
            };
        } else {  // for jQuery 1.8 or below
            return function ($el, properties) {
                var styles;
                styles = {};
                $.each(properties, function (i, property) {
                    styles[property] = $el.css(property);
                });
                return styles
            };
        }
    })();

    var overlayInstance = {};

    var entityMap = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#x27;',
        '/': '&#x2F;'
    }

    var entityRegexe = /[&<>"'\/]/g

    /**
     * Function for escaping strings to HTML interpolation.
     */
    var escape = function (str) {
        if (typeof str !== 'undefined') {
            return str.replace(entityRegexe, function (match) {
                return entityMap[match];
            })
        }
    };

    /**
     * Determine if the array contains a given value.
     */
    var include = function (array, value) {
        var i, l;
        if (array.indexOf)
            return array.indexOf(value) != -1;
        for (i = 0, l = array.length; i < l; i++) {
            if (array[i] === value)
                return true;
        }
        return false;
    };

    var Overlay = (function () {

        var html, css, textareaToWrapper, textareaToOverlay, allowedProps;

        html = {
            wrapper: '<div class="textoverlay-wrapper"></div>',
            overlay: '<div class="textoverlay"></div>'
        };

        css = {
            wrapper: {
                margin: 0,
                padding: 0,
                overflow: 'hidden'
            },
            overlay: {
                position: 'absolute',
                color: 'transparent',
                'white-space': 'pre-wrap',
                'word-wrap': 'break-word',
                overflow: 'hidden'
            },
            textarea: {
                background: 'transparent',
                position: 'relative',
                outline: 0
            }
        };

        // CSS properties transport from textarea to wrapper
        textareaToWrapper = '';//['height'];//['display'];
        // CSS properties transport from textarea to overlay
        textareaToOverlay = [
            'margin-top',
            'margin-right',
            'margin-bottom',
            'margin-left',
            'padding-top',
            'padding-right',
            'padding-bottom',
            'padding-left',
            'font-family',
            'font-weight',
            'font-size',
            'background-color'
        ];

        function Overlay($textarea) {
            var $wrapper, position;

            // Setup wrapper element
            position = $textarea.css('position');
            if (position === 'static')
                position = 'relative';
            $wrapper = $(html.wrapper).css(
                    $.extend({}, css.wrapper, getStyles($textarea, textareaToWrapper), {
                        position: position
                    })
                    );

            // Setup overlay
            this.textareaTop = parseInt($textarea.css('border-top-width'));
            this.$el = $(html.overlay).css(
                    $.extend({}, css.overlay, getStyles($textarea, textareaToOverlay), {
                        top: this.textareaTop,
                        right: parseInt($textarea.css('border-right-width')),
                        bottom: parseInt($textarea.css('border-bottom-width')),
                        left: parseInt($textarea.css('border-left-width'))
                    })
                    );

            // Setup textarea
            this.$textarea = $textarea.css(css.textarea);

            // Render wrapper and overlay
            this.$textarea.wrap($wrapper).before(this.$el);

            // Intercept val method
            // Note that jQuery.fn.val does not trigger any event.
            this.$textarea.origVal = $textarea.val;
            this.$textarea.val = $.proxy(this.val, this);

            // Bind event handlers
            this.$textarea.on({
                'input.overlay': $.proxy(this.onInput, this),
                'change.overlay': $.proxy(this.onInput, this),
                'scroll.overlay': $.proxy(this.resizeOverlay, this),
                'resize.overlay': $.proxy(this.resizeOverlay, this)
            });

            this.strategies = [];
        }

        $.extend(Overlay.prototype, {
            val: function (value) {
                return value == null ? this.$textarea.origVal() : this.setVal(value);
            },
            setVal: function (value) {
                this.$textarea.origVal(value);
                this.renderTextOnOverlay();
                return this.$textarea;
            },
            onInput: function (e) {
                this.renderTextOnOverlay();
            },
            renderTextOnOverlay: function () {
                var text, i, l, strategy, match, style;
                text = $('<div></div>').text(this.$textarea.val());
                // Apply all strategies
                for (i = 0, l = this.strategies.length; i < l; i++) {
                    strategy = this.strategies[i];
                    match = strategy.match;
                    if ($.isArray(match)) {
                        match = $.map(match, function (str) {
                            return str.replace(/(\(|\)|\|)/g, '\$1');
                        });
                        match = new RegExp('(' + match.join('|') + ')', 'g');
                    }

                    // Style attribute's string
                    style = 'background-color:' + strategy.css['background-color'];

                    text.contents().each(function () {
                        var text, html, str, prevIndex;
                        if (this.nodeType != Node.TEXT_NODE)
                            return;
                        text = this.textContent;
                        html = '';
                        if (!$.isArray(strategy.match) && strategy.match !== null && typeof strategy.match === 'object') {

                            var arr = [];
                            var objLastIndex = [];
                            for (var objKey in match) {
                                if (match.hasOwnProperty(objKey)) {
                                    arr.push(text.substr(match[objKey].start, match[objKey].length));
                                    objLastIndex.push(match[objKey].end);
                                }
                            }
                            if (arr.length > 0) {
                                for (var arrKey in arr) {
                                    if (arr[arrKey].indexOf(')') != -1 || arr[arrKey].indexOf('(') != -1 || arr[arrKey].indexOf('|') != -1)
                                        return;
                                }
                                match = new RegExp('(' + arr.join('|') + ')', 'g');

                                for (prevIndex = match.lastIndex = 0; ; prevIndex = match.lastIndex) {
                                    str = match.exec(text);
                                    if (!str) {
                                        if (prevIndex)
                                            html += escape(text.substr(prevIndex));
                                        break;
                                    }
                                    //truncate overlay text
                                    if (match.lastIndex != 0 && objLastIndex.indexOf(match.lastIndex) == -1) {
                                        //if (prevIndex)
                                        html += escape(text.substr(prevIndex, match.lastIndex - prevIndex));
                                        continue;
                                    }
                                    str = str[0];
                                    html += escape(text.substr(prevIndex, match.lastIndex - prevIndex - str.length));
                                    html += '<span style="' + style + '">' + escape(str) + '</span>';
                                }
                                ;
                                if (prevIndex)
                                    $(this).replaceWith(html);
                            } else {
                                $(this).replaceWith(escape(text));
                            }
                        } else {
                            for (prevIndex = match.lastIndex = 0; ; prevIndex = match.lastIndex) {
                                str = match.exec(text);
                                if (!str) {
                                    if (prevIndex)
                                        html += escape(text.substr(prevIndex));
                                    break;
                                }
                                str = str[0];
                                html += escape(text.substr(prevIndex, match.lastIndex - prevIndex - str.length));
                                html += '<span style="' + style + '">' + escape(str) + '</span>';
                            }
                            ;
                            if (prevIndex)
                                $(this).replaceWith(html);
                        }
                    });
                }
                this.$el.html(text.contents());
                return this;
            },
            resizeOverlay: function () {
                this.$el.css({top: this.textareaTop - this.$textarea.scrollTop()});
            },
            register: function (strategies) {
                strategies = $.isArray(strategies) ? strategies : [strategies];
                this.strategies = this.strategies.concat(strategies);
                return this.renderTextOnOverlay();
            },
            destroy: function () {
                var $wrapper;
                this.$textarea.off('.overlay');
                $wrapper = this.$textarea.parent();
                $wrapper.after(this.$textarea).remove();
                this.$textarea.removeData('overlay');
                this.$textarea = null;
            },
            getStrategy: function () {
                return this.strategies;
            },
            reRegister: function (strategies) {
                strategies = $.isArray(strategies) ? strategies : [strategies];
                this.strategies = this.strategies.concat(strategies);
                //this.renderTextOnOverlay();
            }

        });

        return Overlay;

    })();

    $.fn.overlay = function (strategies) {

        //already have instance
        if (overlayInstance[$(this).attr('id')] !== undefined) {
            return this.each(function () {
                var thisOverlay = overlayInstance[$(this).attr('id')];
                $(this).revokeOverlay(strategies, thisOverlay, true);
                $(this).reRenderTextOnOverlay(thisOverlay);
            });
        }
        var dataKey;
        dataKey = 'overlay';
        if (strategies === 'destroy') {
            return this.each(function () {
                var overlay = $(this).data(dataKey);
                if (overlay) {
                    overlay.destroy();
                }
            });
        }

        return this.each(function () {
            var $this, overlay, revoke = false;
            $this = $(this);
            overlay = $this.data(dataKey);
            if (!overlay) {
                overlay = new Overlay($this);
                overlayInstance[$this.attr('id')] = overlay;
                $this.data(dataKey, overlay);
            }
            overlay.register(strategies);

        });
    };

    $.fn.getInstanceOverlay = function (obj) {
        if (overlayInstance[obj.attr('id')] !== undefined) {
            return overlayInstance[obj.attr('id')];
        } else {
            var overlay = overlayInstance[obj.attr('id')] = new Overlay($(this));
            overlay.register(overlay.getStrategy());
            return overlay;
        }
    };

    $.fn.revokeOverlay = function (strategies, instance, revert) {
        var previousStrategy = instance.getStrategy();
        for (var i = 0, l = previousStrategy.length; i < l; i++) {
            if (typeof revert === "undefined") {
                $.extend(previousStrategy[i], strategies[i]);
            } else {
                $.extend(strategies[i], previousStrategy[i]);

            }
        }
        if (typeof revert === "undefined") {
            instance.strategies = previousStrategy;
        } else {
            instance.strategies = strategies;
        }
        //instance.register(previousStrategy);//will cause multi register
    };
    $.fn.reRenderTextOnOverlay = function (instance) {
        instance.renderTextOnOverlay();
    };

    $.fn.destroyOverlayInstance = function (obj) {
        if (overlayInstance[obj.attr('id')] !== undefined) {
            delete overlayInstance[obj.attr('id')];
        }
    };
}));
