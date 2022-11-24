/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery','mooPhrase','qtip'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooTooltip = factory();
    }
}(this, function ($,mooPhrase) {
         
    var validateUser = function(){
        if (typeof(mooViewer) == 'undefined'){
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: mooPhrase.__('please_login')
            }).showModal();
            return false;
        }
        else if (mooCore['setting.require_email_validation'] && !mooViewer['is_confirmed']){
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                model: 'modal',
                title: mooPhrase.__('confirm_email_warning'),
                contents: mooPhrase.__('please_confirm_your_email')
            }).showModal();
            return false;
        }
        else if (mooCore['setting.approve_users'] && !mooViewer['is_approved']){
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: mooPhrase.__('your_account_is_pending_approval')
            }).showModal();
            return false;
        }

        var result = {status:true,message:''};

        $('body').trigger('validateUser',[result]);

        if (!result.status)
        {
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: result.message
            }).showModal();
            return false;
        }

        return true;
    };

     var init = function(){
      if ($('#page_share-ajax_share').length == 0 && mooConfig.profile_popup == 1 && !mooConfig.isMobile) {
    	  $('.qtip').qtip('hide');
          if(!mooConfig.rtl) {
            $('.moocore_tooltip_link').qtip({
                content: {
                    text: function(event, api) {
                       var data1 = $(this).data();
                       $.post(mooConfig.url.base + '/users/ajax_load_tooltip',{item_id: data1.item_id, item_type : data1.item_type}, function(data) {
                                api.set('content.text', data);
                                if ($('.response_friend_request').length) {
                                    $('.response_friend_request').unbind('click');
                                    $('.response_friend_request').on('click', function(){
                                        $( ".response_request" ).show();
                                    });
                                }
                                if ($('.respondRequest').length) {
                                    $('.respondRequest').unbind('click');
                                        $('.respondRequest').on('click', function(){
                                        if (!validateUser()){
                                            api.hide();
                                            return false;
                                        }
                                        var data = $(this).data();
                                        $.post(mooConfig.url.base + '/friends/ajax_respond', {id: data.id, status: data.status}, function(response){
                                            location.reload();
                                        });
                                    });
                                }
                                $('.usertip_action_follow').unbind('click');
                                $('.usertip_action_follow').click(function() {
                                    if (!validateUser()){
                                        api.hide();
                                        return false;
                                    }
                                    element = $(this);
                                    $.ajax({
                                        type: 'POST',
                                        url: mooConfig.url.base + '/follows/ajax_update_follow',
                                        data: {user_id: $(this).data('uid')},
                                        success: function (data) {
                                            $('.core_user_follow[data-uid='+ element.data('uid') +']').each(function () {
                                                if ($(this).data('follow')) {
                                                    $(this).data('follow',0);
                                                    $(this).attr('data-follow', 0);
                                                    $(this).find('.btn-text').html(mooPhrase.__('text_follow'));
                                                    $(this).find('.btn-icon').html('rss_feed');
                                                    $(this).find('.btn-icon').removeClass('moo-icon-check');
                                                    $(this).find('.btn-icon').addClass('moo-icon-rss_feed');
                                                }
                                                else {
                                                    $(this).data('follow',1);
                                                    $(this).attr('data-follow', 1);
                                                    $(this).find('.btn-text').html(mooPhrase.__('text_unfollow'));
                                                    $(this).find('.btn-icon').html('check');
                                                    $(this).find('.btn-icon').removeClass('moo-icon-rss_feed');
                                                    $(this).find('.btn-icon').addClass('moo-icon-check');
                                                }
                                            });
                                            /*if (element.data('follow')) {
                                                element.data('follow', 0);
                                                element.find('.btn-text').html(mooPhrase.__('text_follow'));
                                                element.find('.btn-icon').html('rss_feed');
                                                element.find('.btn-icon').removeClass('moo-icon-check');
                                                element.find('.btn-icon').addClass('moo-icon-rss_feed');
                                            }
                                            else {
                                                element.data('follow', 1);
                                                element.find('.btn-text').html(mooPhrase.__('text_unfollow'));
                                                element.find('.btn-icon').html('check');
                                                element.find('.btn-icon').removeClass('moo-icon-rss_feed');
                                                element.find('.btn-icon').addClass('moo-icon-check');
                                            }*/
                                        }
                                    });
                                });
                        });

                        return mooPhrase.__('loading');
                    }
                },
                hide: {
                    fixed: true,
                    delay: 50,
                    event: 'mouseleave click'
                },
                position: {
                    target: 'event', // Use the triggering element as the positioning target
                    my: 'top left',
                    at: 'right center',
                    adjust: { y:0, },
                    viewport: $(window)
                },
                style: {
                    // classes: 'websnapr qtip-blue'
                    classes: 'qtip-social'
                }
            });
          }
          else {
            $('.moocore_tooltip_link').qtip({
                content: {
                    text: function(event, api) {
                       var data1 = $(this).data();
                       $.post(mooConfig.url.base + '/users/ajax_load_tooltip',{item_id: data1.item_id, item_type : data1.item_type}, function(data) {
                                api.set('content.text', data);
                                if ($('.response_friend_request').length) {
                                    $('.response_friend_request').unbind('click');
                                    $('.response_friend_request').on('click', function(){
                                        $( ".response_request" ).show();
                                    });
                                }
                                if ($('.respondRequest').length) {
                                    $('.respondRequest').unbind('click');
                                        $('.respondRequest').on('click', function(){
                                        if (!validateUser()){
                                            api.hide();
                                            return false;
                                        }
                                        var data = $(this).data();
                                        $.post(mooConfig.url.base + '/friends/ajax_respond', {id: data.id, status: data.status}, function(response){
                                            location.reload();
                                        });
                                    });
                                }

                                $('.usertip_action_follow').unbind('click');
                                $('.usertip_action_follow').click(function() {
                                    if (!validateUser()){
                                        api.hide();
                                        return false;
                                    }
                                    element = $(this);
                                    $.ajax({
                                        type: 'POST',
                                        url: mooConfig.url.base + '/follows/ajax_update_follow',
                                        data: {user_id: $(this).data('uid')},
                                        success: function (data) {
                                            if (element.data('follow')) {
                                                element.data('follow', 0);
                                                element.find('.hidden-xs').html(mooPhrase.__('text_follow'));
                                                element.find('.visible-xs').html('rss_feed');
                                            }
                                            else {
                                                element.data('follow', 1);
                                                element.find('.hidden-xs').html(mooPhrase.__('text_unfollow'));
                                                element.find('.visible-xs').html('check');
                                            }
                                        }
                                    });
                                });
                        });

                        return 'Loading...';
                    }
                },
                hide: {
                    fixed: true,
                    delay: 50,
                    event: 'mouseleave click'
                },
                position: {
                    target: 'event', // Use the triggering element as the positioning target
                    my: 'top right',
                    at: 'left center',
                    adjust: { y:0, },
                    viewport: $(window)
                },
                style: {
                    // classes: 'websnapr qtip-blue'
                    classes: 'qtip-social'
                }
            });
          }
        }
    }
    
    //    exposed public method
    return {
        init:init
    };
}));