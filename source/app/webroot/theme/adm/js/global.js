(function ($) {

    var self = null;

    //Attach this new method to jQuery
    $.fn.extend({
        buttons: null,
        options: null,
        defaults: {
            onAppend: null,
            offsetTop: null,
            overlayOpacity: .3,
            overlayColor: "#000000",
            width: 400,
            draggable: true,
            keyEsc: true,
            overlayClick: false,
            closeButton: true, // X close button
            hideHeader: false,
            hideFooter: true,
            btn_ok: 'Ok', // Label
            btn_cancel: 'Cancel', // Label
            template: "<div class=\"simple-modal-header title-modal\"> \
                {_TITLE_} \
            </div> \
                <div class=\"simple-modal-body modal-body\"> \
                <div class=\"contents\" id=\"simple-modal-body\">{_CONTENTS_}</div> \
            </div> \
                <div class=\"simple-modal-footer\"></div>"
        },
        SimpleModal: function (options) {
            self = this;

            this.buttons = [];
            this.options = $.extend({}, self.defaults, options);

            return this;
        },
        /**
         * public method showModal
         * Open Modal
         * @options: param to rewrite
         * @return node HTML
         */
        showModal: function () {
            var node = null;

            // Switch different modal
            switch (this.options.model) {
                case "modal-ajax":
                    node = this._drawWindow(this.options);
                    this._loadContents({
                        "url": self.options.param.url || "",
                        "onRequestComplete": this.options.param.onRequestComplete
                    });
                    break;
                case "confirm":
                    // Add button confirm
                    this.addButton(this.options.btn_ok, "btn btn-action", function () {
                        // in oppose to original version, i'm not catching exceptions
                        // i want to know what's eventually goes wrong
                        self.options.callback();
                        self.hideModal();
                    });
                    // Add button cancel
                    this.addButton(this.options.btn_cancel, "button button-action");
                    node = this._drawWindow(this.options);
                    break;
                case "modal":
                    this.addButton(this.options.btn_ok, "btn btn-action", function () {
                        self.hideModal();
                    });
                    node = this._drawWindow(this.options);
                    break;
                case "content":
                    node = this._drawWindow(this.options);
                    break;
                default:
                    // Alert
                    this.addButton(this.options.btn_ok, "btn btn-action primary");
                    node = this._drawWindow(this.options);
                    break;
            }

            if (node) {

                // Resize Stage
                this._display();
            }
        },
        /**
         * public method hideModal
         * Close model window
         * return
         */
        hideModal: function () {
            self._overlay('hide');
            // close modal bootstrap
            $('.modal-backdrop').remove();
            $('#simpleModal').remove();
        },
        /**
         * private method _drawWindow
         * Rendering window
         * return node SM
         */
        _drawWindow: function (options) {
            // Add Node in DOM
            var node = $("<div>").addClass('simple-modal modal-dialog').attr('id', 'simple-modal');

            // Set Contents
            node.html($("<div>").addClass('modal-content').html(this._template(self.options.template, {"_TITLE_": options.title || "Untitled", "_CONTENTS_": options.contents || ""})));
            node = $("<div>").addClass("modal fade in").attr('id', 'simpleModal').attr('aria-hidden', false).attr('aria-labelledby', 'myModalLabel').attr('role', 'basic').css({'display': 'block'}).html(node);

            $('body').append(node);
            $('body').append('<div class="modal-backdrop fade in"></div>');
            // Add all buttons
            this._injectAllButtons();

            // Callback append
            if (this.options.onAppend) {
                this.options.onAppend.call(this);
            }
            return node;
        },
        /**
         * public method addButton
         * Add button to Modal button array
         * require @label:string, @classe:string, @clickEvent:event
         * @return node HTML
         */
        addButton: function (label, classe, clickEvent) {
            var bt = $('<a>').attr({
                "title": label,
                "class": classe
            }).click(clickEvent ? function (e) {
                clickEvent.call(self, e);
            } : self.hideModal).text(label);

            this.buttons.push(bt);
            return this;
        },
        /**
         * private method _injectAllButtons
         * Inject all buttons in simple-modal-footer
         * @return
         */
        _injectAllButtons: function () {
            var footer = $("#simple-modal").find(".simple-modal-footer");

            $.each(self.buttons, function (i, e) {
                footer.append(e);
            });
        },
        /**
         * private method _addCloseButton
         * Inject Close botton (X button)
         * @return node HTML
         */
        _addCloseButton: function () {
            var b = $("<a>").addClass('close').attr({"href": "#"}).html('<i class="icon-remove"></i>').click(function (e) {
                self.hideModal();
                return false;
            });
            $("#simple-modal").append(b);
            return b;
        },
        /**
         * private method _overlay
         * Create/Destroy overlay and Modal
         * @return
         */
        _overlay: function (status) {
            switch (status) {
                case 'show':

                    var overlay = $("<div>")
                            .attr("id", "simple-modal-overlay")
                            .css({"background-color": this.options.overlayColor, "opacity": 0});

                    $('body').append(overlay);

                    overlay.animate({opacity: this.options.overlayOpacity});

                    // Behaviour
                    if (this.options.overlayClick) {
                        overlay.click(function (e) {
                            self.hideModal();
                        });
                    }

                    // Add Control Resize
                    $(window).resize(self._display);
                    $(document).keyup(self._escape);
                    break;

                case 'hide':
                    // Remove Overlay
                    $('#simple-modal-overlay').remove();
                    $('#simple-modal').remove();

                    $(window).unbind('resize', self._display);
                    $(document).unbind('keyup', self._escape);
            }
        },
        _escape: function (e) {
            if (e.keyCode == 27)
                self.hideModal();
        },
        /**
         * private method _loadContents
         * Async request for modal ajax
         * @return
         */
        _loadContents: function (param) {
            // Set Loading
            $('#simple-modal-body').spin('small');
            // Match image file
            var re = new RegExp(/([^\/\\]+)\.(jpg|png|gif)$/i), container = $('#simple-modal');
            if (param.url.match(re)) {
                // Hide Header/Footer
                container.addClass("hide-footer");
                // Remove All Event on Overlay
                $("#simple-modal-overlay").unbind(); // Prevent Abort
                // Immagine
                var image = $('<img>').attr('src', param.url)
                        .load(function () {
                            var content = container.find(".contents").empty().append($(this).css('opacity', 0));
                            var dw = container.width() - content.width(), dh = container.height() - content.height();
                            var width = $(this).width() + dw, height = $(this).height() + dh;

                            container.animate({
                                width: width,
                                height: height,
                                left: ($(window).width() - width) / 2,
                                top: ($(window).height() - height) / 2
                            }, 200, function () {
                                image.animate({opacity: 1});
                            });
                        });
            } else {
                $('#simple-modal .contents').load(param.url, function (responseText, textStatus, XMLHttpRequest) {
                    var container = $('#simple-modal');
                    if (textStatus !== 'success') {
                        container.find(".contents").html("loading failed");

                        if (param.onRequestFailure) {
                            param.onRequestFailure();
                        }
                    }
                    else
                    {
                        if (param.onRequestComplete) {
                            param.onRequestComplete();
                        }
                        self._display();
                    }
                });
            }
        },
        /**
         * private method _display
         * Move interface
         * @return
         */
        _display: function () {
            // Update overlay
            $("#simple-modal-overlay").css({width: $(window).width(), height: $(window).height()});

            // Update position popup
            var modal = $("#simple-modal"), top = self.options.offsetTop || ($(window).height() - modal.height()) / 2;
        },
        /**
         * private method _template
         * simple template by Thomas Fuchs
         * @return
         */
        _template: function (s, d) {
            for (var p in d) {
                s = s.replace(new RegExp('{' + p + '}', 'g'), d[p]);
            }
            return s;
        }
    });

})(jQuery);

