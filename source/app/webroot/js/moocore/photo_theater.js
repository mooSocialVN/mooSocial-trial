/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooPhrase', 'mooMention', 'mooToggleEmoji', 'mooBehavior', 'mooAlert', 'mooTooltip','mooUser', 'elastislide'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooPhotoTheater = factory();
    }
}(this, function ($, mooPhrase, mooMention, mooToggleEmoji, mooBehavior, mooAlert, mooTooltip, mooUser) {
    
    var photo_id;
    var active = false;
    var thumb_list;
    var active_event = false;
    var number_page_ajax;
    var is_thumb_load = true;
    var thumb;
    var current_state;
    var is_init_event_popup = false;
    var is_tagging = false;
    var tagCounter = 0;
    var next_photo = '';
    var share_url;
    var first_thumb = false;
    
    var loaded = false;
    var tagging = false;
    var targetX, targetY, mouseX, mouseY, targetWidth, targetHeight, inputX, inputY;
    var tag_uid = 0;
    var taguserid = 0;
    var page = 2;
    var flagScroll = true;

    function displayPhoto() {
        var img = $('#photo_src');
        var windowHeight = $(window).height();
        var pic_real_width, pic_real_height;
        if (img.data( "size" ) && img.data( "size" ) != '')
    	{
        	tmp = img.data( "size" ).split(",");
        	pic_real_width = tmp[0];
        	pic_real_height = tmp[1];
    	}
        if (pic_real_width && pic_real_height)
        {
        	initPhotoAfterGetSize(img,pic_real_width,pic_real_height);
        }
        else
        {
        	$("<img/>") // Make in memory copy of image to avoid css issues
            .attr("src", $(img).attr("src"))
            .load(function () {
                pic_real_width = this.width;   // Note: $(this).width() will not
                pic_real_height = this.height; // work for in memory images.
                initPhotoAfterGetSize(img,pic_real_width,pic_real_height);
                
                $.post(mooConfig.url.base + "/photos/ajax_update_size", {'photo_id':photo_id,'width':pic_real_width,'height':pic_real_height});
            });
        }
        

    }
    
    var initPhotoAfterGetSize = function(img,pic_real_width,pic_real_height)
    {
    	if (pic_real_height >= pic_real_width) {
            $(img).addClass('verticalImagePopup');
        } else {
            if (pic_real_height < (windowHeight - 72))
                $(img).addClass('horizionImagePopup');
            else
                $(img).addClass('verticalImagePopup');
        }

        if ($('#theaterPhotoComment').length > 0)
        {
            // init mooMention
            mooMention.init('theaterPhotoComment');
            
            // init mooToggleEmoji
            mooToggleEmoji.init('theaterPhotoComment', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
        }

        $('#photo_wrapper').spin(false);
        $('#tag-wrapper').show();
        $('#photo_src').css('visibility', 'visible');
        var windowHeight = 0;
        var contentPhoto = 0;
        if ($(window).width() > 992) {
            windowHeight = $(window).height();
            contentPhoto = $('#photo_wrapper').width();
            $('#photoModal #tag-wrapper').height(windowHeight - 72);
            $('#photoModal #tag-wrapper .photo_img').height(windowHeight - 72);
            $('#photoModal #tag-wrapper').width(contentPhoto);
            $('#photoModal .photo_comments').height(windowHeight);
        } else {
            windowHeight = $(window).height();
            contentPhoto = $(window).width();
            $('#photoModal #tag-wrapper').height(windowHeight - 36);
            $('#photoModal #tag-wrapper .photo_img').height(windowHeight - 36);
            $('#photoModal #tag-wrapper').width(contentPhoto);
        }
    }
    
    var initPhotoDetailTags = function(){
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
    }

    var checkShowPhotoTags = function () {
        if($('#tags').find('.photoDetailTags').length > 0){
            $('#tags').show();
        }else {
            $('#tags').hide();
        }
    }
    
    var initPhotoDetailRemoveTags = function(){
        // init photoDetailRemoveTags
        $('.photoDetailRemoveTags').unbind('click');
        $('.photoDetailRemoveTags').on('click', function(){
            var data = $(this).data();
            removeTag('0-'  + data.id, data.id);
        });
    }
    
    var initShowPhoto = function(){
        $('.showPhotoTheater').unbind('click');
        $('.showPhotoTheater').on('click', function(){
            var data = $(this).data();
            showPhoto(data.id, data.thumb);
        });
        initBackHistoryPhotoTheater();
        
        initPhotoDetailTags();
        
        initPhotoDetailRemoveTags();
    }
    
    var initBackHistoryPhotoTheater = function () {
        $(window).unbind('popstate');
        $(window).on('popstate', function() {
            isTheater = getQueryVariable('theater', window.location);
            if(isTheater !== false){
                photo_id = getQueryVariable('pid', window.location);
                showBackHistoryPhotoTheater(photo_id,'1');
            }else{
                $('#photoModal').modal('hide');
            }
        });
    }
    var getQueryVariable = function(variable, location) {
        var query = location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){
                if( typeof pair[1] == "undefined" ){
                    return '';
                }else {
                    return pair[1];
                }
            }
        }
        return(false);
    }
    var loadAjaxThumb = function (page)
    {
        $.post(mooConfig.url.base + "/photos/ajax_thumb_theater/" + photo_id + "/" + page + (taguserid ? '?uid=' + taguserid : ''), function (data) {
            $('#photo_thumbs ul').append(data);
            if (page == number_page_ajax)
            {
                initThumbPhoto();
                return;
            }
            loadAjaxThumb(page + 1);
        });
    }

    var initEventClickPopup = function ()
    {
        $(document).on('click', 'a.photoModal', function (e) {
        	if (mooConfig.force_login && !mooConfig.photo_consider_force)
    		{
        		if (!mooUser.validateUser())
        		{
	        		e.preventDefault();
	        		return;
        		}
    		}
        	
            if (!active)
            {
                return;
            }
            e.preventDefault();
            $('body').append('<div class="photo_modal_loading"></div>');
            $('.photo_modal_loading').spin('large');
            $.ajax({url: $(this).attr('href'), success: function (result) {
                    $('#photoModal .modal-content').html(result);
                    $('#photoModal').modal('show');
                    mooTooltip.init();
                }});
        });
    }

    var initLoadPhotoPopup = function ()
    {
        $('#photoModal').on('shown.bs.modal', function (e) {
            $('.photo_modal_loading').remove();            
            start();
            displayPhoto();
            if (is_thumb_load){
                initThumbPhoto();
            }
        });


        $('#photoModal').on('hidden.bs.modal', function (e) {
            history.pushState({}, '', current_state);
            $('#photoModal .modal-content').html('');
            $('#photoModal').removeData('bs.modal');
        })
    }
    var start = function ()
    {
        photo_id = $('#photo_wrapper').data('photoid');
        tag_uid = $('#photo_wrapper').data('taguid');
        taguserid = $('#photo_wrapper').data('taguserid');
        next_photo = $('#photo_wrapper').data('nextphoto');
        thumb = $('#photo_wrapper').data('thumbfull');
        //load thumb
        
        var windowHeight, contentPhoto;

        var photo_count = $('#photo_wrapper').data('photocount');
        var page = $('#photo_wrapper').data('page');

        if (photo_count > page * 20)
        {
            number_page_ajax = Math.ceil(photo_count / 20);
            $('#photo_thumbs').spin();
            $('#thumb_list_popup').hide();
            is_thumb_load = false;
            loadAjaxThumb(2);
        }
        else
        {
            is_thumb_load = true;
        }

        //init event
        if (!active_event)
        {
            $(window).resize(function () {
                if ($('#photo-content').length == 0){
                    return;
                }
                if ($('#theaterPhotoComment').is(':focus'))
                	return;
                if ($(window).width() > 992) {
                    windowHeight = $(window).height();
                    contentPhoto = $('#photo_wrapper').width();
                    $('#photoModal #tag-wrapper').height(windowHeight - 72);
                    $('#photoModal #tag-wrapper .photo_img').height(windowHeight - 72);
                    $('#photoModal #tag-wrapper').width(contentPhoto);
                    $('#photoModal .photo_comments').height(windowHeight);
                } else {
                    windowHeight = $(window).height();
                    contentPhoto = $(window).width();
                    $('#photoModal #tag-wrapper').height(windowHeight - 36);
                    $('#photoModal #tag-wrapper .photo_img').height(windowHeight - 36);
                    $('#photoModal #tag-wrapper').width(contentPhoto);
                }
                displayPhoto();
                $('#photo_src').css('visibility', 'visible');
            });

            $(document).keydown(function (e) {
                if (!$('#theaterPhotoComment').is(':focus') && !$('[id^="message_item_comment_edit"]').is(':focus')) {
                    if (e.keyCode == 37) {
                        //ctrl + leftbutton pressed
                        $("#photo_left_arrow_lg").trigger("click");
                    } else if (e.keyCode == 39) {
                        //ctrl + rightbutton pressed
                        $("#photo_right_arro_lgw").trigger("click");
                    }
                }
            });

            active_event = true;
        }

        $('#photo_thumbs ul li').unbind('click');
        $('#photo_thumbs ul li').click(function () {
            $('#photo_thumbs ul li').removeClass('active');
            $(this).addClass('active');
        });
        $('#photo_wrapper').spin('large');
        $('#tag-wrapper').hide();
        if (tag_uid){
            url = photo_id + '/uid:' + tag_uid + '?pid=' + photo_id + '&theater';
        }
        else if (taguserid){
            url = photo_id + '?uid=' + taguserid + '&pid=' + photo_id + '&theater';
        }
        else
    	{
        	url = photo_id + '?pid=' + photo_id + '&theater';
    	}

        current_state = window.location.href;
        window.history.pushState({photo_id: photo_id}, "", mooConfig.url.base + '/photos/view/' + url);
        window.history.replaceState({photo_id: photo_id}, "", mooConfig.url.base + '/photos/view/' + url);

        share_url = window.location;
        initPhoto();
    }
    var initPhoto = function ()
    {
        $('#photo_wrapper .toogleThumb').unbind('click');
        $('#photo_wrapper .toogleThumb').click(function () {
            $('#photo_thumbs').toggle();
            if ($('#thumb_list_popup').is(":visible"))
            {
                thumb_list.setCurrent($('#photo_thumb_' + photo_id).index());
            }
        });

        //set action cover
        $('#set_photo_cover').unbind('click');
        $('#set_photo_cover').click(function () {
            set_photo_as_cover();
        });

        //set tag
        is_tagging = false;
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

        $('#set_profile_picture').unbind('click');
        $('#set_profile_picture').click(function () {
            set_photo_as_profile_picture();
        });

        $('#delete_photo').unbind('click');
        $('#delete_photo').click(function () {
            deletePhoto();
        });

        $('#photo_close_icon').unbind('click');
        $('#photo_close_icon').click(function () {
            history.pushState({}, '', current_state);
        });
        $(".sharethis_theater").hideshare({media: thumb, linkedin: false, link: share_url});
        mooBehavior.registerImageComment();
        var comment_scroll_height = 500;
        if(mooConfig.isMobile){
            comment_scroll_height = 300;
        }
        if ($('#theaterComments').height() > comment_scroll_height) {
            $('#theaterComments').slimScroll({height: comment_scroll_height+'px', start: 'top'}).bind('slimscroll', function (e, pos) {
                if (pos == 'bottom') {
                    if (mooConfig.autoLoadMore != '') {
                        if ($('#photoModal .view-more').length > 0)
                        {
                            $('#photoModal .view-more').before('<div style="text-align: center" class="loading"><img src="' + mooConfig.url.base + '/img/loading.gif" /></div>');
                            $('#photoModal .view-more').find('a').trigger('click');
                            flagScroll = false;
                        }
                    }
                }
            });
        }

        $('#theaterPhotoComment').autogrow();
    }

    var closeTagInput = function () {
        $("#tag-target").fadeOut();
        $("#tag-input").fadeOut();
        $("#tag-name").val("");
    }
    var doneTagging = function () {
        is_tagging = false;
        $("#tag-wrapper img").css('cursor', 'default');
        $("#tagPhoto a").html(mooPhrase.__('tag_photo'));

        $('#tag-name').unbind();
        $('#tag-submit').unbind();
        closeTagInput();
    }
    var tagPhoto = function ()
    {
        is_tagging = true;

        $("#tag-wrapper img").css('cursor', 'crosshair');
        $("#tagPhoto a").html(mooPhrase.__('done_tagging'));
        
        $("#tag-wrapper img").unbind('click');
        $("#tag-wrapper img").click(function (e) {
            if (is_tagging)
            {
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
            if (e.keyCode == 13)
                submitTag(0, '');
        });

        //If submit button is clicked
        $('#tag-submit').unbind('click');
        $('#tag-submit').click(function () {
            submitTag(0, '');
            return false;
        });

    }

    function showPhotoWrapper()
    {
        var preload = $('#preload').html();

        if ( preload != '' )
        {
            $('#preload').html('');
            element = $('<div>'+preload + '</div>');
            data = element.find("#photo_wrapper").data();
            
            photo_id = data.photoid;
            tag_uid = data.taguid;
            taguserid = data.taguserid;
            next_photo = data.nextphoto;
            thumb = data.thumbfull;

            $('#photo-content #tag-wrapper').hide();
            
            $('#photo-content .photo_comments').hide();
            if (element.find('.photo_comments').html())
            {
            	$('#photo-content .photo_comments').html(element.find('.photo_comments').html());
            	$('#photo-content .photo_comments').show();
            }
            
            $('#photo_wrapper .info').html(element.find('.info').html());

            $('#photo-content #tag-wrapper').html(element.find('#tag-wrapper').html());
            $('#photo-content #lb_description').html('');
            $('#photo-content #lb_description').html(element.find('#lb_description').html());
            $('#photo_wrapper').spin('large');

            initPhoto();
            displayPhoto();
        }
    }

    function showBackHistoryPhotoTheater(id,no_click_thumb)
    {
        if (no_click_thumb == '1')
        {
            if ($('#thumb_list_popup').is(":visible"))
            {
                thumb_list.setCurrent($('#photo_thumb_' + id).index());
            }
        }

        //reset overlay mention
        $('#theaterPhotoComment').destroyOverlayInstance($('#theaterPhotoComment'));

        photo_id = id;
        $('#thumb_list_popup .active').removeClass('active');
        $('#photo_thumb_'+photo_id).addClass('active');
        $('#photo_wrapper').spin('large');

        var url = '';

        if (tag_uid){
            url = id + '/uid:' + tag_uid;
        }
        else
        {
            url = id;
        }

        var url_nocache = url + '/time/' + (new Date()).getTime();
        if (taguserid)
        {
            url_nocache += '?uid=' + taguserid + '&theater';
            //url += '?uid=' + taguserid + '&theater';
        }else{
            url_nocache += '?theater';
            //url += '?theater';
        }

        $('#preload').load(mooConfig.url.base + '/photos/ajax_view_theater/' + url_nocache, {noCache: 0}, function(){
            is_tagging = false;
            $('#photoModal .slimScrollDiv').attr('style','');
            $('#theaterComments').attr('style','');
            showPhotoWrapper();
            mooTooltip.init();
        });

        //window.history.pushState({photo_id: photo_id},"",mooConfig.url.base + '/photos/view/' + url);
    }
    function showPhoto(id,no_click_thumb)
    {
        if (no_click_thumb == '1')
        {
            if ($('#thumb_list_popup').is(":visible"))
            {
                thumb_list.setCurrent($('#photo_thumb_' + id).index());
            }
        }

        //reset overlay mention
        $('#theaterPhotoComment').destroyOverlayInstance($('#theaterPhotoComment'));

        photo_id = id;
        $('#thumb_list_popup .active').removeClass('active');
        $('#photo_thumb_'+photo_id).addClass('active');
        $('#photo_wrapper').spin('large');
        
        var url = '';
        
        if (tag_uid){
            url = id + '/uid:' + tag_uid;
        }
        else
    	{
        	url = id;
    	}

        var url_nocache = url + '/time/' + (new Date()).getTime();        
        if (taguserid)
    	{
        	url_nocache += '?uid=' + taguserid + '&pid=' + id + '&theater';
        	url += '?uid=' + taguserid + '&pid=' + id + '&theater';
    	}else{
            url_nocache += '?pid=' + id + '&theater';
            url += '?pid=' + id + '&theater';
    	}
        
        $('#preload').load(mooConfig.url.base + '/photos/ajax_view_theater/' + url_nocache, {noCache: 0}, function(){
        	is_tagging = false;
            $('#photoModal .slimScrollDiv').attr('style','');
            $('#theaterComments').attr('style','');
            showPhotoWrapper();
            mooTooltip.init();
        });
        
        
        window.history.pushState({photo_id: photo_id},"",mooConfig.url.base + '/photos/view/' + url);


    }

    var submitTag = function (uid, tagValue)
    {
        if (uid != '' || $("#tag-name").val() != '')
        {
            var style = 'left:' + targetX + 'px; top:' + targetY + 'px';
            $('#photo_wrapper').spin('large');
            $.post(mooConfig.url.base + '/photos/ajax_tag', {photo_id: photo_id, uid: uid, value: $("#tag-name").val(), style: style}, function (data) {
                $('#photo_wrapper').spin(false);
                var json = $.parseJSON(data);

                if (json.result == 1)
                {
                    if (uid){
                        tagValue = '<a href="' + mooConfig.url.base + '/users/view/' + uid + '">' + tagValue + '</a>';
                    }
                    else{
                        tagValue = $("#tag-name").val();
                    }
                    $("#tags").find('.photo-list-tags').append('<span id="hotspot-item-0-' + json.id + '" data-tag-id="' + json.id + '" class="photoDetailTags">' + tagValue + '<a href="javascript:void(0)" class="photoDetailRemoveTags" data-id="' + json.id + '"><i class="material-icons cross-icon-sm">clear</i></a></span>');
   
                    $("#tag-wrapper .photo_img").append('<div id="hotspot-0-' + json.id + '" class="hotspot" style="' + style + '"><span>' + tagValue + '</span></div>');

                    //Adds a new hotspot to image
                    closeTagInput();
                    tagCounter++;
                    
                    initShowPhoto();
                    checkShowPhotoTags();
                }
                else{
                    mooAlert.alert(json.message);
                }
            });
        }
    }
    var removeTag = function (i, tag_id)
    {
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

    var initThumbPhoto = function ()
    {
        first_thumb = false;
        thumb_list = $('#thumb_list_popup').elastislide({
            minItems: 2,
            onReady: function () {
                thumb_list.setCurrent($('#photo_thumb_' + photo_id).index());
                $('#photo_thumbs').spin(false);
                $('#photo_thumbs').css('visibility', 'visible');
                //if ($(window).width() < 992) {
                    if (!first_thumb)
                    {
                        first_thumb = true;
                        $('#photo_thumbs').toggle();
                    }

                //}
            }
        });

        $('#photo_thumb_' + photo_id).addClass('active');
    }

    var set_photo_as_cover = function () {
        $('#set_cover').spin('custom');//tiny
        $.post(mooConfig.url.base + '/users/set_photo_as_cover', {photo_id: photo_id}, function (response)
        {
            var data = $.parseJSON(response);
            location.assign(data.url);
        });
    }

    function deletePhoto()
    {
        next_photo = next_photo != '' ? next_photo : '0';
        mooAlert.confirm(mooPhrase.__('are_you_delete'), mooConfig.url.base + '/photos/ajax_remove/photo_id:' + photo_id + '/next_photo:' + next_photo);
    }

    var set_photo_as_profile_picture = function () {
        $('#set_avatar').spin('custom');
        $.post(mooConfig.url.base + '/users/set_photo_as_profile_picture', {photo_id: photo_id}, function (response)
        {
            var data = $.parseJSON(response);
            window.location = data.url;
        });
    }

    return{
        init: function () {
            if (!is_init_event_popup){
                initLoadPhotoPopup();
            }

            is_init_event_popup = true;
            initEventClickPopup();
        },
        initShowPhoto : initShowPhoto,
        start: function () {
            start();
        },
        submitTag: function (uid, tagValue)
        {
            submitTag(uid, tagValue);
        },
        removeTag: function (id, tag_id)
        {
            removeTag(id, tag_id);
        },
        hideTag: function (tag_id)
        {
            hideTag(tag_id);
        },
        showTag: function (tag_id)
        {
            showTag(tag_id);
        },
        showPhotoWrapper: function ()
        {
            showPhotoWrapper();
        },
        showPhoto: function (id, no_click_thumb)
        {
            if (typeof no_click_thumb == "undefined"){
                no_click_thumb = false;
            }
            
            showPhoto(id, no_click_thumb);
        },
        setActive: function (a)
        {
            active = a;
        }
    }
}));