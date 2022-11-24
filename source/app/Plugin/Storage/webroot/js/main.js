// NODE_ENV=production browserify -t [ babelify --presets [ react ] ]   main.js -s mooChat | uglifyjs -c -m >  node_modules/mooChat.js && mv node_modules/mooChat.js node_modules/mooChat.test.js && java -jar /Users/duy/Documents/tool/moo-release/compiler-latest/compiler.jar --js node_modules/mooChat.test.js --js_output_file node_modules/mooChat.js
// NODE_ENV=production browserify -t [ babelify --presets [ react ] ]   main.js -s mooChat | uglifyjs -c -m >  mooChat.js && mv mooChat.js mooChat.test.js && java -jar /Users/duy/Documents/tool/moo-release/compiler-latest/compiler.jar --js mooChat.test.js --js_output_file mooChat.js

function _getMissingPhotoOnAws(type){
    switch (type){
        case "photo":
            if (window.hasOwnProperty('mooConfig')) {
                if (window.mooConfig.hasOwnProperty('aws')) {
                    if (window.mooConfig.aws.hasOwnProperty('missingPhoto')) return window.mooConfig.aws.missingPhoto;
                }
            }
            break;
        case "photo2":
            if (window.hasOwnProperty('mooConfig')) {
                if (window.mooConfig.hasOwnProperty('aws')) {
                    if (window.mooConfig.aws.hasOwnProperty('missingPhoto2')) return window.mooConfig.aws.missingPhoto2;
                }
            }
            break;
        default:
    }
    return [];
}
function _getMissingObjects(){
    if (window.hasOwnProperty('mooConfig')) {
        if (window.mooConfig.hasOwnProperty('aws')) {
            if (window.mooConfig.aws.hasOwnProperty('missingObjects')) return window.mooConfig.aws.missingObjects;
        }
    }
    return [];
}
function _post(paramName,data,mooAjax){
    var dataPost = {type:paramName};
    dataPost[paramName] = data;
    mooAjax.post({
        url: window.mooConfig.url.base + '/storages/aws.json',
        data: dataPost
    }, function (respsonse) {
        //var json = $.parseJSON(respsonse);
        console.log(respsonse);
    });
}

function _putObjectToAws(){
    window.require(['jquery','mooAjax'],function($,mooAjax){
        var objects = _getMissingObjects();
            var keys = Object.keys(objects);
            if(keys.length > 0){
                for ( var i=0;i< keys.length;i++){
                    if(objects[keys[i]].length > 0 ){
                        _post(keys[i],objects[keys[i]],mooAjax);
                    }
                }
            }

    });

}
//module.exports = function mooChat() {}
module.exports = {
    init:function(uId){
        _putObjectToAws();
    }

}