$(document).ready(function(){	
	//$('textarea:not(.no-grow)').elastic();
	//$('input, textarea').placeholder();
	//$(".tip").tipsy({ html: true, gravity: 's' });
	  
	$('#loginButton').on('click', function(){
		$('#loginForm').toggle();
	});

	registerOverlay();
	
	$('#browse a:not(.overlay):not(.no-ajax)').click(function(){		
		$(this).children('.badge_counter').hide();
		$(this).spin('tiny');
		
		$('#browse .current').removeClass('current');
		$(this).parent().addClass('current');
		
		var div = jQuery(this).attr('rel');
		if ( div == undefined )
			div = 'list-content';
		
		var el = $(this);
		$('#' + div).load( $(this).attr('data-url'), {noCache: 1}, function(){
			//$('#browseLoading').remove();
			el.children('.badge_counter').fadeIn();
			el.spin(false);
			
			// reattach events
			$('textarea:not(.no-grow)').elastic();			
			$(".tip").tipsy({ html: true, gravity: 's' });			
			//boxy.hide();
			registerOverlay();			
			
			window.history.pushState({},"", el.attr('href'));
		});
		
		return false;
	});
	
	jQuery('#keyword').keyup(function(event) {
		if (event.keyCode == '13') {
			$('#browse_all').spin('tiny');
			jQuery('#browse .current').removeClass('current');
			jQuery('#browse_all').addClass('current');
			
			jQuery('#list-content').load( mooConfig.url.base + '/' + jQuery(this).attr('rel') + '/ajax_browse/search/' + encodeURI( jQuery(this).val() ), {noCache: 1}, function(){
				$('#browse_all').spin(false);
				jQuery('#keyword').val('');
			});
		}
	});
	
	jQuery('#global-search').keyup(function(event) {
        if (event.keyCode == '13') {
            window.location = mooConfig.url.base + '/search/index/' + jQuery(this).val();
        }
    });
    
    jQuery('#global-search-filters a:not(.no-ajax)').click(function(){       
        jQuery(this).spin('tiny');
        jQuery('#global-search-filters .current').removeClass('current');
        jQuery(this).parent().addClass('current');
        
        switch ( jQuery(this).attr('id') )
        {
            case 'filter-blogs':
            case 'filter-groups':
            case 'filter-topics':
                jQuery('#search-content').html('<ul class="list6 comment_wrapper" id="list-content">'+mooPhrase.__('loading')+'</ul>');
                break;
                
            case 'filter-albums':
            case 'filter-videos':
                jQuery('#search-content').html('<ul class="list4 albums" id="list-content">'+mooPhrase.__('loading')+'</ul>');
                break;
                
            case 'filter-users':
                jQuery('#search-content').html('<ul class="list1 users_list" id="list-content">'+mooPhrase.__('loading')+'</ul>');
                break;
        }
        
        var obj = $(this);
        jQuery('#list-content').load( encodeURI( jQuery(this).attr('data-url') ), {noCache: 1}, function(){
            obj.spin(false);    
        });
        return false;
    });

    jQuery('.login_as_user').on('click',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        mooConfirm(mooPhrase.__('confirm_login_as_user'),mooConfig.url.base + '/admin/users/login_as_user/'+id);
    });
});

