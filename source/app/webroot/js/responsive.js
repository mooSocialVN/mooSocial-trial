/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) { 
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'bootstrap', 'sidebarModal', 'mooCoreMenu', 'mooNiceSelect'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooResponsive = factory(root.jQuery);
    }
}(this, function ($) {
    var viewport = function () {
        var e = window, a = 'inner';
        if (!('innerWidth' in window)) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return e[ a + 'Width' ];
    };
    var addLeftRightResponsive = function () {
        if (!($('#leftnav').hasClass('in') && viewport() < 992)) {
            $('#leftnav').sidebarModal('hide');
        }
        if (!($('#right').hasClass('in') && viewport() < 992)) {
            $('#right').sidebarModal('hide');
        }
        if (viewport() < 992) {
            if (!($('#leftnav').hasClass('in'))) {
                $('#leftnav').addClass('modal-mobile fade').css('display', 'none');
            }
            if (!($('#right').hasClass('in'))) {
                $('#right').addClass('modal-mobile fade').css('display', 'none');
            }
        } else {
            $('#leftnav').removeClass('modal-mobile fade').css('display', 'block');
            $('#right').removeClass('modal-mobile fade').css('display', 'block');
        }
    }
    var addMainMenuMobile = function () {
        var eleMenuActive = $('#mainMenuSection').find($('.core-menu-link.active')[0]);
        if(eleMenuActive.length > 0){
            var active_icon = eleMenuActive.find('.core-menu-icon').text();
            var active_name = eleMenuActive.find('.core-menu-text').text();
            if(active_icon == ''){
                active_icon = 'menu';
            }
            $('#mainMenuMobileToggle').find('.main-menu-toggle-text').text(active_name);
            $('#mainMenuMobileToggle').find('.main-menu-toggle-icon').text(active_icon);
        }

        $('#mainMenuMobileToggle').click(function (e) {
            e.preventDefault();
            if (viewport() < 992) {
                openMainMenuMobile();
            }
        });
        $('#mainMenuOverview, #mainMenuClose').click(function (e) {
            e.preventDefault();
            if (viewport() < 992) {
                closeMainMenuMobile();
            }
        });
        $('#main_menu').find('li.hasChild .main-menu-arrow, li.hasChild .core-menu-header').each(function (index) {
            var ele_li_parent = $(this).parent();
            $(this).click(function (e) {
                e.preventDefault();
                if (viewport() < 992) {
                    ele_li_parent.addClass('mobile-show-menu-child');
                    ele_li_parent.parent().find('> li:not(.mobile-show-menu-child)').addClass('mobile-hide-menu-child');
                    ele_li_parent.parent().addClass('main-menu-non-overflow');

                    ele_li_parent.animate({
                        'margin-left': "0"
                    }, 500, function() {
                        // Animation complete.
                    });
                }
            });
        });
        $('#main_menu').find('li.hasChild .main-sub-menu-back').each(function (index) {
            var ele_li_parent = $(this).parent();
            $(this).click(function (e) {
                e.preventDefault();
                if (viewport() < 992) {
                    ele_li_parent.animate({
                        'margin-left': "100%"
                    }, 400, function() {
                        ele_li_parent.removeClass('mobile-show-menu-child').css("margin-left", "");
                        ele_li_parent.parent().find('> li.mobile-hide-menu-child').removeClass('mobile-hide-menu-child');
                        ele_li_parent.parent().removeClass('main-menu-non-overflow');
                    });
                }
            });
        });
        $(window).resize(function () {
            if (viewport() >= 992) {
                closeMainMenuMobile();
            }
        });
    };
    var openMainMenuMobile = function () {
        $('#mainMenuSection').addClass('mobile-view');
        $('html').addClass('mobile-menu-open');
    };
    var closeMainMenuMobile = function () {
        $('#mainMenuSection').removeClass('mobile-view');
        $('html').removeClass('mobile-menu-open');
        $('#main_menu').find('li.mobile-show-menu-child').each(function (index) {
            $(this).css("margin-left", "");
            $(this).removeClass('mobile-show-menu-child');
        });
        $('#main_menu').find('li.mobile-hide-menu-child').each(function (index) {
            $(this).removeClass('mobile-hide-menu-child');
        });
        $('#main_menu').find('.main-menu-non-overflow').each(function (index) {
            $(this).removeClass('.main-menu-non-overflow');
        });
    };

    var fixBootrapPoup = function () {
        $(document).on('hidden.bs.modal', function (e) {
            $(e.target).removeData('bs.modal');
        });
    };

    var scrollDetect = function () {
        if (viewport() < 992) {
            $('#header_mobi').css('display', 'block');
        } else {
            $('#header_mobi').css('display', 'none');
            $('.notify_group').css('display', 'block');
        }
        var _top = $(window).scrollTop();
        var _direction;
        var el = $('body');
        $(window).scroll(function () {
            if (viewport() < 992 && !el.hasClass('openNotify')) {
                var _cur_top = $(window).scrollTop();
                if (_top < _cur_top && _top > 0)
                {
                    if ($('.sl-rsp-modal').hasClass('in')) {

                    }
                    else {
                        _direction = 'down';
                        $('body').addClass('faceOutEffect');
                    }

                }
                else
                {
                    if ($('.sl-rsp-modal').hasClass('in')) {

                    }
                    else {
                        _direction = 'up';
                        $('body').removeClass('faceOutEffect');
                    }

                }
                _top = _cur_top;
            }
        });

    };

    var slideSearch = function () {
        $('#global-search').focus(function () {
            $(this).addClass('active');
        }).blur(function () {
            $(this).removeClass('active');
        });

    };
    var hideMenuAjax = function () {
        if (viewport() < 992) {
            if ($('.menu_top_list').size() > 0) {
                $('.menu_top_list a').unbind('click');
                $('.menu_top_list a').click(function () {
                    $('#leftnav').sidebarModal('hide');
                    $('#right').sidebarModal('hide');
                    $('body').scrollTop(0);
                });
            }
            /*if ($('.menu-list').size() > 0) {
                $('.menu-list a').unbind('click');
                $('.menu-list a').click(function () {
                    $('#leftnav').sidebarModal('hide');
                    $('#right').sidebarModal('hide');
                    $('body').scrollTop(0);
                });
            }*/
            if ($('#global-search-filters').size() > 0) {
                $('#global-search-filters a').unbind('click');
                $('#global-search-filters a').click(function () {
                    $('#leftnav').sidebarModal('hide');
                    $('#right').sidebarModal('hide');
                    $('body').scrollTop(0);
                });
            }
        }


    };
    var loadingState = function () {
        $('.loadingBtn').unbind('click');
        $('.loadingBtn').on('click', function () {
            $(this).button('loading');
        })
    };
    var msieversion = function () {
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0) {
            $('.upload-section span').css('display', 'none');
        }
        return false;
    };
    var fullHeaderScroll = function () {
        scrollDesktop();
        $(window).scroll(function () {
            scrollDesktop();
        });
        $('body').trigger('afterResponsiveFullHeaderScroll', [{}]);
    };
    var scrollDesktop = function () {
        if (viewport() > 992) {
            var _top = $(window).scrollTop();
            if (_top > 56) {
                $('body').addClass('documentScrolling');
            } else {
                $('body').removeClass('documentScrolling');
            }
        }
    };
    var scrollTopMobile = function () {
        if (viewport() < 992) {
            window.scrollTo(0, 0);
        }
    };
    var keepOpenDropdown = function () {

        $(document).on('click', '.dropdown-menu', function (e) {
            $(this).hasClass('keep_open') && e.stopPropagation();
        });

    };
    var HoldWhenPressInput = function () {
        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {

            $('.modal').on('show.bs.modal', function () {

                // Position modal absolute and bump it down to the scrollPosition
                $(this)
                        .css({
                            position: 'absolute',
                            marginTop: $(window).scrollTop() + 'px',
                            bottom: 'auto'
                        });

                // Position backdrop absolute and make it span the entire page
                //
                // Also dirty, but we need to tap into the backdrop after Boostrap
                // positions it but before transitions finish.
                //
                setTimeout(function () {
                    $('.modal-backdrop').css({
                        position: 'absolute',
                        top: 0,
                        left: 0,
                        width: '100%',
                        height: Math.max(
                                document.body.scrollHeight, document.documentElement.scrollHeight,
                                document.body.offsetHeight, document.documentElement.offsetHeight,
                                document.body.clientHeight, document.documentElement.clientHeight
                                ) + 'px'
                    });
                }, 0);
            });
        }
    };
    var arragePhotoFeed = function () {
        if ($('.PE').size() > 0) {
            $('.PE').each(function () {
                var photoContent = $(this).parent();
                var photoContentWidth = photoContent.width();
                // 3 photos
                var largeImageWidth = 0.667 * photoContentWidth;
                var smallImageWidth = 0.332 * photoContentWidth;
                photoContent.find('.ej').css({'width': largeImageWidth, 'height': largeImageWidth});
                photoContent.find('.sp').css({'width': smallImageWidth, 'height': largeImageWidth / 2});
                photoContent.find('.sp.eq').css({'width': smallImageWidth, 'height': (largeImageWidth / 2) - 1});
                //4 photos
                var largeImageWidth1 = 0.749 * photoContentWidth;
                var smallImageWidth1 = 0.249 * photoContentWidth;
                photoContent.find('.ej1').css({'width': largeImageWidth1, 'height': largeImageWidth1});
                photoContent.find('.sp1').css({'width': smallImageWidth1, 'height': largeImageWidth1 / 3});
                photoContent.find('.sp1.eq1').css({'width': smallImageWidth1, 'height': (largeImageWidth1 / 3) - 2});

                $('body').trigger('afterArragePhotoFeed', [{element: $(this)}]);
            });

        }
    };

    var checkDimensionSingleImage = function () {
        if ($('.single_img').size() > 0) {
            $('.single_img').each(function () {
                var img = $(this);
                var pic_real_width, pic_real_height;
                $("<img/>") // Make in memory copy of image to avoid css issues
                        .attr("src", $(img).attr("src"))
                        .load(function () {
                            pic_real_width = this.width;   // Note: $(this).width() will not
                            pic_real_height = this.height; // work for in memory images.

                            if (pic_real_height >= pic_real_width) {
                                $(img).addClass('verticalImage');
                            } else {
                                $(img).addClass('horizionImage');
                            }
                            
                            $('body').trigger('afterCheckDimensionSingleImage', [{element: $(img)}]);
                        });
            })


        }
    };
    var preventscrollbody = function () {
        $("#portlet-config").on("show.bs.modal", function () {
            $(".content-wrapper").css('height', $(window).height());
            $('body').addClass('open-modal');
        }).on("hide.bs.modal", function () {
            $(".content-wrapper").css('height', 'auto');
            $('body').removeClass('open-modal');
        });
        $("#themeModal").on("show.bs.modal", function () {
            $("#content-wrapper").css('height', $(window).height());
            $('body').addClass('open-modal');
        }).on("hide.bs.modal", function () {
            $("#content-wrapper").css('height', 'auto');
            $('body').removeClass('open-modal');
        });
        $("#langModal").on("show.bs.modal", function () {
            $("#content-wrapper").css('height', $(window).height());
            $('body').addClass('open-modal');
        }).on("hide.bs.modal", function () {
            $("#content-wrapper").css('height', 'auto');
            $('body').removeClass('open-modal');
        });
    };
    var menuiPadHorizontal = function () {
        $('.btn_open_large').unbind('click');
        $('.btn_open_large').click(function () {
            $('.open_large_menu').toggle();
        });

    };
    var closeLeftBarWhenSearchMobile = function () {
        $('#leftnav input').bind('keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                $('#leftnav').sidebarModal('hide');
            }
        })


    };
    var detectKeyBoardShow = function () {
        $(document).ready(function () {
            $('input,textarea').bind('focus', function () {
                $('body').addClass('keyboard');
            });
        });
        $(document).ready(function () {
            $('input,textarea').bind('blur', function () {
                $('body').removeClass('keyboard');
            });
        });
    };
    var toggleFeedAction = function () {
        if ($('.stt-action').size() > 0) {
            var myMarginTop = 0;
            $('.stt-action > #userTagging-id-userTagging > i').unbind('click').click(function () {
                myMarginTop = parseInt($(".stt-action").css("marginTop"));
                if ($(this).next().hasClass('hidden')) {
                    $(this).next().hide();
                    if ($('#wall_photo_preview').is(':visible')) {
                        $('#wall_photo_preview').css('bottom', '39px');
                    }
                    myMarginTop -= 30;
                } else {
                    $(this).next().show();
                    myMarginTop += 30;
                    if ($('#wall_photo_preview').is(':visible')) {
                        $('#wall_photo_preview').css('bottom', '70px');
                    }
                }
                $('.stt-action').css('margin-top', myMarginTop);
            });
        }
    };
    var defineScroll = function () {
        if (viewport() < 992) {
            // $('body').kinetic();
        }
    };
    var catCollapse = function(){
        $('.menu-list-toggle').CategoryMenuToggle();
    };
    
    // Fix bug safari on IOS 11 , MOOSOCIAL-3832
    var initModalSafari11 = function(){
            $(".modal").on("show.bs.modal", function () {
                if( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
                    $('body').addClass('modal-iphone');
                } 
            });
    };

    var initLoginPopup = function () {
        $('.dropdown-popup-toggle').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).parent().toggleClass('open');
        });

        $(document).on('click', function (e) {
            var target = $(e.target);
            if ( target.parents(".login-popup-group").length != 1 ) {
                $('.login-popup-group').removeClass('open');
            }
        });
    };
    var document_width, document_height;

    var initGridListView = function (eleID) {
        var eleGridList = $(eleID);
        var eleTarget = $(eleGridList.attr('data-target'));

        if( eleGridList.length > 0 ){
            var eleActive = eleGridList.find('.gl-item.active:first');
            var sortType = eleActive.attr('data-type');
            eleTarget.removeClass('grid-view').removeClass('list-view');
            if(sortType == 'grid'){
                eleTarget.addClass('grid-view');
            }else if(sortType == 'list'){
                eleTarget.addClass('list-view');
            }

            eleGridList.find('.gl-item').unbind('click').bind('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                var _sortType = $(this).attr('data-type');

                eleGridList.find('.active').removeClass('active');

                $(this).addClass('active');

                eleTarget.removeClass('grid-view').removeClass('list-view');
                if(_sortType == 'grid'){
                    eleTarget.addClass('grid-view');
                }else if(_sortType == 'list'){
                    eleTarget.addClass('list-view');
                }
            });
        }
    };

    return{
        init: function () {
            detectKeyBoardShow();
            addLeftRightResponsive();
            addMainMenuMobile();
            scrollDetect();
            fullHeaderScroll();
            arragePhotoFeed();
            checkDimensionSingleImage();
            closeLeftBarWhenSearchMobile();
            //toggleFeedAction();
            catCollapse();
            initModalSafari11();
            document_width=$(document).width(); 
            document_height=$(document).height();
            $(window).resize(function () {

                addLeftRightResponsive();

                if($(document).width() != document_width && $(document).height() != document_height)
                {
                    //addMainMenuMobile();
                    scrollDetect();
                    arragePhotoFeed();
                    document_width=$(document).width(); 
                    document_height=$(document).height();
                }

            });
            fixBootrapPoup();
            slideSearch();
            hideMenuAjax();
            msieversion();
            //scrollTopMobile();
            keepOpenDropdown();
            defineScroll();
            //initGridListView('#GridListBar');

            $('select.core-select').niceSelect();

            $('.sidebar-modal').on('show.bs.sidebarModal', function (e) {
                var element = $(this);
                var attr_id = element.attr('id');
                var position = '';
                if(attr_id == 'leftnav'){
                    position = 'left';
                }else if(attr_id == 'right'){
                    position = 'right';
                }
                $(document).trigger('afterSidebarModalShow', [{element: element, position: position}]);
            });
            $('.sidebar-modal').on('hide.bs.sidebarModal', function (e) {
                var element = $(this);
                var attr_id = element.attr('id');
                var position = '';
                if(attr_id == 'leftnav'){
                    position = 'left';
                }else if(attr_id == 'right'){
                    position = 'right';
                }
                $(document).trigger('afterSidebarModalHide', [{element: element, position: position}]);
            });
        },
        initFeedImage: function () {
            arragePhotoFeed();
            checkDimensionSingleImage();
        },
        arragePhotoFeed: function (){
            arragePhotoFeed();
        },
        initGridListView: function (eleID) {
            initGridListView(eleID);
        },
        initLoginPopup: function () {
            initLoginPopup();
        }
    }
}));