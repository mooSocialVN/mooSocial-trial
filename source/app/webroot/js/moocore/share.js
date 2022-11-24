/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooPhrase', 'mooUser', 'mooToggleEmoji', 'hideshare', 'bootstrap'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooShare = factory();
    }
}(this, function ($, mooPhrase, mooUser, mooToggleEmoji) {
    
    var file_uploading = 0;
    
    // app/View/Activities/ajax_share.ctp
    var init = function () {
        $(window).on('beforeunload', function () {
            if (file_uploading == 1)
            {
                return confirmNavigation();
            }
        });

        window.initShareBtn();
        
        $('#shareFeedModal').on('hidden.bs.modal', function (e) {
            var frame = document.getElementById('iframeShare');
            frame.height = '0px';
            $(e.target).removeData('bs.modal');
        });
    }

    window.closeModal = function () {
        $('#shareFeedModal').modal('hide');
    };

    window.statusModal = function ($title, $msg) {
        $.fn.SimpleModal({
            btn_ok: mooPhrase.__('btn_ok'),
            btn_cancel: mooPhrase.__('btn_cancel'),
            model: 'modal',
            title: $title,
            contents: $msg
        }).showModal();
    }

    window.initShareBtn = function () {
        $('body').off('click', '.shareFeedBtn').on('click', '.shareFeedBtn', function () {
            if (!mooUser.validateUser()){
                return false;
            }

            var iframeSrc = $(this).attr('share-url');

            //check login user first
            $.post(mooConfig.url.base + '/share/index', function (data) {
                try {
                    data = JSON.parse(data);
                    if (data['nonLogin']) {
                        mooUser.validateUser();
                    }
                } catch (e) {
                    $('#shareFeedModal iframe').attr("src", iframeSrc);
                    $('#shareFeedModal').modal({show: true});
                }

            });


        });
    }

    // MOOSOCIAL-2141
    $(document).keyup(function (e) {
        if (e.keyCode == 27) {

            if (file_uploading == 1)
            {
                return confirmNavigation();
            }
        }
    });

    var confirmNavigation = function ()
    {
        if (file_uploading == 1)
        {
            var msg = mooPhrase.__('are_you_sure_leave_this_page');
            if (confirm(msg))
            {
                file_uploading = 0;
                $(window).unbind('beforeunload');
                $('#themeModal').modal('hide');
                return true;
            } else {
                return;
            }
        } else {
            file_uploading = 0;
            $('#themeModal').modal('hide')
            return;
        }

    }
    
    // app/View/Share/ajax_share.ctp
    var initOnAjaxShare = function(options){
        
        $(".sharethis").hideshare({
            linkedin: false,
            link : options.social_link_share // $social_link_share
        });

        $('#myTabDrop1').click(function(){
            $('#myTabDrop1-contents').toggleClass('show_hide_dropdown');
        })

    
        var activeTab = null;
    
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // clear warning
            $('#shareWarning').html('').hide();
            $('#recaptcha_content').hide();

            var type = $(e.target).attr("href");
            activeTab = type;
            $('#share_type').val(type);
            switch (type) {
                case "#friend":
                case "#msg":
                    $("#friend").addClass('active in');
                    $("#msg").remove('active in');
                    break;
                case "#email":
                	$('#recaptcha_content').show();
                	break;
                default:

                    break;
            }
            $('#myTabDrop1').html($(this).html());
            
             var shareHeight = $('body').height() - 40;

            $('#page_share-ajax_share .userTagged').css('position','fixed');
        });
        $('a[data-toggle="tab"]').click(function(){
            $('#myTabDrop1-contents').removeClass('show_hide_dropdown');
        })
        $('#shareBtn').click(function () { 
            // clear warning
            $('#shareWarning').html('');

            switch (activeTab) {
                case "#friend":
                    if ($('#friendSuggestion').val() == ''){
                        $('#shareWarning').html(mooPhrase.__('please_select_friends_to_share')).show();
                        return;
                    }
                    break;
                case "#msg":
                    if ($('#friendSuggestion').val() == ''){
                        $('#shareWarning').html(mooPhrase.__('please_select_friends_to_share')).show();
                        return;
                    }
                    break;
                case "#group":
                    if ($('#groupSuggestion').val() == ''){
                        $('#shareWarning').html(mooPhrase.__('please_select_groups_to_share')).show();
                        return;
                    }
                    break;
                case "#email":
                    if ($('textarea[name="data[email]"]').val() == ''){
                        $('#shareWarning').html(mooPhrase.__('please_input_emails_to_share')).show();
                        return;
                    }
                    break;
                default:
                    break;
            }
            $('#shareBtn').addClass('disabled');

            $.post(options.do_share_url,
                $("#activity_share_form").serialize(),
                function (data) {            		
                    var parseJson = $.parseJSON(data);
                    if (!parseJson.success)
                    {
                    	$('#shareWarning').html(parseJson.msg).show();
                    	$('#shareBtn').removeClass('disabled');
                    	return;
                    }
                    window.parent.closeModal();
                    window.parent.statusModal(mooPhrase.__('status'), parseJson.msg);
                }
            );
        });
        
        var textarea = '', textoverlay = '', usertagging = '';

        $('#myTabDrop1-contents li a').on('click',function(){
            var target = $(this).attr('href');
            var $this = $(this).parents('#content-wrapper');

            if(target == '#msg' || target == '#email' || target == '#socialshare'){ //remove tagging and mention
                textarea = $this.find('textarea#message');
                textoverlay = $this.find('.textoverlay-wrapper');
                usertagging = $this.find('.userTagged .user-tagging-container');
                if (textoverlay.length > 0) {
                    textoverlay.hide();
                    textoverlay.find('input.messageHidden').attr('name','messageTextHidden');
                }
                else {
                    textarea.hide();
                    textarea.attr('name','messageTextHidden')
                }
                $this.find('#messageHidden').attr({'name':'data[message]'});
                $this.find('#messageHidden').val('');

                $this.find('#messageHidden').show();
                usertagging.hide();

            } else {
                if (typeof textarea === 'object') {
                    if(typeof textoverlay === 'object') {
                        $this.find('#messageHidden').attr('name','messageTextHidden').hide();
                        if (textoverlay.length > 0) {
                            textoverlay.find('input.messageHidden').attr('name','data[message]');
                            textoverlay.find('input.messageHidden').val('');
                            textoverlay.find('div.textoverlay').html('');
                            textoverlay.show();
                        } else {
                            textarea.attr('name','data[message]');
                            textarea.show();
                        }
                        textarea.val('');
                    }
                    if(typeof usertagging === 'object') {
                        usertagging.show();
                    }
                    textarea = textoverlay = usertagging = '';
                }
            }
        });
    }

    //    exposed public method
    return {
        init : init,
        initOnAjaxShare : initOnAjaxShare
    };
}));

