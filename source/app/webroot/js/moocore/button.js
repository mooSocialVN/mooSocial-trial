/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooButton = factory();
    }
}(this, function ($) {
    
    var tmp_class;
    var disableButton = function(button){
        tmp_class = $("#" + button + " i").attr("class");
        $("#" + button + " i").attr("class", "icon-refresh icon-spin");
        $("#" + button).addClass('disabled');
    };

    var enableButton = function(button){
        $("#" + button + " i").attr("class", tmp_class);
        $("#" + button).removeClass('disabled');
    };
    
    return {
        disableButton : disableButton,
        enableButton : enableButton
    }
    
}));
