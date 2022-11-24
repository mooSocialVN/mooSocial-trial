/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooFileUploader', 'mooBehavior', 'mooAlert', 'mooPhrase', 'mooUser', 'mooOverlay', 'mooGlobal', 'tinyMCE'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooBlog = factory();
    }
}(this, function ($, mooFileUploader, mooBehavior, mooAlert, mooPhrase, mooUser, mooOverlay, mooGlobal, tinyMCE) {

    // init js on blog create action
    // app/Plugin/Blog/View/Blogs/create.ctp
    var initOnCreate = function () {

        var uploader = new mooFileUploader.fineUploader({
            element: $('#photos_upload')[0],
            autoUpload: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions : mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/blog/blog_upload/images"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function (id, fileName, response) {
                	$('#blog_photo_ids').val($('#blog_photo_ids').val() + ',' + response.photo_id);
                    tinyMCE.activeEditor.insertContent('<p align="center"><a href="' + response.large + '" class="attached-image"><img src="' + response.thumb + '"></a></p><br>');
                }
            }
        });

        $('#triggerUpload').unbind('click');
        $('#triggerUpload').click(function () {
            uploader.uploadStoredFiles();
        });

        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            if (tinyMCE.activeEditor !== null) {
                $('#editor').val(tinyMCE.activeEditor.getContent());
            }
            mooBehavior.createItem('blogs', true);
        });

        var uploader1 = new mooFileUploader.fineUploader({
            element: $('#blog_thumnail')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit: mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/blog/blog_upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function (id, fileName, response) {
                    $('#blog_thumnail_preview > img').attr('src', response.thumb);
                    $('#blog_thumnail_preview > img').show();
                    $('#thumbnail').val(response.file);
                }
            }
        });
        
        // bind action to button delete
        deleteBlog();
        
        // toggleUploader
        $('#toggleUploader').unbind('click');
        $('#toggleUploader').on('click', function(){
            $('#images-uploader').slideToggle();
        });
    }

    // app/Plugin/Blog/View/Blogs/view.ctp
    var initOnView = function () {
        mooOverlay.registerImageOverlay();
        
        // bind action to button delete
        deleteBlog();
        
        // init action addfriend
        mooUser.initRespondRequest();
    }

    var initOnEdit = function () {

    }
    
    // app/Plugin/Blog/View/Elements/lists/blogs_list.ctp
    var initOnListing = function(){
        mooBehavior.initMoreResults();
        
        // bind action to button delete
        deleteBlog();
        
        $('.likeItem').unbind('click');
        $('.likeItem').click(function(){
            
            var obj = $(this);

            var data = $(this).data();
            
            var type = data.type;
            var item_id = data.id;
            var thumb_up = data.status;

            var isLike = false;
            if(obj.hasClass('active')){
                isLike = true;
            }

            if(obj.hasClass('do_ajax')){
                return;
            }
            obj.addClass('do_ajax');
            $.post(mooConfig.url.base + '/likes/ajax_add/' + type + '/' + item_id + '/' + thumb_up, { noCache: 1 }, function(data){
                try
                {
                    var res = $.parseJSON(data);
                    var eleParent = obj.parents('.like-section:first');
                    eleParent.find('.likeCount:first').html( parseInt(res.like_count) );
                    eleParent.find('.dislikeCount:first').html( parseInt(res.dislike_count) );

                    if ( thumb_up ) {
                        //obj.toggleClass('active');
                        //obj.next().next().removeClass('active');
                        eleParent.find('.likeItem').removeClass('active');
                        if(!isLike){
                            obj.addClass('active');
                        }
                    } else {
                        //obj.toggleClass('active');
                        //obj.prev().prev().removeClass('active');
                        eleParent.find('.likeItem').removeClass('active');
                        if(!isLike){
                            obj.addClass('active');
                        }
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
    
    var deleteBlog = function(){
        $('.deleteBlog').unbind('click');
        $('.deleteBlog').click(function(){
           
           var data = $(this).data();
           var deleteUrl = mooConfig.url.base + '/blogs/delete/' + data.id;
           mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_remove_this_entry'), deleteUrl);
        });
    }

    return {
        initOnCreate : initOnCreate,
        initOnView : initOnView,
        initOnEdit : initOnEdit,
        initOnListing : initOnListing
    }

}));