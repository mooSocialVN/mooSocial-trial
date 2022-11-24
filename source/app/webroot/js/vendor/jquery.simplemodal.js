( function( factory ) {
    // UMD wrapper
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( [ 'jquery', 'mooPhrase' ], factory );
    } else if ( typeof exports !== 'undefined' ) {
        // Node/CommonJS
        module.exports = factory( require( 'jquery' ) );
    } else {
        // Browser globals
        root.mooSimpleModal = factory();
    }
}( function( $, mooPhrase ) {

    var self = null;

    //Attach this new method to jQuery
    $.fn.extend({
        buttons: null,
        options: null,

        defaults: {
            onAppend:      null,
            offsetTop:     null,
            overlayOpacity:.3,
            overlayColor:  "#000000",
            width:         400,
            draggable:     true,
            keyEsc:        true,
            overlayClick:  false,
            closeButton:   true, // X close button
            hideHeader:    false,
            hideFooter:    true,
            btn_ok:        mooPhrase.__('btn_ok'), // Label
            btn_cancel:    mooPhrase.__('btn_cancel'), // Label
            template:"<div class=\"simple-modal-header modal-header\"><div class=\"title-modal\"> \
                {_TITLE_} \
            </div></div> \
                <div class=\"simple-modal-body modal-body\"> \
                <div class=\"contents\" id=\"simple-modal-body\">{_CONTENTS_}</div> \
            </div> \
                <div class=\"simple-modal-footer modal-footer\"></div>"
        },

        SimpleModal: function(options) {
            self = this;

            this.buttons = [];
            this.options = $.extend({}, self.defaults, options);

            return this;
        },

        /**
         * public method showModal
         * Open Modal
         * @options: param to rewrite
         * @return node HTML
         */
        showModal: function() {
            var node = null;

            // Switch different modal
            switch(this.options.model) {
                case "modal-ajax":
                    node = this._drawWindow(this.options);
                    this._loadContents({
                        "url": self.options.param.url || "",
                        "onRequestComplete": this.options.param.onRequestComplete
                    });
                    break;
                case "confirm":
                    // Add button confirm
                    this.addButton(this.options.btn_ok, "btn btn-modal_save", function() {
                        // in oppose to original version, i'm not catching exceptions
                        // i want to know what's eventually goes wrong
                        self.options.callback();
                        self.hideModal();
                    });
                    // Add button cancel
                    this.addButton(this.options.btn_cancel, "btn btn-modal_close");
                    node = this._drawWindow(this.options);
                    break;
                case "modal":
                    this.addButton(this.options.btn_ok, "btn btn-modal_save", function() {
                        self.hideModal();
                    });
                    node = this._drawWindow(this.options);
                    break;
                case "content":
                    node = this._drawWindow(this.options);
                    break;
                default:
                    // Alert
                    this.addButton(this.options.btn_ok, "btn btn-modal_save");
                    node = this._drawWindow(this.options);
                    break;
            }

            if (node) {

                // Resize Stage
                this._display();
            }
        },

        /**
         * public method hideModal
         * Close model window
         * return
         */
        hideModal: function() {
            self._overlay('hide');
            // close modal bootstrap
            $('.modal-backdrop').remove();
            $('#simpleModal').remove();
        },

        /**
         * private method _drawWindow
         * Rendering window
         * return node SM
         */
        _drawWindow:function(options) {
            // Add Node in DOM
            var node = $("<div>").addClass('simple-modal modal-dialog').attr('id', 'simple-modal');

            // Set Contents
            node.html($("<div>").addClass('modal-content').html(this._template(self.options.template, {"_TITLE_":options.title || "Untitled", "_CONTENTS_":options.contents || ""})));
            node = $("<div>").addClass("modal fade in").attr('id', 'simpleModal').attr('aria-hidden', false).attr('aria-labelledby', 'myModalLabel').attr('role', 'basic').css({'display':'block'}).html(node);

            $('body').append(node);
            $('body').append('<div class="modal-backdrop fade in"></div>');
            // Add all buttons
            this._injectAllButtons();

            // Callback append
            if (this.options.onAppend) {
                this.options.onAppend.call(this);
            }
            return node;
        },

        /**
         * public method addButton
         * Add button to Modal button array
         * require @label:string, @classe:string, @clickEvent:event
         * @return node HTML
         */
        addButton: function(label, classe, clickEvent) {
            var bt = $('<a>').attr({
                "title" : label,
                "class" : classe
            }).click(clickEvent ? function(e) { clickEvent.call(self, e); } : self.hideModal).text(label);

            this.buttons.push(bt);
            return this;
        },

        /**
         * private method _injectAllButtons
         * Inject all buttons in simple-modal-footer
         * @return
         */
        _injectAllButtons: function() {
            var footer = $("#simple-modal").find(".simple-modal-footer");

            $.each(self.buttons, function(i, e) {
                footer.append(e);
            });
        },

        /**
         * private method _addCloseButton
         * Inject Close botton (X button)
         * @return node HTML
         */
        _addCloseButton: function() {
            var b = $("<a>").addClass('close').attr({"href": "#"}).html('<i class="material-icons">clear</i>').click(function(e) {
                self.hideModal();
                return false;
            });
            $("#simple-modal").append(b);
            return b;
        },

        /**
         * private method _overlay
         * Create/Destroy overlay and Modal
         * @return
         */
        _overlay: function(status) {
            switch(status) {
                case 'show':

                    var overlay = $("<div>")
                        .attr("id", "simple-modal-overlay")
                        .css({"background-color": this.options.overlayColor, "opacity": 0});

                    $('body').append(overlay);

                    overlay.animate({opacity: this.options.overlayOpacity});

                    // Behaviour
                    if (this.options.overlayClick) {
                        overlay.click(function(e) { self.hideModal(); });
                    }

                    // Add Control Resize
                    $(window).resize(self._display);
                    $(document).keyup(self._escape);
                    break;

                case 'hide':
                    // Remove Overlay
                    $('#simple-modal-overlay').remove();
                    $('#simple-modal').remove();

                    $(window).unbind('resize', self._display);
                    $(document).unbind('keyup', self._escape);
            }
        },

        _escape: function(e) {
            if (e.keyCode == 27) self.hideModal();
        },

        /**
         * private method _loadContents
         * Async request for modal ajax
         * @return
         */
        _loadContents: function(param) {
            // Set Loading
            $('#simple-modal-body').spin('small');
            // Match image file
            var re = new RegExp( /([^\/\\]+)\.(jpg|png|gif)$/i ), container = $('#simple-modal');
            if (param.url.match(re)) {
                // Hide Header/Footer
                container.addClass("hide-footer");
                // Remove All Event on Overlay
                $("#simple-modal-overlay").unbind(); // Prevent Abort
                // Immagine
                var image = $('<img>').attr('src', param.url)
                    .load(function() {
                        var content = container.find(".contents").empty().append($(this).css('opacity', 0));
                        var dw = container.width() - content.width(), dh = container.height() - content.height();
                        var width = $(this).width()+dw, height  = $(this).height()+dh;

                        container.animate({
                            width: width,
                            height: height,
                            left: ($(window).width() - width)/2,
                            top: ($(window).height() - height)/2
                        }, 200, function() {
                            image.animate({opacity: 1});
                        });
                    });
            } else {
                $('#simple-modal .contents').load(param.url, function(responseText, textStatus, XMLHttpRequest) {
                    var container = $('#simple-modal');
                    if (textStatus !== 'success') {
                        container.find(".contents").html("loading failed");

                        if (param.onRequestFailure) {
                            param.onRequestFailure();
                        }
                    }
                    else
                    {
                        if (param.onRequestComplete) {
                            param.onRequestComplete();
                        }
                        self._display();
                    }
                });
            }
        },

        /**
         * private method _display
         * Move interface
         * @return
         */
        _display: function() {
            // Update overlay
            $("#simple-modal-overlay").css({width: $(window).width(), height: $(window).height()});

            // Update position popup
            var modal = $("#simple-modal"), top = self.options.offsetTop || ($(window).height() - modal.height())/2;
        },

        /**
         * private method _template
         * simple template by Thomas Fuchs
         * @return
         */
        _template:function(s,d) {
            for(var p in d) {
                s=s.replace(new RegExp('{'+p+'}','g'), d[p]);
            }
            return s;
        }
    });

}));
