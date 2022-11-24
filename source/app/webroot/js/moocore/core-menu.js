(function ($) {
    var urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

        if (results==null){
            return null;
        }
        else{
            return results[1] || 0;
        }
    };
    var isInViewport = function (elem) {
        var viewportTop = $(window).scrollTop();
        var viewport = {
            top: viewportTop,
            left: 0,
            right: $(window).width(),
            bottom: viewportTop + $(window).height()
        };
        var bounding = {
            top: elem.offset().top,
            left: elem.offset().left,
            right: elem.offset().left + elem.outerWidth(),
            bottom: elem.offset().top + elem.outerHeight()
        };
        //console.log('bounding', bounding);
        //console.log('viewport',viewport);
        var out = {};
        out.top = (viewport.top > bounding.top) ? false: true;
        out.bottom = (viewport.bottom < bounding.bottom) ? false: true;
        out.left = (bounding.left < 0) ? false : true;
        out.right = (bounding.right > viewport.right) ? false: true;
        out.any = (!out.top || !out.left || !out.bottom || !out.right) ? false : true;
        return out;
    };

    var HorizontalMenu = function () {
        var defaults = {
            asStickyBrowseMenuFor: ''
        };

        var ele_header = $('#header');

        var flagOpenDropdown = false;
        var eleHTML = $('body');
        var eleHorizontalOverlay = $('<div id="CoreHorizontalMenuOverlay" class="core_horizontal_menu_overlay" style="display: none;"></div>');
        var targetDropdownActive = null;
        var dropdownArrow = '<div class="horizontal-menu-close"><span class="horizontal-menu-close-icon material-icons">expand_less</span></div>';

        var arrangeLayout = function (_this, ele_more, ele_more_dropdown) {
            var menuWidth = _this.innerWidth();
            var totalItemWidth = 0;
            _this.find('> li:not(.core-horizontal-more)').each(function (index) {
                totalItemWidth += $(this).outerWidth();
            });
            if(totalItemWidth > menuWidth){
                var ele_sub = ele_more_dropdown.find('> li').first();
                if(ele_sub.length > 0){
                    ele_more.prev().insertBefore(ele_sub);
                }else{
                    ele_more.prev().appendTo(ele_more_dropdown);
                }
            }
            if(ele_more_dropdown.find('> li').length > 0){
                ele_more.removeClass('hidden');
            }else{
                ele_more.addClass('hidden');
            }
            reArrangeLayout(_this, menuWidth, ele_more, ele_more_dropdown);

            _this.find('li.hasChild').each(function (){
                var $sub_menu = $(this).find('.horizontal-menu-sub');
                if( $sub_menu.find('> li.current').length > 0 ){
                    $(this).addClass('current');
                }else{
                    $(this).removeClass('current');
                }
            });
        };
        var reArrangeLayout = function (_this, menuWidth, ele_more, ele_more_dropdown) {
            var totalItemWidth = 0;
            _this.find('> li').each(function (index) {
                totalItemWidth += $(this).outerWidth();
            });
            if(totalItemWidth > menuWidth){
                var ele_sub = ele_more_dropdown.find('> li').first();
                if(ele_sub.length > 0){
                    ele_more.prev().insertBefore(ele_sub);
                }else{
                    ele_more.prev().appendTo(ele_more_dropdown);
                }
                reArrangeLayout(_this, menuWidth, ele_more, ele_more_dropdown);
            }
        };
        var resizeLayout = function (_this, ele_more, ele_more_dropdown) {
            ele_more_dropdown.find('> li').each(function (index) {
                $(this).insertBefore(ele_more);
            });
            arrangeLayout(_this, ele_more, ele_more_dropdown);
        };

        var openDropdownMenu = function (_this, eleItemDropdownHolder) {
            flagOpenDropdown = true;

            var this_top = _this.offset().top - $(window).scrollTop();
            var header_height = ele_header.outerHeight(true);
            //console.log(this_top);
            if( this_top > header_height ){
                //$('html, body').scrollTop(_this.offset().top);
                //$('body').addClass('faceOutEffectXX');
                $('html, body').animate({scrollTop: _this.offset().top}, 100, 'swing', function() {
                    //$('body').addClass('faceOutEffect');
                    var itemHolder_top = eleItemDropdownHolder.offset().top - $(window).scrollTop();
                    var dropdown_top = itemHolder_top + eleItemDropdownHolder.innerHeight();

                    eleItemDropdownHolder.find('> .horizontal-menu-sub').css({'top': dropdown_top+'px'});
                    eleHorizontalOverlay.show();
                    eleHTML.addClass('core_horizontal_menu_open');
                    eleItemDropdownHolder.addClass('horizontal-menu-open');
                });
            }else{
                var itemHolder_top = eleItemDropdownHolder.offset().top - $(window).scrollTop();
                var dropdown_top = itemHolder_top + eleItemDropdownHolder.innerHeight();

                eleItemDropdownHolder.find('> .horizontal-menu-sub').css({'top': dropdown_top+'px'});
                eleHorizontalOverlay.show();
                eleHTML.addClass('core_horizontal_menu_open');
                eleItemDropdownHolder.addClass('horizontal-menu-open');
            }
        };
        var closeDropdownMenu = function (_this) {
             if(flagOpenDropdown){
                flagOpenDropdown = false;
                targetDropdownActive = null;
                eleHorizontalOverlay.hide();
                eleHTML.removeClass('core_horizontal_menu_open');
                _this.find('.horizontal-menu-open').removeClass('horizontal-menu-open');
                _this.find('.horizontal-menu-close').remove();
                _this.find('.horizontal-menu-sub').css('top','');
             }
        };

        var reset = function (_this, ele_more, ele_more_dropdown) {
            closeDropdownMenu(_this);
            resizeLayout(_this, ele_more, ele_more_dropdown);
        };

        var initLayout = function (_this, ele_more, ele_more_dropdown) {
            arrangeLayout(_this, ele_more, ele_more_dropdown);
            $(window).resize(function () {
                reset(_this, ele_more, ele_more_dropdown);
            });
        };

        var isInViewport = function (_this, ele_more, ele_more_dropdown){
            let elementTop = ele_more_dropdown.offset().top;
            let elementBottom = elementTop + ele_more_dropdown.outerHeight();
            let viewportTop = $(window).scrollTop();
            let viewportBottom = viewportTop + $(window).height();
            //let flag_in_viewport = elementBottom > viewportTop && elementTop < viewportBottom;
            if(elementBottom > viewportBottom){
                //console.log('ngoai page');
                return (viewportBottom - elementTop);
            }else {
                return true;
            }
        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});
                $('body').append(eleHorizontalOverlay);

                return this.each(function () {
                    var _this = $(this);

                    var asStickyBrowseMenuFor = false;
                    if(opt.asStickyBrowseMenuFor != ''){
                        if($(opt.asStickyBrowseMenuFor).length != 0){
                            asStickyBrowseMenuFor = true;
                        }
                    }

                    var ele_more = _this.find('.core-horizontal-more');
                    var ele_more_dropdown = _this.find('.core-horizontal-dropdown');
                    _this.find('> li').each(function (index) {
                        if( !$(this).hasClass('core-horizontal-more') ){
                            $(this).attr('stt', index);
                        }
                    });

                    if(asStickyBrowseMenuFor == true){
                        arrangeLayout(_this, ele_more, ele_more_dropdown);
                    }else{
                        initLayout(_this, ele_more, ele_more_dropdown);
                    }

                    $(this).find('a.horizontal-menu-header').click(function (e) {
                        e.preventDefault();
                        //e.stopPropagation();
                        if($(window).width() < 992) {
                            var eleParent = $(this).parent();
                            if (eleParent.parent().hasClass('core-horizontal-menu')) {
                                if (targetDropdownActive == null) {
                                    targetDropdownActive = $(this)[0];
                                    if (eleParent.find('> .horizontal-menu-close').length == 0) {
                                        eleParent.append(dropdownArrow);
                                    }
                                    //eleParent.addClass('horizontal-menu-open');
                                    openDropdownMenu(_this, eleParent);
                                } else {
                                    if (targetDropdownActive == $(this)[0]) {
                                        eleParent.removeClass('horizontal-menu-open');
                                        closeDropdownMenu(_this);
                                    } else {
                                        targetDropdownActive = $(this)[0];
                                        _this.find('.horizontal-menu-open').removeClass('horizontal-menu-open');
                                        _this.find('.horizontal-menu-close').remove();
                                        if (eleParent.find('> .horizontal-menu-close').length == 0) {
                                            eleParent.append(dropdownArrow);
                                        }
                                        //eleParent.addClass('horizontal-menu-open');
                                        openDropdownMenu(_this, eleParent);
                                    }
                                }
                            } else {
                                if (eleParent.hasClass('horizontal-menu-open')) {
                                    eleParent.removeClass('horizontal-menu-open');
                                    eleParent.find('.horizontal-menu-open').removeClass('horizontal-menu-open');
                                } else {
                                    eleParent.addClass('horizontal-menu-open');
                                }
                            }
                        }
                    });

                    $(document).click(function (e) {
                        if($(window).width() < 992) {
                            if (!_this.is(e.target) && _this.has(e.target).length === 0) {
                                var isopened = _this.find('.horizontal-menu-open').length;

                                if (isopened != 0) {
                                    _this.find('.horizontal-menu-open').removeClass('horizontal-menu-open');
                                    closeDropdownMenu(_this);
                                }
                            } else {
                                if ($(e.target).hasClass('horizontal-menu-link')) {
                                    var eleLink = $(e.target);
                                } else {
                                    var eleLink = $(e.target).parent('.horizontal-menu-link');
                                }
                                if (!eleLink.hasClass('horizontal-menu-header')) {
                                    closeDropdownMenu(_this);
                                }
                            }
                        }
                    });

                    if($(this).hasClass('horizontal-menu-waiting')){
                        $(this).removeClass('horizontal-menu-waiting');
                    }

                    if($(window).width() >= 992) {
                        ele_more.hover(
                            function () {
                                $(this).addClass('core-horizontal-more-show');
                                let inViewport = isInViewport(_this, ele_more, ele_more_dropdown);
                                if (inViewport == true) {
                                    ele_more_dropdown.removeClass('horizontal-sub-x');
                                } else {
                                    ele_more_dropdown.addClass('horizontal-sub-x');

                                    let ele_li_item = ele_more_dropdown.find('> li');
                                    let item_height = ele_li_item.outerHeight(true);
                                    let item_width = 200;//ele_li_item.outerWidth(true);
                                    let count_limit = Math.ceil(inViewport / item_height) - 1;
                                    let col_count = Math.ceil(ele_li_item.length / count_limit);
                                    if(col_count > 7){
                                        col_count = 7;
                                    }
                                    let menu_width = _this.width();
                                    let more_dropdown_width = col_count * item_width;
                                    /*if (more_dropdown_width > menu_width) {
                                        more_dropdown_width = menu_width;
                                    }*/
                                    ele_more_dropdown.css('width', more_dropdown_width);
                                }
                            }, function () {
                                $(this).removeClass('core-horizontal-more-show');
                                ele_more_dropdown.removeClass('horizontal-sub-x');
                                ele_more_dropdown.css('width', '');
                            }
                        );
                    }
                    /*$(window).scroll(function() {
                        closeDropdownMenu(_this);
                    });*/
                });
            },
            reset: function(){
                return this.each(function(){
                    var _this = $(this);
                    var ele_more = _this.find('.core-horizontal-more');
                    var ele_more_dropdown = ele_more.find('.core-horizontal-dropdown');

                    reset(_this, ele_more, ele_more_dropdown);
                });
            },
            close: function () {
                return this.each(function(){
                    var _this = $(this);
                    closeDropdownMenu(_this);
                });
            }
        };
    }();

    var StickyBrowseMenu = function(){
        var defaults = {
            asHorizontalMenuFor: ''
        };

        var resizeStickyMenu = function (_this) {
            var eleAction = _this.find('.horizontal-action');
            var eleMenu = _this.find('.horizontal-content');

            if(!eleAction.is(':hidden')){
                var stikyWidth = _this.width();
                var actWidth = eleAction.outerWidth();
                var menuWidth = stikyWidth - actWidth;
                eleMenu.css('max-width', menuWidth + 'px');
            }else{
                eleMenu.css('max-width', '100%');
            }
        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});
                return this.each(function () {
                    var _this = $(this);
                    var asHorizontalMenuFor = false;
                    if(opt.asHorizontalMenuFor != ''){
                        if($(opt.asHorizontalMenuFor).length != 0){
                            asHorizontalMenuFor = true;
                        }
                    }

                    resizeStickyMenu(_this);
                    if(asHorizontalMenuFor){
                        $(opt.asHorizontalMenuFor).HorizontalMenuReset();
                    }
                    $(window).scroll(function () {
                        resizeStickyMenu(_this);
                        if(asHorizontalMenuFor){
                            $(opt.asHorizontalMenuFor).HorizontalMenuReset();
                        }
                    });
                    $(window).resize(function () {
                        resizeStickyMenu(_this);
                        if(asHorizontalMenuFor){
                            $(opt.asHorizontalMenuFor).HorizontalMenuReset();
                        }
                    });

                });
            }
        };
    }();

    var CoreBrowseMenu = function(){
        var defaults = {
            asCoreBrowseMenuFor: '',
            asHorizontalMenuFor: ''
        };

        var first_ajax_flag = false;

        var checkParentsActive = function (_this) {
            _this.parents('li.hasChild').addClass('current');
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

        var setPageHeaderTitle = function (_this) {
            var header_title = _this.attr('header-title');
            var elePageHeader = $(document).find('#PageHeaderTitle');

            if(elePageHeader.length != 0){
                if( (typeof header_title != "undefined") && header_title != '' ){
                    elePageHeader.html(header_title);
                }else{
                    elePageHeader.html(elePageHeader.attr('header-title'));
                }
            }
        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});

                return this.each(function () {
                    var _this = $(this);

                    var asCoreBrowseMenuFor = false;
                    if(opt.asCoreBrowseMenuFor != ''){
                        if($(opt.asCoreBrowseMenuFor).length != 0){
                            asCoreBrowseMenuFor = true;
                        }
                    }

                    var asHorizontalMenuFor = false;
                    if(opt.asHorizontalMenuFor != ''){
                        if($(opt.asHorizontalMenuFor).length != 0){
                            asHorizontalMenuFor = true;
                        }
                    }

                    var flag_link_active = false;
                    if( urlParam('core-link-active') != null ){
                        var curHref = window.location.href;
                        var newHref = curHref.replace( new RegExp('[\?&]' + 'core-link-active' + '=([^&#]*)'), '');
                        window.history.pushState({}, "", newHref);
                        flag_link_active = true;
                    }

                    var url_hash = $(location).attr('hash');
                    var element_menu_ajax_item = null;
                    var flag = false;

                    $(this).find('a.core-menu-ajax').each(function () {
                        var hash = $(this).attr('data-anchor');
                        var autoload = $(this).attr('autoload');

                        $(this).click(function (e) {
                            e.preventDefault();

                            //$(this).children('.badge_counter').hide();
                            $(this).spin('tiny');

                            if(asCoreBrowseMenuFor){
                                $(opt.asCoreBrowseMenuFor).find('.current').removeClass('current');
                            }else{
                                $(this).find('.current').removeClass('current');
                            }

                            $(this).parent().addClass('current');
                            ///-----
                            checkParentsActive($(this));
                            ///-----

                            var div = $(this).attr('rel');
                            if (div == undefined){
                                div = 'list-content';
                            }

                            var el = $(this);

                            $('#' + div).load($(this).attr('data-url') + '?' + $.now(), function (response) {

                                var res = '';
                                try {
                                    res = $.parseJSON(response).data;
                                } catch (error) {
                                    res = response
                                }

                                //el.children('.badge_counter').fadeIn();
                                el.spin(false);

                                setPageHeaderTitle(el);

                                // reattach events
                                //$('textarea:not(.no-grow)').autogrow();
                                //$(".tip").tipsy({html: true, gravity: 's'});
                                //mooOverlay.registerOverlay();

                                $('.truncate').each(function () {
                                    if (parseInt($(this).css('height')) >= 145){
                                        var element = $('<a href="javascript:void(0)" class="show-more">' + $(this).data('more-text') + '</a>');
                                        $(this).after(element);
                                        element.click(function(e){
                                            showMore(this);
                                        });
                                    }
                                });

                                window.history.pushState({}, "", el.attr('href'));
                                if ($(window).width() < 992) {
                                    $('#leftnav').sidebarModal('hide');
                                    $('#right').sidebarModal('hide');
                                    $('html,body').scrollTop(0);
                                }

                                var _isInViewport = isInViewport($('#' + div));
                                if(!_isInViewport.top){
                                    var scrollTop = $('#' + div).offset().top - $('#header').outerHeight(true);

                                    if( $('#stickyBrowseMenu').length > 0 ){
                                        scrollTop = scrollTop - $('#stickyBrowseMenu').outerHeight(true);
                                    }
                                    if( $('#profile-scroll').length > 0 ){
                                        scrollTop = scrollTop - $('#profile-scroll').find('.profile-scroll-main').outerHeight(true);
                                    }
                                    $('html,body').scrollTop(scrollTop);
                                }

                                if(asHorizontalMenuFor){
                                    $(opt.asHorizontalMenuFor).HorizontalMenuClose();
                                }

                                $('body').trigger('afterAjaxCoreBrowseMenuCallback',[{element_menu: el}]);
                            });

                            //return false;
                        });

                        if( (autoload == 'true') && (flag == false) ){
                            flag = true;
                            element_menu_ajax_item = $(this);
                        }
                        if( url_hash == hash ){
                            flag = true;
                            element_menu_ajax_item = $(this);
                        }
                    });

                    if( (flag_link_active == false) && (element_menu_ajax_item != null) && (first_ajax_flag == false) ){
                        first_ajax_flag = true;
                        element_menu_ajax_item.trigger( "click" );
                    }
                });
            },
            spinStart: function (eleID) {
                if( (typeof eleID == "undefined") || eleID == '' ){
                    eleID = '#browse_all';
                }
                return this.each(function(){
                    var _this = $(this);

                    $(this).find('.current').removeClass('current');

                    var eleMenuItem = $(this).find(eleID);
                    eleMenuItem.addClass('current').spin('tiny');
                    setPageHeaderTitle(eleMenuItem.find('> .horizontal-menu-link'));

                });
            },
            spinStop: function (eleID) {
                if( (typeof eleID == "undefined") || eleID == '' ){
                    eleID = '#browse_all';
                }
                return this.each(function(){
                    var _this = $(this);
                    $(this).find(eleID).spin(false);
                });
            }
        }
    }();

    var CategoryMenuDropdown = function(){
        var defaults = {

        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});

                return this.each(function () {
                    var _this = $(this);
                    var ele_dropdown_label = _this.find('.browse-dropdown_label');

                    $('body').on('afterAjaxCoreBrowseMenuCallback', function(e, data){
                        if(_this.find(data.element_menu).length > 0){
                            ele_dropdown_label.html( data.element_menu.attr('header-title') );
                        }else{
                            ele_dropdown_label.html( ele_dropdown_label.attr('data-title') );
                        }
                    });
                    $('body').on('afterAjaxSearchServerJSCallback', function(e, data){
                        ele_dropdown_label.html( ele_dropdown_label.attr('data-title') );

                    });
                });
            }
        };
    }();

    var CategoryMenuToggle = function(){
        var defaults = {

        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});

                return this.each(function () {
                    var _this = $(this);
                    $(this).find('.menu-list-header').each(function () {
                        $(this).click(function (e) {
                            e.preventDefault();
                            $(this).parent().toggleClass('open');
                        });
                    });
                });
            }
        };
    }();

    var StickyProfileMenu = function(){
        var defaults = {
            asHorizontalMenuFor: ''
        };

        var ele_header = $('#header');
        var profileOffsetTop = 0;

        var checkMirror = function (ele_main, ele_mirror) {
            ele_mirror.css({'height' : ele_main.outerHeight( true )});
        };
        var init = function (_this, ele_main, ele_mirror) {
            _this.addClass('profile-scroll');
            checkMirror(ele_main, ele_mirror);
        };

        var scrollProfile = function (_this, ele_main) {
            if($(window).width() >= 992) {
                var header_height = ele_header.outerHeight();
                var header_top = ele_header.offset().top - $(window).scrollTop();
                var header_calculator_top = header_height + header_top;

                var _top = $(window).scrollTop() + header_calculator_top;
                if (_top > profileOffsetTop) {
                    _this.addClass('profileScrolling');
                    ele_main.css('top', header_calculator_top);
                } else {
                    _this.removeClass('profileScrolling');
                    ele_main.css('top', 0);
                }
            }
        };

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});

                return this.each(function () {
                    if($(window).width() >= 992) {
                        var _this = $(this);
                        var ele_main = _this.find('.profile-scroll-main');
                        var ele_mirror = _this.find('.profile-scroll-jump');
                        var ele_menu = _this.find('.profile-menu');

                        var asHorizontalMenuFor = false;
                        if (opt.asHorizontalMenuFor != '') {
                            if ($(opt.asHorizontalMenuFor).length != 0) {
                                asHorizontalMenuFor = true;
                            }
                        }

                        profileOffsetTop = ele_menu.offset().top;

                        init($(this), ele_main, ele_mirror);

                        scrollProfile($(this), ele_main);
                        $(window).scroll(function () {
                            scrollProfile(_this, ele_main);
                        });

                        //if ($(window).width() >= 992) {
                        $(window).resize(function () {
                            profileOffsetTop = ele_menu.offset().top;
                            checkMirror(ele_main, ele_mirror);
                        });
                        //}

                        $('body').on('afterResponsiveFullHeaderScroll', function (e, data) {
                            //if ($(window).width() >= 992) {
                            scrollProfile($(this), ele_main);
                            //}
                        });
                    }
                });
            },
            reset: function (){
                return this.each(function () {
                    if($(window).width() >= 992) {
                        var _this = $(this);
                        var ele_main = _this.find('.profile-scroll-main');
                        var ele_mirror = _this.find('.profile-scroll-jump');
                        var ele_menu = _this.find('.profile-menu');

                        //if ($(window).width() >= 992) {
                        profileOffsetTop = ele_menu.offset().top;
                        checkMirror(ele_main, ele_mirror);
                        //}
                    }
                });
            }
        };
    }();

    $.fn.extend({
        HorizontalMenu: HorizontalMenu.init,
        HorizontalMenuReset: HorizontalMenu.reset,
        HorizontalMenuClose: HorizontalMenu.close,
        StickyBrowseMenu: StickyBrowseMenu.init,
        CoreBrowseMenu: CoreBrowseMenu.init,
        CoreBrowseMenuSpinStart: CoreBrowseMenu.spinStart,
        CoreBrowseMenuSpinStop: CoreBrowseMenu.spinStop,
        CategoryMenuDropdown: CategoryMenuDropdown.init,
        CategoryMenuToggle: CategoryMenuToggle.init,
        StickyProfileMenu: StickyProfileMenu.init,
        StickyProfileMenuReset: StickyProfileMenu.reset
    });
})(jQuery);