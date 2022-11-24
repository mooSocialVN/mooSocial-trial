/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooFileUploader', 'mooGlobal','mooMention'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooAttach = factory();
    }
}(this, function ($, mooFileUploader, mooGlobal, mooMention) {
    
    // app/View/Activities/ajax_share.ctp
    // app/View/Elements/activities.ctp
    // app/View/Elements/comment_form.ctp
    var registerAttachComment = function(id, type){
        if(typeof type == "undefined") {
            type = '';
        }
        else {
            type = '#' + type + ' ';
        }
        if($(type + '#comment_button_attach_'+id).length > 0) {
            var uploader = new mooFileUploader.fineUploader({
                element: $(type + '#comment_button_attach_'+id)[0],
                text: {
                    uploadButton: '<div class="comment-upload-section"><span class="post-area-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit: mooConfig.sizeLimit
                },
                multiple: false,
                request: {
                    endpoint: mooConfig.url.base+"/upload/wall"
                },
                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id_img, fileName){
                        var element = $('<span id="attach_'+id+'_'+id_img+'" style="background-image:url('+mooConfig.url.base+'/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                        $(type + '#comment_preview_image_'+id).append(element);
                        $(type + '#comment_button_attach_'+id).hide();

                        $('body').trigger('onSubmitRegisterAttachCommentCallback',[{id: id, type:type}]);
                    },
                    onComplete: function(id_img, fileName, response, xhr) {
                        $(this.getItemByFileId(id_img)).remove();
                        img = $('<img src="'+ mooConfig.url.base + '/' +response.photo+'">');
                        img.load(function() {
                            var element = $('#attach_'+id+'_'+id_img);
                            element.attr('style','background-image:url(' + mooConfig.url.base + '/' + response.photo + ')');
                            var deleteItem = $('<a href="javascript:void(0);"><i class="material-icons thumb-review-delete">clear</i></a>');
                            element.append(deleteItem);
                            
                            element.find('.thumb-review-delete').unbind('click');
                            element.find('.thumb-review-delete').click(function(){
                                element.remove();
                                $(type + '#comment_button_attach_'+id).show();
                                $(type + '#comment_image_'+id).val('');

                                $('body').trigger('onCompleteRegisterAttachCommentDeleteThumbCallback',[{id: id, type:type}]);
                                });

                            $('body').trigger('onCompleteRegisterAttachCommentImageLoadedCallback',[{id: id, type:type}]);
                        });
                        //clear parse link
                        $('.cmt_preview_link').remove();
                        $('#userCommentLink'+id).val('');
                        $('#userCommentVideo'+id).val('');
                        $('#userCommentEditLink'+id).val('');
                        $('#userCommentEditVideo'+id).val('');

                        if($('#photoModal #photo-content').length) {
                            $('#photoModal #userCommentLink' + id).val('');
                            $('#photoModal #userCommentVideo' + id).val('');
                            $('#photoModal #userCommentEditLink' + id).val('');
                            $('#photoModal #userCommentEditVideo' + id).val('');
                        }

                        $(type + '#comment_image_'+id).val(response.photo);

                        $('body').trigger('onCompleteRegisterAttachCommentCallback',[{id: id, type:type}]);
                    }
                }
            });
        }
    };
    
    var registerAttachCommentEdit = function(type,id){
        if($('#'+type+'_comment_attach_'+id).length > 0) {
            var uploader = new mooFileUploader.fineUploader({
                element: $('#'+type+'_comment_attach_'+id)[0],
                text: {
                    uploadButton: '<div class="comment-upload-section"><span class="post-area-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit: mooConfig.sizeLimit
                },
                multiple: false,
                request: {
                    endpoint: mooConfig.url.base+"/upload/wall"
                },
                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id_img, fileName){
                        var element = $('<span id="attach_'+'_'+id+'_'+id_img+'" style="background-image:url('+mooConfig.url.base+'/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                        $('#'+type+'_comment_preview_attach_'+id).append(element);
                        $('#'+type+'_comment_attach_'+id).hide(); 
                        
                        $('body').trigger('onSubmitRegisterAttachCommentEditCallback',[{id: id, type:type}]);
                    },
                    onComplete: function(id_img, fileName, response, xhr) {
                            $(this.getItemByFileId(id_img)).remove()

                            img = $('<img src="'+ mooConfig.url.base + '/' +response.photo+'">');
                    img.load(function() {
                            var element = $('#attach_'+'_'+id+'_'+id_img);
                            element.attr('style','background-image:url(' + mooConfig.url.base + '/' + response.photo + ')');
                        var deleteItem = $('<a href="javascript:void(0);"><i class="material-icons thumb-review-delete">clear</i></a>');
                        element.append(deleteItem);
                        
                        element.find('.thumb-review-delete').unbind('click');
                        element.find('.thumb-review-delete').click(function(){
                            element.remove();
                            $('#'+type+'_comment_attach_'+id).show();
                            $('#'+type+'_comment_attach_id_'+id).val('');
                            
                            $('body').trigger('onCompleteRegisterAttachCommentEditDeleteThumbCallback',[{id: id, type:type}]);
                        });
                        
                        $('body').trigger('onCompleteRegisterAttachCommentEditImageLoadedCallback',[{id: id, type:type}]);
                    })

                        $('#'+type+'_comment_attach_id_'+id).val(response.photo);
                        $('#'+type+'_comment_attach_'+id).hide();

                        $('body').trigger('onCompleteRegisterAttachCommentEditCallback',[{id: id, type:type}]);
                        
                        //clear parse link
                        $('.cmt_preview_link').remove();
                        $('#userCommentLink'+id).val('');
                        $('#userCommentVideo'+id).val('');
                        $('#userCommentEditLink'+id).val('');
                        $('#userCommentEditVideo'+id).val('');
                    }
                }
            });
        }
    };

    var registerAttachCommentReplay = function(id, type){
        mooMention.init('commentReplyForm'+id);
        if(typeof type == "undefined")
        {
            type = '';
        }
        else
        {
            type = '#' + type + ' ';
        }
        if($(type + '#comment_reply_button_attach_'+id).length > 0){
            var uploader = new mooFileUploader.fineUploader({
                element: $(type + '#comment_reply_button_attach_'+id)[0],
                text: {
                    uploadButton: '<div class="comment-upload-section"><span class="post-area-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit: mooConfig.sizeLimit
                },
                multiple: false,
                request: {
                    endpoint: mooConfig.url.base+"/upload/wall"
                },
                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id_img, fileName){
                        var element = $('<span id="attach_'+id+'_'+id_img+'" style="background-image:url('+mooConfig.url.base+'/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                        $(type + '#comment_reply_preview_image_'+id).append(element);
                        $(type + '#comment_reply_button_attach_'+id).hide();
                    },
                    onComplete: function(id_img, fileName, response, xhr) {
                        $(this.getItemByFileId(id_img)).remove();
                        img = $('<img src="'+ mooConfig.url.base + '/' +response.photo+'">');
                        img.load(function() {
                            var element = $('#attach_'+id+'_'+id_img);
                            element.attr('style','background-image:url(' + mooConfig.url.base + '/' + response.photo + ')');
                            var deleteItem = $('<a href="javascript:void(0);"><i class="material-icons thumb-review-delete">clear</i></a>');
                            element.append(deleteItem);

                            element.find('.thumb-review-delete').unbind('click');
                            element.find('.thumb-review-delete').click(function(){
                                element.remove();
                                $(type + '#comment_reply_button_attach_'+id).show();
                                $(type + '#comment_reply_image_'+id).val('');
                            });
                        });

                        $(type + '#comment_reply_image_'+id).val(response.photo);

                        //clear parse link
                        $('#userReplyLink'+id).val('');
                        $('#userReplyVideo'+id).val('');
                    }
                }
            });
        }
    };

    var registerAttachActivityCommentReplay = function(id, type){
        mooMention.init('activitycommentReplyForm'+id);
        if(typeof type == "undefined")
        {
            type = '';
        }
        else
        {
            type = '#' + type + ' ';
        }
        if ($(type + '#activitycomment_reply_button_attach_'+id).length > 0){
            var uploader = new mooFileUploader.fineUploader({
                element: $(type + '#activitycomment_reply_button_attach_'+id)[0],
                text: {
                    uploadButton: '<div class="comment-upload-section"><span class="post-area-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit: mooConfig.sizeLimit
                },
                multiple: false,
                request: {
                    endpoint: mooConfig.url.base+"/upload/wall"
                },
                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id_img, fileName){
                        var element = $('<span id="attach_'+id+'_'+id_img+'" style="background-image:url('+mooConfig.url.base+'/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                        $(type + '#activitycomment_reply_preview_image_'+id).append(element);
                        $(type + '#activitycomment_reply_button_attach_'+id).hide();
                    },
                    onComplete: function(id_img, fileName, response, xhr) {
                        $(this.getItemByFileId(id_img)).remove();
                        img = $('<img src="'+ mooConfig.url.base + '/' +response.photo+'">');
                        img.load(function() {
                            var element = $('#attach_'+id+'_'+id_img);
                            element.attr('style','background-image:url(' + mooConfig.url.base + '/' + response.photo + ')');
                            var deleteItem = $('<a href="javascript:void(0);"><i class="material-icons thumb-review-delete">clear</i></a>');
                            element.append(deleteItem);

                            element.find('.thumb-review-delete').unbind('click');
                            element.find('.thumb-review-delete').click(function(){
                                element.remove();
                                $(type + '#activitycomment_reply_button_attach_'+id).show();
                                $(type + '#activitycomment_reply_image_'+id).val('');
                            });
                        });

                        $(type + '#activitycomment_reply_image_'+id).val(response.photo);

                        //clear parse link
                        $('#userReplyLink'+id).val('');
                        $('#userReplyVideo'+id).val('');
                    }
                }
            });
        }
    };

    var registerAttachCommentItemReplay = function(id, type){
        mooMention.init('item_commentReplyForm'+id);
        if(typeof type == "undefined")
        {
            type = '';
        }
        else
        {
            type = '#' + type + ' ';
        }
        if($(type + '#item_comment_reply_button_attach_'+id).length > 0) {
            var uploader = new mooFileUploader.fineUploader({
                element: $(type + '#item_comment_reply_button_attach_'+id)[0],
                text: {
                    uploadButton: '<div class="comment-upload-section"><span class="post-area-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span></div>'
                },
                validation: {
                    allowedExtensions: mooConfig.photoExt,
                    sizeLimit: mooConfig.sizeLimit
                },
                multiple: false,
                request: {
                    endpoint: mooConfig.url.base+"/upload/wall"
                },
                callbacks: {
                    onError: mooGlobal.errorHandler,
                    onSubmit: function(id_img, fileName){
                        var element = $('<span id="attach_'+id+'_'+id_img+'" style="background-image:url('+mooConfig.url.base+'/img/indicator.gif);background-size:inherit;background-repeat:no-repeat"></span>');
                        $(type + '#item_comment_reply_preview_image_'+id).append(element);
                        $(type + '#item_comment_reply_button_attach_'+id).hide();
                    },
                    onComplete: function(id_img, fileName, response, xhr) {
                        $(this.getItemByFileId(id_img)).remove();
                        img = $('<img src="'+ mooConfig.url.base + '/' +response.photo+'">');
                        img.load(function() {
                            var element = $('#attach_'+id+'_'+id_img);
                            element.attr('style','background-image:url(' + mooConfig.url.base + '/' + response.photo + ')');
                            var deleteItem = $('<a href="javascript:void(0);"><i class="material-icons thumb-review-delete">clear</i></a>');
                            element.append(deleteItem);

                            element.find('.thumb-review-delete').unbind('click');
                            element.find('.thumb-review-delete').click(function(){
                                element.remove();
                                $(type + '#item_comment_reply_button_attach_'+id).show();
                                $(type + '#item_comment_reply_image_'+id).val('');
                            });
                        });

                        $(type + '#item_comment_reply_image_'+id).val(response.photo);

                        //clear parse link
                        $('#userReplyLink'+id).val('');
                        $('#userReplyVideo'+id).val('');
                    }
                }
            });
        }
    };
    
    return {
        registerAttachComment : registerAttachComment,
        registerAttachCommentEdit : registerAttachCommentEdit,
        registerAttachCommentReplay : registerAttachCommentReplay,
        registerAttachActivityCommentReplay : registerAttachActivityCommentReplay,
        registerAttachCommentItemReplay: registerAttachCommentItemReplay
    }   
}));