var sModal;

function registerOverlay()
{
	$('.overlay').unbind('click');
	$('.overlay').click(function()
	{
		overlay_title = $(this).attr('title');
		overlay_url = $(this).attr('href');
		overlay_div = $(this).attr('rel');

		if (overlay_div)
		{
			sModal = $.fn.SimpleModal({
		        model: 'modal',
		        title: overlay_title,
		        contents: $('#' + overlay_div).html()
		   });
		}
		else
		{
			sModal = $.fn.SimpleModal({
		        width: 600,
		        model: 'modal-ajax',
		        title: overlay_title,
		        offsetTop: 100,
		        param: {
		            url: overlay_url,
		            onRequestComplete: function() {
		            	$(".tip").tipsy({ html: true, gravity: 's' });
		            },
		            onRequestFailure: function() { }
		        }
		    });
		}
		
		sModal.showModal();

		return false;
	});
}

function registerImageOverlay()
{
	$('.attached-image').magnificPopup({
        type:'image',
        gallery: { enabled: true },
        zoom: { 
            enabled: true, 
            opener: function(openerElement) {
              return openerElement.parent();
            }
        }
    });
}

function submitComment(activity_id)
{
	if (jQuery.trim(jQuery("#commentForm_"+activity_id).val()) != '')
	{
		$('#commentButton_' + activity_id + ' a').addClass('disabled');
		$('#commentButton_' + activity_id + ' a').prepend('<i class="icon-refresh icon-spin"></i>');
		$.post(mooConfig.url.base + "/activities/ajax_comment", {activity_id: activity_id, comment: jQuery("#commentForm_"+activity_id).val()}, function(data){
			if (data != '')
				showPostedComment(activity_id, data);
		});
	}
}

