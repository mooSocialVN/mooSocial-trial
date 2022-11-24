/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'mooAjax', 'mooButton', 'mooBehavior', 'mooAlert', 'mooPhrase', 'mooGroup',
            'spin'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooVideo = factory();
    }
}(this, function ($, mooAjax, mooButton, mooBehavior, mooAlert, mooPhrase, mooGroup) {

    // app/Plugin/Video/View/Videos/create.ctp
    var initOnCreate = function () {
        $('#fetchButton').unbind('click');
        $('#fetchButton').click(function () {
            $('#fetchButton').spin('small');
            $("#videoForm .error-message").hide();

            mooButton.disableButton('fetchButton');

            mooAjax.post({
                url: mooConfig.url.base + "/videos/aj_validate",
                data: $("#createForm").serialize()
            }, function (data) {
                mooButton.enableButton('fetchButton');

                if (data) {
                    $("#fetchForm .error-message").html(JSON.parse(data).error);
                    $("#fetchForm .error-message").show();
                    $('#fetchButton').spin(false);
                } else {
                    mooAjax.post({
                        url: mooConfig.url.base + "/videos/fetch",
                        data: $("#createForm").serialize()
                    }, function (data) {
                        mooButton.enableButton('fetchButton');

                        $("#fetchForm").slideUp();
                        $("#videoForm").html(data);
                    });
                }
            });
            return false;
        });

    };

    // app/Plugin/Video/View/Videos/aj_fetch.ctp
    var initAfterFetch = function () {
        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            mooBehavior.createItem('view', true)
        });

        // bind action to button delete
        deleteVideo();
    }

    // app/Plugin/Video/View/Videos/view.ctp
    var initOnView = function(){
        // bind action to button delete
        deleteVideo();
    }

    // app/Plugin/Video/View/Elements/group/videos_list.ctp
    // app/Plugin/Video/View/Elements/lists/videos_list.ctp
    var initOnListing = function(){
        mooBehavior.initMoreResults();
        // bind action to button delete
        deleteVideo();

        $('.ajaxLoadPage').unbind('click');
        $('.ajaxLoadPage').on('click', function(){
            var data = $(this).data();
            mooGroup.loadPage('videos', data.url);
        });

        $('#saveBtn').unbind('click');
        $('#saveBtn').click(function () {
            $(this).addClass('disabled');
            mooBehavior.createItem('live', true);
        });
    }

    var deleteVideo = function(){
        $('.deleteVideo').unbind('click');
        $('.deleteVideo').click(function(){
            if ($('#themeModal').is(':visible'))
                $('#themeModal').modal('hide');

            var data = $(this).data();
            var deleteUrl = mooConfig.url.base + '/livevideos/delete/' + data.id;
            mooAlert.confirm(mooPhrase.__('are_you_sure_you_want_to_remove_this_video'), deleteUrl);
        });
    }

    return {
        initOnCreate : initOnCreate,
        initAfterFetch : initAfterFetch,
        initOnView : initOnView,
        initOnListing : initOnListing
    }
}));
