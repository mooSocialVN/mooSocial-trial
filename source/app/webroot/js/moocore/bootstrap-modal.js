(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node, CommonJS-like
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals (root is window)
        root.mooBsModal = factory(root.jQuery);
    }
}(this, function ($) {
    var $bsDocEl = $('html, body');
    var $bsWrap = $('#content-wrapper');
    var bsScrollTop;

    var lockBody = function() {
        if( $(window).scrollTop() > 0 ){
            bsScrollTop = $(window).scrollTop();
            $bsWrap.css({
                position: 'relative',
                top: - (bsScrollTop)
            });
        }
        $bsDocEl.css({
            height: "100%",
            overflow: "hidden"
        });
    };

    var unlockBody = function() {
        $bsDocEl.css({
            height: "",
            overflow: ""
        });

        $bsWrap.css({
            position: '',
            top: ''
        });

        $bsDocEl.animate({ scrollTop: bsScrollTop }, 0);
        bsScrollTop = null;
    };

    return{
        init: function () {

            $(document).find('.modal').each(function(index){
                var $ele_id = $('#'+$(this).attr('id'));

                $ele_id.on('show.bs.modal', function (showEvent) {
                    if (mooConfig.isMobile) {
                        lockBody();
                    }
                });
                $ele_id.on('hidden.bs.modal', function (e) {
                    if (mooConfig.isMobile) {
                        unlockBody();
                    }
                });
            });

        }
    }
}));