function submitItemComment(item_type, item_id, activity_id)
{
	if ($.trim(jQuery("#commentForm_"+activity_id).val()) != '')
	{
		$('#commentButton_' + activity_id + ' a').prepend('<i class="icon-refresh icon-spin"></i>');
		$('#commentButton_' + activity_id + ' a').addClass('disabled');
		$.post(mooConfig.url.base + "/comments/ajax_share", {type: item_type, target_id: item_id, message: jQuery("#commentForm_"+activity_id).val(), activity: 1}, function(data){
			if (data != '')
				showPostedComment(activity_id, data);
		});
	}
}

function showPostedComment(activity_id, data)
{
	$('#newComment_'+activity_id).before(data);
	$('.slide').slideDown();
	$('#commentButton_' + activity_id + ' a').removeClass('disabled');
	$('#commentButton_' + activity_id + ' a i').remove();
	$("#commentForm_"+activity_id).val('');
	$("#commentButton_"+activity_id).hide();
	registerCrossIcons();				
	$('.commentBox').css('height', '27px');
}

function showCommentButton(activity_id)
{
	$("#commentButton_"+activity_id).show();
}

function showCommentForm(activity_id)
{
	jQuery("#comments_"+activity_id).show();
	jQuery("#newComment_"+activity_id).show();
}

function postWall()
{
	var msg = $('#message').val();
	if ($.trim(msg) != '')
	{
		disableButton('status_btn');
		$.post(mooConfig.url.base + "/activities/ajax_share", $("#wallForm").serialize(), function(data){
			enableButton('status_btn');
			$('#message').val("");
			if (data != '')
			{
				$('#list-content').prepend(data);			
				registerCrossIcons();
				$('#message').css('height', '25px');
				$('#wall_photo_preview').fadeOut(function(){
					$('.slide').slideDown();
					$('#wall_photo_preview').html('');
					$('#wall_photo_preview').show();
				});
			}
		});
	}
}

function ajax_postComment()
{
	if ($.trim($('#postComment').val()) != '')
	{
		$('#shareButton').addClass('disabled');
		$('#shareButton').prepend('<i class="icon-refresh icon-spin"></i>');
		$.post(mooConfig.url.base + "/comments/ajax_share", $("#commentForm").serialize(), function(data){
			$('#shareButton').removeClass('disabled');
			$('#shareButton i').remove();
			
			$('#postComment').val("");
			if (data != '')
			{
				$('#comments').append(data);
				$('.slide').slideDown();	
				$('#message').css('height', '37px');
				$("#comment_count").html( parseInt($("#comment_count").html()) + 1 );
								
				$("#comments li").hover(
					function () {
					$(this).contents('.cross-icon').show();
				  }, 
				  function () {
					$(this).contents('.cross-icon').hide();
				  }
				);
			}
		});
	}
}

function createItem( type, jsonView)
{
	disableButton('createButton');
    var action = 'ajax_save';
    if(jsonView)
        action  = 'save';
    mooAjax.post({
        url : mooConfig.url.base + "/" + type + "/"+action,
        data: jQuery("#createForm").serialize()
    }, function(data){
        enableButton('createButton');
        var json = $.parseJSON(data);

        if ( json.result == 1 )
            window.location = mooConfig.url.base + '/' + type + '/view/' + json.id;
        else
        {
            $(".error-message").show();
            $(".error-message").html(json.message);

        }
    });
} 

