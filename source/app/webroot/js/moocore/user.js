/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooPhrase', 'mooFileUploader', 'mooAlert', 'mooGlobal', 'mooButton', 'mooOverlay', 'mooBehavior', 'mooAjax', 'mooTooltip','Cropper', 'mooCoreMenu', 'spinner', 'tipsy', 'multiselect', 'Jcrop', 'bootstrap'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooUser = factory();
    }
}(this, function ($, mooPhrase, mooFileUploader, mooAlert, mooGlobal, mooButton, mooOverlay, mooBehavior, mooAjax, mooTooltip, Cropper, mooCoreMenu) {

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

    // app/View/Elements/registration.ctp
    var initOnRegistration = function(){

        $('#username').keyup(function() {
            var value = '';
            if ($('#username').val().trim() != '')
                value = '-' + $('#username').val().trim();
            $('#profile_user_name').html(value);
        });

        $("#submitFormsignup").unbind('click');
        $("#submitFormsignup").click(function(){
            $('#step1Box').spin('small');

            $('#submitFormsignup').attr('disabled', 'disabled');
            $.post(mooConfig.url.base + "/users/ajax_signup_step1", $("#regForm").serialize(), function(data){

                $('#step1Box').spin(false);

                if (data.indexOf('mooError') > 0) {
                    $("#regError").fadeIn();
                    $("#regError").html(data);
                    $('#submitFormsignup').removeAttr('disabled');
                } else {
                    $("#regError").fadeOut();
                    
                    var obj = {status: false,data:data};
                    $('body').trigger('initOnRegistrationStep1Callback',[obj]);
                    if (!obj.status)
                	{
                    $("#regFields").append(data);
                	}
                    
                    $("#captcha").fadeIn();
                    $('#step1Box').remove();
                    $(".tip").tipsy({ html: true, gravity: 's' });

                    $(".multi").multiSelect({
                        selectAll: false,
                        noneSelected: '',
                        oneOrMoreSelected: mooPhrase.__('per_selected')
                    });
                }
            });

        });

        $("#step2Submit").unbind('click');
        $("#step2Submit").click(function(){
            if($('#tos').is(':checked')){

                $('#step2Box').spin('small');

                $('#step2Submit').attr('disabled', 'disabled');

                $.post(mooConfig.url.base + "/users/ajax_signup_step2", $("#regForm").serialize(), function(data){
                    $('#step2Box').spin(false);
                    var result = '';
                    var isJson = false;

                    try
                    {
                        result = JSON.parse(data);
                        isJson = true;
                    }
                    catch(e)
                    {

                    }

                    var sUrlRedirect = mooConfig.url.base + '/';
                    if(isJson && result.redirect) {
                        sUrlRedirect = result.redirect;
                        }

                    if (!isJson && data != '') {
                            $("#regError").fadeIn();
                            $("#regError").html(data);
                            $('#step2Submit').removeAttr('disabled');
                            if (typeof grecaptcha !== "undefined") {
                                grecaptcha.reset(); // FIXED_JS if ($this->Moo->isRecaptchaEnabled()):
                            }                            
                            return;
                        }
                    var obj = {status: false,sUrlRedirect:sUrlRedirect};
                    $('body').trigger('initOnRegistrationStep2Callback',[obj]);
                    if (!obj.status)
                    {
                    	window.location = sUrlRedirect;
                    }
                    
                });
            }else{
                $("#regError").fadeIn();
                $("#regError").html(mooPhrase.__('you_have_to_agree_with_term_of_service'));
            }
        });
    }

    var initOnSignupStep1FieldCountry = function()
    {
        $('#country_id').unbind('change');
        $('#country_id').change(function(){
            $('.country_city').hide();
            $('.country_state').hide();
            $('#state_id').html("<option value=''></option>");
            $('#city_id').html("<option value=''></option>");
            if ($('#country').val() != '') {
                $.getJSON(mooConfig.url.base + "/countries/ajax_get_state/" + $('#country_id').val(), function (result) {
                    if (result.count > 0)
                    {                        
                        var first_id = 0;
                        $.each(result.data, function(field){
                            if (first_id == 0)
                            {
                                first_id = result.data[field].id;
                            }
                            $('#state_id').append("<option value='"+result.data[field].id+"'>" + result.data[field].name + "</option>");
                        });

                        if (result.data.length == 1)
                        {
                            $('#state_id').val(first_id);
                            $('#state_id').trigger('change');
                        }
                        else
                        {
                            $('.country_state').show();
                        }
                    }
                });
            }
        });
		
		$('#state_id').unbind('change');
        $('#state_id').change(function(){
            $('.country_city').hide();
            $('#city_id').html("<option value=''></option>");
            if ($('#state_id').val() != '') {
                $.getJSON(mooConfig.url.base + "/countries/ajax_get_city/" + $('#state_id').val(), function (result) {
                    if (result.count > 0)
                    {
                        $('.country_city').show();                        
                        $.each(result.data, function(field){
                            $('#city_id').append("<option value='"+result.data[field].id+"'>" + result.data[field].name + "</option>");
                        });
                    }
                });
            }
        });
    }

    // app/Plugin/SocialIntegration/View/Auths/signup_step2.ctp
    var initOnSocialRegistration = function(is_recaptcha, provider){
        $('#username').keyup(function() {
            var value = '';
            if ($('#username').val().trim() != '')
                value = '-' + $('#username').val().trim();
            $('#profile_user_name').html(value);
        });

        $(".multi").multiSelect({
            selectAll: false,
            noneSelected: '',
            oneOrMoreSelected: mooPhrase.__('per_selected')
        });
        $("#step2Submit").click(function(){
            if($('#tos').is(':checked')){
                $('#step2Box').spin('small');

                $('#step2Submit').attr('disabled', 'disabled');
                $.post(mooConfig.url.base + "/social/auths/ajax_signup_step2/" + provider, $("#regForm").serialize(), function(data){
                    $('#step2Box').spin(false);
                    var result = '';
                    var isJson = false;
                    try{
                        result = JSON.parse(data);
                        isJson = true;
                    }
                    catch(e){
                        isJson = false;
                    }
                    if(isJson){
                        if(result.redirect){
                            window.location = result.redirect;
                        }
                    }
                    else{
                        if (data != '') {
                            $("#regError").fadeIn();
                            $("#regError").html(data);
                            $('#step2Submit').removeAttr('disabled');
                            if (is_recaptcha){
                                grecaptcha.reset();
                            }
                        } else {
                            window.location = mooConfig.url.base + '/';
                        }
                    }
                });
            }else{
                $("#regError").fadeIn();
                $("#regError").html(mooPhrase.__('you_have_to_agree_with_term_of_service'));
            }
        });
    }

    // app/View/Users/ajax_signup_step1.ctp
    var initOnSignupStep1 = function(){

        var uploader = new mooFileUploader.fineUploader({
            element: $('#profile_picture')[0],
            request: {
                endpoint: mooConfig.url.base + "/upload/avatar_tmp"
            },
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span> ' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            multiple: false,
            callbacks:{
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    $('#profile_picture_preview > img').attr('src', mooConfig.url.base + '/uploads/tmp/'+response.filename);
                    $('#profile_picture_preview > img').show();
                    $('#profile_picture_preview > img').css({height:'150px'});
                    $('#avatar').val(response.filepath);
                }
            }
        });
    }

    var storeCoords = function(c) {
        x = c.x;
        y = c.y;
        w = c.w;
        h = c.h;
    }

    // app/View/Users/avatar.ctp
    var jcrop_api;
    var cropper;
    var x = 0,
        y = 0,
        w = 0,
        h = 0;
    var initOnProfilePicture = function(){

        $('#save-avatar').unbind('click');
        $('#save-avatar').click(function () {
        	if ($('#avatar_wrapper img').data('default') == null)
        	{
	        	if( ! mooConfig.isMobile ) {
		            var data = $(this).data();
		            if (x == 0 && y == 0 && w == 0 && h == 0){
		                mooAlert.alert(mooPhrase.__('please_select_area_for_cropping'));
		            }
		            else{
		                $('#avatar_wrapper').spin('large');
		                var modal = $('#portlet-config');
		
		                $.post(mooConfig.url.base + '/upload/thumb', {x: x, y: y, w: w, h: h}, function (response) {
		                    $('#avatar_wrapper').spin(false);
		                    if (response != '') {
		                        var json = $.parseJSON(response);
		                        $('#member-avatar').attr('src', json.thumb);
		                        window.location = data.url; // 
		                    }
		                });
		            }
	        	}
	        	else
	    		{
	        		var data = $(this).data();
	        		cropper.getCroppedCanvas().toBlob((blob) => {
	          		  const formData = new FormData();
	
	          		  formData.append('croppedImage', blob);
	
	          		  // Use `jQuery.ajax` method
	          		  $.ajax(mooConfig.url.base + '/upload/thumb_blob', {
	          		    method: "POST",
	          		    data: formData,
	          		    processData: false,
	          		    contentType: false,
	          		    success() {
	          		    	window.location = data.url;
	          		    },
	          		    error() {
	          		      console.log('Upload error');
	          		    },
	          		  });
		          	});
	    		}
        	}
        });
        if ($('#avatar_wrapper img').data('default') == null)
    	{
	        if( ! mooConfig.isMobile ) {
	            $('#av-img2').Jcrop({
	                aspectRatio: 1,
	                onSelect: storeCoords,
	                minSize: [200, 200]
	            }, function () {
	                jcrop_api = this;
	            });
	        }
	        else
	        {
	            //$('#save-avatar').addClass('hide');
	            //$('#submit-avatar').removeClass('hide');
	        	$('#avatar_wrapper').spin('large');
	        	var image = document.querySelector('#av-img2');
	            cropper = new Cropper(image, {
		        	aspectRatio: 1 / 1,
		        	zoomable : false,
		        	viewMode : 3,
		        	minCropBoxWidth: 200,
		            minCropBoxHeight: 200,
		            ready : function(){
		            	$('#avatar_wrapper').spin(false);
		            },
		            cropmove: function () {
		                cropper = this.cropper;
		                var cropBoxData = cropper.getCropBoxData();
		                console.log(cropBoxData);
		                x = cropBoxData.left;
		                y = cropBoxData.top;
		                w = cropBoxData.width;
		                h = cropBoxData.height;
		            }
		        });
	        }
    	}

        var uploader = new mooFileUploader.fineUploader({
            element: $('#select-0')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    $('#av-img').attr('src', response.avatar);
                    $('#av-img2').attr('src', response.avatar);
                    $('#member-avatar').attr('src', response.thumb);
                    
                    if ($('#avatar_wrapper img').data('default') == 1)
                    {
                    	if( ! mooConfig.isMobile ) {
                            $('#av-img2').Jcrop({
                                aspectRatio: 1,
                                onSelect: storeCoords,
                                minSize: [200, 200]
                            }, function () {
                                jcrop_api = this;
                            });
                        }
                        else
                        {
                            //$('#save-avatar').addClass('hide');
                            //$('#submit-avatar').removeClass('hide');
                        	$('#avatar_wrapper').spin('large');
                        	var image = document.querySelector('#av-img2');
                            cropper = new Cropper(image, {
                	        	aspectRatio: 1 / 1,
                	        	zoomable : false,
                	        	viewMode : 3,
                	        	minCropBoxWidth: 200,
                	            minCropBoxHeight: 200,
                	            ready : function(){
            		            	$('#avatar_wrapper').spin(false);
            		            },
                	            cropmove: function () {
                	                cropper = this.cropper;
                	                var cropBoxData = cropper.getCropBoxData();
                	                console.log(cropBoxData);
                	                x = cropBoxData.left;
                	                y = cropBoxData.top;
                	                w = cropBoxData.width;
                	                h = cropBoxData.height;
                	            }
                	        });
                        }
                    }
                    $('#avatar_wrapper img').data('default',null);
                    if( ! mooConfig.isMobile ) {
                    	jcrop_api.setImage(response.avatar);
                    }
                    else
                    {
                    	cropper.replace(response.avatar);
                    }
                    $('.avatar-rotate').show();
                }
            }
        });

        initRotatePhoto(jcrop_api);
    }

    var initRotatePhoto = function(JCropperAvatar){

        $('.rotate_avatar').unbind('click');
        $('.rotate_avatar').on('click', function(){
            $('.rotate_avatar').hide();
            var data = $(this).data();
            $('#avatar_wrapper').spin('large');
            $.post(mooConfig.url.base + '/users/ajax_rotate', {mode:data.mode}, function (data){
                dataJson = JSON.parse(data);
                $('#avatar_wrapper').spin(false);
                $('.rotate_avatar').show();

                $('#av-img').attr('src',  dataJson["200_square"]);
                $('#av-img2').attr('src',  dataJson["600"]);
                if( !mooConfig.isMobile ) {
                    JCropperAvatar.setImage(dataJson["600"]);
                }else{
                    //$('#avatar_wrapper img').attr('src', dataJson["600"]);
                    cropper.replace(dataJson["600"]);
                }
                $('#member-avatar').attr('src', dataJson["50_square"]);
            });

        });
    }

    // app/View/Users/view.ctp
    var jcrop_api;
    var x = 0,
        y = 0,
        w = 0,
        h = 0;
    var initOnUserView = function(){

        $('#themeModal').on('click',' .save-avatar',function() {
            $('#avatar_wrapper').spin('large');
            var modal = $('#themeModal');

            $.post(mooConfig.url.base + '/upload/thumb', {x: x, y: y, w: w, h: h}, function(data) {

                modal.modal('hide');

                if ( data != '' ){
                    var json = $.parseJSON(data);
                    $('#member-avatar').attr('src', json.thumb);
                    $('#av-img').attr('src', json.avatar_mini);

                    $('body').trigger('afterSaveAvatarSuccess', [{avatar: json}]);
                }
            });

        });

        $('#themeModal').on('click',' .save-cover',function() {
            var modal = $('#themeModal');
            $('#cover_wrapper').spin('large');
            
            if (!mooConfig.isMobile || $('#cover_wrapper img').data('default') != null)
            {
	            var jcrop_width = $('#cover_wrapper .jcrop-holder').width();
	            var jcrop_height = $('#cover_wrapper .jcrop-holder').height();
	
	            $.post(mooConfig.url.base + '/upload/thumb_cover', {x: x, y: y, w: w, h: h, jcrop_width: jcrop_width, jcrop_height: jcrop_height}, function(data) {
	
	                modal.modal('hide');
	
	                if ( data != '' ){
	                    var json = $.parseJSON(data);
	                    $('#cover_img_display').attr("src",json.thumb);
	                    $('#cover_img_background').css("background-image","url("+json.thumb+")");

	                    $('body').trigger('afterSaveCoverSuccess', [{cover: json}]);
	                }
	            });
        	}
            else
            {
            	console.log(cropper);
            	cropper.getCroppedCanvas().toBlob((blob) => {
          		  const formData = new FormData();

          		  formData.append('croppedImage', blob);

          		  // Use `jQuery.ajax` method
          		  $.ajax(mooConfig.url.base + '/upload/thumb_cover_blob', {
          		    method: "POST",
          		    data: formData,
          		    processData: false,
          		    contentType: false,
          		    success(data) {
          		    	modal.modal('hide');
          		  	
    	                if ( data != '' ){
    	                    var json = $.parseJSON(data);
    	                    $('#cover_img_display').attr("src",json.thumb);
                            $('#cover_img_background').css("background-image","url("+json.thumb+")");

    	                    $('body').trigger('afterSaveCoverSuccess', [{cover: json}]);
    	                }
          		    },
          		    error() {
          		      console.log('Upload error');
          		    },
          		  });
	          	});
            }
        });
    }

    // app/View/Friends/ajax_add.ctp
    var initAddFriend = function(){
        $("#addFriendForm textarea").unbind('keyup');
        $("#addFriendForm textarea").keyup(function(){

            if(this.value.length > parseInt($(this).attr('maxlength'))){
                return false;
            }
        
            $("#addFriendForm #message_count").html(parseInt($(this).attr('maxlength')) - this.value.length);
        });
        $('#sendReqAddFriendBtn').unbind('click');
        $('#sendReqAddFriendBtn').click(function(){

            var data = $(this).data();
            var uid = data.uid;
            $('#sendReqAddFriendBtn').spin('small');

            mooButton.disableButton('sendReqAddFriendBtn');

            $.post(mooConfig.url.base + "/friends/ajax_sendRequest", $("#addFriendForm").serialize(), function(data){

                if ($('.suggestion_block').length){
                    $('.suggestion_block #addFriend_' + uid).parents('li:first').remove();
                    if ($('.suggestion_block li').length == 0){
                        $('.suggestion_block').remove();
                    }
                }

                mooButton.enableButton('sendReqAddFriendBtn');

                $('#themeModal').modal('hide');

                //mooAlert.alert(data);

                $('#addFriend_' + uid).parents('div.user-idx-item').append('<a href="' + mooConfig.url.base + '/friends/ajax_cancel/' + uid + '" id="cancelFriend_' + uid +'" class="add_people" title="' + mooPhrase.__('cancel_a_friend_request') + '"><i class="material-icons">clear</i>' + mooPhrase.__('cancel_request') + '</a>');
                $('#addFriend_' + uid).remove();
                if ($('#blogAddFriend').length){
                    $('#blogAddFriend').parents('.blog_view_leftnav').append('<li><a href="' + mooConfig.url.base + '/friends/ajax_cancel/' + uid + '" id="blogCancelFriend" class="" title="' + mooPhrase.__('cancel_a_friend_request') + '"><i class="material-icons icon-small">clear</i>' + mooPhrase.__('cancel_request') + '</a></li>');
                    $('#blogAddFriend').parents('li:first').remove();
                }
                if ($('#userAddFriend').length){
                    $('#userAddFriend').parents('.profile-action').append('<a id="userCancelFriend" href="' + mooConfig.url.base + '/friends/ajax_cancel/' + uid + '" class="topButton button button-action" title="' + mooPhrase.__('cancel_a_friend_request') + '"><i class="visible-xs visible-sm material-icons">clear</i><i class="hidden-xs hidden-sm">' + mooPhrase.__('cancel_request') + '</i></a>');
                    $('#userAddFriend').remove();
                }

                location.reload();
            });
            return false;
        });
    }

    // app/View/Friends/ajax_remove.ctp
    var initRemoveFriend = function(){

        $('#removeFriendButton').unbind('click');
        $('#removeFriendButton').click(function(){

            var data = $(this).data();
            var uid = data.uid;

            mooButton.disableButton('removeFriendButton');

            $.post(mooConfig.url.base + "/friends/ajax_removeRequest", $("#removeFriendForm").serialize(), function(data){

                mooButton.enableButton('removeFriendButton');

                $('#themeModal').modal('hide');

                // mooAlert.alert(data);

                var liUser = $('#removeFriend_'  + uid).parents('li:first')
                var liUserParent = liUser.parents('li[id^="activity_"]');

                liUser.remove();

                //remove this out of activity
                liUserParent.remove();

                location.reload();
            });

            return false;
        });
    }

    var initRemoveFollow = function(){

        $('#removeFollowButton').unbind('click');
        $('#removeFollowButton').click(function(){

            var data = $(this).data();
            var uid = data.uid;

            mooButton.disableButton('removeFollowButton');

            $.post(mooConfig.url.base + "/follows/ajax_removeRequest", $("#removeFollowForm").serialize(), function(data){

                mooButton.enableButton('removeFollowButton');

                $('#themeModal').modal('hide');

                $('#profile_follow').click();
                var count = parseInt($('#profile_follow .badge_counter').html());
                count--;
                $('#profile_follow .badge_counter').html(count);
            });

            return false;
        });
    }

    // app/View/Friends/ajax_requests.ctp
    var initAjaxRequest = function(){
        $('.respondRequest').unbind('click');
        $('.respondRequest').on('click', function(){
            if (!validateUser()){
                return false;
            }
            $(this).addClass('disabled');
            var data = $(this).data();
            if ($('#friend_request_count').length > 0){
                var current_request = $('#friend_request_count').html();
                var new_request = parseInt(current_request - 1);
                if (new_request <= 0){
                    $('#friend_request_count').parents('li:first').remove();
                }else {
                    $('#friend_request_count').html(new_request);
                }
            }

            $.post(mooConfig.url.base + '/friends/ajax_respond', {id: data.id, status: data.status}, function(response){
                $('#request_'+ data.id).html(response);
            });
        });

    }

    var initAjaxRequestPopup = function(){
        $('.respondRequest').unbind('click');
        $('.respondRequest').on('click', function(){
            if (!validateUser()){
                return false;
            }
            $(this).addClass('disabled');
            var data = $(this).data();

            $.post(mooConfig.url.base + '/friends/ajax_respond', {id: data.id, status: data.status}, function(response){
                $('#request_'+ data.id).html(response);

                location.reload();
            });
        });

    }

    // app/View/Users/ajax_birthday_more.ctp
    var initBirthdayPopup = function(){
        $('.more-birthday-email').unbind('click');
        $('.more-birthday-email').click(function(){
            if($('#langModal').modal('show')){
                $('#langModal').modal('hide');
            }
        })

        $('.postFriendWall').unbind('click');
        $('.postFriendWall').click(function(){
            var id = $(this).data('id');
            var me = $(this);
            var msg = $('#message_'+id).val();
            if ($.trim(msg) != '')
            {
                mooButton.disableButton('status_btn_'+id);
                $.post(mooConfig.url.base + "/activities/send_birthday_wish", $("#wallForm_"+id).serialize(), function(response){
                    var json = $.parseJSON(response);
                    mooButton.enableButton('status_btn_'+id);
                    $('#message_'+id).val("");
                    if (json.success)
                    {
                        mooButton.enableButton('status_btn_'+id);
                        me.parent().parent(".birthday-wish").html("<div style='padding:5px 0px;'>" + mooPhrase.__('birthday_wish_is_sent')+ "</div>");
                    }
                });
            }
        })
    }

    var respondRequest =  function(id, status){
        if (!validateUser()){
            return false;
        }
        $.post(mooConfig.url.base + '/friends/ajax_respond', {id: id, status: status}, function(response){
            location.reload();
        });
    }

    // app/View/Users/ajax_cover.ctp
    var initEditCoverPicture = function(){

        var JCropper;
        if( !mooConfig.isMobile && $('#cover_wrapper img').data('default') == null) {
            $('#cover-img').Jcrop({
                aspectRatio: 4,
                onSelect: storeCoords,
                minSize: [ 400, 100 ],
                boxWidth: 570
            }, function(){
                JCropper = this;
            });
        }
        else if (mooConfig.isMobile && $('#cover_wrapper img').data('default') == null)
        {
        	$('#cover_wrapper').spin('large');
        	var image = document.querySelector('#cover-img');
            cropper = new Cropper(image, {
	        	aspectRatio: 4 / 1,
	        	zoomable : false,
	        	viewMode : 3,
	        	minCropBoxWidth: 400,
	            minCropBoxHeight: 100,
	            ready : function(){
	            	$('#cover_wrapper').spin(false);
	            },
	            cropmove: function () {
	                cropper = this.cropper;
	                var cropBoxData = cropper.getCropBoxData();
	                console.log(cropBoxData);
	                x = cropBoxData.left;
	                y = cropBoxData.top;
	                w = cropBoxData.width;
	                h = cropBoxData.height;
	            }
	        });
        }

        var uploader = new mooFileUploader.fineUploader({
            element: $('#select-1')[0],
            multiple: false,
            autoUpload: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/upload/cover"
            },
            callbacks: {
                onSubmit: function(id, fileName){
                    var promise = validateFileDimensions(id, [400, 100],this);
                    return promise;
                },
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    $('#cover_img_display').attr("src",response.cover);
                    $('#cover_img_background').css("background-image","url("+response.cover+")");
                    if( !mooConfig.isMobile) {
                        $('#cover_wrapper img').attr('src', response.photo);
                        $('#cover_wrapper img').attr('style','');
                        if (JCropper)
                        {
                            JCropper.destroy();
                        }
                        $('#cover-img').Jcrop({
                            aspectRatio: 4,
                            onSelect: storeCoords,
                            minSize: [ 400, 100 ],
                            boxWidth: 570
                        }, function(){
                            JCropper = this;
                        });
                    }
                    if( mooConfig.isMobile && $('#cover_wrapper img').data('default') != null) {
                    	$('#cover_wrapper').spin('large');
                        $('#cover_wrapper img').attr('src', response.photo);
                    	var image = document.querySelector('#cover-img');
                        cropper = new Cropper(image, {
            	        	aspectRatio: 4 / 1,
            	        	zoomable : false,
            	        	viewMode : 3,
            	        	minCropBoxWidth: 400,
            	            minCropBoxHeight: 100,
            	            ready : function(){
            	            	$('#cover_wrapper').spin(false);
            	            },
            	            cropmove: function () {
            	            	$('#cover_wrapper').spin(false);
            	                cropper = this.cropper;
            	                var cropBoxData = cropper.getCropBoxData();
            	                console.log(cropBoxData);
            	                x = cropBoxData.left;
            	                y = cropBoxData.top;
            	                w = cropBoxData.width;
            	                h = cropBoxData.height;
            	            }
            	        });
                    }
                    else if(mooConfig.isMobile)
                    {                    	
                    	cropper.replace(response.photo);
                    }
                    $('#cover_wrapper img').data('default',null);
                }
            }
        });
        function validateFileDimensions(id, dimensionsLimits,obj)
        {
            window.URL = window.URL || window.webkitURL;
            var file = obj.getFile(id);
            var reader  = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {

                var image = new Image();
                var status = false;
                var sizeDetermination = {};

                image.onerror = function(e) {
                    sizeDetermination['error'] = mooPhrase.__('cannot_determine_dimensions_for_image_may_be_too_large');
                };

                image.onload = function() {
                    sizeDetermination = { width: this.width, height: this.height };

                    var minWidth = sizeDetermination.width >= dimensionsLimits[0],
                        minHeight = sizeDetermination.height >= dimensionsLimits[1];

                    // if min-width or min-height satisfied the limits, then approve the image
                    if( minWidth && minHeight ){
                        uploader.uploadStoredFiles();
                    }
                    else{
                        uploader.clearStoredFiles();
                        mooAlert.alert(mooPhrase.__('please_choose_an_image_that_s_at_least_400_pixels_wide_and_at_least_150_pixels_tall'));
                    }
                };
                image.src = reader.result;
            }
        }
    }

    // app/View/Users/ajax_avatar.ctp
    var initEditProfilePicture = function(){
        var JCropperAvatar;
        if( !mooConfig.isMobile ) {
            $('#av-img2').Jcrop({
                aspectRatio: 1,
                onSelect: storeCoords,
                minSize: [ 200, 200 ],
                boxWidth: 570
            }, function(){
                JCropperAvatar = this;
                initRotatePhoto(JCropperAvatar);
            });
        }
        else{
            $('.modal-footer').addClass('hide');
            initRotatePhoto(JCropperAvatar);
        }

        var uploader = new mooFileUploader.fineUploader({
            element: $('#select-0')[0],
            multiple: false,
            text: {
                uploadButton: '<div class="upload-section"><span class="upload-section-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>' + mooPhrase.__('drag_or_click_here_to_upload_photo') + '</div>'
            },
            validation: {
                allowedExtensions: mooConfig.photoExt,
                sizeLimit : mooConfig.sizeLimit
            },
            request: {
                endpoint: mooConfig.url.base + "/upload/avatar"
            },
            callbacks: {
                onError: mooGlobal.errorHandler,
                onComplete: function(id, fileName, response) {
                    $('#av-img').attr('src', response.avatar_mini);
                    if( !mooConfig.isMobile ) {
                        JCropperAvatar.setImage(response.avatar);
                    }else{
                        $('#avatar_wrapper img').attr('src', response.avatar);
                    }
                    $('#member-avatar').attr('src', response.thumb);
                    $('.avatar-rotate').show();
                }
            }
        });
    }

    // app/View/Elements/ajax/profile_edit.ctp
    var initOnProfileEdit = function(){

        $(".multi").multiSelect({
            selectAll: false,
            noneSelected: '',
            oneOrMoreSelected: mooPhrase.__('per_selected'),
        });

        $('#username').keyup(function() {
            var value = '';
            if ($('#username').val().trim() != '')
                value = '-' + $('#username').val().trim();
            $('#profile_user_name').html(value);
        });

        // bind action check username
        $('#checkButton').unbind('click');
        $('#checkButton').click(function(){
            checkUsername();
        });
    }

    var checkUsername = function(){

        mooButton.disableButton('checkButton');

        $.post(mooConfig.url.base + "/users/ajax_username", {username: $('#username').val()}, function(data){

            mooButton.enableButton('checkButton');

            var res = $.parseJSON(data);

            $('#message').html( res.message );

            if ( res.result == 1 ){
                $('#message').css('color', 'green');
            }
            else {
                $('#message').css('color', 'red');
            }

            $('#message').show();
        });
    }

    // app/View/Elements/lists/users_list.ctp
    var initOnUserList = function(){

        $("#list-content li").hover(
            function () {
                $(this).contents().find('.delete-icon').show();
            },
            function () {
                $(this).contents().find('.delete-icon').hide();
            }
        );

        // app/View/Elements/lists/users_list_bit.ctp
        initRespondRequest();

        // init remove member
        initRemoveMember();

        // init change admin action
        initChangeAdmin();

        mooBehavior.initMoreResults();
    }

    // app/View/Elements/lists/users_list_bit.ctp
    var initRemoveMember = function(){
        $('.removeMember').unbind('click');
        $('.removeMember').on('click', function(){
            var data = $(this).data();
            removeMember(data.id);
        });
    }

    // app/View/Elements/lists/users_list_bit.ctp
    var initChangeAdmin = function(){
        $('.changeAdmin').unbind('click');
        $('.changeAdmin').on('click', function(){
            var data = $(this).data();
            changeAdmin(data.id, data.type);
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

    var initRespondRequest = function(){
        $('.respondRequest').unbind('click');
        $('.respondRequest').on('click', function(){
            $('.respondRequest').unbind('click');
            var data = $(this).data();
            respondRequest(data.id, data.status);
        });

        $('.user_action_follow').unbind('click');
        $('.user_action_follow').click(function(){
			if (!validateUser()){
        		return false;
        	}
            element = $(this);
            $.ajax({
                type: 'POST',
                url: mooConfig.url.base + '/follows/ajax_update_follow',
                data : {user_id:$(this).data('uid')},
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
                    /*if (element.data('follow'))
                    {
                        element.data('follow',0);
                        element.attr('data-follow',0);
                        element.find('.btn-text').html(mooPhrase.__('text_follow'));
                        element.find('.btn-icon').html('rss_feed');
                    }
                    else
                    {
                        element.data('follow',1);
                        element.attr('data-follow',1);
                        element.find('.btn-text').html(mooPhrase.__('text_unfollow'));
                        element.find('.btn-icon').html('check');
                    }*/
                }
            });
        });

        if($('.profile-action .dropdown-menu li').length == 0){
            $('.profile-action .dropdown').hide();
        }
    }

    var initShowAlbums = function(){
        $('.showAlbums').unbind('click');
        $('.showAlbums').on('click', function(){
            showAlbums($(this).data('userId'));
        });
    }

    // app/View/Users/view.ctp
    var showAlbums = function (uid){

        $('#user_photos').spin('tiny');
        $('#user_photos').children('.badge_counter').hide();

        $('#profile-content').load(mooConfig.url.base + '/photos/profile_user_album/' + uid, {noCache: 1}, function (response) {
            $(this).html(response);
            $('#user_photos').spin(false);
            $('#user_photos').children('.badge_counter').fadeIn();
        });
    }

    // app/View/Users/view.ctp
    var requestJoinGroup = function(group_id){

        $.post(mooConfig.url.base + '/groups/request_to_join', {group_id: group_id}, function() {
            $.fn.SimpleModal({
                btn_ok: mooPhrase.__('btn_done'),
                btn_cancel: mooPhrase.__('btn_cancel'),
                callback: function(){
                    window.location = "";// "<?php echo $this->Html->url(array('plugin' => 'group', 'controller' => 'groups', 'action' => 'view', $groupTypeItem['id'])); ?>";
                },
                title: mooPhrase.__('join_group_request'),
                contents: mooPhrase.__('your_request_to_join_group_sent_successfully'),
                model: 'confirm',
                hideFooter: false,
                closeButton: false
            }).showModal();
        });
    }

    // app/View/Users/index.ctp
    // app/View/Landing/index.ctp
    var initOnUserIndex = function(){

        $(".multi").multiSelect({
            selectAll: false,
            noneSelected: '',
            oneOrMoreSelected: mooPhrase.__('per_selected')
        });

        $("#searchPeople").unbind('click');
        $("#searchPeople").click(function(){

            $('.browse-menu').CoreBrowseMenuSpinStart('#browse_all');

            $.post(mooConfig.url.base + '/users/ajax_browse/search', $("#filters").serialize(), function(data){
                $('.browse-menu').CoreBrowseMenuSpinStop('#browse_all');
                $('#list-content').html(data);
                mooOverlay.registerOverlay();

                $('body').trigger('afterSearchPeopleUserCallback',[]);
            });

            if($(window).width() < 992){
                $('#leftnav').sidebarModal('hide');
                $('#right').sidebarModal('hide');
                $('body').scrollTop(0);
            }
        });

        $('body').on('afterAjaxSearchServerJSCallback', function(e, data){
            if(data.search_name == 'users'){
                mooOverlay.registerOverlay();
            }
        });
    }

    // app/View/Users/profile.ctp
    var initOnUserProfile = function(){
        $('.deactiveMyAccount').unbind('click');
        $('.deactiveMyAccount').on('click', function(){
            mooAlert.confirm(mooPhrase.__('confirm_deactivate_account'), mooConfig.url.base + '/users/deactivate');
        });

        $('.deleteMyAccount').unbind('click');
        $('.deleteMyAccount').on('click', function(){
            mooAlert.confirm(mooPhrase.__('confirm_delete_account'), mooConfig.url.base + '/users/delete_account');
        });

        $('#save_profile').click(function( event ) {
            event.preventDefault();
            button = $(this);
            button.addClass('disabled');
            mooAjax.post({
                url : mooConfig.url.base + '/users/ajax_save_profile',
                data: jQuery("#form_edit_user").serialize()
            }, function(data){
                var json = $.parseJSON(data);

                if ( json.status )
                {
                    location.reload();
                }
                else
                {
                    button.removeClass('disabled');
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            return false;
        });
    }

    // app/View/Widgets/user/closeNetworkSignup.ctp
    var initOnCloseNetworkSignup = function(is_recaptcha){
        $('#username').keyup(function() {
            var value = '';
            if ($('#username').val().trim() != '')
                value = '-' + $('#username').val().trim();
            $('#profile_user_name').html(value);
        });

        $("#submitFormsignup").click(function(){
            $('#step1Box').spin('small');

            $('#submitFormsignup').attr('disabled', 'disabled');
            $.post(mooConfig.url.base + "/users/ajax_signup_step1", $("#regForm").serialize(), function(data){
                $('#step1Box').spin(false);

                if (data.indexOf('mooError') > 0) {
                    $("#regError").fadeIn();
                    $("#regError").html(data);
                    $('#submitFormsignup').removeAttr('disabled');
                } else {
                    $("#regError").fadeOut();
                    var obj = {status: false,data:data};
                    $('body').trigger('initOnRegistrationStep1Callback',[obj]);
                    if (!obj.status)
                	{
                    $("#regFields").append(data);
                	}
                    
                    $("#captcha").fadeIn();
                    $('#step1Box').remove();
                    $(".tip").tipsy({ html: true, gravity: 's' });

                    $(".multi").multiSelect({
                        selectAll: false,
                        noneSelected: '',
                        oneOrMoreSelected: mooPhrase.__('per_selected')
                    });
                }
            });

        });

        $("#step2Submit").click(function(){
            if($('#tos').is(':checked')){

                var isJson = false;

                $('#step2Box').spin('small');

                $('#step2Submit').attr('disabled', 'disabled');
                $.post(mooConfig.url.base + "/users/ajax_signup_step2", $("#regForm").serialize(), function(data){
                	$('#step2Box').spin(false);
                    var result = '';
                    var isJson = false;

                    try
                    {
                        result = JSON.parse(data);
                        isJson = true;
                    }
                    catch(e)
                    {

                    }

                    var sUrlRedirect = mooConfig.url.base + '/';
                    if(isJson && result.redirect) {
                        sUrlRedirect = result.redirect;
                        }

                    if (!isJson && data != '') {
                            $("#regError").fadeIn();
                            $("#regError").html(data);
                            $('#step2Submit').removeAttr('disabled');
                            if (is_recaptcha)
                            {
                                grecaptcha.reset(); // FIXED_JS if ($this->Moo->isRecaptchaEnabled()):
                            }
                            return;
                        }
                    var obj = {status: false,sUrlRedirect:sUrlRedirect};
                    $('body').trigger('initOnRegistrationStep2Callback',[obj]);
                    if (!obj.status)
                    {
                    	window.location = sUrlRedirect;
                    }
                });

            }else{
                $("#regError").fadeIn();
                $("#regError").html(mooPhrase.__('you_have_to_agree_with_term_of_service'));
            }
        });
    }

    var resendValidationLink = function(){
        $('#resend_validation_link').unbind('click');
        $('#resend_validation_link').on('click', function(){
            $.post(mooConfig.url.base + '/users/resend_validation', {}, function(data){
                mooAlert.alert(mooPhrase.__('validation_link_has_been_resend'));
            });
        });
    }

    var initBlockUser = function(){

        $('#blockUserButton').unbind('click');
        $('#blockUserButton').click(function(){

            $('#blockUserButton').spin('small');

            mooButton.disableButton('blockUserButton');

            $.post(mooConfig.url.base + "/user_blocks/ajax_do_add", $("#blockUserForm").serialize(), function(data){

                mooButton.enableButton('blockUserButton');

                $('#themeModal').modal('hide');
                window.location.href = mooConfig.url.base + '/';
            });
            return false;
        });
    }

    var initUnBlockUser = function(){

        $('#unBlockUserButton').unbind('click');
        $('#unBlockUserButton').click(function(){

            $('#unBlockUserButton').spin('small');

            mooButton.disableButton('unBlockUserButton');

            $.post(mooConfig.url.base + "/user_blocks/ajax_do_remove", $("#unBlockUserForm").serialize(), function(data){

                mooButton.enableButton('unBlockUserButton');

                $('#themeModal').modal('hide');

                location.reload();
            });
            return false;
        });
    }

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
    var initSearchFriend = function(id)
    {
        $('#form_friend_search').submit(function( event ) {
            event.preventDefault();
            return false;
        });

        $('#form_friend_search').find('.friend_search_btn').click(function (e) {
            searchFriend(id);
        });

        $('#search_friend').unbind('keyup');
        $('#search_friend').keyup(function() {
            searchFriend(id);
        });
    }
    var searchFriend = function (id) {
        delay(function(){
            if (id)
            {
                url = mooConfig.url.base + "/users/profile_user_friends/"+id;
            }
            else
            {
                url = mooConfig.url.base + "/users/ajax_browse/home";
            }
            $.post(url, {is_search: true,search: $('#search_friend').val()}, function (data) {
                $('#list-content').html(data);
                mooBehavior.initMoreResults();
                mooTooltip.init();
            });
        }, 200 );
    }

    var loadProfileType = function(type){
        $('.core_profile_type_id').unbind('change').change(function(){
            var profile_type_id = $(this).val();
            var data_for = $(this).attr('data-for');
            var ele_custom_field = $(data_for);
            $.get( mooConfig.url.base + "/users/ajax_loadfields/" + profile_type_id + '/' + type, function( data ) {
                ele_custom_field.html( data );

                $(".multi").multiSelect({
                    selectAll: false,
                    noneSelected: '',
                    oneOrMoreSelected: mooPhrase.__('per_selected'),
                });

                $('body').trigger('afterChangeProfileTypeUserCallback',[{'data_for': data_for}]);
            });
        });
    }

    return{
        validateUser : validateUser,
        initOnRegistration : initOnRegistration,
        initOnSignupStep1 : initOnSignupStep1,
        initOnSignupStep1FieldCountry : initOnSignupStep1FieldCountry,
        initOnProfilePicture : initOnProfilePicture,
        initAddFriend : initAddFriend,
        initBirthdayPopup : initBirthdayPopup,
        initEditCoverPicture : initEditCoverPicture,
        initEditProfilePicture : initEditProfilePicture,
        initRemoveFriend : initRemoveFriend,
        initOnProfileEdit : initOnProfileEdit,
        initOnUserList : initOnUserList,
        initAjaxRequest : initAjaxRequest,
        initAjaxRequestPopup : initAjaxRequestPopup,
        initShowAlbums : initShowAlbums,
        initRespondRequest : initRespondRequest,
        initOnUserIndex : initOnUserIndex,
        initOnUserProfile : initOnUserProfile,
        initOnCloseNetworkSignup : initOnCloseNetworkSignup,
        resendValidationLink : resendValidationLink,
        initOnSocialRegistration : initOnSocialRegistration,
        initOnUserView : initOnUserView,
        initBlockUser : initBlockUser,
        initUnBlockUser : initUnBlockUser,
        initRemoveFollow: initRemoveFollow,
        initSearchFriend: initSearchFriend,
        loadProfileType: loadProfileType
    }
}));