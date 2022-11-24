/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooPhrase', 'mooAjax', 'simplemodal'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooAlert = factory();
    }
}(this, function ($, mooPhrase, mooAjax) {
    
    var alert = function(msg){
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('btn_ok'), 
            btn_cancel: mooPhrase.__('cancel'),
            title: mooPhrase.__('message'), 
            hideFooter: false, 
            closeButton: false, 
            model: 'alert', 
            contents: msg
        }).showModal();
    };

    var confirm = function(msg, url){
        // Set title
        $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
        // Set content
        $($('#portlet-config  .modal-body')[0]).html(msg);
        // OK callback
        $('#portlet-config  .modal-footer .ok').click(function(){
            window.location = url;
        });
        $('#portlet-config').modal('show');
    };
    
    // using for confirm popup with ajax request
    var confirmWithCallback = function(msg, url, callback){
        // Set title
        $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
        // Set content
        $($('#portlet-config  .modal-body')[0]).html(msg);
        // OK callback
        $('#portlet-config  .modal-footer .ok').click(function(){
            mooAjax.get({url : url}, callback);
        });
        $('#portlet-config').modal('show');
    }
    
    var confirmSubmitForm = function(msg, form_id){
        $.fn.SimpleModal({
            btn_ok : mooPhrase.__('btn_ok'),
            btn_cancel: mooPhrase.__('cancel'),
            model: 'confirm',
            callback: function(){
                document.getElementById(form_id).submit();
            },
            title: 'Please Confirm',
            contents: msg,
            hideFooter: false,
            closeButton: false
        }).showModal();
    };
    
    return {
        alert : alert,
        confirm : confirm,
        confirmSubmitForm : confirmSubmitForm
    }
    
}));
