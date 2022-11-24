/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooButton', 'mooOverlay', 'mooResponsive', 'mooAjax', 'mooAlert',
            'spinner'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'), require('button'));
    } else {
        // Browser globals (root is window)
        root.mooBehavior = factory();
    }
}(this, function ($, mooButton, mooOverlay, mooResponsive, mooAjax, mooAlert) {
    
    var flagScroll = true;
    
    //    methods
    var initAutoLoadMore = function(){
        if(mooConfig.autoLoadMore != ''){
            $(window).scroll(function(){
                var $elem = $('.view-more');
                if($elem.length > 0){
                    var $window = $(window);

                    var docViewTop = $window.scrollTop();
                    var docViewBottom = docViewTop + $window.height();

                    var elemTop = $elem.offset().top;
                    var elemBottom = elemTop + $elem.height();

                    if(( elemBottom <= docViewBottom) && (elemTop >= docViewTop) && flagScroll && $('.shepherd-element').length == 0)
                    {
                        $elem.before('<div style="text-align: center" class="loading"><img src="'+mooConfig.url.base+'/img/loading.gif" /></div>');
                        $elem.find('a').trigger('click');
                        flagScroll = false;
                    }
                }
            });
        }
    };
    
    var createItem = function( type, jsonView ){
        mooButton.disableButton('saveBtn');
        var action  = 'ajax_save';
        
        if(jsonView){
            action = 'save';
        }
        
        mooAjax.post({
            url : mooConfig.url.base + "/" + type + "/"+action,
            data: $("#createForm").serialize()
        }, function(data){
            var json = $.parseJSON(data);

            if ( json.result == 1 ){
                window.location = mooConfig.url.base + '/' + type + '/view/' + json.id;
            }
            else{
                mooButton.enableButton('saveBtn');
                $(".error-message").show();
                $(".error-message").html(json.message);
                if ($('.spinner').length > 0){
                    $('.spinner').remove();
                }
            }
        });
    };
    
    // app/Plugin/Blog/View/Elements/lists/blogs_list.ctp
    // app/Plugin/Event/View/Elements/lists/events_list.ctp
    // app/Plugin/Group/View/Elements/ajax/group_photo.ctp
    // app/Plugin/Group/View/Elements/lists/groups_list.ctp
    // app/Plugin/Photo/View/Elements/lists/albums_list.ctp
    // app/Plugin/Topic/View/Elements/ajax/group_topic.ctp
    // app/Plugin/Topic/View/Elements/lists/topics_list.ctp
    // app/Plugin/Video/View/Elements/lists/videos_list.ctp
    // app/View/Histories/ajax_show.ctp
    var initMoreResults = function(){
        // init moreResults
        $('.view-more .viewMoreBtn').unbind( "click" );
        $('.view-more .viewMoreBtn').click(function(){
            var data = $(this).data();
            moreResults(data.url, data.div, this); 
        });
        
        $('.view-more-chrono .viewMoreBtn').unbind( "click" );
        $('.view-more-chrono .viewMoreBtn').click(function(){
            var data = $(this).data();
            moreResultsChrono(data.url, data.div, this); 
        });
    }
    
    var initMoreResultsPopup = function(){
    	// init moreResults
        $('.view-more .viewMoreBtn').unbind( "click" );
        $('.view-more .viewMoreBtn').click(function(){
            var data = $(this).data();
            moreResultsPopup(data.url, data.div, this); 
        });
    }
    
    var moreResultsPopup = function(url, div, obj){
        $(obj).spin('small');
        $(obj).parent().css('display', 'none');
                
        $.post(mooConfig.url.base + url, '' ,function(data){
            $(obj).spin(false);
            $('#' + div).find('.view-more:first').remove();
            $('#' + div).children('.clear:first').remove();
            $('#' + div).find('.loading:first').remove();
            
            $("#" + div).append(data);
            
            // bind load more button
            initMoreResultsPopup();
        });
    };
    
    var moreResults = function(url, div, obj){
        $(obj).spin('small');
        $(obj).parent().css('display', 'none');
        var postData = {};
        
        if(typeof(window.searchParams) === 'undefined'){
            window.searchParams = '';
        }
        $.post(mooConfig.url.base + url,window.searchParams ,function(data){
            $(obj).spin(false);
            $('#' + div).find('.view-more:first').remove();
            $('#' + div).children('.clear:first').remove();
            $('#' + div).find('.loading:first').remove();
            flagScroll = true;
            if ( div == 'comments' || div == 'theaterComments' ){
                $("#" + div).append(data);
                
                // move load more to end of comment list
                $('#'+div+' .view-more').insertAfter('#'+div+' li[id^="itemcomment_"]:last');
            }
            else{
                $("#" + div).append(data);
                
            }

            mooOverlay.registerOverlay();
            registerImageComment();

            $(".tip").tipsy({ html: true, gravity: 's' });

            window.initShareBtn();

            mooResponsive.initFeedImage();
            
            // bind load more button
            initMoreResults();

            $('body').trigger('afterMoreResultsBehaviorCallback',[]);
        });
    };
    
    var moreResultsChrono = function(url, div, obj){
        $(obj).spin('small');
        $(obj).parent().css('display', 'none');
        var postData = {};
        
        if(typeof(window.searchParams) === 'undefined'){
            window.searchParams = '';
        }
        $.post(mooConfig.url.base + url,window.searchParams ,function(data){
            $(obj).spin(false);
            $('#' + div).find('.view-more:first').remove();
            $('#' + div).children('.clear:first').remove();
            $('#' + div).find('.loading:first').remove();
            flagScroll = true;
            if ( div == 'comments' || div == 'theaterComments' ){
                $("#" + div).prepend(data);
                
                // move load more to end of comment list
                $('#'+div+' .view-more').insertAfter('#'+div+' li[id^="itemcomment_"]:last');
            }
            else{
                $("#" + div).prepend(data);
                
            }

            mooOverlay.registerOverlay();
            registerImageComment();

            $(".tip").tipsy({ html: true, gravity: 's' });

            window.initShareBtn();

            mooResponsive.initFeedImage();
            
            // bind load more button
            initMoreResults();

            $('body').trigger('afterMoreResultsBehaviorCallback',[]);
        });
    };
    
    var toggleCheckboxes = function(obj){
        if ( obj.checked ){
            $('.check').attr('checked', 'checked');
        }
        else{
            $('.check').attr('checked', false);
        }
    };
    
    var toggleMenu = function(menu){
        
        if ( menu == 'leftnav' ){
            if ( $('#leftnav').css('left') == '-200px' ){
                $('#leftnav').animate({left:0}, 300);
                $('#right').animate({right:-204}, 300);
                $('#center').animate({left:200}, 300);
            }
            else{
                $('#leftnav').animate({left:-200}, 300);
                $('#center').animate({left:0}, 300);
            }
        }
        else{
            if ( $('#right').css('right') == '-204px' ){
                $('#right').show();
                $('#right').animate({right:0}, 300);
                $('#leftnav').animate({left:-200}, 300);
                $('#center').animate({left:0}, 300);
            }
            else{
                $('#right').animate({right:-204}, 300, function(){
                    $('#right').hide();
                });
            }
        }
    };
    
    var registerImageComment = function(){
        
        if ($('.comment_thumb a').length){
            $('.comment_thumb a').magnificPopup({
                type:'image',
                gallery: { enabled: false },
                zoom: {
                    enabled: true,
                    opener: function(openerElement) {
                        return openerElement;
                    }
                }
            });
        }
    }
    
    var registerEventThumb = function(){
        
        if ($('.event-detail-thumb').length){
            $('.event-detail-thumb').magnificPopup({
                type:'image',
                gallery: { enabled: false },
                zoom: {
                    enabled: true,
                    opener: function(openerElement) {
                        return openerElement;
                    }
                }
            });
        }
    }
    
    // app/View/Reports/ajax_create.ctp
    var initOnReportItem = function(){
        
        $('#reportButton').unbind('click');
        $('#reportButton').click(function(){
            mooButton.disableButton('reportButton');
            $('#reportButton').spin('small');
            
            mooAjax.post({
                url : mooConfig.url.base + "/reports/ajax_save",
                data : $("#reportForm").serialize()
            }, function(data){
                mooButton.enableButton('reportButton');
                $('#reportButton').spin(false);
                
                var json = $.parseJSON(data);

                if ( json.result == 1 )
                {
                    $(".error-message").hide();
                    $("#reason").val("");
                    $("#reason").trigger('updateAutoGrow');
                    mooAlert.alert(json.message);
                    $('#portlet-config').modal('hide');
                    $('#themeModal').modal('hide');
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            
	});
	return false;
    }
	
	//////////////////////////////////start feed form//////////////////////////////////
    var _currentEnablePlugin = [];
    var initFeedForm = function()
    {
        $('body').on('startFeedPlugin3drCallback', function(e, data){
            var index = _currentEnablePlugin.indexOf(data.plugin_name);
            if (index == -1) {
                _currentEnablePlugin.push(data.plugin_name);
                disableOtherPlugins(data.plugin_name);
				$('body').trigger('listFeedPlugin3drEnableCallback',[{plugins:_currentEnablePlugin}]);
				$('body').trigger('checkActivityFormActionCallback');
            }
        })
        
        $('body').on('stopFeedPlugin3drCallback', function(e, data){
            var index = _currentEnablePlugin.indexOf(data.plugin_name);
            if (index > -1) {
                enableOtherPlugins(data.plugin_name);
                _currentEnablePlugin.splice(index, 1);
                checkOtherPluginsStillEnabled();
				$('body').trigger('listFeedPlugin3drEnableCallback',[{plugins:_currentEnablePlugin}]);
                $('body').trigger('checkActivityFormActionCallback');
            }
        })

        $('body').on('refreshFeedPlugin3drCallback', function(e, data){
            var index = _currentEnablePlugin.indexOf(data.plugin_name);
            if(data.status === "add"){
                if (index == -1) {
                    _currentEnablePlugin.push(data.plugin_name);
                    disableOtherPlugins(data.plugin_name);
                    $('body').trigger('checkActivityFormActionCallback');
                }
            }else if(data.status === "remove"){
                if (index > -1) {
                    _currentEnablePlugin.splice(index, 1);
                    enableOtherPlugins(data.plugin_name);
                    checkOtherPluginsStillEnabled();
                    $('body').trigger('checkActivityFormActionCallback');
                }
            }
        })
    }
    
    function enableOtherPlugins(key){
        var _plugins = mooConfig.FeedPluginConfig[key];
        if(_plugins.length == 0)
        {
            return;
        }
        $('body').trigger('enablePluginsCallback',[{plugins:_plugins}]);
    }
    
    function disableOtherPlugins(key){
        var _plugins = mooConfig.FeedPluginConfig[key];
        if(_plugins.length == 0)
        {
            return;
        }
        $('body').trigger('disablePluginsCallback',[{plugins: _plugins}]);
    }
    
    function checkOtherPluginsStillEnabled(){
        if(_currentEnablePlugin.length == 0)
        {
            return;
        }
        for(var i = 0; i < _currentEnablePlugin.length; i++){
            disableOtherPlugins(_currentEnablePlugin[i])
        }
    }
    //////////////////////////////////end feed form//////////////////////////////////

    //    exposed public methods
    return {
        initAutoLoadMore : initAutoLoadMore,
        createItem : createItem,
        initMoreResults : initMoreResults,
        initMoreResultsPopup : initMoreResultsPopup,
        toggleCheckboxes : toggleCheckboxes,
        toggleMenu : toggleMenu,
        registerImageComment : registerImageComment,
        registerEventThumb : registerEventThumb,
        initOnReportItem : initOnReportItem,
		initFeedForm: initFeedForm
    }
}));