function moreResults(url, div, obj)
{	
	$(obj).spin('small');
	$(obj).css('color', 'transparent');
	$.post(mooConfig.url.base + url, function(data){
		$(obj).spin(false);
		$('#' + div + ' .view-more').remove();
		if ( div == 'comments' )
			$("#" + div).prepend(data);
		else
			$("#" + div).append(data);
			
		registerOverlay();
	});
}

function mooAlert(msg)
{
    $.fn.SimpleModal({btn_ok: 'OK', title: 'Message', hideFooter: false, closeButton: false, model: 'alert', contents: msg}).showModal();

}

function mooConfirm( msg, url )
{
    // Set title
    $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
    // Set content
    $($('#portlet-config  .modal-body')[0]).html(msg);
    // OK callback
    $('#portlet-config  .modal-footer .ok').click(function(){
        window.location = url;
    });
    $('#portlet-config').modal('show');

}

function mooConfirmBox( msg, callback )
{
    // Set title
    $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
    // Set content
    $($('#portlet-config  .modal-body')[0]).html(msg);
    // OK callback, remove all events bound to this element
    $('#portlet-config  .modal-footer .ok').off("click").click(function(){
        callback();
        $('#portlet-config').modal('hide');
    });
    $('#portlet-config').modal('show');

}

function mooConfirmSendMail( msg, url, msg_after )
{
    // Set title
    $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
    // Set content
    $($('#portlet-config  .modal-body')[0]).html(msg);
    // OK callback
    $('#portlet-config  .modal-footer .ok').click(function(){
        // Set title
        $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('send_email_progress'));
        // Set content
        $($('#portlet-config  .modal-body')[0]).html(msg_after+'<br /><br /><iframe frameborder="0" width="100%" height="200" src='+url+'></iframe>');

        $('.ok').hide();
        $('#portlet-config').modal('show');
    });
    $('#portlet-config').modal('show');
}

function toggleCheckboxes(obj)
{
    if ( obj.checked ){
        $(obj).parents('.field-description').find('.check').attr('checked', 'checked');
        $(obj).parents('.field-description').find('span').addClass('checked');
    }
    else{
        $(obj).parents('.field-description').find('.check').attr('checked', false);
        $(obj).parents('.field-description').find('span').removeClass('checked');
    }

}


function toggleCheckboxes2(obj)
{
    if ( obj.checked ){
        jQuery('.check').attr('checked', 'checked');
        jQuery('.check').parent('span').addClass('checked');
    }
	else{
        jQuery('.check').attr('checked', false);
        jQuery('.check').parent('span').removeClass('checked');
    }

}


function confirmSubmitForm(msg, form_id)
{
    $('#category').val($("#category_id").val());
    // Set title
    $($('#portlet-config  .modal-header .modal-title')[0]).html(mooPhrase.__('please_confirm'));
    // Set content
    $($('#portlet-config  .modal-body')[0]).html(msg);
    // OK callback
    $('#portlet-config  .modal-footer .ok').click(function(){
        $('#portlet-config').modal('hide');
        document.getElementById(form_id).submit();
    });
    $('#portlet-config').modal('show');

}

function registerCrossIcons()
{
	$("#list-content li").hover(
		function () {
		$(this).contents('.cross-icon').show();
	  }, 
	  function () {
		$(this).contents('.cross-icon').hide();
	  }
	);
}

function likeIt( type, item_id, thumb_up )
{
	jQuery.post(mooConfig.url.base + '/likes/ajax_add/' + type + '/' + item_id + '/' + thumb_up, { noCache: 1 }, function(data){
	    try
	    {
    	    var res = jQuery.parseJSON(data);
    	    
            jQuery('#like_count').html( parseInt(res.like_count) );
            jQuery('#dislike_count').html( parseInt(res.dislike_count) );  
            jQuery('#like_count2').html( parseInt(res.like_count) );       
            
            if ( thumb_up )
            {
                jQuery('#like_count').parent().toggleClass('active');
                jQuery('#dislike_count').parent().removeClass('active');
            }
            else
            {
                jQuery('#dislike_count').parent().toggleClass('active');
                jQuery('#like_count').parent().removeClass('active');
            }
        } 
        catch (err)
        {
            alert(data);
        }
	});
}

