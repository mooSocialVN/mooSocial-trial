/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooResponsive', 'mooCoreMenu','mooPhrase','mooTooltip', 'spinner'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooSearch = factory();
    }
}(this, function ($, mooResponsive, mooCoreMenu, mooPhrase, mooTooltip) {
    
    var defaults = {
        asHorizontalMenuFor: ''
    };

    //    methods
    var globalSearchMore = function globalSearchMore(filter){
        $('#filter-' + filter).trigger('click');
    };
    
    // app/View/Search/index.ctp
    // app/View/Search/suggestion_filter.ctp
    var init = function(opt){
        opt = $.extend({}, defaults, opt||{});

        var asHorizontalMenuFor = false;
        if(opt.asHorizontalMenuFor != ''){
            if($(opt.asHorizontalMenuFor).length != 0){
                asHorizontalMenuFor = true;
            }
        }

        $('#global-search-filters li').unbind("click");
        $('#global-search-filters li').click(function(){
        	var element = $(this).find('a');
        	if (element.hasClass('no-ajax'))
        		return true;
        	
            element.spin('tiny');
            $('#global-search-filters .current').removeClass('current');
            element.parent().addClass('current');

            switch ( element.attr('id') )
            {
                case 'filter-blogs':
                case 'filter-groups':
                case 'filter-topics':
                    $('#search-content').html('<div class="core-loading topics" id="list-content">' + mooPhrase.__('loading') + '</div>');
                    break;

                case 'filter-albums':
                case 'filter-videos':
                    $('#search-content').html('<div class="core-loading albums" id="list-content">' + mooPhrase.__('loading') + '</div>');
                    break;

                case 'filter-users':
                    $('#search-content').html('<div class="core-loading users_list" id="list-content">' + mooPhrase.__('loading') + '</div>');
                    break;
                default :
                    $('#search-content').html('<div class="core-loading" id="list-content">' + mooPhrase.__('loading') + '</div>');
            }

            var obj = element;
            var type = element.hasClass('json-view');
            var data = element.data();
            $('#search_result_content').load( encodeURI( data.url ), {noCache: 1}, function(response){
                obj.spin(false);
                mooResponsive.init();
                initGlobalSearchMore();
                mooTooltip.init();

                if(asHorizontalMenuFor){
                    $(opt.asHorizontalMenuFor).HorizontalMenuClose();
                }

                $('body').trigger('afterAjaxSearchGlobalSearchCallback',[]);
            });

            return false;
        });
        
        // bind globalSearchMore
        initGlobalSearchMore();
    };
    
    // app/View/Search/hashtags.ctp
    var hashInit = function(params, opt){

        opt = $.extend({}, defaults, opt||{});

        var parseJSON = $.parseJSON(params);
        init(opt);
        var tabs = parseJSON['tabs'];
        if(tabs != '')
        {
            if ($("#filter-"+tabs).length > 0)
            {
                $("#filter-"+tabs).spin('tiny');
                $('#global-search-filters .current').removeClass('current');
                $("#filter-"+tabs).parent().addClass('current');
                $('#search_result_content').html(mooPhrase.__('loading'));
                $('#search_result_content').load( $('#filter-'+tabs).attr('data-url'), function(response){
                    $('#filter-'+tabs).spin(false);
                    mooResponsive.init();
                });
            }else{
                window.location.replace(parseJSON['link']);
                
            }
        }
        
        // bind globalSearchMore
        initGlobalSearchMore();
    };
    
    var initGlobalSearchMore = function(){
        // bind globalSearchMore
        $('.globalSearchMore').unbind('click');
        $('.globalSearchMore').on('click', function(){
           var data = $(this).data();
           globalSearchMore(data.query);
        });
    }
    
    //    exposed public method
    return {
        initGlobalSearchMore : initGlobalSearchMore,
        init:init,
        hashInit:hashInit
    };
}));