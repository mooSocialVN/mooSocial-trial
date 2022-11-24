mooApp.controller('BlogsIndexController', ['$scope','cfg','Restangular','$sce',function($scope,cfg,Restangular,$sce) {
    $scope.isShowNoResult = false;
    $scope.isShowLoadMore = false;
    var current ={
        filter:cfg._ALL_ENTRIES_, /* current filter */
        page  : 1,    /* current Page */
        totalPage : 1    /* total page of current filter */
    };
    /* Default Option for Filter*/
    var oDefaults = {type:false,event:false,page:1};
    var blogs = Restangular.all('api/blog/blogs/browse');
    function setCurrent(options){
        current = jQuery.extend( {}, current, options );
    };
    function getCurrent(option){
        if(typeof option === 'undefined'){
            return current;
        }else{
            return current[option];
        }
    };
    function render(blogs){};
    function setActiveMenu($el){
        var p = $el.parent();
        p.siblings().removeClass('current');
        p.addClass('current');
    };
    $scope.filter = function(options){

        var settings = jQuery.extend( {}, oDefaults, options );
        setCurrent({page:settings.page});
        if(settings.type !== false){
            setCurrent({filter:cfg[settings.type]});
        }
        if(settings.event !== false){
            setActiveMenu(angular.element(event.currentTarget));
        }
        if(settings.page == 1){
            blogs.one(getCurrent('filter')).getList().then(function(blogs) {

                if ( blogs.length == 0){ // no more result ?
                    $scope.no_more_result = true;
                }else{
                    $scope.blogs = blogs;
                }
            });
        }else{
            blogs.one(getCurrent('filter')).one("page:"+settings.page).getList().then(function(blogs) {
                if ( blogs.length == 0){
                    $scope.no_more_result = true;
                }else{
                    $scope.blogs = jQuery.merge($scope.blogs,blogs);
                }

            });
        }

    }

    $scope.loadMore = function(){
        var nextPage = getCurrent('page') + 1 ;
        $scope.filter({page:nextPage});
    }
}]);