function likePhoto( item_id, thumb_up )
{ 
    jQuery.post(mooConfig.url.base + '/likes/ajax_add/photo/' + item_id + '/' + thumb_up, { noCache: 1 }, function(data){
        try
        {
            var res = jQuery.parseJSON(data);
            
            jQuery('#photo_like_count2').html( parseInt(res.like_count) );
            jQuery('#photo_dislike_count2').html( parseInt(res.dislike_count) );        
            
            if ( thumb_up )
            {
                jQuery('#photo_like_count').toggleClass('active');
                jQuery('#photo_dislike_count').removeClass('active');
            }
            else
            {
                jQuery('#photo_dislike_count').toggleClass('active');
                jQuery('#photo_like_count').removeClass('active');
            }
        } 
        catch (err)
        {
            alert(data);
        }
    });
}

function likeActivity(type, id, thumb_up)
{
	$.post(mooConfig.url.base + '/likes/ajax_add/' + type + '/' + id + '/' + thumb_up, { noCache: 1 }, function(data){
	    try
	    {
    		var res = $.parseJSON(data);
            $('#' + type + '_like_' + id).html( parseInt(res.like_count) );
            $('#' + type + '_dislike_' + id).html( parseInt(res.dislike_count) );
            
            if ( thumb_up )
            {
                $('#' + type + '_l_' + id).toggleClass('active');
                $('#' + type + '_d_' + id).removeClass('active');
            }
            else
            {
                $('#' + type + '_d_' + id).toggleClass('active');
                $('#' + type + '_l_' + id).removeClass('active');
            }
        } 
        catch (err)
        {
            alert(data);
        }
	});
}

function showFeedVideo( source, source_id, activity_id )
{
	$('#video_teaser_' + activity_id + ' .vid_thumb').spin('small');
	$('#video_teaser_' + activity_id).load(mooConfig.url.base + '/videos/embed', { source: source, source_id: source_id }, function(){
		$('#video_teaser_' + activity_id + ' > .vid_thumb').spin(false);
	});
}



function toggleMenu(menu)
{
    if ( menu == 'leftnav' )
    {
        if ( jQuery('#leftnav').css('left') == '-200px' )
        {
            jQuery('#leftnav').animate({left:0}, 300);
            jQuery('#right').animate({right:-204}, 300);
            jQuery('#center').animate({left:200}, 300);
        }
        else
        {
            jQuery('#leftnav').animate({left:-200}, 300);
            jQuery('#center').animate({left:0}, 300);
        }
    }
    else
    {
        if ( jQuery('#right').css('right') == '-204px' )
        {
            jQuery('#right').show();
            jQuery('#right').animate({right:0}, 300);
            jQuery('#leftnav').animate({left:-200}, 300);
            jQuery('#center').animate({left:0}, 300);
        }
        else
        {
            jQuery('#right').animate({right:-204}, 300, function(){
            	jQuery('#right').hide();
            });            
            //jQuery('#center').animate({left:0}, 300);
        }
    }
}

function globalSearchMore( filter )
{
    jQuery('#filter-' + filter).trigger('click');
}

function showMooDropdown(obj)
{
    jQuery(obj).next().toggle();
}

function doModeration( action, type )
{
    
    var tmp  = type.substring(0,type.length - 1);
    var url = tmp + '/' + tmp + '_plugins';
    
    switch ( action )
    {
        case 'delete':
            $('#deleteForm').attr('action', mooConfig.url.base + '/admin/' + url + '/delete');
            confirmSubmitForm('Are you sure you want to delete these ' + type + '?', 'deleteForm'); 
        break;
        
        case 'move':
            $('#deleteForm').attr('action', mooConfig.url.base + '/admin/' + url + '/move');
            $('#category_id').show();
        break;
        
        default:
            $('#category_id').hide();
    }
}

