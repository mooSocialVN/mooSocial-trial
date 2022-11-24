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
        //root.mooPhrase = factory();
        root.mooPhrase = factory(root.jQuery);
    }
}(this, function ($) {
    var mooPhraseVars = {};
    
    // add phrase
    var add = function(name, value){
        mooPhraseVars[name] = value;
    };
    
    // set phrase
    var set = function(obj){
        mooPhraseVars = obj;
    };
    
    // get phrase
    var __ = function(name){
        return mooPhraseVars[name] ;
    };
    //    exposed public methods
    return {
        add:add,
        __:__,
        set:set
    }
}));