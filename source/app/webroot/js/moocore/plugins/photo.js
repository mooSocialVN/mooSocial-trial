/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooBehavior', 'mooAlert', 'mooAjax', 'mooPhrase', 'mooOverlay', 'mooPhotoTheater', 'mooLike',
            'hideshare', 'spinner'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooPhoto = factory();
    }
}(this, function ($, mooBehavior, mooAlert, mooAjax, mooPhrase, mooOverlay, mooPhotoTheater, mooLike) {

    var loaded = false;
    var is_tagging = false;
    var targetX, targetY, mouseX, mouseY, targetWidth, targetHeight, inputX, inputY;
    var photo_id = 0;
    var tagCounter = 0;
    var tag_uid = 0;
    var taguserid = 0;
    var page = 2;
    var ref = '';
    
    var init = function() {
        mooPhotoTheater.init();
    }

    var initOnCreateAlbum = function () {
        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            mooBehavior.createItem('albums', true);
        });
    }

    var initOnListing = function () {
        mooBehavior.initMoreResults();
        
        // bind action deleteAlbum
        deleteAlbum();
    }

    var initOnEditAlbum = function () {
        $('#select_photos').change(function () {
            if ($(this).val() == 'move') {
                $('#album_id_select').removeClass('hidden');
            }
            else {
                $('#album_id_select').addClass('hidden');
            }
        });

        // bind action deleteAlbum
        deleteAlbum();
    }

    var initOnViewAlbum = function () {
        // bind action deleteAlbum
        deleteAlbum();
    }

    // app/Plugin/Photo/View/Photos/view.ctp
    // app/Plugin/Photo/View/Elements/misc/photo_view_script.ctp
    // app/Plugin/Photo/View/Elements/ajax/photo_detail.ctp
    var initOnPhotoView = function (options) {   
        photo_id = options.photo_id;
        photo_thumb = options.photo_thumb;
        tag_uid = options.tag_uid;
        taguserid = options.taguserid;
        type = options.type;
        target_id = options.target_id;
        album_type = options.album_type;
        album_type_id = options.album_type_id;
        if (ref == '')
        	ref = options.ref;

        $('#photo_thumbs ul li').unbind('click');
        $('#photo_thumbs ul li:not(.viewmore-photo)').click(function () {
            $('#photo_thumbs ul li').removeClass('active');
            $(this).addClass('active');
        });

        $('#photo_thumb_' + photo_id).addClass('active');

        $(".sharethis").hideshare(
        {
            media: mooConfig.url.base + 'uploads/photos/thumbnail/' + photo_id + '/' + photo_thumb,
            linkedin: false
        });
        
        // init showPhotoWrapper app/Plugin/Photo/View/Elements/ajax/photo_detail.ctp
        $('#photo_src').on('load', function(){
            showPhotoWrapper();
        });
        
        // init delete photo
        $('#delete_photo').unbind('click');
        $('#delete_photo').on('click', function(){
            var data = $(this).data();
            deletePhoto(data.nextPhoto);
        });
        
        // init set as cover
        $('.set_cover').unbind('click');
        $('.set_cover').on('click', function(){
            set_photo_as_cover();
        });
        
        // init set as profile picture
        $('.set_avatar').unbind('click');
        $('.set_avatar').on('click', function(){
            set_photo_as_profile_picture();
        });
        
        // init  Tag Photo
        $('#tagPhoto').unbind('click');
        $('#tagPhoto').click(function () {
            if (!is_tagging)
            {
                tagPhoto();
            }
            else
            {
                doneTagging();
            }
        });
        
        // init photoDetailTags
        $('.photoDetailTags')
        .on('mouseout', function(){
            var data = $(this).data();
            hideTag('0-' + data.tagId)
        })
        .on('mouseover', function(){
            var data = $(this).data();
            showTag('0-' + data.tagId)
        });
        
        // init photoDetailRemoveTags
        $('.photoDetailRemoveTags').unbind('click');
        $('.photoDetailRemoveTags').on('click', function(){
            var data = $(this).data();
            removeTag('0-'  + data.id, data.id);
        });
        
        // init like
        mooLike.initLikePhoto();
        
        // initShowPhoto        
        initShowPhoto();
        checkShowPhotoTags();

        $('#photo_load_btn').unbind('click');
        $('#photo_load_btn').on('click',function(){
            loadMoreThumbs();
        });
        
        initRotatePhoto();
        
        $('#photo_close_icon').attr('href',ref);
    };
    
    var initShowPhoto = function(){
        $('.showPhoto').unbind('click');
        $('.showPhoto').on('click', function(){
            var data = $(this).data();
            showPhoto(data.id);
        });
        
        initBackHistoryPhoto();
    }
    
    var initBackHistoryPhoto = function () {
        $(window).unbind('popstate');
        $(window).on('popstate', function() {
        	try
        	{
        		var url = window.location.href.split("?")[0];
        		url = url.replace(window.location.origin,'');
        		url = url.replace(mooConfig.url.base+'/photos/view/','');
        		if (!isNaN(parseInt(url)))
    			{
        			showPhoto(url,true)
    			}
        	}
        	catch(e)
        	{
        		
        	}
        });
    }

    var checkShowPhotoTags = function () {
        if($('#tags').find('.photoDetailTags').length > 0){
            $('#tags').show();
        }else {
            $('#tags').hide();
        }
    }

    var initRotatePhoto = function(){
        var isRefeshPageAfterClosingTheater = false;
        $('#photoModal').on('hidden.bs.modal', function () {
            if(isRefeshPageAfterClosingTheater){
                location.reload();
            }
        });
        $('.rotate_img').unbind('click');
        $('.rotate_img').on('click', function(){
            $('.rotate_img').hide();
            var data = $(this).data();
            $('#photo_wrapper').spin('large');
            var photo_id = data.id;
            $.post(mooConfig.url.base + '/photos/ajax_rotate', {id: photo_id, mode:data.mode}, function (data){
                isRefeshPageAfterClosingTheater = true;
                dataJson = JSON.parse(data);
                console.log(dataJson["1500"]);
                $('#photo_wrapper').spin(false);
                $('.rotate_img').show();
                //$('#photo_src').attr('src', $('#photo_src').attr('src') + '?' + (new Date).getTime());
                $('#photo_src').attr('src', dataJson["1500"]);
                //$("#photo_thumb_" + photo_id + " > a > img").attr('src', $("#photo_thumb_" + photo_id + " > a > img").attr('src')+ '?' + (new Date).getTime());
                $("#photo_thumb_" + photo_id + " > a > img").attr('src', dataJson["75_square"]);
                if($("#layer_square_modal_" + photo_id).length){
                      var bg = $("#layer_square_modal_" + photo_id).css('background-image');
                       bg = bg.replace(/^url\(['"]?/,'').replace(/['"]?\)$/,'');
                       bg += '?' + (new Date).getTime();
                       $("#layer_square_modal_" + photo_id).css('background-image', 'url(' + bg + ')');
                }
                
                if($("#layer_square_" + photo_id).length){
                      var bg = $("#layer_square_" + photo_id).css('background-image');
                       bg = bg.replace(/^url\(['"]?/,'').replace(/['"]?\)$/,'');
                       bg += '?' + (new Date).getTime();
                    $("#layer_square_" + photo_id).css('background-image', 'url(' + bg + ')');
                }
                
                $('.photoModal').each(function(){
                   var img_el = $(this).find('img:first');
                   img_el.attr('src',img_el.attr('src') + '?' + (new Date).getTime())
                });
            });
            
        });
    }
    
    var loadMoreThumbs = function(){

        $('#photo_wrapper').spin('large');
        
        $.post(mooConfig.url.base + '/photos/ajax_fetch', {type: type, album_type:album_type, album_type_id: album_type_id, target_id: target_id, page: page,taguserid:taguserid}, function (data)
        {
            $('#photo_wrapper').spin(false);
            if (data != '')
            {
                page++;
                $('#photo_thumbs ul').append(data);
                $('#photo_load_btn').parent().remove();

                $('#photo_load_btn').unbind('click');
                $('#photo_load_btn').on('click',function(){
                    loadMoreThumbs();
                });

                $('.showPhoto').unbind('click');
                $('.showPhoto').on('click', function(){
                    var data = $(this).data();
                    showPhoto(data.id);
                });
            }
        });
    }


    var showPhotoWrapper = function () {

        if (loaded) {
            return;
        }

        loaded = true;

        var preload = $('#preload').html();

        if (preload != '') {

            $('#preload').html('');
            $('#photo-content').html(preload);
            mooOverlay.registerOverlay();

            $(".sharethis").hideshare(
                    {
                        media: $('#photo_src').attr('src'),
                        linkedin: false,
                        link: window.location.href
                    });

            if (is_tagging) {
                tagPhoto();
            }
        }

        $('#photo_wrapper').fadeIn();
    }

    var set_photo_as_cover = function () {
        
        $('#set_cover').spin('tiny');

        $.post(mooConfig.url.base + '/users/set_photo_as_cover', {photo_id: photo_id}, function (response)
        {
            var data = $.parseJSON(response);
            window.location = data.url;
        });
    }

    var tagPhoto = function () {

        is_tagging = true;
        $("#tag-wrapper img").css('cursor', 'crosshair');

        $("#tagPhoto a").html(mooPhrase.__('done_tagging'));

        $("#tag-wrapper img").unbind('click');
        $("#tag-wrapper img").click(function (e) {

            if (is_tagging) {
                //Determine area within element that mouse was clicked
                mouseX = e.pageX - $("#tag-wrapper").offset().left;
                mouseY = e.pageY - $("#tag-wrapper").offset().top;

                //Get height and width of #tag-target
                targetWidth = $("#tag-target").outerWidth();
                targetHeight = $("#tag-target").outerHeight();

                //Determine position for #tag-target
                targetX = mouseX - targetWidth / 2;
                targetY = mouseY - targetHeight / 2;

                //Determine position for #tag-input
                inputX = mouseX + targetWidth / 2;
                inputY = mouseY - targetHeight / 2;

                //Animate if second click, else position and fade in for first click
                if ($("#tag-target").css("display") == "block")
                {
                    $("#tag-target").animate({left: targetX, top: targetY}, 500);
                    $("#tag-input").animate({left: inputX, top: inputY}, 500);
                } else {
                    $("#tag-target").css({left: targetX, top: targetY}).fadeIn();
                    $("#tag-input").css({left: inputX, top: inputY}).fadeIn();
                }

                //Give input focus
                $("#tag-name").focus();

                $("#friends_list").html($("#friends").html());
                
                // init friends_list tagFriends
                $('.tagFriends').unbind('click');
                $('.tagFriends').on('click', function(){
                    var data = $(this).data();
                    submitTag(data.id, data.tagValue);
                });
            }
        });

        //If cancel button is clicked
        $('#tag-cancel').unbind('click');
        $('#tag-cancel').click(function () {
            closeTagInput();
            return false;
        });

        //If enter button is clicked within #tag-input
        $("#tag-name").keyup(function (e) {
            if (e.keyCode == 13) {
                submitTag(0, '');
            }
        });

        //If submit button is clicked
        $('#tag-submit').unbind('click');
        $('#tag-submit').click(function () {
            submitTag(0, '');
            return false;
        });
        
    }


    var deletePhoto = function (nextPhoto) {
        nextPhoto = typeof nextPhoto !== 'undefined' ? nextPhoto : '0';
        mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_delete_this_photo'), mooConfig.url.base + '/photos/ajax_remove/photo_id:' + photo_id + '/next_photo:' + nextPhoto);
    }


    var submitTag = function (uid, tagValue)
    {
        if (uid != '' || $("#tag-name").val() != '')
        {
            var style = 'left:' + targetX + 'px; top:' + targetY + 'px';
            $('#photo_wrapper').spin('large');
            $.post(mooConfig.url.base + '/photos/ajax_tag',
                    {
                        photo_id: photo_id,
                        uid: uid,
                        value: $("#tag-name").val(),
                        style: style
                    }, function (data) {
                $('#photo_wrapper').spin(false);

                var json = $.parseJSON(data);

                if (json.result == 1)
                {
                    if (uid) {
                        tagValue = '<a href="' + mooConfig.url.base + '/users/view/' + uid + '">' + tagValue + '</a>';
                    }
                    else {
                        tagValue = $("#tag-name").val();
                    }

                    $("#tags").find('.photo-list-tags').append('<span class="photoDetailTags" id="hotspot-item-'+tagCounter+'-'+json.id+'" data-tag-id="'+json.id+'" id="hotspot-item-' + tagCounter + '">' + tagValue + '<a class="photoDetailRemoveTags" data-id="'+json.id+'" href="javascript:void(0)"><i class="material-icons cross-icon-sm">clear</i></a></span>');
                    $("#tag-wrapper").append('<div id="hotspot-' + tagCounter + '-' + json.id +'" class="hotspot" style="' + style + '"><span>' + tagValue + '</span></div>');

                    //Adds a new hotspot to image
                    closeTagInput();
                    tagCounter++;

                    checkShowPhotoTags();
                    
                    // init photoDetailTags
                    $('.photoDetailTags').off('mouseout');
                    $('.photoDetailTags').off('mouseover');
                    $('.photoDetailTags')
                    .on('mouseout', function(){
                        var data = $(this).data();
                        hideTag('0-' + data.tagId)
                    })
                    .on('mouseover', function(){
                        var data = $(this).data();
                        showTag('0-' + data.tagId)
                    });
                    
                    // init photoDetailRemoveTags
                    $('.photoDetailRemoveTags').unbind('click');
                    $('.photoDetailRemoveTags').on('click', function(){
                        var data = $(this).data();
                        removeTag('0-'  + data.id, data.id);
                    });
                }
                else {
                    mooAlert.alert(json.message);
                }
            });
        }
    }

    var set_photo_as_profile_picture = function () {
        
        $('#set_avatar').spin('tiny');
        
        $.post(mooConfig.url.base + '/users/set_photo_as_profile_picture', {photo_id: photo_id}, function (response)
        {
            var data = $.parseJSON(response);
            window.location = data.url;
        });
    }

    var showPhoto = function (id, no_change_url){
    	no_change_url = typeof no_change_url !== 'undefined' ? no_change_url : false;
        photo_id = id;
        $('#photo_wrapper').spin('large');
        var url = '';
        loaded = false;

        if (tag_uid) {
            url = id + '/uid:' + tag_uid;
        }else
        if (taguserid)
        {
        	url = id + '?uid=' + taguserid;
        }
        else {
            url = id;
        }
        
        $('#preload').load(mooConfig.url.base + '/photos/ajax_view/' + url, {noCache: 1}, function () {
            $('#photo_thumbs .active').removeClass('active');
            $('#photo_thumb_' + id).addClass('active');
            
            var preload = $('#preload').html();
        
            if (preload != '') {

                $('#preload').html('');
                $('#photo-content').html(preload);
                mooOverlay.registerOverlay();

                $(".sharethis").hideshare(
                {
                    media: $('#photo_src').attr('src'),
                    linkedin: false,
                    link: window.location.href
                });

                if (is_tagging) {
                    tagPhoto();
                }
            }

            $('#photo_wrapper').fadeIn();
        });

        if (!no_change_url)
        {
	        window.history.pushState({photo_id: photo_id}, "", mooConfig.url.base + '/photos/view/' + url);
	        window.history.replaceState({photo_id: photo_id}, "", mooConfig.url.base + '/photos/view/' + url);
    	}

    }


    var doneTagging = function () {
        is_tagging = false;
        $("#tag-wrapper img").css('cursor', 'default');
        $("#tagPhoto a").html(mooPhrase.__('tag_photo'));

        $('#tag-name').unbind();
        $('#tag-submit').unbind();
        closeTagInput();
    }

    var closeTagInput = function () {
        $("#tag-target").fadeOut();
        $("#tag-input").fadeOut();
        $("#tag-name").val("");
    }

    var removeTag = function (i, tag_id) {
        $("#hotspot-item-" + i).remove();
        $("#hotspot-" + i).remove();
        checkShowPhotoTags();
        $.post(mooConfig.url.base + '/photos/ajax_remove_tag', {tag_id: tag_id});
    }

    var showTag = function (i) {
        $("#hotspot-" + i).addClass("hotspothover");
    }

    var hideTag = function (i) {
        $("#hotspot-" + i).removeClass("hotspothover");
    }

    var deleteAlbum = function () {
        $('.deleteAlbum').unbind('click');
        $('.deleteAlbum').click(function () {

            var data = $(this).data();
            var deleteUrl = mooConfig.url.base + '/albums/do_delete/' + data.id;
            mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_delete_this_album_all_photos_will_also_be_deleted'), deleteUrl);
        });
    }
    

    return {
        init : init,
        initOnCreateAlbum : initOnCreateAlbum,
        initOnListing : initOnListing,
        initOnEditAlbum : initOnEditAlbum,
        initOnViewAlbum : initOnViewAlbum,
        initOnPhotoView : initOnPhotoView,
        initShowPhoto : initShowPhoto
    }
}));