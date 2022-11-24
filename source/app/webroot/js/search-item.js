(function ($) {
    var SearchItemUI = function () {
        var defaults = {
            asButtonOpenFor: ''
        };

        var switchForm = function (_this, isSearchMore){
            var adv_keyword_input = null;
            var adv_clone_input = null;
            var field_name = null;

            if( _this.find('input.advanced-search-keyword').length > 0 ){
                adv_keyword_input = _this.find('input.advanced-search-keyword');
                field_name = adv_keyword_input.attr('name');

                if( _this.find('.header_search_popup').find('input[name="'+field_name+'"]').length > 0 ){
                    adv_clone_input = _this.find('.header_search_popup').find('input[name="'+field_name+'"]');
                }

                if(adv_clone_input != null){
                    if(isSearchMore === true){
                        adv_clone_input.val(adv_keyword_input.val());
                        adv_keyword_input.prop( "disabled", true );
                        adv_clone_input.prop( "disabled", false );

                        adv_keyword_input.hide();
                        adv_clone_input.show();

                        adv_clone_input.focus();
                    }else{
                        adv_keyword_input.val(adv_clone_input.val());
                        adv_keyword_input.prop( "disabled", false );
                        adv_clone_input.prop( "disabled", true );

                        adv_clone_input.hide();
                        adv_keyword_input.show();

                        adv_keyword_input.focus();
                    }
                }else{
                    adv_keyword_input.focus();
                }
            }else{
                var $firstInput = _this.find("input:text:visible:first").focus();
                var $firstTextArea = _this.find("textarea:visible:first").focus();

                if($firstInput.length == 0) {
                    $firstTextArea.focus();
                } else {
                    $firstInput.focus();
                }
            }
        };

        var closeSearch = function (_this) {
            _this.removeClass('advanced-search-open');
            _this.removeClass('advanced-search-show-popup');
            _this.find('.header_search_popup').removeClass('search-popup-open');
            _this.find('.header-advanced-search').css({
                width: 'auto'
                //top: '',
                //left: '',
                //right: ''
            });
            $('html').removeClass('main-advanced-popup-open');
        };

        var openFullFormSearch = function (_this) {
            /*_this.toggleClass('advanced-search-open');
            _this.find('.header_search_popup').toggleClass('search-popup-open');
            _this.toggleClass('advanced-search-show-popup');
            $('html').toggleClass('main-advanced-popup-open');
            _this.find('input.advanced-search-keyword').focus();*/

            openKeywordFormSearch(_this);
            openMoreFormSearch(_this);
        }

        var openKeywordFormSearch = function (_this) {
            _this.toggleClass('advanced-search-open');
            //_this.find('input.advanced-search-keyword').focus();
            switchForm(_this, false);
        }

        var openMoreFormSearch = function (_this) {
            if( _this.hasClass('advanced-search-show-popup') ){
                closeSearch(_this);
            }else {
                _this.find('.header_search_popup').toggleClass('search-popup-open');
                _this.addClass('advanced-search-show-popup');
                $('html').toggleClass('main-advanced-popup-open');
                //_this.find('input.advanced-search-keyword').focus();

                var box_header = _this.parent();
                /*var box_header_offset = _this.parent().offset();

                var offset_right = $(window).width() - (box_header.outerWidth() + box_header_offset.left);

                var content_offset = $('#content-wrapper').offset();

                var more_top = content_offset.top;

                if ($('body').hasClass('documentScrolling')) {

                } else {
                    more_top += 15;
                }
                var search_top = box_header_offset.top - $(window).scrollTop();*/

                _this.find('.header-advanced-search').css({
                    width: box_header.outerWidth(),
                    //top: search_top + 'px',
                    //left: box_header_offset.left+'px',
                    //right: offset_right+'px'
                });

                switchForm(_this, true);
            }
        }

        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});

                return this.each(function () {
                    var _this = $(this);
                    var window_width = $(window).width();

                    if(opt.asButtonOpenFor != ''){
                        if($(opt.asButtonOpenFor).length != 0){
                            $(opt.asButtonOpenFor).click(function (e) {
                                e.preventDefault();
                                var openType = $(this).attr('data-open');
                                if( typeof openType !== 'undefined'){
                                    if(openType == 'full'){
                                        openFullFormSearch(_this);
                                    }else{
                                        openKeywordFormSearch(_this);
                                    }
                                }else {
                                    openKeywordFormSearch(_this);
                                }
                                //e.stopPropagation();
                            });
                        }
                    }

                    $(this).find('.box_header_search_overview').click(function (e) {
                        e.preventDefault();
                        //e.stopPropagation();
                        if( $(window).width() >= 768 ){
                            if( !_this.hasClass('advanced-search-show-popup') ){
                                closeSearch(_this);
                            }
                        }else{
                            closeSearch(_this);
                        }
                    });
                    $(this).find('.header_search_more').click(function (e) {
                        e.preventDefault();
                        //e.stopPropagation();
                        openMoreFormSearch(_this);
                    });
                    $(this).find('.btn-search_close').click(function (e) {
                        e.preventDefault();
                        //e.stopPropagation();
                        closeSearch(_this);
                    });

                    $('body').on('afterAjaxSearchServerJSCallback', function(e, data){
                        closeSearch(_this);
                    });

                    $(window).resize(function (){
                        var res_width = $(window).width();
                        if(window_width != res_width){
                            window_width = res_width;
                            closeSearch(_this);
                        }
                    });

                });
            },
            close: function () {
                return this.each(function(){
                    var _this = $(this);
                    closeSearch(_this);
                });
            }
        };
    }();

    $.fn.extend({
        SearchItemUI: SearchItemUI.init,
        SearchItemUIClose: SearchItemUI.close
    });
})(jQuery);