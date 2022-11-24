export class Comments {
    constructor(initialValues) {
        this.streamId = 0;
        this.autoHideCountDown = 5; // It means 5s
        this.api = {get_comments:null,get_count:null};
        this.scrollUp = true;
        for (let key in initialValues) {
            if (initialValues.hasOwnProperty(key)) {
                this[key] = initialValues[key];
            }
            this.api.get_comments += '?access_token='+this.access_token;
        }
        this.comments_init()
    }

    comments_init(){
        var me = this;
        require(["jquery"], function($) {$(document).ready(function(){

            function autoRefreshComment() {
                console.log("autoRefreshComment")
                $.get(me.api.get_comments, function (data) {


                    var currentCount = $('#comment_count').text();
                    var nextCount = $(data).find("#comment_count").text();

                    if (currentCount != nextCount) {
                        // For autohide
                        $('#center').show();
                        me.autoHideCountDown = getRndInteger(10,15);

                        $('#comment_count').text(nextCount);
                        $('#comments').html($(data).find("#comments").html());
                        console.log("window.innerHeight",window.innerHeight,window);
                        $('#comments').css({"overflow": "scroll", "height": window.innerHeight-20});
                        setTimeout(function () {
                            if(me.scrollUp){
                                $('#comments').scrollTop(0);
                            }else{
                                $('#comments').scrollTop($('#comments')[0].scrollHeight);
                            }

                        }, 500);

                    }
                });
            }

            function autoHideComment() {
                me.autoHideCountDown -=1;
                if (me.autoHideCountDown < 0){
                    $('#center').hide();
                }
            }

            function getRndInteger(min, max) {
                return Math.floor(Math.random() * (max - min + 1) ) + min;
            }
            setInterval(autoRefreshComment, 10000);
            setInterval(autoHideComment, 1000);

            // support call autoRefreshComment from native app
            window.autoRefreshComment = autoRefreshComment;
        });});

    }


}
