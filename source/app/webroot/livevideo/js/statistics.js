var interval;
export function destroy_cron() {
    clearInterval(interval);
}

export function init_cron_statistics(uri,callback,jwt) {
    interval = setInterval(function () {

        $.ajax({
            dataType: "json",
            url: uri,
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Content-Type","application/json");
                xhr.setRequestHeader ("Authorization",jwt);
            }
        }).done(function( data ) {
                callback(data)
            });
        /*
        $.getJSON( uri, function( data ) {
            callback(data)
        });*/
    },1000);
}

