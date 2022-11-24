/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooBehavior', 'mooFileUploader', 'mooAjax', 'mooOverlay', 'mooAlert', 'mooPhrase', 'mooGlobal',
            'tinyMCE', 'mooUser'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooTopic = factory();
    }
}(this, function ($, mooBehavior, mooFileUploader, mooAjax, mooOverlay, mooAlert, mooPhrase, mooGlobal, tinyMCE, mooUser) {
    
    // app/Plugin/Topic/View/Topics/create.ctp
    // app/Plugin/Topic/View/Topics/group_create.ctp
    var initOnCreate = function () {
        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            if (tinyMCE.activeEditor !== null) {
                $('#editor').val(tinyMCE.activeEditor.getContent());
            }
            mooBehavior.createItem('topics', true);
        });
    
        var uploader = new mooFileUploader.fineUploader({
            element: $('#attachments_upload')[0],
            autoUpload: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo_attachment') +' </div>'
            },
            validation: {
                allowedExtensions: mooConfig.attachmentExt,
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/topic/topic_upload/attachments/" + $('#plugin_topic_id').val()
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    var attachs = $('#attachments').val();

                    if (response.attachment_id){
                        tinyMCE.activeEditor.insertContent('<p><a href="' + mooConfig.url.base + '/attachments/download/' + response.attachment_id + '" class="attached-file">' + response.original_filename + '</a></p><br>');
                        if ( attachs == '' ){
                            $('#attachments').val( response.attachment_id );
                        }
                        else{
                            $('#attachments').val(attachs + ',' + response.attachment_id);
                        }
                    }else if(response.thumb){                    	
                    	$('#topic_photo_ids').val($('#topic_photo_ids').val() + ',' + response.photo_id);
                        tinyMCE.activeEditor.insertContent('<p align="center"><a href="' + response.large + '" class="attached-image"><img src="' + response.thumb + '"></a></p><br>');
                    }
                }
            }
        });

        $('#triggerUpload').click(function() {
            uploader.uploadStoredFiles();
        });

        var uploader1 = new mooFileUploader.fineUploader({
            element: $('#topic_thumnail')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/topic/topic_upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    $('#topic_thumnail_preview > img').attr('src', response.thumb);
                    $('#topic_thumnail_preview > img').show();
                    $('#thumbnail').val(response.file_path);
                }
            }
        });

        $('.attach_remove').unbind('click');
        $('.attach_remove').click(function(){
            var obj = $(this);
            var data = $(this).data();
            mooAjax.post({
                url : mooConfig.url.base + '/attachments/ajax_remove/' + data.id
            }, function(data){
                obj.parent().fadeOut();
                var arr = $('#attachments').val().split(',');
                var pos = arr.indexOf(obj.attr('data-id'));
                arr.splice(pos, 1);
                $('#attachments').val(arr.join(','));
            });
            
            return false;
	});
        
        // bind action to button delete
        deleteTopic();
        
        // toggleUploader
        $('#toggleUploader').unbind('click');
        $('#toggleUploader').on('click', function(){
            $('#images-uploader').slideToggle();
        });
    }
    
    var toggleUploader = function() {
        $('#images-uploader').slideToggle();
    }
    
    // app/Plugin/Topic/View/Topics/view.ctp
    var initOnView = function(){
        mooOverlay.registerImageOverlay();
        
        // bind action to button delete
        deleteTopic();
    }
    
    // app/Plugin/Topic/View/Elements/lists/topics_list.ctp
    var initOnListing = function(){
        mooBehavior.initMoreResults();
        
        // bind action to button delete
        deleteTopic();
        
        $('.likeItem').unbind('click');
        $('.likeItem').click(function(){
            
            var obj = $(this);

            var data = $(this).data();
            
            var type = data.type;
            var item_id = data.id;
            var thumb_up = data.status;

            if(obj.hasClass('do_ajax')){
                return;
            }
            obj.addClass('do_ajax');
            $.post(mooConfig.url.base + '/likes/ajax_add/' + type + '/' + item_id + '/' + thumb_up, { noCache: 1 }, function(data){
                try
                {
                    var res = $.parseJSON(data);

                    obj.parents('.like-section:first').find('.likeCount:first').html( parseInt(res.like_count) );
                    obj.parents('.like-section:first').find('.dislikeCount:first').html( parseInt(res.dislike_count) );

                    if ( thumb_up )
                    {
                        obj.toggleClass('active');
                        obj.next().next().removeClass('active');
                    }
                    else
                    {
                        obj.toggleClass('active');
                        obj.prev().prev().removeClass('active');
                    }
                }
                catch (err)
                {
                    mooUser.validateUser();
                }
                obj.removeClass('do_ajax');
            });
        });
    }
    
    // app/Plugin/Topic/View/Elements/group/topics_list.ctp
    var initOnGroupListing = function(){
        mooBehavior.initMoreResults();
        
        // bind action to button delete
        deleteTopic();
        
        $('.likeItem').unbind('click');
        $('.likeItem').click(function(){
            
            var obj = $(this);
            
            var data = $(this).data();
            
            var type = data.type;
            var item_id = data.id;
            var thumb_up = data.status;
            
            $.post(mooConfig.url.base + '/likes/ajax_add/' + type + '/' + item_id + '/' + thumb_up, { noCache: 1 }, function(data){
                try
                {
                    var res = $.parseJSON(data);

                    obj.parents('.like-section:first').find('.likeCount:first').html( parseInt(res.like_count) );
                    obj.parents('.like-section:first').find('.dislikeCount:first').html( parseInt(res.dislike_count) );

                    if ( thumb_up )
                    {
                        obj.toggleClass('active');
                        obj.next().next().removeClass('active');
                    }
                    else
                    {
                        obj.toggleClass('active');
                        obj.prev().prev().removeClass('active');
                    }
                }
                catch (err)
                {
                    mooUser.validateUser();
                }
            });
        });
    }
    
    var deleteTopic = function(){
        $('.deleteTopic').unbind('click');
        $('.deleteTopic').click(function(){
           
           var data = $(this).data();
           var deleteUrl = mooConfig.url.base + '/topics/do_delete/' + data.id;
           mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_remove_this_topic'), deleteUrl);
        });
    }

    return {
        initOnCreate: initOnCreate,
        initOnView : initOnView,
        initOnListing : initOnListing,
        toggleUploader : toggleUploader,
        initOnGroupListing : initOnGroupListing
    }
}));