var tmp_class;
function disableButton(button)
{
	tmp_class = $("#" + button + " i").attr("class");
	$("#" + button + " i").attr("class", "icon-refresh icon-spin");
	$("#" + button).addClass('disabled');
}

function enableButton(button)
{
	$("#" + button + " i").attr("class", tmp_class);
	$("#" + button).removeClass('disabled');
}

function initTabs(tab)
{
	jQuery('#' + tab + ' .tabs > li').click(function(){
        jQuery('#' + tab + ' li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('#' + tab + ' .tab').hide();
        jQuery('#'+jQuery(this).attr('id')+'_content').show();
    });
}

function showMore(obj)
{
	$(obj).prev().css('max-height', 'none');
	$(obj).replaceWith('<a href="javascript:void(0)" onclick="showLess(this)" class="show-more">' + $(obj).prev().data('less-text') + '</a>');
}

function showLess(obj)
{
	$(obj).prev().css('max-height', '');
	$(obj).replaceWith('<a href="javascript:void(0)" onclick="showMore(this)" class="show-more">' + $(obj).prev().data('more-text') + '</a>');
}

/*function viewFullSite()
{
	$.cookie('fullsite', 1, { expires: 7 });
	location.reload();
}

function viewMobileSite()
{
	$.removeCookie('fullsite');
	location.reload();
}*/


// spin
!function(t,e,i){var o=["webkit","Moz","ms","O"],r={},n;function a(t,i){var o=e.createElement(t||"div"),r;for(r in i)o[r]=i[r];return o}function s(t){for(var e=1,i=arguments.length;e<i;e++)t.appendChild(arguments[e]);return t}var f=function(){var t=a("style",{type:"text/css"});s(e.getElementsByTagName("head")[0],t);return t.sheet||t.styleSheet}();function l(t,e,i,o){var a=["opacity",e,~~(t*100),i,o].join("-"),s=.01+i/o*100,l=Math.max(1-(1-t)/e*(100-s),t),p=n.substring(0,n.indexOf("Animation")).toLowerCase(),u=p&&"-"+p+"-"||"";if(!r[a]){f.insertRule("@"+u+"keyframes "+a+"{"+"0%{opacity:"+l+"}"+s+"%{opacity:"+t+"}"+(s+.01)+"%{opacity:1}"+(s+e)%100+"%{opacity:"+t+"}"+"100%{opacity:"+l+"}"+"}",f.cssRules.length);r[a]=1}return a}function p(t,e){var r=t.style,n,a;if(r[e]!==i)return e;e=e.charAt(0).toUpperCase()+e.slice(1);for(a=0;a<o.length;a++){n=o[a]+e;if(r[n]!==i)return n}}function u(t,e){for(var i in e)t.style[p(t,i)||i]=e[i];return t}function c(t){for(var e=1;e<arguments.length;e++){var o=arguments[e];for(var r in o)if(t[r]===i)t[r]=o[r]}return t}function d(t){var e={x:t.offsetLeft,y:t.offsetTop};while(t=t.offsetParent)e.x+=t.offsetLeft,e.y+=t.offsetTop;return e}var h={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#000",speed:1,trail:100,opacity:1/4,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"};function m(t){if(!this.spin)return new m(t);this.opts=c(t||{},m.defaults,h)}m.defaults={};c(m.prototype,{spin:function(t){this.stop();var e=this,i=e.opts,o=e.el=u(a(0,{className:i.className}),{position:i.position,width:0,zIndex:i.zIndex}),r=i.radius+i.length+i.width,s,f;if(t){t.insertBefore(o,t.firstChild||null);f=d(t);s=d(o);u(o,{left:(i.left=="auto"?f.x-s.x+(t.offsetWidth>>1)+'px':parseInt(i.left,10)+r+'%'),top:(i.top=="auto"?f.y-s.y+(t.offsetHeight>>1):parseInt(i.top,10)+r)+"px"})}o.setAttribute("aria-role","progressbar");e.lines(o,e.opts);if(!n){var l=0,p=i.fps,c=p/i.speed,h=(1-i.opacity)/(c*i.trail/100),m=c/i.lines;(function y(){l++;for(var t=i.lines;t;t--){var r=Math.max(1-(l+t*m)%c*h,i.opacity);e.opacity(o,i.lines-t,r,i)}e.timeout=e.el&&setTimeout(y,~~(1e3/p))})()}return e},stop:function(){var t=this.el;if(t){clearTimeout(this.timeout);if(t.parentNode)t.parentNode.removeChild(t);this.el=i}return this},lines:function(t,e){var i=0,o;function r(t,o){return u(a(),{position:"absolute",width:e.length+e.width+"px",height:e.width+"px",background:t,boxShadow:o,transformOrigin:"left",transform:"rotate("+~~(360/e.lines*i+e.rotate)+"deg) translate("+e.radius+"px"+",0)",borderRadius:(e.corners*e.width>>1)+"px"})}for(;i<e.lines;i++){o=u(a(),{position:"absolute",top:1+~(e.width/2)+"px",transform:e.hwaccel?"translate3d(0,0,0)":"",opacity:e.opacity,animation:n&&l(e.opacity,e.trail,i,e.lines)+" "+1/e.speed+"s linear infinite"});if(e.shadow)s(o,u(r("#000","0 0 4px "+"#000"),{top:2+"px"}));s(t,s(o,r(e.color,"0 0 1px rgba(0,0,0,.1)")))}return t},opacity:function(t,e,i){if(e<t.childNodes.length)t.childNodes[e].style.opacity=i}});(function(){function t(t,e){return a("<"+t+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',e)}var e=u(a("group"),{behavior:"url(#default#VML)"});if(!p(e,"transform")&&e.adj){f.addRule(".spin-vml","behavior:url(#default#VML)");m.prototype.lines=function(e,i){var o=i.length+i.width,r=2*o;function n(){return u(t("group",{coordsize:r+" "+r,coordorigin:-o+" "+-o}),{width:r,height:r})}var a=-(i.width+i.length)*2+"px",f=u(n(),{position:"absolute",top:a,left:a}),l;function p(e,r,a){s(f,s(u(n(),{rotation:360/i.lines*e+"deg",left:~~r}),s(u(t("roundrect",{arcsize:i.corners}),{width:o,height:i.width,left:i.radius,top:-i.width>>1,filter:a}),t("fill",{color:i.color,opacity:i.opacity}),t("stroke",{opacity:0}))))}if(i.shadow)for(l=1;l<=i.lines;l++)p(l,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(l=1;l<=i.lines;l++)p(l);return s(e,f)};m.prototype.opacity=function(t,e,i,o){var r=t.firstChild;o=o.shadow&&o.lines||0;if(r&&e+o<r.childNodes.length){r=r.childNodes[e+o];r=r&&r.firstChild;r=r&&r.firstChild;if(r)r.opacity=i}}}else n=p(e,"animation")})();if(typeof define=="function"&&define.amd)define(function(){return m});else t.Spinner=m}(window,document);

(function(factory) {

  if (typeof exports == 'object') {
    // CommonJS
    factory(require('jquery'), require('spin'))
  }
  else if (typeof define == 'function' && define.amd) {
    // AMD, register as anonymous module
    define(['jquery', 'spin'], factory)
  }
  else {
    // Browser globals
    if (!window.Spinner) throw new Error('Spin.js not present')
    factory(window.jQuery, window.Spinner)
  }

}(function($, Spinner) {

  $.fn.spin = function(opts, color) {

    return this.each(function() {
      var $this = $(this),
        data = $this.data();

      if (data.spinner) {
        data.spinner.stop();
        delete data.spinner;
      }
      if (opts !== false) {
        opts = $.extend(
          { color: color || $this.css('color') },
          $.fn.spin.presets[opts] || opts
        )
        data.spinner = new Spinner(opts).spin(this)
      }
    })
  }

  $.fn.spin.presets = {
    tiny: { lines:11, length:3, width:1, radius:3, left: 88 },
    small: { lines:11, length:5, width:2, radius:5 },
    large: { color:'#fff', lines:11, length:9, width:7, radius:10, shadow: true }
  }

}));