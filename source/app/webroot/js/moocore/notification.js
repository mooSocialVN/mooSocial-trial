/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooAjax', 'mooAlert', 'mooButton', 'mooPhrase','mooBehavior', 'mooUser', 'tinycon', 'slimScroll', 'spinner'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooNotification = factory();
    }
}(this, function ($, mooAjax, mooAlert, mooButton, mooPhrase,mooBehavior, mooUser) {
    var url = {};
    var active = true;
    var interval = 10000; // seconds

    var initLoadNotification = function() {
        if ($('#notificationDropdown')) {
            $('#notificationDropdown').unbind('click');
            $('#notificationDropdown').click(function() {
                var show_notification_url = url.show_notification;
                if (typeof(show_notification_url) != 'undefined'){
                    //$(this).next('ul:first').spin('tiny');
                    var ele_spin = $(this).find('.spin');
                    ele_spin.spin({ lines: 10, length: 5, width: 4, radius: 8 });

                    mooAjax.get({
                        url : show_notification_url,
                    }, function(data){
                        ele_spin.spin(false);
                        $('#notifications_list').html(data);
                        //$('#notificationDropdown').next('ul:first').spin(false);
                        $('.initSlimScroll').slimScroll({ height: '500px' });
                        //binding hover delete icon
                        /*$("#notifications_list li").hover(
                            function () {
                                $(this).contents().find('.delete-icon').show();
                            },
                            function () {
                                $(this).contents().find('.delete-icon').hide();
                            }
                        );*/
                    });
                    
                }
            });
        }

        if ($('#conversationDropdown')) {
            $('#conversationDropdown').unbind('click');
            $('#conversationDropdown').click(function() {
                var show_conversation_url = url.show_conversation;
                //$(this).next('ul:first').spin('tiny');
                var ele_spin = $(this).find('.spin');
                ele_spin.spin({ lines: 10, length: 5, width: 4, radius: 8 });
                
                mooAjax.get({
                    url : show_conversation_url,
                }, function(data){
                    ele_spin.spin(false);
                    $('#conversation_list').html(data);
                    //$('#conversationDropdown').next('ul:first').spin(false);
                    $('.initSlimScroll').slimScroll({ height: '500px' });
                    //$(window).scrollTop(0);
                });
                
            });
        }
    }

    var initRefreshNotification = function(){
        var refresh_notification_url = url.refresh_notification_url;
        if (typeof(refresh_notification_url) != 'undefined'){
            window.setInterval(function(){
                $.getJSON(refresh_notification_url, function(data) {
                    // update notification count for sidebar menu
                    if ($('#notification_count')){
                        $('#notification_count').html(data.notification_count);
                    }

                    // update notification count for topbar menu
                    if (parseInt(data.notification_count) > 0){
                        if($('.notification_count').length > 0)
                        {
                            $('.notification_count').html(data.notification_count);

                        }else{
                            $('#notificationDropdown').append('<span class="notification_count">1</span>');
                        }
                    }else{
                        if($('.notification_count')){
                            $('.notification_count').remove();

                            $(document).find(".notification_item").each(function () {
                                if($(this).find('.unread').length > 0){
                                    NotificationMarkAsRead($(this));
                                }
                            });
                        }
                    }

                    // update conversation count
                    if (parseInt(data.conversation_count) > 0){
                        if($('.conversation_count').length > 0)
                        {
                            $('.conversation_count').html(data.conversation_count);

                        }else{
                            $('#conversationDropdown').append('<span class="conversation_count">1</span>');
                        }
                    }else{
                        if($('.conversation_count')){
                            $('.conversation_count').remove();
                        }
                    }

                }).fail(function() {
                    console.log("Error when calling " + refresh_notification_url)
                });
            }, interval);
        }
    }
    
    // app/View/Notifications/show.ctp
    var initRemoveNotification = function(){
        $('.removeNotification').unbind('click');
        $('.removeNotification').on('click', function(){
            var data = $(this).data();
            removeNotification(data.id);
        });
    }
    
    var removeNotification = function(id){
        if (!mooUser.validateUser())
        {
            return;
        }
        mooAjax.get({
            url : mooConfig.url.base + '/notifications/ajax_remove/'+id,
        }, function(data){

            var ele_noti_status = $($(".notification_item[rel='"+id+"']")[0]).find('.notification_item_status');

            if ( ele_noti_status.hasClass('unread') && $("#notification_count").html() != '0' )
            {
                var noti_count = parseInt($(".notification_count").html()) - 1;

                if(noti_count == 0)
                {
                    $(".notification_count").remove();
                }
                else
                {
                    $(".notification_count").html( noti_count );
                }
                $("#notification_count").html( noti_count );

                //Tinycon.setBubble( noti_count );
            }

            $(".notification_item[rel='"+id+"']").slideUp("slow", function (){
                $(".notification_item[rel='"+id+"']").remove();
            });
            
            $('body').trigger('afterRemoveNotificationCallback',[]);
        });
    };
    
    // app/View/Notifications/ajax_show.ctp
    var initAjaxShow = function(){
        
        /*$("#notifications_list_content li").hover(
            function () {
		$(this).contents().find('.delete-icon').show();
            },
            function () {
		$(this).contents().find('.delete-icon').hide();
            }
	);*/

        // bind action remove notification
        $('.removeNotification').unbind('click');
        $('.removeNotification').click(function(){
            
            var data = $(this).data();
            // remove a notification
            removeNotification(data.id);
        });
        
        // bind action clear all notification
        $('.clearAllNotification').unbind('click');
        $('.clearAllNotification').click(function(){
            clearNotifications();
        });
        
        mooBehavior.initMoreResults();
    }
    
    var clearNotifications = function(){
        if (!mooUser.validateUser())
        {
            return;
        }
        $.get(mooConfig.url.base + '/notifications/ajax_clear');
        $(".notification_list").slideUp();
        $("#new_notifications").fadeOut();
        $("#notification_count").html('0');
        $('.notification_count').html('0');
        Tinycon.setBubble(0);

        $('body').trigger('afterClearNotificationCallback',[]);
        return false;
    }
    
    // app/View/Notifications/stop.ctp
    var initNotification = function(){
        $('#notificationButton').unbind('click');
        $('#notificationButton').click(function () {
            var item_type = $('#item_type').val();
            var item_id = $('#item_id').val();
            
            mooButton.disableButton('notificationButton');
            
            $('#notificationButton').spin('small');
            
            $.post(mooConfig.url.base + "/notifications/ajax_save", $("#notificationForm").serialize(), function (data) {
                mooButton.enableButton('notificationButton');
                $('#notificationButton').spin(false);
                var json = $.parseJSON(data);

                if (json.result == 1)
                {
                    $(".error-message").hide();
                    if (json.is_stop == 1){
                        $('#stop_notification_' + item_type + item_id).html(mooPhrase.__('turn_on_notifications'));
                    }else{
                        $('#stop_notification_' + item_type + item_id).html(mooPhrase.__('stop_notifications'));
                    }
                    
                    mooAlert.alert(json.message);
                    $('#portlet-config').modal('hide');
                    $('#themeModal').modal('hide');
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
        });
        return false;
    }
    
    // app/View/Notifications/ajax_show.ctp
    // app/View/Notifications/show.ctp
    // app/View/Notifications/stop.ctp
    var init = function(){
        if (active)
        {
            initLoadNotification();
            initRefreshNotification();
        }
    }
    
    var setUrl = function(a){
        url = a;
    }
    
    var setActive = function(a){
        active = a;
    }
    
    var setInterval = function(a){
        // only set new interval when it greater than 0, by default it's 30 seconds
        if (a > 0){
            interval = a * 1000;
        }
    }
    
    var initMarkRead = function(){
        $('.markMsgStatus').unbind('click');
        $('.markMsgStatus').click(function(){
            if (!mooUser.validateUser())
            {
                return;
            }
           var data = $(this).data();
           var obj = $(this);
           mooAjax.post({
                url: mooConfig.url.base + '/notifications/mark_read',
                data: {
                    id : data.id,
                    status : data.status
                }
            }, function (respsonse) {
                obj.data('status',data.status === '1' ? '0' : '1');
                var json = $.parseJSON(respsonse);
                var currentCounter = $('#notification_count').html();
               $(".notification_item[rel='"+data.id+"']").each(function () {
                   if (json.status === '1') {
                       NotificationMarkAsRead($(this));

                       // update counter
                       $('#notification_count').html(parseInt(currentCounter) - 1);

                       if (parseInt(currentCounter) - 1 > 0){
                           if($('.notification_count').length > 0)
                           {
                               $('.notification_count').html(parseInt(currentCounter) - 1);

                           }else{
                               $('#notificationDropdown').append('<span class="notification_count">1</span>');
                           }
                       }else{
                           if($('.notification_count')){
                               $('.notification_count').remove();
                           }
                       }
                   }else {
                       NotificationMarkAsUnRead($(this));

                       // update counter
                       $('#notification_count').html(parseInt(currentCounter) + 1);

                       if($('.notification_count').length > 0)
                       {
                           $('.notification_count').html(parseInt(currentCounter) + 1);

                       }else{
                           $('#notificationDropdown').append('<span class="notification_count">1</span>');
                       }
                   }
               });
            });
        });
        
        // init markAllNotificationAsRead
        $('.markAllNotificationAsRead').unbind('click');
        $('.markAllNotificationAsRead').click(function(){
            if (!mooUser.validateUser())
            {
                return;
            }
            mooAjax.post({
                url: mooConfig.url.base + '/notifications/mark_all_read',
                data: {}
            }, function (respsonse) {
                var json = $.parseJSON(respsonse);
                if (json.success == true){
                    
                    $('.mark_read').hide();
                    $('.mark_unread').show();
                    
                    // remove number for topbar dropdown
                    $('.notification_count').remove();
                    
                    // set count to 0 for home sidebar
                    $("#notification_count").html('0');
                    
                    // notifications items
                    $(document).find(".notification_item").each(function () {
                        if($(this).find('.unread').length > 0){
                            NotificationMarkAsRead($(this));
                        }
                    });
                }
            });
        });
        
        $('.clearAllNotifications').unbind('click');
        $('.clearAllNotifications').click(function(){
            if (!mooUser.validateUser())
            {
                return;
            }
            mooAjax.post({
                url: mooConfig.url.base + '/notifications/clear_all_notifications',
                data: {}
            }, function (data) {                  
                    $('.notification_count').remove();
                    
                    $("#notification_count").html('0');
                    
                    $('#notifications_list').html(data);
                    $('#notificationDropdown').next('ul:first').spin(false);
                    $('.initSlimScroll').slimScroll({ height: '500px' });
            });
        });
    }
    var NotificationMarkAsUnRead = function (_element) {
        _element.find('.notification-group-main').addClass('unread');
        _element.find('.mark_read').hide();
        _element.find('.mark_unread').show();
    };
    var NotificationMarkAsRead = function (_element) {
        _element.find('.unread').removeClass('unread');
        _element.find('.mark_read').hide();
        _element.find('.mark_unread').show();
    };

    var friendAdd = function(){
    	$('.reponse_request').unbind('click');
        $('.reponse_request').click(function(){
            if (!mooUser.validateUser())
            {
                return;
            }
            if( !$(this).hasClass('reponse_request_disable') ){
                $(this).parent().find('.reponse_request').addClass('reponse_request_disable');
                var id = $(this).data('id');
                var status = $(this).data('status');
                var obj = $(this);

                var currentCounter = 0;
                if( $('.notification_count').length > 0 ){
                    currentCounter = $('.notification_count').html();
                }else if($('#notification_count').length > 0){
                    currentCounter = $('#notification_count').html();
                }

                var new_counter = parseInt(currentCounter) - 1;

                if($('#notification_count').length > 0 && new_counter >= 0){
                    $('#notification_count').html(new_counter);
                }

                if (new_counter > 0){
                    if($('.notification_count').length > 0)
                    {
                        $('.notification_count').html(new_counter);
                    }else{
                        $('#notificationDropdown').append('<span class="notification_count">1</span>');
                    }
                }else{
                    if($('.notification_count')){
                        $('.notification_count').remove();
                    }
                }
                mooAjax.post({
                    url: mooConfig.url.base + '/friends/ajax_friend',
                    data: {id:id,status:status}
                }, function (data) {
                    $(".notification_item[rel='"+id+"']").each(function () {
                        $(this).html(data);
                    });
                });
            }
        });
    }

    return{
        init: init,
        setUrl: setUrl,
        setActive: setActive,
        setInterval: setInterval,
        removeNotification : removeNotification,
        initAjaxShow : initAjaxShow,
        initNotification : initNotification,
        initRemoveNotification : initRemoveNotification,
        initMarkRead : initMarkRead,
        friendAdd: friendAdd
    }
}));