/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) { 
        // AMD
        define(['jquery', 'mooOverlay', 'mooBehavior', 'mooResponsive', 'mooShare', 'mooNotification', 'mooPhoto', 'mooUser', 'mooCoreMenu',
            'tipsy', 'autogrow', 'spinner'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.ServerJS = factory(root.jQuery);
    }
}(this, function ($, mooOverlay, mooBehavior, mooResponsive, mooShare, mooNotification, mooPhoto, mooUser, mooCoreMenu) {
    
    var init = function () {
        
        $('textarea:not(.no-grow)').autogrow();

        
        $(".tip").tipsy({html: true, gravity: $.fn.tipsy.autoNS,follow: 'x'});
        
        $('.truncate').each(function () {
            if (parseInt($(this).css('height')) >= 145){
                var element = $('<a href="javascript:void(0)" class="show-more">' + $(this).data('more-text') + '</a>');
                $(this).after(element);
                element.click(function(e){
                    showMore(this);
                });
            }
        });

        $('.comment-truncate').each(function () {
            if (parseInt($(this).css('height')) >= 45){
                var element = $('<a href="javascript:void(0)" class="show-more">' + $(this).data('more-text') + '</a>');
                $(this).after(element);
                element.click(function(e){
                    showMore(this);
                });
            }
        });

        mooOverlay.registerOverlay();

        mooBehavior.registerImageComment();

        initMainSearch();
        
        // init cookie
        initCookieAccept();

        initSearch();
        
        // init template responsive
        mooResponsive.init();
        
        // init notification
        mooNotification.init();
        
        // init share action
        mooShare.init();
        
        // init moreResults
        mooBehavior.initMoreResults();
        
        // init photo theater
        mooPhoto.init();
        
        // init auto loadmore
        mooBehavior.initAutoLoadMore();

        $('.browse-menu').CoreBrowseMenu({asCoreBrowseMenuFor: '.browse-menu', asHorizontalMenuFor: '.core-horizontal-menu'});
        $('body').on('afterAjaxCoreBrowseMenuCallback', function(e, data){
            $('textarea:not(.no-grow)').autogrow();
            $(".tip").tipsy({html: true, gravity: 's'});
            mooOverlay.registerOverlay();
        });
        $('.browse_menu-dropdown').CategoryMenuDropdown();

        // init resend_validation_link
        mooUser.resendValidationLink();

        initAppearance();

        //custom scroll to comment use this when ajax change the url
        $('body').append('<input type="hidden" id="url_path" value="'+window.location.pathname+'">');

    };
    
    var initCookieAccept = function(){
        
        $('.accept-cookie').unbind('click');
        $('.accept-cookie').on('click',function(){
            
            var answer = $(this).data('answer');
            var $this = $(this);
            $.post(mooConfig.url.base+'/users/accept_cookie',{answer:answer},function(data){
                data = JSON.parse(data);
                if (data.result) {
                    $('.cookies-warning').remove();
                    $('body').removeClass('page_has_cookies');
                }
                else {
                    location.href = data.url;
                }
            })
        });
        
        $('.delete-warning-cookies').unbind('click');
        $('.delete-warning-cookies').on('click',function(){
            $('.cookies-warning').remove();
            $('body').removeClass('page_has_cookies');
        });
    }
    
    var showMore = function(obj){
        
        $(obj).prev().css('max-height', 'none');
        var element = $('<a href="javascript:void(0)" class="show-more">' + $(obj).prev().data('less-text') + '</a>');
        $(obj).replaceWith(element);
        element.click(function(e){
            showLess(this);
        });
        $('body').trigger('afterShowMoreServerJSCallback',[]);
    }

    var showLess = function(obj){
        
        $(obj).prev().css('max-height', '');
        var element = $('<a href="javascript:void(0)" class="show-more">' + $(obj).prev().data('more-text') + '</a>');
        $(obj).replaceWith(element);
        element.click(function(e){
            showMore(this);
        });
        $('body').trigger('afterShowMoreServerJSCallback',[]);
    }
    
    var showFeedVideo = function(source, source_id, activity_id ){
        
        $('#video_teaser_' + activity_id + ' .vid_thumb').spin('small');
        $('#video_teaser_' + activity_id).load(mooConfig.url.base + '/videos/embed', { source: source, source_id: source_id }, function(){
            $('#video_teaser_' + activity_id + ' > .vid_thumb').spin(false);
        });
    }
    
    var initSearch = function () {
        if ($('.suggestionInitSlimScroll').height() > 500) {
            $('.suggestionInitSlimScroll').slimScroll({height: '500px'});
        }

        $('#global-search').keyup(function (event) {
            var searchVal = $(this).val();
            if (searchVal != '') {
                $.post(mooConfig.url.base + "/search/suggestion/all", {searchVal: searchVal}, function (data) {
                    $('.global-search .slimScrollDiv').show();
                    $('#display-suggestion').html(data).show();
                });
            }

            if (event.keyCode == '13') {
                if ($(this).val() != '') {
                    var searchStr = $(this).val().replace('#', '');
                    if ($(this).val().indexOf('#') > -1) {
                        window.location = mooConfig.url.base + '/search/hashtags?q=' + encodeURIComponent(searchStr);
                    } else {
                        window.location = mooConfig.url.base + '/search/index?q=' + encodeURIComponent(searchStr);
                    }
                }
            }
        });

        $('#global-search').focusout(function (event) {
            if ($('#display-suggestion').is(":hover") == false) {
                $('#display-suggestion').html('').hide();
                $('.global-search .slimScrollDiv').hide();
            }
        });

        $('#global-search').focus(function (event) {

            $('#global-search').trigger('keyup');

        });

        $('#globalSearchBtnMobile').click(function (e) {
            e.preventDefault();
            $(this).parent().addClass('search-mobile-open');
            $('#global-search').focus();
            $('html').addClass('mobile-search-open');
        });

        $('#globalSearchOverview').click(function (e) {
            e.preventDefault();
            $(this).parent().removeClass('search-mobile-open');
            $('html').removeClass('mobile-search-open');
        });
        $('#globalSearchCancel').click(function (e) {
            e.preventDefault();
            $(this).parent().parent().removeClass('search-mobile-open');
            $('html').removeClass('mobile-search-open');
        });
    };
    
    var initMainSearch = function () {
        $('#form_main_search').find('.header_search_btn').click(function (e) {
            $('#form_main_search').submit();
        });

        $('#form_main_search').submit(function( event ) {
            var _this = $(this);
            var searchType = _this.attr('search-type');//ajax or no-ajax
            var method = _this.attr('method');
            var action = _this.attr('action');
            var url = '';
            var contentId = '#list-content';
            var data = {};

            var e_keyword = _this.find('#keyword');
            var search_name = '';
            if(e_keyword.length > 0){
                search_name = e_keyword.attr('rel');
            }

            if( (typeof action === "undefined") || action == '' ){
                if(search_name != ''){
                    var ajax_browse = 'ajax_browse';
                    var ext = '';
                    if (e_keyword.hasClass('json-view')) {
                        ajax_browse = 'browse';
                    }
                    if (e_keyword.attr('rel') == 'albums') {
                        contentId = '#album-list-content';
                    } else {
                        contentId = '#list-content';
                    }
                    url = mooConfig.url.base + '/' + search_name + '/' + ajax_browse + '/search/' + encodeURI(e_keyword.val() + ext);
                }
            }else{
                url = action;
            }

            if(method.toUpperCase() == 'POST'){
                data = _this.serialize();
            }else{
                if(_this.find('.search-popup-open').length > 0){
                    data = _this.serialize();
                }
            }

            if(searchType == 'ajax' && url != ''){
                event.preventDefault();

                $.ajax({
                    url: url,
                    type: method.toUpperCase(),
                    dataType: 'html',
                    cache: false,
                    data: data,
                    beforeSend: function() {
                        $('.browse-menu').CoreBrowseMenuSpinStart();
                        window.history.pushState({}, "", $('#browse_all').find('a.horizontal-menu-link').attr('href'));
                    }
                }).done(function(response) {
                    $(contentId).html(response);

                    $('.browse-menu').CoreBrowseMenuSpinStop();
                    //$('#keyword').val('');
                    e_keyword.val('');

                    $(".tip").tipsy({html: true, gravity: 's'});
                    mooOverlay.registerOverlay();

                    $('body').trigger('afterAjaxSearchServerJSCallback',[{search_name: search_name}]);
                });

            }
        });

    };

    var initAppearance = function () {
        $('#appearance').change(function () {
            var dark_mode = 0;
            if($(this).is(':checked')){
                dark_mode = 1;
            } else {
                dark_mode = 0;
            }
            $('#appearanceMode').spin('tiny');
            $('#appearance').attr('disabled', 'disabled')
            $.post(mooConfig.url.base + "/users/ajax_appearance", {dark_mode: dark_mode}, function (data) {
                $('#appearanceMode').spin(false);
                window.location.reload();
            });
        });
    };
    //    exposed public method
    return {
        init: init,
        
    };
}));