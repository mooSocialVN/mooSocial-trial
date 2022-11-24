/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery','mooPhrase', 'mooBehavior', 'mooMention', 'mooToggleEmoji', 'mooFileUploader', 'mooUser', 'mooButton', 'mooGlobal',
            'mooResponsive', 'mooAttach', 'mooComment', 'mooLike', 'mooTooltip', 'mooAlert',
            'autogrow', 'spinner', 'mooNiceSelect'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooActivities = factory();
    }
}(this, function ($, mooPhrase, mooBehavior, mooMention, mooToggleEmoji, mooFileUploader, mooUser,
    mooButton, mooGlobal, mooResponsive, mooAttach, mooComment, mooLike, mooTooltip, mooAlert) {
    
    var config = {};
    
    var initRemoveTags = function(){
        $('.removeTags').unbind('click');
        $('.removeTags').click(function(){
            var data = $(this).data();
            removeTags(data.activityId, data.activityItemType);
        });
    }
    
    var removeTags = function(item_id, item_type){
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('confirm'),
            btn_cancel: mooPhrase.__('cancel'),
            callback: function(){
                $.post(mooConfig.url.base + '/activities/ajax_remove_tags', {item_id: item_id, item_type : item_type}, function() {
                    window.location.reload();
                });
            },
            title: mooPhrase.__('remove_tags'),
            contents: mooPhrase.__('remove_tags_contents'),
            model: 'confirm', 
            hideFooter: false, 
            closeButton: false
        }).showModal();
    };
    
    var initShowAllComments = function(){
        $('.showAllComments').unbind('click');
        $('.showAllComments').on('click', function(){
            var data = $(this).data();
            var div_id = 'comments_' + data.id;
            $('#all_comments_' + data.id).hide();

            if(data.page == 1 && $('#'+div_id+' div[id^=comments_reply_]').length){
                $('html, body').animate({
                    scrollTop: $('#'+div_id).offset().top - 150
                }, 900);
            }
            $.post(mooConfig.url.base + "/activities/ajax_browse_comment/"+ data.type +"/" + data.target +"/" + data.id + "/" + data.close + "/" + data.page , function(response){
                if (response != ''){
                    var eleCommentParentLists = $('#' + div_id).find('.comment_parent_lists');

                    if(data.page == 1) {
                        //$('#' + div_id + '>li[id*=comment_]').remove();
                        eleCommentParentLists.empty();
                    }

                    if (mooConfig.comment_sort_style === '1') {
                        //$('#' + div_id).prepend(response);
                        //$('#all_comments_' + data.id).prependTo('#' + div_id);
                        eleCommentParentLists.prepend(response);
                    }
                    else {
                        //$('#' + div_id).append(response);
                        //$('#all_comments_' + data.id).appendTo('#' + div_id);
                        eleCommentParentLists.append(response);
                    }

                    mooTooltip.init();
                    mooBehavior.registerImageComment();

                    //if(($('#' + div_id + '>div[id*=comment_]').length ) <  data.total) {
                    if((eleCommentParentLists.find('.comment-item').length ) <  data.total) {
                        $('#all_comments_' + data.id + ' .showAllComments').data('page', data.page + 1);
                        $('#all_comments_' + data.id).show();
                    }
                }

                $('body').trigger('afterShowAllCommentsCallback',[{data: data}]);
            });
        });
    }
    
    var removeActivity = function(id)
    {
        if (!mooUser.validateUser())
        {
            return;
        }
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('ok'),
            btn_cancel: mooPhrase.__('cancel'),
            callback: function(){
                $.post(mooConfig.url.base + '/activities/ajax_remove', {id: id}, function() {
                    $('#activity_'+id).fadeOut('normal', function() {
                        $('#activity_'+id).remove();

                        //plugin: sticky sidebar
                        $('body').trigger('afterRemoveActivityCallback',[]);
                    });
                });
            },
            title: mooPhrase.__('please_confirm'),
            contents: mooPhrase.__('please_confirm_remove_this_activity'),
            model: 'confirm', 
            hideFooter: false, 
            closeButton: false
        }).showModal();
    };
    
    
    var initEditActivity = function(){
        $('.editActivity').unbind("click");
        $('.editActivity').click(function(){
            var data = $(this).data();
            editActivity(data.activityId);
        });
    }
    
    var initRemoveActivity = function(){
        $('.removeActivity').unbind("click");
        $('.removeActivity').click(function(){
            var data = $(this).data();
            removeActivity(data.activityId);
        });
    }
    
    // app/View/Activities/ajax_load_activity_edit.ctp
    var initOnAjaxLoadActivityEdit = function(){
        
        // init cancel edit activity event
        $('.cancelEditActivity').unbind('click');
        $('.cancelEditActivity').click(function(){
            var data = $(this).data();
            cancelEditActivity(data.activityId);
        });
        
        // init comfirm edit activity event
        $('.confirmEditActivity').unbind('click');
        $('.confirmEditActivity').click(function(){
            var data = $(this).data();
            confirmEditActivity(data.activityId);
        });
    }

    var activity_edit_array = [];
    var editActivity = function(activity_id)
    {
    	if ($('#activity_edit_'+activity_id).length == 0)
        {
            $.post(mooConfig.url.base + '/activities/ajax_loadActivityEdit/'+ activity_id, function(data){
                $('#activity_feed_content_text_'+activity_id + ' .activity_feed_message').hide();
                $(data).insertAfter($('#activity_feed_content_text_'+activity_id + ' .activity_feed_message'));
                activity_edit_array.push(activity_id);
                init();

                
                //user mention
                mooMention.init($(data).find('textarea').attr('id'),'edit_activity');
                
                //user emoji
                //mooToggleEmoji.init($(data).find('textarea').attr('id'), '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');

                //plugin: sticky sidebar
                $('body').trigger('afterLoadFormEditActivityCallback',[{activity_id: activity_id}]);
            });
        }
    };

    var cancelEditActivity = function(activity_id)
    {
        //destroy overlay instance;
        if($('#message_edit_'+activity_id).siblings('.textoverlay')){
            $('#message_edit_'+activity_id).destroyOverlayInstance($('#message_edit_'+activity_id));
        }

        $('#activity_feed_content_text_'+activity_id + ' .activity_feed_message').show();
        $('#activity_edit_'+activity_id).remove();

        var index = $.inArray(activity_id, activity_edit_array);
        activity_edit_array.splice(index, 1);

        //plugin: sticky sidebar
        $('body').trigger('afterCancelFormEditActivityCallback',[]);
    };

    var confirmEditActivity = function(activity_id)
    {
        var beforeEditActivityObj = {emptyContent: false, targetId: "", params:{}};
        $('body').trigger('beforeEditActivityCallback',[beforeEditActivityObj]);
        if ((beforeEditActivityObj.emptyContent === true && parseInt(beforeEditActivityObj.targetId) == activity_id) || $.trim($('#message_edit_'+activity_id).val()) != '')
        {
            var messageVal;
            if($("#message_edit_"+activity_id+"_hidden").length != 0){
                messageVal = $("#message_edit_"+activity_id+'_hidden').val();
            }else{
                messageVal = $("#message_edit_"+activity_id).val()
            }
            
            var params = {message: messageVal};
            if(parseInt(beforeEditActivityObj.targetId) == activity_id && beforeEditActivityObj.params != null){
                $.extend(params, beforeEditActivityObj.params);
            }
            $.post(mooConfig.url.base + '/activities/ajax_editActivity/'+ activity_id,params, function(data){
                //destroy overlay instance;
                if($('#message_edit_'+activity_id).siblings('.textoverlay')){
                    $('#message_edit_'+activity_id).destroyOverlayInstance($('#message_edit_'+activity_id));
                }

                $('#activity_feed_content_text_'+activity_id + ' .activity_feed_message').html($(data).html());
                $('#history_activity_'+activity_id).show();
                cancelEditActivity(activity_id);
                
                $('body').trigger('afterEditActivityCallback',[beforeEditActivityObj]);
            });
        }
    };
    
     
    var removeActivityPhotoComment = function(id)
    {
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('ok'),
            btn_cancel: mooPhrase.__('cancel'),
            callback: function(){
                $.post(mooConfig.url.base + '/comments/ajax_remove', {id: id}, function() {
                    $('#photo_comment_'+id).fadeOut('normal', function() {
                        $('#photo_comment_'+id).remove();
                    });
                });
            },
            title:  mooPhrase.__('please_confirm'),
            contents: mooPhrase.__('please_confirm_remove_this_activity'),
            model: 'confirm', hideFooter: false, closeButton: false
        }).showModal();
    };
    
    var submitComment = function(activity_id)
    {
        if (!mooUser.validateUser())
        {
            return;
        }
    	var beforePostCommentObj = {emptyContent: false, targetId: "", params:{}};
        $('body').trigger('beforePostCommentCallback',[beforePostCommentObj]);
        if ((beforePostCommentObj.emptyContent === true && parseInt(beforePostCommentObj.targetId) == activity_id) || $.trim($("#commentForm_"+activity_id).val()) != '' || $.trim($('#comment_image_'+activity_id).val()) != '' || $.trim($('#userCommentLink'+activity_id).val()) != '' || $.trim($('#userCommentVideo'+activity_id).val()) != '')
        {
            $('#commentButton_' + activity_id + ' a').addClass('disabled');
            $('#commentButton_' + activity_id + ' a').prepend('<i class="icon-refresh icon-spin"></i>');
            var comment = ($("#commentForm_"+activity_id).siblings('input.messageHidden').length > 0) ? $("#commentForm_"+activity_id).siblings('input.messageHidden').val() : $("#commentForm_"+activity_id).val();
            var params = {activity_id: activity_id,thumbnail:$('#comment_image_'+activity_id).val(), comment: comment, userCommentLink: $("#userCommentLink"+activity_id).val(), userCommentVideo: $("#userCommentVideo"+activity_id).val()};
            if(parseInt(beforePostCommentObj.targetId) == activity_id && beforePostCommentObj.params != null){
                $.extend(params, beforePostCommentObj.params);
            }
            
            $.post(mooConfig.url.base + "/activities/ajax_comment", params, function(data){
                if (data != ''){
                    showPostedComment(activity_id, data);

                    //clear parse link
                    $('.cmt_preview_link').remove();
                    $('#userCommentLink'+activity_id).val('');
                    $('#userCommentVideo'+activity_id).val('');
                    
                    //reset mention
                    var textArea = $("#commentForm_"+activity_id);
                    mooMention.resetMention(textArea);
                    mooTooltip.init();
                    
                    $('body').trigger('afterSubmitCommentCallbackSuccess',[beforePostCommentObj]);
                }
            });
        }
        else
        {
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: mooPhrase.__('share_comment_can_not_empty')
            }).showModal();
        }
    };
    
    var submitItemComment = function(item_type, item_id, activity_id)
    {
        if (!mooUser.validateUser())
        {
            return;
        }
    	var beforePostCommentObj = {emptyContent: false, targetId: "", params:{}};
        $('body').trigger('beforePostCommentCallback',[beforePostCommentObj]);
        if ((beforePostCommentObj.emptyContent === true && parseInt(beforePostCommentObj.targetId) == activity_id) || $.trim($("#commentForm_"+activity_id).val()) != '' || $.trim($('#comment_image_'+activity_id).val()) != '' || $.trim($('#userCommentLink'+activity_id).val()) != '' || $.trim($('#userCommentVideo'+activity_id).val()) != '')
        {
            $('#commentButton_' + activity_id + ' a').prepend('<i class="icon-refresh icon-spin"></i>');
            $('#commentButton_' + activity_id + ' a').addClass('disabled');
            var message = '';
            if($("#commentForm_"+activity_id).siblings('.messageHidden').length > 0){
                message = $("#commentForm_"+activity_id).siblings('.messageHidden').val();
            }else{
                message = $("#commentForm_"+activity_id).val();
            }
            var params = {type: item_type, target_id: item_id, thumbnail:$('#comment_image_'+activity_id).val() ,message: message, activity: 1, userCommentLink: $("#userCommentLink"+activity_id).val(), userCommentVideo: $("#userCommentVideo"+activity_id).val()};
            if(parseInt(beforePostCommentObj.targetId) == activity_id && beforePostCommentObj.params != null){
                $.extend(params, beforePostCommentObj.params);
            }
            $.post(mooConfig.url.base + "/comments/ajax_share", params, function(data){
                if (data != ''){
                    showPostedComment(activity_id, data);

                    //clear parse link
                    $('.cmt_preview_link').remove();
                    $('#userCommentLink'+activity_id).val('');
                    $('#userCommentVideo'+activity_id).val('');

                    //reset mention
                    var textArea = $("#commentForm_"+activity_id);
                    mooMention.resetMention(textArea);
                    mooTooltip.init();
                    
                    $('body').trigger('afterSubmitCommentCallbackSuccess',[beforePostCommentObj]);
                }
            });
        }
        else
        {
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: mooPhrase.__('share_comment_can_not_empty')
            }).showModal();
        }
    };

    var showPostedComment = function(activity_id, data)
    {
        var eleCommentParentLists = $('#comments_'+activity_id).find('.comment_parent_lists');
        if (mooConfig.comment_sort_style === '1'){
            var div_id = 'comments_' + activity_id;
            //$('#newComment_'+activity_id).before(data);
            eleCommentParentLists.append(data);
            //$('#'+div_id+' li.closed-comment').prependTo('#newComment_'+activity_id);
        }else{
            //$('#newComment_'+activity_id).after(data);
            eleCommentParentLists.prepend(data);
        }
        
        $('.slide').slideDown();
        $('#commentButton_' + activity_id + ' a').removeClass('disabled');
        $('#commentButton_' + activity_id + ' a i').remove();
        $("#commentForm_"+activity_id).val('');
        //$("#commentButton_"+activity_id).hide();
        
        $('.commentBox').css('height', '27px');
        $('#comment_preview_image_' + activity_id).html('');
        $('#comment_image_' + activity_id).val('');
        $('#comment_button_attach_'+activity_id).show();
        mooBehavior.registerImageComment();
        init();

        $('body').trigger('afterActivityShowPostedCommentCallback',[{activity_id: activity_id, data: data}]);
    };

    var changeActivityPrivacy = function(obj, activity_id, privacy)
    {
        $.post(mooConfig.url.base + '/activities/ajax_changeActivityPrivacy/',{activityId: activity_id, privacy: privacy}, function(data){
            if(data != ''){
                data = JSON.parse(data);
                var parent = obj.parents('.dropdown');
                parent.find('a#permission_'+activity_id).attr('original-title',data.text);
                parent.find('a#permission_'+activity_id+' .feed_time-icon').removeClass('moo-icon-public moo-icon-people');
                parent.find('a#permission_'+activity_id+' .feed_time-icon').addClass('moo-icon-'+data.icon).html(data.icon);
                parent.find('.dropdown-menu li a').removeClass('n52');
                obj.addClass('n52');
            }
        });
    };
    
    // app/View/Elements/activity_form.ctp
    // app/View/Elements/activities.ctp
    // app/View/Comments/ajax_share.ctp
    // app/View/Activities/ajax_share.ctp
    var init = function(configParam){
        $('textarea:not(.no-grow)').autogrow();
        if( typeof config !== undefined) config = configParam;

        // init remove tags
        initRemoveTags();
        
        // bind edit activity event
        initEditActivity();
        
        // bind remove activity event
        initRemoveActivity();
        
        // bind edit activity comment event
        mooComment.initEditActivityComment();
             
        // bind remove activity comment event
        mooComment.initRemoveActivityComment();
        
        // bind remove item comment event
        mooComment.initRemoveItemComment();
        
        // remove  activity photo comment event
        $('body').off('click.activity','a.admin-or-owner-confirm-delete-photo-comment').on('click.activity','a.admin-or-owner-confirm-delete-photo-comment',function(){
            var data = $(this).data();

            if( typeof data.commentId !== undefined){
                removeActivityPhotoComment(data.commentId);
            }
        });
        // submitComment event
        $('body').off('click.activity','a.viewer-submit-comment').on('click.activity','a.viewer-submit-comment',function(){
            var data = $(this).data();

            if( typeof data.activityId !== undefined){
                submitComment(data.activityId);
            }
        });
        // submitComment event
        $('body').off('click.activity','a.viewer-submit-item-comment').on('click.activity','a.viewer-submit-item-comment',function(){
            var data = $(this).data();

            if( typeof data.itemType !== undefined && typeof data.activityItemId !== undefined && typeof data.activityId !== undefined){
                submitItemComment(data.itemType,data.activityItemId,data.activityId);
            }
        });
        // submitReply event
        $('body').off('click.activity','a.activity_reply_comment_button').on('click.activity','a.activity_reply_comment_button',function(){
            var data = $(this).data();
            type = data.type;
            id = data.id;
            var activity_id = data.activity;

            showReplies(type,id,0,activity_id);
        });
        $('body').off('click.activity','a.activity_reply_comment').on('click.activity','a.activity_reply_comment',function(){
            if (!mooUser.validateUser())
            {
                return;
            }
            var data = $(this).data();
            button = $(this);
            type = data.type;
            id = data.id;
            typeid = '';
            if (type != 'comment')
            {
                typeid = 'activity';
            }

            var beforePostReplyObj = {emptyContent: false, targetId: "", params:{}};
            $('body').trigger('beforePostReplyCallback',[beforePostReplyObj]);
            if ((beforePostReplyObj.emptyContent === true && parseInt(beforePostReplyObj.targetId) == id) || $.trim($("#"+typeid+"commentReplyForm"+id).val()) != '' || $.trim($('#'+typeid+'comment_reply_image_'+id).val()) != '' || $.trim($('#userReplyLink'+id).val()) != '' || $.trim($('#userReplyVideo'+id).val()) != '')
            {
                button.prepend('<i class="icon-refresh icon-spin"></i>');
                button.addClass('disabled');
                var message = '';
                if($("#"+typeid+"commentReplyForm"+id).siblings('.messageHidden').length > 0){
                    message = $("#"+typeid+"commentReplyForm"+id).siblings('.messageHidden').val();
                }else{
                    message = $("#"+typeid+"commentReplyForm"+id).val();
                }
                
                var params = {activity:1,type: type, target_id: id, thumbnail:$('#'+typeid+'comment_reply_image_'+id).val() ,message: message, userCommentLink: $("#userReplyLink"+id).val(), userCommentVideo: $("#userReplyVideo"+id).val()};
                if(parseInt(beforePostReplyObj.targetId) == id && beforePostReplyObj.params != null){
                    $.extend(params, beforePostReplyObj.params);
                }
                $.post(mooConfig.url.base + "/comments/ajax_share", params, function(data){
                    if (data != ''){
                        var eleCommentReplyLists = $('#' + typeid + 'newComment_reply_' + id).parent().find('.comment_reply_lists');

                        if( $('#'+typeid+'comments_reply_' + id).hasClass('isLoadNew')){
                            //$('#' + typeid + 'newComment_reply_' + id).before(data);
                            eleCommentReplyLists.append(data);
                        }else {
                            if (mooConfig.reply_sort_style === '1') {
                                //$('#' + typeid + 'newComment_reply_' + id).before(data);
                                eleCommentReplyLists.append(data);
                            } else {
                                //$('#' + typeid + 'newComment_reply_' + id).after(data);
                                eleCommentReplyLists.prepend(data);
                            }
                        }

                        $('.slide').slideDown("fast", function () {
                            $('body').trigger('afterShowSubmitReplySuccessCallback');
                        });
                        button.removeClass('disabled');

                        $("#"+typeid+"commentReplyForm"+id).val('');

                        $('.commentBox').css('height', '27px');
                        $('#'+typeid+'comment_reply_preview_image_' + id).html('');
                        $('#'+typeid+'comment_reply_image_' + id).val('');
                        $('#'+typeid+'comment_reply_button_attach_'+id).show();
                        mooBehavior.registerImageComment();

                        //reset mention
                        var textArea = $("#"+typeid+"commentReplyForm"+id);
                        mooMention.resetMention(textArea);
                        mooTooltip.init();

                        //clear parse link
                        $('#userReplyLink'+id).val('');
                        $('#userReplyVideo'+id).val('');
                        
                        $('body').trigger('afterSubmitReplySuccessCallback',[beforePostReplyObj]);
                    }
                });
            }
            else
            {
                $.fn.SimpleModal({
                    btn_ok : mooPhrase.__('btn_ok'),
                    btn_cancel: mooPhrase.__('cancel'),
                    model: 'modal',
                    title: mooPhrase.__('warning'),
                    contents: mooPhrase.__('share_comment_can_not_empty')
                }).showModal();
            }
        });

        mooComment.initReplyReply();

        $('body').off('click.activity','a.activity_reply_comment_viewmore').on('click.activity','a.activity_reply_comment_viewmore',function(){
            var data = $(this).data();
            type = data.type;
            id = data.id;
            var close = data.close;
            var activity_id = data.activity;

            if(typeof close == 'undefined'){
                close = 0;
            }

            showReplies(type,id, close, activity_id);
        });
        //change activity's privacy
        $('body').off('click.activity','a.change-activity-privacy').on('click.activity','a.change-activity-privacy',function(){
            var data = $(this).data();
            if(typeof data.activityId !== undefined && typeof data.privacy !== undefined){
                changeActivityPrivacy($(this),data.activityId, data.privacy);
            }
        });
        
        // init showCommentForm
        mooComment.initShowCommentForm();
        
        // init LikeActivit
        mooLike.initLikeActivity();
        
        // init remove item comment
        mooComment.initRemoveItemComment();
        
        // init edit item comment
        mooComment.initEditItemComment();
        
        // init show comment btn on focus textarea 
        mooComment.initShowCommentBtn();
        
        // init View all %s comments
        initShowAllComments();
        
        // init load more
        mooBehavior.initMoreResults();

        //bind Close comment
        initCloseComment();
        
		//init feed form
        mooBehavior.initFeedForm();

        $('body').trigger('afterActivityInitCallback',[]);
    }

    var showReplies = function(type, id, close_comment, activity_id)
    {
        $('.activity_reply_comment_viewmore').each(function(){
            data = $(this).data();

            if (data.id == id && data.type == type)
            {
                $(this).parent().remove();
                return true;
            }
        });

        var div_id = '';
        if (type == 'comment')
        {
            div_id = 'comments_reply_' + id;
            if ($('#newComment_reply_' + id).is(":visible") && !$('#' + div_id).hasClass('isLoadNew')) {
                $('#newComment_reply_' + id +' .commentBox').focus();
                return;
            }
            $('#newComment_reply_' + id).show();
            $('#newComment_reply_' + id +' .commentBox').focus();
        }
        else
        {
            div_id = 'activitycomments_reply_' + id;
            if ($('#activitynewComment_reply_' + id).is(":visible") && !$('#' + div_id).hasClass('isLoadNew')) {
                $('#activitynewComment_reply_' + id+' .commentBox').focus();
                return;
            }
            $('#activitynewComment_reply_' + id).show();
            $('#activitynewComment_reply_' + id+' .commentBox').focus();
        }

        var url = mooConfig.url.base + "/comments/browse/"+type + "/" +id + '/id_content:'+div_id;
        if(typeof close_comment != 'undefined'){
            url += '/is_close_comment:' + close_comment;
        }
        if(typeof activity_id != 'undefined'){
            url += '/activity_id:' + activity_id;
        }

        $.post(url, function(data){
            if (data != ''){
                var eleCommentReplyLists = $('#' + div_id).find('.comment_reply_lists');
                if($('#' + div_id).hasClass('isLoadNew')){
                    //$('#' + div_id + '>li:not(:last-child)').remove();
                    eleCommentReplyLists.empty();
                    $('#' + div_id).removeClass('isLoadNew');
                }

                if (mooConfig.reply_sort_style === '1') {
                    //$('#' + div_id).prepend(data);
                    eleCommentReplyLists.prepend(data);
                }
                else {
                    //$('#' + div_id).append(data);
                    eleCommentReplyLists.append(data);
                }

                mooTooltip.init();
                mooBehavior.registerImageComment();
            }

            $('body').trigger('afterActivityAjaxShowRepliesCallback',[{type: type, id: id, close_comment: close_comment, activity_id: activity_id}]);
        });

        $('body').trigger('afterActivityShowRepliesCallback',[{type: type, id: id, close_comment: close_comment, activity_id: activity_id}]);
    }

    function retrieveImageFromClipboardAsBlob(pasteEvent, callback){
        if(pasteEvent.clipboardData == false){
            if(typeof(callback) == "function"){
                callback(undefined);
            }
        };

        var items = pasteEvent.clipboardData.items;

        if(items == undefined){
            if(typeof(callback) == "function"){
                callback(undefined);
            }
        };

        for (var i = 0; i < items.length; i++) {
            // Skip content if not image
            if (items[i].type.indexOf("image") == -1) continue;
            // Retrieve image on clipboard as blob
            var blob = items[i].getAsFile();

            if(typeof(callback) == "function"){
                callback(blob);
            }
        }
    }

    function uuidv4() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    // app/View/Elements/activity_form.ctp
    var stop_fetch_link = false;
    var initActivityForm = function(){
        var _plugin3rd_photo = 'PhotoFeed';
        var _plugin3rd_user_tagging = 'UserTaggingFeed';

        window.addEventListener("paste", function(e){
            if ($("#message").is(":focus"))
            {
                // Handle the event
                retrieveImageFromClipboardAsBlob(e, function(imageBlob){
                    // If there's an image, display it in the canvas
                    const formData = new FormData();

                    formData.append('qqfile', imageBlob);
                    var id = uuidv4();
                    var element = $('<span id="feed_'+id+'" class="photo-review-thumb feed_image" style="background-image:url(' + mooConfig.url.base + '/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                    element.insertBefore('.addMoreImage');
                    $('#wall_photo_preview').show();
                    $('#addMoreImage').show();
                    // Use `jQuery.ajax` method
                    $.ajax(mooConfig.url.base + '/upload/wall', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success(data) {
                            response = JSON.parse(data);
                            if (response.success){
                                $('[data-toggle="tooltip"]').tooltip('hide');
                                var img = $('<img src="'+response.file_path+'">');
                                img.load(function() {
                                    var element = $('#feed_'+id);
                                    element.data('thumb',response.photo);
                                    element.attr('style','background-image:url(' + response.file_path + ')');
                                    var deleteItem = $('<a href="javascript:void(0);" class="thumb-review-remove"><i class="material-icons thumb-review-delete">clear</i></a>');
                                    element.append(deleteItem);

                                    element.find('.thumb-review-delete').unbind('click');
                                    element.find('.thumb-review-delete').click(function(e){
                                        e.preventDefault();
                                        $(this).parents('span').remove();
                                        $('#wall_photo').val($('#wall_photo').val().replace(response.photo + ',',''));
                                        $('body').trigger('afterDeleteWallPhotoCallback',[response]);
                                    });
                                });

                                var wall_photo = $('#wall_photo').val();
                                $('#wall_photo').val(wall_photo+ response.photo + ',');
                                destroyPreviewlink();
                            }
                            $('body').trigger('afterUploadWallPhotoCallback',[response]);
                        },
                        error() {
                            console.log('Upload error');
                        },
                    });
                });
            }
        }, false);

        $('[data-toggle="tooltip"]').tooltip();
        
        if($('#select-2').length > 0) {
            var uploader = new mooFileUploader.fineUploader({
                element: $('#select-2')[0],
                text: {
                    uploadButton: '<div class="stt-action-btn"><div class="stt-action-w"><span class="stt-action-icon material-icons">photo_camera</span></div></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit : mooConfig.sizeLimit
                },
                multiple: true,
                request: {
                    endpoint: mooConfig.url.base + "/upload/wall"
                },

                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id, fileName){
                        var element = $('<div id="feed_'+id+'" class="photo-review-thumb feed_image" style="background-image:url(' + mooConfig.url.base + '/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></div>');
                        element.insertBefore('.addMoreImage');
                        $('#wall_photo_preview').show();
                        $('#addMoreImage').show();
                        $('body').trigger('beforeUploadWallPhotoCallback');
                    },
                    onComplete: function(id, fileName, response, xhr) {
                        if (response.success){
                            $('[data-toggle="tooltip"]').tooltip('hide');
                            $(this.getItemByFileId(id)).remove();
                            var img = $('<img src="'+response.file_path+'">');
                            var element = $('#feed_'+id);
                            element.data('thumb',response.photo);
                            img.load(function() {
                                element = $('#feed_'+id);
                                element.attr('style','background-image:url(' + response.file_path + ')');
                                var deleteItem = $('<a href="javascript:void(0);" class="thumb-review-remove"><span class="material-icons thumb-review-delete">clear</span></a>');
                                element.append(deleteItem);

                                element.find('.thumb-review-delete').unbind('click');
                                element.find('.thumb-review-delete').click(function(e){
                                     e.preventDefault();
                                     $(this).parent().parent().remove();
                                     $('#wall_photo').val($('#wall_photo').val().replace(response.photo + ',',''));
                                     $('body').trigger('afterDeleteWallPhotoCallback',[response]);
                                });
                            });

                            var wall_photo = '';
                            $('.feed_image').each(function(){
                                wall_photo += $(this).data('thumb') + ',';
                            });

                            $('#wall_photo').val(wall_photo);
                            destroyPreviewlink();

                            $('body').trigger('afterUploadPhotoPlugin3drCallback',[response]);
                        }
                        $('body').trigger('afterUploadWallPhotoCallback',[response]);
                    }
                }
            });
        }

        $('#addMoreImage').unbind('click');
        $('#addMoreImage').click(function(){
            $('#select-2 input[name=file]').click();
        });
        
        // init onfocus share what's news
        $('#message').on('focus', function(){
            mooComment.showCommentButton(0);
        });
        
        // bind share button
        $('#status_btn').unbind('click');
        $('#status_btn').click(function(){
            postWall(); 
        });

        $('select#privacy').niceSelect();
        
        // show activity form
        $('#status_box').slideDown("slow", function () {
            $('body').trigger('afterShowStatusBoxCallback');
        });
        
        $('#message').on('paste', function (e) {  
			if ($.trim($('#wall_photo').val()) != '')
                return;
            if($('#preview_link').length == 0){
                if (e.originalEvent.clipboardData) {            
                    var text = e.originalEvent.clipboardData.getData("text/uri-list");
					if(text == ""){
						text = e.originalEvent.clipboardData.getData("text/plain");
					}
                    pasteInFeed(text);
                }
            }
        });


        $('#message').on('keydown keyup keypress', function (e) {
        	if ($.trim($('#wall_photo').val()) != '')
        		return;
            if(!e.ctrlKey && $('#preview_link').length == 0){
                var text = $(this).val();
                pasteInFeed(text);
            }        
        });

        $('body').on('enablePluginsCallback', function(e, data){
            var _plugins = data.plugins;
            if(_plugins.indexOf(_plugin3rd_photo) > -1){
                showPhotoFeed();
            }
        });

        $('body').on('disablePluginsCallback', function(e, data){
            var _plugins = data.plugins;
            if(_plugins.indexOf(_plugin3rd_photo) > -1){
                hidePhotoFeed();
            }
        });

        responsiveActivityForm();
    }

    var showPhotoFeed = function () {
        $('#AddPhotoFeed').removeClass('feed-hide').show();
        $('#wall_photo_preview').hide();
        $('#wall_photo').val('');
        $('#wall_photo_preview').find('.photo-review-thumb').each(function(){
            if($(this).attr('id') != 'addMoreImage') {
                $(this).remove();
            }
        });
    }

    var hidePhotoFeed = function () {
        $('#AddPhotoFeed').addClass('feed-hide').hide();
        $('#wall_photo_preview').hide();
        $('#wall_photo_preview').find('.photo-review-thumb').each(function(){
            if($(this).attr('id') != 'addMoreImage') {
                $(this).remove();
            }
        });
        $('#wall_photo').val('');
    }

    var checkFeedStatusItem = function () {
        $.when( $('body').on('checkActivityFormActionCallback'), $('body').on('showUploadPhotoFeed'), $('body').on('hideUploadPhotoFeed'), $('body').on('showResetUploadPhotoFeed'), $('body').on('hideResetUploadPhotoFeed') ).then(function( x ) {
            setTimeout(function(){
                var feed_status_count = 0;
                $('.stt-action').find('.stt-action-item').each(function (index, value) {
                    if( $(this).is(':hidden') || $(this).hasClass('feed-hide') ){
                        $(this).attr('order', '');
                    } else {
                        feed_status_count++;
                        $(this).attr('order', feed_status_count);
                    }
                });
                checkFeedStatusHeight();
            }, 100);
        });
    }

    var checkFeedStatusHeight = function () {
        var sttAction = $('#commentButton_0');
        if(sttAction.length > 0){
            if(sttAction.position().top > 0){
                sttAction.parent().addClass('stt-2line');
            }else{
                sttAction.parent().removeClass('stt-2line');
            }
        }
    }

    var responsiveActivityForm = function () {
        $(window).resize(function () {
            checkFeedStatusHeight();
        });
        checkFeedStatusItem();
        $('body').on('checkActivityFormActionCallback', function(e, data){
            checkFeedStatusItem();
        });
    }

    function getUrlFromText(text) {
        result = text.match(/\b([\d\w\.\/\+\-\?\:]*)((ht|f)tp(s|)\:\/\/|[\d\d\d|\d\d]\.[\d\d\d|\d\d]\.|www\.|\.tv|\.ac|\.com|\.edu|\.gov|\.int|\.mil|\.net|\.org|\.biz|\.info|\.name|\.pro|\.museum|\.co)([\d\w\.\/\%\+\-\=\&amp;\?\:\\\&quot;\'\,\|\~\;]*)\b/gi);
        if (result)
    	{
        	return result[0].charAt(0).toLowerCase() + result[0].slice(1);
    	}
    }
    
    var pasteInFeed = function(iContent){
         var content = $('#message').val();        
         //check url tiktok -> don't slice content
         var isUrlTiktok = strpos(iContent,'www.tiktok.com',0);
         if ( (strpos(iContent,'https://',0) || strpos(iContent,'http://',0)) && !isUrlTiktok) {
            iContent = getUrlFromText(iContent);
         }
         if (array_delete_links.hasOwnProperty(iContent))
        	 return;

           if (iContent && (substr(iContent, 0, 7) == 'http://' || substr(iContent, 0, 8) == 'https://' || (substr(iContent, 0, 4) == 'www.')))
        {
            var checkHttps = strpos(iContent,'https://',0);
            var checkHttp = strpos(iContent,'http://',0);           
            if(checkHttps === 0  || checkHttp === 0){
                //check video link
                var checkV1 = strpos(iContent,'youtube.com',0);
                var checkV2 = strpos(iContent,'youtu.be',0);
                var checkV3 = strpos(iContent,'vimeo.com',0);
                if(!checkV1 && !checkV2 && !checkV3){
                    $('.userTagging-userShareLink').removeClass('hidden');
                    $('.userTagging-userShareVideo').addClass('hidden');
                    $('#userShareVideo').val('');
                    //$('#userShareLink').val(iContent);
                    getLinkPreview('userShareLink', iContent, true, content);
                }else{
                    $('.userTagging-userShareVideo').removeClass('hidden');
                    $('.userTagging-userShareLink').addClass('hidden');
                    $('#userShareLink').val('');
                    $('#userShareVideo').val(iContent);
                    getLinkPreview('userShareVideo', iContent, true, content);              
                }
            }      
        }
    }
          
    var substr = function(sString, iStart, iLength) { 
        if(iStart < 0) 
        {
            iStart += sString.length;
        }

        if(iLength == undefined) 
        {
            iLength = sString.length;
        } 
        else if(iLength < 0)
        {
            iLength += sString.length;
        } 
        else 
        {
            iLength += iStart;
        }

        if(iLength < iStart) 
        {
            iLength = iStart;
        }

        return sString.substring(iStart, iLength);
    }

    var strpos = function(haystack, needle, offset) {
        var i = (haystack+'').indexOf(needle, (offset || 0));
        return i === -1 ? false : i;
    }
    
    var removePreviewlink = function(){
        $('.removeImage').unbind('click');
        $('.removeImage').on('click', function(){
           $(this).parent().remove();
           $('#shareImage').val('0');
        }); 
        $('.removeContent').unbind('click');
        $('.removeContent').on('click', function(){
        	destroyPreviewlink();
        });      
    }
    
    var destroyPreviewlink = function()
    {
    	if ($.trim($('#userShareLink').val()) != '')
    	{
    		array_delete_links[$.trim($('#userShareLink').val())] = '1';
    	}
    	if ($.trim($('#userShareVideo').val()) != '')
    	{
    		array_delete_links[$.trim($('#userShareVideo').val())] = '1';
    	}
    	
    	$('#preview_link').remove();
        $('#userShareLink').val('');
        $('#userShareVideo').val('');
        $('#shareImage').val('1');
        $('body').trigger('afterDestroyPreviewLinkWallCallback',[]);
    }
    
    var requestSent = false;
    var array_save_links = {};
    var array_delete_links = {};
    var getLinkPreview = function(el, content, paste, oldContent){
    	var element = $('.userTagging-'+ el);
        
    	if (!array_save_links.hasOwnProperty(content))
        {
    		element.spin('tiny');
        }
        setTimeout(function(){ //break the callstack to let the event finish
            if(!requestSent) {
            	if (array_save_links.hasOwnProperty(content))
    	        {
    	    		console.log(array_save_links[content]);
    	    		requestSent = true;
    	    		doPreviewLink(element,content, paste, oldContent,array_save_links[content]);	    		
    	        	return;
    	        }
            	
                requestSent = true;    
                var fbURL=mooConfig.url.base + "/activities/ajax_preview_link";                
                $.post(fbURL, {content:content}, function(resp){
                		array_save_links[content]= resp;
                        element.spin(false);
                        doPreviewLink(element,content, paste, oldContent,resp);
                });                  
            }
        },0);
    }
    
    var doPreviewLink = function(element,content, paste, oldContent, resp)
    {
        $('#preview_link').remove();
        var obj = jQuery.parseJSON(resp);

        if(!jQuery.isEmptyObject(obj)) {
            var data = '';
            if (typeof obj.title !== "undefined" && obj.title !== "404 Not Found" && obj.title !== "403 Forbidden") {
                data = '<div class="activity_item activity_item_preview_link" id="preview_link">';
                data += '<a class="removePreviewlink removeContent" href="javascript:void(0)"><i class="icon-delete material-icons">clear</i></a>';
                if (typeof obj.image !== "undefined" && obj.image != '') {
                    data += '<div class="activity_left"><a class="removePreviewlink removeImage" href="javascript:void(0)"><span class="icon-delete material-icons">clear</span></a>';
                    if (obj.image.indexOf('http') != -1) {
                        data += '<img src="' + obj.image + '" class="activity-img">';
                    } else {
                        data += '<img src="' + mooConfig.url.base + '/uploads/links/' + obj.image + '" class="activity-img">';
                    }
                    data += '<input type="hidden" name="data[share_image]" id="userShareLink" value="1">';
                    data += '</div>';
                }
                if (obj.image != '') {
                    data += '<div class="activity_right">';
                } else {
                    data += '<div>';
                }
                data += '<a class="activity_item_title attachment_edit_link" href="' + obj.url + '" target="_blank" rel="nofollow">';
                data += obj.title;
                data += '</a>';
                if (typeof obj.description !== "undefined" && obj.description != '') {
                    data += '<div class="feed_item_text attachment_body_description">';
                    data += '<a class="attachment_edit_link comment_message feed_detail_text">' + obj.description + '</a>';
                    data += '</div>';
                }
                data += '<input type="hidden" name="data[share_text]" id="userShareLink" value="1">';
                data += '</div></div>';
            } else if (typeof obj.type !== "undefined" && obj.type == "img") {

                data = '<div class="activity_item activity_item_preview_link" id="preview_link">';
                if (typeof obj.image !== "undefined" && obj.image != '') {
                    data += '<a class="removePreviewlink removeContent" href="javascript:void(0)"><span class="icon-delete material-icons">clear</span></a>';
                    data += '<div class="activity_parse_img">';
                    data += '<img src="' + obj.image + '" class="activity-img">';

                    data += '<input type="hidden" name="data[share_image]" id="userShareLink" value="1">';
                    data += '</div>';
                }
                data += '<input type="hidden" name="data[share_text]" id="userShareLink" value="1">';
                data += '</div>';
            }

            if (data != '') {
                element.append(data);
                if (paste) {
                    $('.textoverlay').text(oldContent);
                    $('.autogrow-textarea-mirror').text(oldContent);
                }
                removePreviewlink();
                $('#userShareLink').val(content);
                $('body').trigger('afterPreviewLinkWallCallback', []);
            }
        }
        requestSent = false;
    }

    var postWall = function()
    {
        if (!mooUser.validateUser()){
            return false;
        }

        var beforePostWallObj = {emptyContent: false};
        $('body').trigger('beforePostWall',[beforePostWallObj]);
        var msg = $('#message').val();
        if (beforePostWallObj.emptyContent === true || $.trim(msg) != '' || ($("#video_destination").length > 0 && $.trim($("#video_destination").val()) !== '') || $.trim($('#userShareLink').val()) != '' || $.trim($('#userShareVideo').val()) !='' || ($('#wall_photo_preview :not(#addMoreImage)').html() != '' && $('#wall_photo_preview :not(#addMoreImage)').html() != 'add'))
        {

            mooButton.disableButton('status_btn');
            $('#status_btn').spin('small');
            $.post(mooConfig.url.base + "/activities/ajax_share", $("#wallForm").serialize(), function(data){
                $('#wall_photo').val('');
                mooButton.enableButton('status_btn');
                $('#message').val("");
                $('.userTagging-userShareLink').addClass('hidden');
                $('.userTagging-userShareVideo').addClass('hidden');
                $('#shareImage').val('1');
                if ($("#video_destination").length > 0 && $("#video_destination").val() !== ''){
                    $.fn.SimpleModal({
                        model: 'content',
                        title: mooPhrase.__('upload_video_phrase_4'),
                        contents: mooPhrase.__('upload_video_phrase_0')
                    }).showModal();

                    setTimeout(function(){
                        $('#simpleModal').hideModal();
                    }, 3000);
                }
                else{
                    if (data != '')
                    {
                        if($('.no-feed').length > 0 ){
                            $('#list-content .no-feed').remove();
                        }

                        if($("#chk_story").length == 0 || !$('#chk_story').is(':checked')) {
                            $('#list-content').prepend(data);
                            //register image
                            var attachment_id = $(data).find('div[id^=comment_button_attach_]').data('id');
                            mooAttach.registerAttachComment(attachment_id);
                        }

                        $('#message').css('height', '36px');
                        $('.slide').slideDown();

                        $('#wall_photo_preview .photo-review-thumb:not(.addMoreImage)').remove();
                        $('#addMoreImage').hide();
                        $('.form-feed-holder').css('padding-bottom','0px');

                    }
                }

                $('#status_btn').spin(false);
                mooResponsive.init();
                $(".tip").tipsy({ html: true, gravity: 's' });
                $('[data-toggle="tooltip"]').tooltip();

                //reset mention
                var textArea = $("#wallForm").find('#message');

                mooMention.resetMention(textArea);

                mooTooltip.init();

                $('#preview_link').remove();
                array_delete_links = {};
                $('#userShareLink').val('');
                $('#userShareVideo').val('');
                $('body').trigger('afterPostWallCallbackSuccess',[]);

            });
            $('.stt-action #userTagging-id-userTagging').addClass('hidden');//$('.stt-action .userTagging-userTagging').addClass('hidden');
            $('.stt-action').css('margin-top','0');
            $('#wall_photo_preview').hide();
            $('#userTagging').tagsinput('removeAll');
        }else{
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('cancel'),
                model: 'modal',
                title: mooPhrase.__('warning'),
                contents: mooPhrase.__('share_whats_new_can_not_empty')
            }).showModal();
        }
    }

    var initCloseComment = function(){
        $('.closeComment').unbind("click");
        $('.closeComment').click(function(){
            if (!mooUser.validateUser())
            {
                return;
            }
            $(this).blur();
            var data = $(this).data();
            $.post(mooConfig.url.base + '/comments/ajax_close', {item_id: data.id, item_type: data.type}, function(data) {
                var json = JSON.parse(data);
                if(json.result == 1){
                    mooAlert.alert(json.message);
                }
            });

            if(data.close == '1') {
                $(this).html(mooPhrase.__('close_comment'));
                $(this).data('close', 0);
            }else{
                $(this).html(mooPhrase.__('open_comment'));
                $(this).data('close', 1);
            }
        });
    }

    //    exposed public method
    return {
        init:init,
        initActivityForm : initActivityForm,
        initOnAjaxLoadActivityEdit : initOnAjaxLoadActivityEdit
    };
}));