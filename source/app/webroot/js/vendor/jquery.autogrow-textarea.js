// Based off https://code.google.com/p/gaequery/source/browse/trunk/src/static/scripts/jquery.autogrow-textarea.js?r=2
// Modified by David Beck

( function( factory ) {
    // UMD wrapper
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( [ 'jquery' ], factory );
    } else if ( typeof exports !== 'undefined' ) {
        // Node/CommonJS
        module.exports = factory( require( 'jquery' ) );
    } else {
        // Browser globals
        factory( jQuery );
    }
}( function( $ ) {

    jQuery.fn.autogrow = function() {
        return this.each(function() {
            var _this = $(this);

            var createMirror = function(textarea) {
                jQuery(textarea).after('<div class="autogrow-textarea-mirror"></div>');
                return jQuery(textarea).next('.autogrow-textarea-mirror')[0];
            }

            var sendContentToMirror = function (textarea) {
                mirror.innerHTML = String(textarea.value)
                        .replace(/&/g, '&amp;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#39;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/\n/g, '<br />') +
                    '.<br/>.'
                ;

                if (jQuery(textarea).height() != jQuery(mirror).height())
                    jQuery(textarea).height(jQuery(mirror).height());
                
                _this.trigger('afterAutogrowCallback',[{element:_this}]);
            }

            var growTextarea = function () {
                sendContentToMirror(this);
            }

            // Create a mirror
            var mirror = createMirror(this);

            // Style the mirror
            mirror.style.display = 'none';
            mirror.style.wordWrap = 'break-word';
            mirror.style.whiteSpace = 'normal';
            mirror.style.padding = jQuery(this).css('padding');
            mirror.style.width = jQuery(this).css('width');
            mirror.style.fontFamily = jQuery(this).css('font-family');
            mirror.style.fontSize = jQuery(this).css('font-size');
            mirror.style.lineHeight = jQuery(this).css('line-height');

            // Style the textarea
            this.style.overflow = "hidden";
            this.style.minHeight = this.rows+"em";

            // Bind the textarea's event
            this.onkeyup = growTextarea;

            $(this).bind('updateAutoGrow', growTextarea);

            // Fire the event for text already present
            sendContentToMirror(this);

        });
    };
} ) );
