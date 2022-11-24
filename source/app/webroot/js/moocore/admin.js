/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooAlert', 'mooPhrase'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooAdmin = factory();
    }
}(this, function ($, mooAlert, mooPhrase) {
    
    var doModeration = function (action, type) {
        switch (action)
        {
            case 'delete':
                $('#deleteForm').attr('action', mooConfig.url.base + '/admin/' + type + '/delete');
                mooAlert.confirmSubmitForm(mooPhrase.__('are_you_sure_you_want_to_delete_these') + ' ' + type + '?', 'deleteForm');
                break;

            case 'move':
                $('#deleteForm').attr('action', mooConfig.url.base + '/admin/' + type + '/move');
                $('#category_id').show();
                break;

            default:
                $('#category_id').hide();
        }
    };

    return {
        doModeration: doModeration
    }
}));
