/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooOverlay', 'mooResponsive', 'mooPhrase', 'mooBehavior','mooTooltip', 'spinner', 'autogrow', 'tipsy'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooTab = factory();
    }
}(this, function ($, mooOverlay, mooResponsive, mooPhrase, mooBehavior, mooTooltip) {

    var initTabs = function (tab) {
        $('#' + tab + ' .tabs > li').click(function () {
            $('#' + tab + ' li').removeClass('active');
            $(this).addClass('active');
            $('#' + tab + ' .tab').hide();
            $('#' + $(this).attr('id') + '_content').show();
        });
    };

    // app/View/Home/index.ctp
    var initHomeTabs = function (tab) {
        if ($('#' + tab).length > 0)
        {
            $('#' + tab).spin('tiny');
            $('#' + tab).children('.badge_counter').hide();
            $('.browse-menu .current').removeClass('current');
            $('#' + tab).parent().addClass('current');
            $('#home-content').html(mooPhrase.__('loading'));
            $('#home-content').load($('#' + tab).attr('data-url'), function (response) {
                $('#' + tab).spin(false);
                $('#' + tab).children('.badge_counter').fadeIn();
                // reattach events
                $('textarea').autogrow();
                $(".tip").tipsy({html: true, gravity: 's'});
                mooOverlay.registerOverlay();

                $('body').trigger('afterHomeTabLoadTabCallback',[]);
            });
        }
        else {
            window.location = mooConfig.url.base + '/';
        }

    }
    
    // app/View/Elements/activities_m.ctp
    // app/View/Elements/ajax/home_activity.ctp
    var initActivitySwitchTabs = function(){
        $("#feed-type a").unbind('click');
        $("#feed-type a").click(function(){
            $('#whats_new').spin('tiny');
            $("#feed-type a").removeClass('current');
            $(this).addClass('current');
            var url = $(this).data('href');
            if (!url)
            	url = $(this).attr('href');

            $('body').trigger('beforeActivitySwitchTabCallback',[]);

            $("#list-content").load(url, {noCache: 1}, function(){
                $('#whats_new').spin(false);
                mooResponsive.init();
                $(".tip").tipsy({html: true, gravity: 's'});
                console.log(mooBehavior);
                mooBehavior.initMoreResults();
                mooTooltip.init();

                $('body').trigger('afterHomeTabLoadTabCallback',[]);
            });
            return false;
        });
    }

    return{
        initTabs: initTabs,
        initHomeTabs: initHomeTabs,
        initActivitySwitchTabs : initActivitySwitchTabs
    }

}));