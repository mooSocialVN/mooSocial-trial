/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooBehavior', 'mooFileUploader', 'mooAlert', 'mooAjax', 'mooMention', 'mooTopic',
            'mooToggleEmoji', 'mooButton', 'mooOverlay', 'mooGlobal', 'mooPhrase', 'spinner', 'autogrow', 'tipsy', 'tinyMCE', 'typeahead','bloodhound' ,'tagsinput'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooGroup = factory();
    }
}(this, function ($, mooBehavior, mooFileUploader, mooAlert, mooAjax, mooMention, mooTopic,
                  mooToggleEmoji, mooButton, mooOverlay, mooGlobal, mooPhrase) {
    
    // app/Plugin/Group/View/Groups/create.ctp
    var initOnCreate = function () {

        var uploader = new mooFileUploader.fineUploader({
            element: $('#select-0')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span> ' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/group/group_upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function (id, fileName, response) {
                    $('#item-avatar').attr('src', response.file_url);
                    $('#item-avatar').show();
                    $('#photo').val(response.file_path);
                }
            }
        });

        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            if (tinyMCE.activeEditor !== null) {
                $('#editor').val(tinyMCE.activeEditor.getContent());
            }
            if (tinyMCE.activeEditor !== null) {
                $('#editor').val(tinyMCE.activeEditor.getContent());
            }
            mooBehavior.createItem('groups', true);
        });
    }
    
    // app/Plugin/Group/View/Groups/ajax_invite.ctp
    var initAjaxInvite = function(){
        
    	var friends_userTagging = new Bloodhound({
            datumTokenizer:function(d){
                return Bloodhound.tokenizers.whitespace(d.name);
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
            	url: mooConfig.url.base + '/users/friends.json',
                cache: false,
                filter: function(list) {

                    return $.map(list.data, function(obj) {
                        return obj;
                    });
                }
            },
            
            identify: function(obj) { return obj.id; },
		});
		
		friends_userTagging.initialize();


    	 $('#friends').tagsinput({
             freeInput: false,
             itemValue: 'id',
             itemText: 'name',
             typeaheadjs: {
                 name: 'friends_userTagging',
                 displayKey: 'name',
                 highlight: true,
                 limit:10,
                 source: friends_userTagging.ttAdapter(),
                 templates:{
                     notFound:[
                         '<div class="empty-message">',
                         	mooPhrase.__('no_results'),
                         '</div>'
                     ].join(' '),
                     suggestion: function(data){
	                     if($('#friends').val() != '')
	                     {
	                         var ids = $('#friends').val().split(',');
	                         if(ids.indexOf(data.id) != -1 )
	                         {
	                             return '<div class="empty-message" style="display:none">'+mooPhrase.__('no_results')+'</div>';
	                         }
	                     }
                         return [
                             '<div class="suggestion-item">',
                                 '<img alt src="'+data.avatar+'"/>',
                                 '<span class="text">'+data.name+'</span>',
                             '</div>',
                         ].join('')
                     }
                 }
             }
         });
	
        $('#sendButton').unbind('click');
	    $('#sendButton').click(function(){
            $('#sendButton').spin('small');
            mooButton.disableButton('sendButton');
            $(".error-message").hide();
            
            mooAjax.post({
                url : mooConfig.url.base + '/groups/ajax_sendInvite',
                data: $("#sendInvite").serialize()
            }, function(data){
                mooButton.enableButton('sendButton');
                $('#sendButton').spin(false);
                var json = $.parseJSON(data);
                if ( json.result == 1 )
                {
                    $('#sendButton').hide();
                    $('#simple-modal-body').html(json.msg);
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            
            return false;

        });
	
		$('#invite_type_group').change(function(){
			$('#invite_friend').hide();
			$('#invite_email').hide();
			if ($('#invite_type_group').val() == '1')
			{
				$('#invite_friend').show();
			}
			else
			{
				$('#invite_email').show();
			}
		});
    }
    
    var initOnAjaxGroupVideo = function(){
        $('#profile-content').unbind('click');
        $('#profile-content').on('click', '#share-new', function () {
            var data = $(this).data();
            mooAjax.post({
                url: data.url,
                data: {
                    group_id: data.id
                }
            }, function (response) {
                $('#videoModal .modal-content').html(response);
                 
            });
        });
    }

    // app/Plugin/Group/View/Groups/view.ctp
    var initOnView = function () {
        
        // bind leaveGroup
        $('.leaveGroup').unbind('click');
        $('.leaveGroup').on('click', function(){
            var data =  $(this).data();
            var leaveUrl = mooConfig.url.base + '/groups/do_leave/' + data.id;
            mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_leave_this_group'), leaveUrl);
        });

        $('#profile-content').unbind('click');
        $('#profile-content').on('click', '#fetchButton', function () {
            
            $('#fetchButton').spin('small');
            $("#videoForm .error-message").hide();
            mooButton.disableButton('fetchButton');

            mooAjax.post({
                url: mooConfig.url.base + "/videos/aj_validate",
                data: $("#createForm").serialize()
            }, function (data) {
                mooButton.enableButton('fetchButton');
                if (data) {
                    $("#fetchForm .error-message").html($.parseJSON(data).error);
                    $("#fetchForm .error-message").show();
                    $('#fetchButton').spin(false);
                } else {

                    mooAjax.post({
                        url: mooConfig.url.base + "/videos/fetch",
                        data: $("#createForm").serialize()
                    }, function (response) {
                        mooButton.enableButton('fetchButton');
                        $("#fetchForm").slideUp();
                        $("#videoForm").html(data);
                    });

                }
            });

            return false;
        });
        
        // bind action to button delete
        deleteGroup();
        
        var topic_id = $('.topicId').attr('data-id');
        var video_id = $('.videoId').attr('data-id');
        var comment_id = $('.commentId').attr('data-id');
        var reply_id = $('.replyId').attr('data-id');
        var url_cmt = '';
        var tab = $('.tab').attr('data-id');
        var is_edit = $('.isEdit').attr('data-id');

        if(comment_id !== '0'){
            url_cmt = '/comment_id:' + comment_id;

            if(reply_id !== '0'){
                url_cmt += '/reply_id:' + reply_id;
            }
        }

        if (topic_id !== '0'){
            $('#browseGroupDetail li').removeClass('current');
            $('#topics').parent().addClass('current');
            if(is_edit !== '0'){
                loadPage('topics', mooConfig.url.base + '/topics/group_create/' + topic_id);
            }else {
                loadPage('topics', mooConfig.url.base + '/topics/ajax_view/' + topic_id + url_cmt);
            }
        }
        
        if (video_id !== '0'){
            $('#browseGroupDetail li').removeClass('current');
            $('#videos').parent().addClass('current');
            loadPage('videos', mooConfig.url.base + '/videos/ajax_view/' + video_id + url_cmt);
        }
        
        if ($("#" + tab).length > 0)
        {
            $('#' + tab).spin('tiny');
            $('#' + tab).children('.badge_counter').hide();
            $('#browseGroupDetail .current').removeClass('current');
            $('#' + tab).parent().addClass('current');

            $('#profile-content').load( $('#' + tab).attr('data-url'), {noCache: 1}, function(response){
                $('#' + tab).spin(false);
                $('#' + tab).children('.badge_counter').fadeIn();

                // reattach events
                $('textarea').autogrow();
                $(".tip").tipsy({ 
                    html: true, 
                    gravity: 's' 
                });
                mooOverlay.registerOverlay();
            });
        }
	
    }
    
    var inviteMore = function()
    {
        var group_id = $('.groupId').attr('data-id');
        $('#themeModal .modal-content').load(mooConfig.url.base + '/groups/ajax_invite/' + group_id);
    }

    // app/Plugin/Group/View/Elements/lists/groups_list.ctp
    var initOnListing = function () {
        mooBehavior.initMoreResults();
        
        // bind action to button delete
        deleteGroup();
    }

    var deleteGroup = function () {
        
        $('.deleteGroup').unbind('click');
        $('.deleteGroup').click(function () {
            
            var data = $(this).data();
            var deleteUrl = mooConfig.url.base + '/groups/do_delete/' + data.id;
            mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_remove_this_group_br_all_group_contents_will_also_be_deleted'), deleteUrl);
        });
    }
    
    // app/Plugin/Topic/View/Elements/ajax/group_topic.ctp
    var initOnTopicList  = function(){
        
        // bind action delete a topic in group
        $('.deleteTopic').unbind('click');
        $('.deleteTopic').on('click', function(){
            var data = $(this).data();
            deleteGroupTopic(data.id, data.group);
        });
        
        // bind action create topic in group
        $('.createGroupTopic').unbind('click');
        $('.createGroupTopic').on('click', function(){
            loadPage('topics', mooConfig.url.base + '/topics/group_create');
        });
        
        $('.ajaxLoadTopicDetail').unbind('click');
        $('.ajaxLoadTopicDetail').on('click', function(){
            var data = $(this).data();
            loadPage('topics', data.url);
        });
        
        $('.ajaxLoadTopicEdit').unbind('click');
        $('.ajaxLoadTopicEdit').on('click', function(){
            var data = $(this).data();
            loadPage('topics', data.url);
        });
        
        mooBehavior.initMoreResults();
    }
    
    // app/Plugin/Topic/View/Topics/ajax_view.ctp
    var initOnAjaxViewTopic = function(url){
        $('.ajaxLoadTopicEdit').unbind('click');
        $('.ajaxLoadTopicEdit').on('click', function(){
            var data = $(this).data();
            loadPage('topics', data.url);
        });
        
        // bind action delete a topic in group
        $('.deleteTopic').unbind('click');
        $('.deleteTopic').on('click', function(){
            var data = $(this).data();
            deleteGroupTopic(data.id, data.group);
        });

        window.history.pushState({}, "", url);
    }
    
    // app/Plugin/Topic/View/Topics/group_create.ctp
    var initOnCreateGroupTopic = function(){
        cancelGroupTopic();
        
        $('#toggleUploader').unbind('click');
        $('#toggleUploader').on('click', function(){
            mooTopic.toggleUploader();
        });
        
        $('#ajaxCreateButton').unbind('click');
        $('#ajaxCreateButton').on('click', function(){
            ajaxCreateItem('topics', true);
        });
        
        // bind action delete topic
        $('.deleteTopic').unbind('click');
        $('.deleteTopic').on('click', function(){
            var data = $(this).data();
            deleteGroupTopic(data.id, data.group);
        });
        
        var tiny_plugins = "advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table  directionality emoticons template paste textcolor";
        if (mooConfig.isMobile){
            tiny_plugins = "textcolor emoticons fullscreen";
        }
        
        tinyMCE.remove("textarea#editor");
        tinyMCE.init({
            selector: "textarea#editor",
            language : mooConfig.tinyMCE_language,
            skin: mooConfig.tinyMCE_skin,
            content_css: mooConfig.tinyMCE_content_css,
            content_style: mooConfig.tinyMCE_content_style,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            plugins: [tiny_plugins],
            toolbar1: "styleselect | bold italic | bullist numlist outdent indent | forecolor backcolor emoticons | link unlink anchor image | preview fullscreen code",
            image_advtab: true,
            image_dimensions: false,
            width: '100%',
            height: '300px',
            menubar: false,
            forced_root_block : 'div',
            relative_urls : false,
            remove_script_host : true,
            document_base_url : mooConfig.url.base,
            browser_spellcheck: true,
            contextmenu: false,
            entity_encoding: 'raw',
            directionality : mooConfig.site_directionality
        });
    }
    
    var deleteGroupTopic = function(topic_id, group_id){
        
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('btn_ok'),
            btn_cancel: mooPhrase.__('btn_cancel'),
            callback: function(){
                $.post( mooConfig.url.base  + '/topics/ajax_delete/' + topic_id, function(data){ 
                    loadPage('topics', mooConfig.url.base + '/topics/browse/group/' + group_id);

                    if ( $("#group_topics_count").html() != '0' ){
                        $("#group_topics_count").html( parseInt($("#group_topics_count").html()) - 1 );
                    }
                });     
            },
            title: mooPhrase.__('please_confirm'),
            contents: mooPhrase.__('are_you_sure_you_want_to_remove_this_topic'),
            model: 'confirm', 
            hideFooter: false, 
            closeButton: false        
        }).showModal();
    }
    
    var cancelGroupTopic = function(){
        // cancel when create new topic
        $('.cancelTopic').unbind('click');
        $('.cancelTopic').on('click', function(){
            var data = $(this).data();
            $('#profile-content').load( data.url , {noCache: 1}, function(response){
                $("#profile-content").html(response);
            });
        });
        
        // cancel when edit topic
        $('.cancelTopic1').unbind('click');
        $('.cancelTopic1').on('click', function(){
            var data = $(this).data();
            loadPage('topics', data.url);
        });
        
    }

    var removeMember = function (id)
    {
        $.fn.SimpleModal({
            btn_ok : mooPhrase.__('btn_ok'),
            btn_cancel: mooPhrase.__('btn_cancel'),
            callback: function () {
                $.post(mooConfig.url.base + '/groups/ajax_remove_member', {id: id}, function () {
                    $('#member_' + id).fadeOut();

                    if ($("#group_user_count").html() != '0') {
                        $("#group_user_count").html(parseInt($("#group_user_count").html()) - 1);
                    }
                });
            },
            title: mooPhrase.__('please_confirm'),
            contents: mooPhrase.__('are_you_sure_you_want_to_remove_this_member'),
            model: 'confirm', 
            hideFooter: false, 
            closeButton: false
        }).showModal();

        return false;
    }

    var changeAdmin = function (id, type)
    {
        var msg = mooPhrase.__('are_you_sure_you_want_to_make_this_member_a_group_admin');
        if (type == 'remove') {
            msg = mooPhrase.__('are_you_sure_you_want_to_demote_this_group_admin');
        }

        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('btn_ok'),
            btn_cancel: mooPhrase.__('btn_cancel'),
            callback: function () {
                $.post(mooConfig.url.base + '/groups/ajax_change_admin', {id: id, type: type}, function () {
                    window.location.reload();
                });
            },
            title: mooPhrase.__('please_confirm'),
            contents: msg,
            model: 'confirm', 
            hideFooter: false, 
            closeButton: false
        }).showModal();

        return false;
    }

    var loadPage = function (link_id, url, jsonView){
        
        $('#' + link_id).children('.badge_counter').hide();
        $('#' + link_id).spin('tiny');
        
        var group_id = $('.groupId').attr('data-id');
        
        mooAjax.post({
            url: url,
            data: {
                group_id: group_id
            }
        }, function (response) {

            $('#' + link_id).children('.badge_counter').fadeIn();
            $('#' + link_id).spin(false);

            if (jsonView) {
                $('#profile-content').html(response.data);
            }
            else {
                $('#profile-content').html(response);
            }

            // reattach events
            $('textarea').autogrow();
            
            $(".tip").tipsy({html: true, gravity: 's'});
            
            mooOverlay.registerImageOverlay();
            
            $('.tipsy').remove();

            // init mooMention
            mooMention.init('postComment');
            
            // init mooToggleEmoji
            mooToggleEmoji.init($(response).find('textarea').attr('id'), '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');

        });
    }

    var ajaxCreateItem = function (type, jsonView){
        var ext = '';
        var ajax_save = 'save';
        if (type == 'topics'){
            $('#editor').val(tinyMCE.activeEditor.getContent());
        }
        
        if (jsonView){
            ajax_save = 'save';
        }
        
        mooButton.disableButton('ajaxCreateButton');

        var is_edit = $("#createForm #id").val();
        
        mooAjax.post({
            url: mooConfig.url.base + "/" + type + "/" + ajax_save,
            data: $("#createForm").serialize()
        }, function (data) {

           mooButton.enableButton('ajaxCreateButton');

            var json = $.parseJSON(data);
            if (json.result == 1){
                
                loadPage(type, mooConfig.url.base + '/' + type + '/ajax_view/' + json.id + ext);

                if (is_edit === undefined) {
                    $("#group_" + type + "_count").html(parseInt($("#group_" + type + "_count").html()) + 1);
                }
            }
            else{
                
                $(".error-message").show();
                $(".error-message").html(json.message);
            }

        });
    }

    // init js for photo tab in a group
    // app/Plugin/Group/View/Elements/ajax/group_photo.ctp
    var initTabPhoto1 = function () {
        $('.groupUploadPhoto').unbind('click');
        $('.groupUploadPhoto').click(function(){
            
            var data = $(this).data();
            loadPage('photos', mooConfig.url.base + '/photos/ajax_upload/Group_Group/' + data.groupId+'?content=1');
        });
        
        mooBehavior.initMoreResults();
    }
    
    // app/Plugin/Photo/View/Photos/ajax_upload.ctp
    var initTabPhoto2 = function(){
        
        var newPhotos = [];
        var target_id = $('#target_id').val();
        var type = $('type').val();
        
        var uploader2 = new mooFileUploader.fineUploader({
            element: $('#photos_upload')[0],
            autoUpload: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span> ' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions : mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/photo/photo_upload/album/" + type + "/" + target_id
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                	if (!$.isEmptyObject(response))
                	{
	                    newPhotos.push( response.photo );
	                    $('#new_photos').val( newPhotos.join(',') );
	                    $('#nextStep').show();
                	}
                }
            }
        });

        $('#triggerUpload').unbind('click');
        $('#triggerUpload').click(function() {
            uploader2.uploadStoredFiles();
        });

        $('#nextStep').unbind('click');
        $('#nextStep').click(function(){
            $('#loadingSpin').spin('tiny');
            $('#uploadPhotoForm').submit();
            $(this).addClass('disabled');
        });
    }

    // init js for video tab in a group
    // app/Plugin/Video/View/Videos/group_fetch.ctp
    var initTabVideo = function () {
        
        // bind action button delete
        /*$('.deleteVideo').click(function(){
            var video_id = $(this).attr('data-id');
            var group_id = $(this).attr('data-group-id');
            var data = $(this).data();
            $('.modal').hide();
            
            $.fn.SimpleModal({
                btn_ok : mooPhrase.__('btn_ok'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                callback: function(){
                    $.post(mooConfig.url.base + '/videos/ajax_delete/' + video_id, function(data){
                        loadPage('videos', mooConfig.url.base + '/videos/browse/group/' + group_id);
                        if ( $("#group_videos_count").html() != '0' ){
                            $("#group_videos_count").html( parseInt($("#group_videos_count").html()) - 1 );
                        }
                    });	
                },
                title: mooPhrase.__('please_confirm'),
                contents: mooPhrase.__('are_you_sure_you_want_to_remove_this_video'),
                model: 'confirm', 
                hideFooter: false, 
                closeButton: true        
            }).showModal();
        });*/
        
        // bind action button cancel
        $('.cancelVideo').unbind('click');
        $('.cancelVideo').click(function(){
            
            var data = $(this).data();
            loadPage('videos', mooConfig.url.base + '/videos/ajax_view/' + data.id);
        });
        
        // bind action button save
        $('.saveVideo').unbind('click');
        $('.saveVideo').click(function(){
            $('#videoModal').modal('hide');
            ajaxCreateItem('videos', true)
        });
    }

    // init js for topic tab in a group
    var initTabTopic = function () {

    }

    return {
        initOnCreate : initOnCreate,
        initOnView : initOnView,
        initOnListing : initOnListing,
        initTabVideo : initTabVideo,
        initTabPhoto1 : initTabPhoto1,
        initTabPhoto2 : initTabPhoto2,
        initTabTopic : initTabTopic,
        initAjaxInvite : initAjaxInvite,
        initOnTopicList : initOnTopicList,
        initOnCreateGroupTopic : initOnCreateGroupTopic,
        removeMember : removeMember,
        changeAdmin : changeAdmin,
        loadPage : loadPage,
        initOnAjaxGroupVideo : initOnAjaxGroupVideo,
        initOnAjaxViewTopic : initOnAjaxViewTopic
    }
}));