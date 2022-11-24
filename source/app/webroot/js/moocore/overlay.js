/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooPhrase', 'mooTooltip', 'magnificPopup'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooOverlay = factory();
    }
}(this, function ($, mooPhrase, mooTooltip) {
    
    var registerOverlay = function(){
        mooTooltip.init();
        var sModal;
        
        $('.overlay').unbind('click');
        
        $('.overlay').click(function()
        {
            var overlay_title = $(this).attr('title');
            var overlay_url = $(this).attr('href');
            var overlay_div = $(this).attr('rel');

            if (overlay_div)
            {
                sModal = $.fn.SimpleModal({
                    btn_ok : mooPhrase.__('btn_ok'),
                    btn_cancel: mooPhrase.__('btn_cancel'),
                    model: 'modal',
                    title: overlay_title,
                    contents: $('#' + overlay_div).html()
                });
            }
            else
            {
                sModal = $.fn.SimpleModal({
                    width: 600,
                    model: 'modal-ajax',
                    title: overlay_title,
                    offsetTop: 100,
                    param: {
                        url: overlay_url,
                        onRequestComplete: function() {
                            $(".tip").tipsy({ html: true, gravity: 's' });
                        },
                        onRequestFailure: function() { }
                    }
                });
            }

            sModal.showModal();

            return false;
        });
    };

    var registerImageOverlay = function(){
        mooTooltip.init();
        $('.attached-image').magnificPopup({
            type:'image',
            gallery: { enabled: true },
            zoom: {
                enabled: true,
                opener: function(openerElement) {
                    return openerElement;
                }
            }
        });      
    };

    return{
        registerOverlay : registerOverlay,
        registerImageOverlay : registerImageOverlay,
    }
}));
