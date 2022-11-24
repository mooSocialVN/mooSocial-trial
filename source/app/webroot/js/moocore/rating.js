/* Copyright (c) SocialLOFT LLC
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 * @author: mooSocial
 * @license: https://moosocial.com/license/
 */

(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooRating = factory();
    }
}(this, function ($) {
    var allow_re_rating = 0;
    
    var init = function(allow_re_rating){
        if(typeof allow_re_rating !== 'undefined' && allow_re_rating == 1)
        {
            setAllowReRating();
            $('body').on('mouseenter','div[id^="stars_"]',function(e){
                $(this).mousemove(function(e){
                    var offset = $(this).offset();
                    var width = e.pageX - offset.left;
                    var step = $(this).data('step');
                    var score = Math.ceil((width/(24*step)));
                    if(score == 0)
                        score = 1;
                    render_rating((score*step),$(this));
                    score_description((score*step),$(this));
                });
            }).on('mouseleave','div[id^="stars_"]',function(e){
                var score = $(this).children('.rated').attr('data-score');
                render_rating(score,$(this));
                summary_info($(this).siblings('.start-comment'),score);
            });

            $('body').on('click','div[id^="stars_"]',function(e){
                var width = $(this).children('.rated').width();
                var step = $(this).data('step');
                var score = Math.ceil(width/24);
                if(score > Math.ceil($(this).width()/24))// score > limit score
                    score = Math.ceil($(this).width()/24);
                var div = $(this);
                var uid = $(this).data('id');
                div.siblings('.start-comment').html('Thank you');
                $.post(mooConfig.url.base+'/ratings/do_rate',{params:$(this).attr('id'),score:score,uid:uid},function(data){
                    var result;
                    try {
                        result = JSON.parse(data);
                    }
                    catch (err){
                        result = 0;
                    }
                    if(result != 0){
                        div.children('.rated').attr('data-score',result.score);
                        div.siblings('.start-comment').attr('data-votes',result.votes);
                        summary_info(div.siblings('.start-comment'),result.score);
                        render_rating(result.score,div);
                    }
                })
            });
        }
    }

    //private because it's not returned
    var score_description = function(score,ratedItem)
    {
        var text = '';
        if(score > Math.ceil(ratedItem.width()/24))
            score = Math.ceil(ratedItem.width()/24);
        switch(parseInt(score)){
            case 1 : text = "Very bad";
                break;
            case 2 : text = "Bad";
                break;
            case 3 : text = "Average";
                break;
            case 4 : text = "Good";
                break;
            case 5 : text = "Perfect";
                break;
        }
        ratedItem.siblings('.start-comment').html(text);
    };
    var summary_info = function(commentOb,score)
    {
        commentOb.html(score+'/'+Math.ceil(commentOb.width()/24)+' (from '+commentOb.attr('data-votes')+' votes)');
    };
    var render_rating = function(score,starOb)
    {
        var rated_width = 24 * score;
        var unrated_width = starOb.width() - rated_width;
        starOb.find('.rated').css({width:rated_width+'px'});
        starOb.find('.un-rated').css({width:unrated_width+'px'});
        starOb.find('.un-rated').css({left:rated_width+'px'});
    };

    var setAllowReRating = function (){
        allow_re_rating = 1;
    };
    var getAllowReRating = function(){
        return allow_re_rating;
    };

    //    exposed public methods
    return {
        init:init,
        getAllowReRating: getAllowReRating
    }
}));
