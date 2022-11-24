/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooAjax', 'mooButton', 'mooAlert', 'mooPhrase',
            'spinner', 'tokeninput'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooGlobal = factory();
    }
}(this, function ($, mooAjax, mooButton, mooAlert, mooPhrase) {

    // app/View/Friends/ajax_invite.ctp
    var initInviteFriendBtn = function (mode) {
        
        $('#inviteButton').unbind('click');
        $('#inviteButton').click(function () {
            $('#inviteButton').spin('small');
            mooButton.disableButton('inviteButton');
            $(".error-message").hide();
            mooAjax.post({
                url: mooConfig.url.base + '/friends/ajax_invite?mode='+mode,
                data: $("#inviteForm").serialize()
            }, function (data) {
                mooButton.enableButton('inviteButton');
                $('#inviteButton').spin(false);
                var json = $.parseJSON(data);
                if (json.result == 1)
                {
                	if (mode == 'model')
            		{
                		$('#inviteFormBody').html(mooPhrase.__('your_invitation_has_been_sent'));
                        $('#inviteButton').remove();

                		return;
            		}
                    $("#to").val('');
                    $("#message").val('');
                    $(".error-message").hide();
                    mooAlert.alert(mooPhrase.__('your_invitation_has_been_sent'));
                    if (typeof grecaptcha == "object")
                	{
                    	grecaptcha.reset();
                	}
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            
            return false;
        });
    }
    
    // app/View/Conversations/view.ctp
    var initLeaveConversation = function(){
        $('.leaveConversation').unbind('click');
        $('.leaveConversation').on('click', function(){
            var data = $(this).data();
            mooAlert.confirm(data.msg, data.url);
        });
    }
    
    // app/View/Conversations/ajax_send.ctp
    var initConversationSendBtn = function(){
        
	$("#friends").tokenInput(mooConfig.url.base + "/friends/do_get_json",
            { 
                preventDuplicates: true, 
                hintText: mooPhrase.__('enter_a_friend_s_name'),
                noResultsText: mooPhrase.__('no_results'),
                tokenLimit: 20,
                resultsFormatter: function(item){
                    return '<li class="token-input-result-item"><div class="token-input-result-main"><div class="token-input-result-img">'+ item.avatar +'</div><div class="token-input-result-name">'+ item.name +'</div></div></li>';
                } 
            }
	);
	
        $('#sendButton').unbind('click');
	    $('#sendButton').click(function(){
            mooButton.disableButton('sendButton');
            $('#sendButton').spin('small');
            $.post(mooConfig.url.base + "/conversations/ajax_doSend", $("#sendMessage").serialize(), function(data){
                mooButton.enableButton('sendButton');
                $('#sendButton').spin(false);
                var json = $.parseJSON(data);
            
                if ( json.result == 1 )
                {
                    $("#subject").val('');
                    $("#message").val('');
                    $(".error-message").hide();

                    $('#themeModal').modal('hide');
                    mooAlert.alert(mooPhrase.__('your_message_has_been_sent'));
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }       
            });
		
            return false;
	});
    }
    
    // app/View/Conversations/ajax_add.ctp
    var initConversationAjaxAdd = function(){
        
        $("#friends").tokenInput(mooConfig.url.base + "/friends/do_get_json",
            { preventDuplicates: true, 
              hintText: mooPhrase.__('enter_a_friend_s_name'),
              noResultsText: mooPhrase.__('no_results'),
              tokenLimit: 20,
              resultsFormatter: function(item)
              {
                return '<li class="token-input-result-item"><div class="token-input-result-main"><div class="token-input-result-img">'+ item.avatar +'</div><div class="token-input-result-name">'+ item.name +'</div></div></li>';
              } 
            }
        );

	$('#sendButton').click(function(){
            mooButton.disableButton('sendButton');   
            
            $.post(mooConfig.url.base + "/conversations/ajax_doAdd", $("#sendMessage").serialize(), function(data){
                
                mooButton.enableButton('sendButton');
                var json = $.parseJSON(data);

                if ( json.result == 1 ){
                    window.location.reload();
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }   
            });
            
            return false;
	});
    }
    
    var errorHandler = function(id, fileName, reason) {
    	if (mooConfig.product_mode == 0)
    	{
    		reason = mooPhrase.__('upload_error');
    	}
        if ($(this._element).find('.qq-upload-list .errorUploadMsg').length > 0){
        	$(this._element).find('.qq-upload-list .errorUploadMsg').html(reason);
        }else {
        	$(this._element).find('.qq-upload-list').prepend('<li class="errorUploadMsg">' + reason + '</li>');
        }
        $(this._element).find('.qq-upload-fail').remove();
    };
    
    // app/View/Elements/lists/messages_list.ctp
    var initMsgList = function(){
        $('.markMsgStaus').unbind('click');
        $('.markMsgStaus').click(function(){
           var data = $(this).data();
           var obj = $(this);
           mooAjax.post({
                url: mooConfig.url.base + '/conversations/mark_read',
                data: {
                    id : data.id,
                    status : data.status
                }
            }, function (respsonse) {
                var json = $.parseJSON(respsonse);
                var currentCounter = $('#messages .badge_counter').html();
                if (json.status === '1'){
                    obj.parents('li:first').find('.notification-group-main').addClass('unread');
                    obj.hide();
                    obj.prev().show();
                    
                    // update counter
                    $('#messages .badge_counter').html(parseInt(currentCounter) + 1);
                    
                    // update conversation count
                    if($('.conversation_count').length > 0)
                    {
                        $('.conversation_count').html(parseInt(currentCounter) + 1);

                    }else{
                        $('#conversationDropdown').append('<span class="conversation_count">1</span>');
                    }
                    
                }else{
                    obj.parents('li:first').find('.notification-group-main').removeClass('unread');
                    obj.hide();
                    obj.next().show();
                    
                    // update counter
                    $('#messages .badge_counter').html(parseInt(currentCounter) - 1);
                    
                    // update conversation count
                    if (parseInt(currentCounter) - 1 > 0){
                        if($('.conversation_count').length > 0)
                        {
                            $('.conversation_count').html(parseInt(currentCounter) - 1);

                        }else{
                            $('#conversationDropdown').append('<span class="conversation_count">1</span>');
                        }
                    }else{
                        if($('.conversation_count')){
                            $('.conversation_count').remove();
                        }
                    }
                }
            });
        });
    }

    var searchConversations = function () {
        $.get(mooConfig.url.base + '/conversations/ajax_browse?keyword='+ $('#conv_keyword').val(), function(html){
            $('#list-content').html(html);
        });
    }

    var initSearchMessage = function(){
        $('#form_friend_search').submit(function( event ) {
            event.preventDefault();
            return false;
        });

        $('#form_friend_search').find('.header_search_btn').click(function (e) {
            searchConversations();
        });

        $('#form_conv_search').submit(function( event ) {
            event.preventDefault();
            return false;
        });

        $('#form_conv_search').find('.header_search_btn').click(function (e) {
            searchConversations();
        });

        $('#conv_keyword').on('keyup', function (e) {
            searchConversations();
        });
    }

    return {
        initInviteFriendBtn : initInviteFriendBtn, 
        initConversationSendBtn : initConversationSendBtn,
        initLeaveConversation : initLeaveConversation,
        errorHandler : errorHandler,
        initConversationAjaxAdd : initConversationAjaxAdd,
        initMsgList : initMsgList,
        initSearchMessage : initSearchMessage,
    }
}));