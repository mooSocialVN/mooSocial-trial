
var moo = function () {

    var handleSidebarMenu = function (){

        $($($('ul.page-sidebar-menu').find('li.active')[0]).parents('li')[0]).addClass('active open');
    }

    return {

        //main function to initiate the theme
        init: function () {

            handleSidebarMenu(); // handles style customer tool
        }
    };
}();
