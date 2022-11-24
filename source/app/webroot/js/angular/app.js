var mooApp = angular.module('mooApp',['restangular','ngSanitize'])
    .config(function($provide, $compileProvider, $filterProvider,RestangularProvider) {
        $provide.constant('cfg',{
            '_ALL_ENTRIES_' : 'all',
            '_MY_ENTRIES_'  : 'my',
            '_FRIENDS_ENTRIES_':'friends'
        });
        RestangularProvider.setBaseUrl(root).setRequestSuffix('.json');

    });

mooApp.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode){
        return $sce.trustAsHtml(htmlCode);
    }
}]);


