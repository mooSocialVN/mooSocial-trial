import {WebRTCAdaptor} from "./webrtc_adaptor.js"
import {getUrlParameter} from "./fetch.stream.js"
import {init_cron_statistics,destroy_cron} from "./statistics.js"

export class Publishing {
    constructor(initialValues) {

        /**
         * If publishing stops for any reason, it tries to republish again.
         */
        this.autoRepublishEnabled = true;
        /**
         * Timer job that checks the WebRTC connection
         */
        this.autoRepublishIntervalJob = null;
        this.start_publish_button = document.getElementById("start_publish_button");
        this.start_publish_button.addEventListener("click", this.startPublishing.bind(this), false);
        this.stop_publish_button = document.getElementById("stop_publish_button");
        this.stop_publish_button.addEventListener("click", this.stopPublishing.bind(this), false);
        //this.options = document.getElementById("options");
        //this.options.addEventListener("click", this.toggleOptions.bind(this), false);
        //this.send = document.getElementById("send");
        //this.send.addEventListener("click", this.sendData.bind(this), false);

        this.token = getUrlParameter("token");
        this.rtmpForward = getUrlParameter("rtmpForward");
        this.webRTCAdaptor = null;
        this.streamId = null;
        this.path = null;
        this.jwt = null;
        this.isEnableStickerPlugin = 0;
        this.maxVideoBitrateKbps = 900;
        this.pc_config = {
            'iceServers' : [ {
                'urls' : 'stun:stun.l.google.com:19302'
            } ]
        };
        /*
    //sample turn configuration
    {
       iceServers: [
                    { urls: "",
                      username: "",
                      credential: "",
                    }
                   ]
    };
    */
        this.sdpConstraints = {
            OfferToReceiveAudio : false,
            OfferToReceiveVideo : false
        };

        this.mediaConstraints = {
            video : true,
            audio : true
        };

        this.api = {start_stream:null,stop_stream:null,get_comments:null,get_count:null};
        this.countdownX = null;
        this.length = 0;

        for (var key in initialValues) {
            if (initialValues.hasOwnProperty(key)) {
                this[key] = initialValues[key];
            }
        }

        if (location.protocol.startsWith("https")) {
            this.websocketURL =  "wss://" + initialValues.path;
        }else{
            this.websocketURL =  "ws://" + initialValues.path;
        }
        // For localhost
        this.websocketURL =  "wss://" + initialValues.path;
        this.webRTCAdaptor = null;


        this.initWebRTCAdaptor(false, this.autoRepublishEnabled);
        console.log(this);
    }

    init() {

    }

    startPublishing() {
        this.webRTCAdaptor.publish(this.streamId, this.token);
        this.start_publish_button.disabled = true;
        $(this.start_publish_button).text("Starting...");
    }

    stopPublishing() {
        $(this.stop_publish_button).hide();
        $('#live-video').hide();
        //$('#options').hide();
        $('#livevideoOption').hide();
        $('#title-countdown-container').hide();

        $('#message-end-video').show();
        if (this.autoRepublishIntervalJob != null) {
            clearInterval(this.autoRepublishIntervalJob);
            this.autoRepublishIntervalJob = null;
        }
        this.sendData('stop-stream');
        var me = this;
        setTimeout(function(){
            me.webRTCAdaptor.stop(me.streamId);
            me.webRTCAdaptor.closeStream();
        },500);

    }



    toggleOptions() {
        $(".options").toggle();
    }

    sendData(msg) {
        console.log("Disable sendData");
        return ;
        try {
            var iceState = this.webRTCAdaptor.iceConnectionState(this.streamId);
            if (iceState != null && iceState != "failed" && iceState != "disconnected") {

                this.webRTCAdaptor.sendData(this.streamId, msg);
            }
            else {
                alert("WebRTC publishing is not active. Please click Go Live! first")
            }
        }
        catch (exception) {
            console.error(exception);
            alert("Message cannot be sent. Make sure you've enabled data channel on server web panel");
        }
    }

    switchVideoMode(chbx) {
        if(chbx.value == "screen") {
            //webRTCAdaptor.switchDesktopWithMicAudio(streamId);
            this.webRTCAdaptor.switchDesktopCapture(this.streamId);
        }
        else if(chbx.value == "screen+camera"){
            this.webRTCAdaptor.switchDesktopCaptureWithCamera(this.streamId);
        }
        else {
            this.webRTCAdaptor.switchVideoCameraCapture(this.streamId, chbx.value);
        }
    }
    switchAudioMode(chbx) {
        this.webRTCAdaptor.switchAudioInputSource(this.streamId, chbx.value);
    }

    getCameraRadioButton(deviceName, deviceId) {
        return "<div class=\"form-check form-check-inline\">" +
            "<input class=\"form-check-input video-source\" name=\"videoSource\" type=\"radio\" value=\"" + deviceId + "\" id=\"" + deviceId + "\">" +
            "<label class=\"form-check-label font-weight-light\" for=\"" + deviceId + "\" style=\"font-weight:normal\">" +
            deviceName +
            "</label>" +
            "</div>";
    }

    getAudioRadioButton(deviceName, deviceId) {
        return "<div class=\"form-check form-check-inline\">" +
            "<input class=\"form-check-input audio-source\" name=\"audioSource\" type=\"radio\" value=\"" + deviceId + "\" id=\"" + deviceId + "\">" +
            "<label class=\"form-check-label font-weight-light\" for=\"" + deviceId + "\" style=\"font-weight:normal\">" +
            deviceName +
            "</label>" +
            "</div>";
    }

    checkAndRepublishIfRequired() {
        var iceState = this.webRTCAdaptor.iceConnectionState(this.streamId);
        console.log("Ice state checked = " + iceState);

        if (iceState == null || iceState == "failed" || iceState == "disconnected"){
            this.webRTCAdaptor.stop(this.streamId);
            this.webRTCAdaptor.closePeerConnection(this.streamId);
            this.webRTCAdaptor.closeWebSocket();
            this.initWebRTCAdaptor(true, this.autoRepublishEnabled);
        }
    }

     startAnimation() {
        var me = this;
        $("#broadcastingInfo").fadeIn(800, function () {
            $("#broadcastingInfo").fadeOut(800, function () {
                var state = me.webRTCAdaptor.signallingState(me.streamId);
                if (state != null && state != "closed") {
                    var iceState = me.webRTCAdaptor.iceConnectionState(me.streamId);
                    if (iceState != null && iceState != "failed" && iceState != "disconnected") {
                        me.startAnimation();
                    }
                }
            });
        });
    }
    comments_init(){
        var me = this;
        require(["jquery","mooPhoto","mooPhotoTheater","mooComment"], function($,mooPhoto,mooPhotoTheater,mooComment) {$(document).ready(function(){
            mooComment.initReplyCommentItem();
            //$('#comments').css({"overflow": "scroll", "height": "400"});
            $('#comments').addClass('livevideo-comment-scroll');

            // Hacking for afterComment event
            function afterSubmitCommentCallbackSuccess(e, data) {
                setTimeout(function () {
                    $('#comments').scrollTop($('#comments')[0].scrollHeight);

                    // issue it call one so we rebind it again by initSticker()
                    if(me.isEnableStickerPlugin == 1 ){
                        $('body').on("afterSubmitCommentCallbackSuccess", afterSubmitCommentCallbackSuccess);
                    }

                }, 500);
            }

            $('body').on("afterSubmitCommentCallbackSuccess", afterSubmitCommentCallbackSuccess);

            function autoRefreshComment() {

                $.get(me.api.get_comments, function (data) {


                    var currentCount = $('#comment_count').text();
                    var nextCount = $(data).find("#comment_count").text();

                    if (currentCount != nextCount) {
                        $('#comment_count').text(nextCount);
                        $('#comments').html($(data).find("#comments").html());
                        //$('#comments').css({"overflow": "scroll", "height": "400"});
                        $('#comments').addClass('livevideo-comment-scroll');
                        setTimeout(function () {
                            $('#comments').scrollTop($('#comments')[0].scrollHeight);
                        }, 500);

                    }
                });
            }

            setInterval(autoRefreshComment, 8000);
        });});

    }
    callback_publish_started(obj){
        var me = this;
        $.post( this.api.start_stream, { streamId: this.streamId, title: $('#title-publishing').val(),privacy:$('#privacy').val() })
            .done(function( data ) {
                //alert( "Data Loaded: " + data );
                var json = $.parseJSON(data);

                $(me.start_publish_button).hide();
                //$('#title-publishing').hide();
                $('#livevideoFrmTitle').hide();
                $('#livevideoTitle').find('.livevideo-title').html($('#title-publishing').val());

                //$('#privacy').parent().parent().hide();
                $('#livevideoPrivacy').hide();

                if($('#title-publishing').val() != ''){
                    $('#title-h1-publishing').text($('#title-publishing').val());
                }
                $(me.stop_publish_button).show();
                me.stop_publish_button.disabled = false;
                me.startAnimation();
                me.api.get_comments += '/'+json['id'];
                $.get(me.api.get_comments,function (data) {
                    console.log(data)
                    //$('#action  .box_content').html(data);
                    $('#livevideoComment').html(data);
                    $('#player').removeClass('col-md-offset-2');
                    $('#action').removeClass('livevideo-hide-comment');
                    setTimeout(function () {
                        me.comments_init();
                    },500);
                });
                me.start_cron();
                $('#view-count-container').show();
                if(me.length > 0){
                    $('#title-countdown-container').show();
                    me.start_countdown(me.length,"title-countdown");
                }
            });

        if (this.autoRepublishEnabled && this.autoRepublishIntervalJob == null) {
            this.autoRepublishIntervalJob = setInterval(() => {
                me.checkAndRepublishIfRequired();
            }, 3000);
        }
        this.webRTCAdaptor.enableStats(obj.streamId);
    }

    callback_publish_finished(obj){
        $.post( this.api.stop_stream, { streamId: this.streamId, title: "" })
            .done(function( data ) {
                console.log( "Data Loaded: " + data );
            });
        console.log("publish finished");

        this.start_publish_button.disabled = false;
        this.stop_publish_button.disabled = true;
        $("#stats_panel").hide();
        $('#view-count-container').hide();
        this.stop_cron();
    }

    callback_statistics(data){
        console.log("callback_statistics",data);
        if(data["totalWebRTCWatchersCount"] !== undefined){
            if (data["totalWebRTCWatchersCount"] !== -1){
                $('#view-count-number').text(data["totalWebRTCWatchersCount"]);
            }else{
                // Do nothing
            }
        }
    }



    initWebRTCAdaptor(publishImmediately, autoRepublishEnabled) {
        var me = this;
        this.webRTCAdaptor = new WebRTCAdaptor({
            websocket_url: me.websocketURL,
            mediaConstraints: me.mediaConstraints,
            peerconnection_config: me.pc_config,
            sdp_constraints: me.sdpConstraints,
            localVideoId: "localVideo",
            debug: true,
            bandwidth: me.maxVideoBitrateKbps,
            callback: (info, obj) => {
                if (info == "initialized") {
                    console.log("initialized");
                    me.start_publish_button.disabled = false;
                    me.stop_publish_button.disabled = true;
                    if (publishImmediately) {
                        me.webRTCAdaptor.publish(me.streamId, me.token)
                    }

                } else if (info == "publish_started") {
                    //stream is being published
                    me.callback_publish_started(obj);
                    /*
                    console.log("publish started");
                    me.start_publish_button.disabled = true;
                    me.stop_publish_button.disabled = false;
                    me.startAnimation();
                    if (autoRepublishEnabled && me.autoRepublishIntervalJob == null) {
                        me.autoRepublishIntervalJob = setInterval(() => {
                            me.checkAndRepublishIfRequired();
                        }, 3000);
                    }
                    me.webRTCAdaptor.enableStats(obj.streamId);*/
                } else if (info == "publish_finished") {
                    //stream is being finished
                    me.callback_publish_finished(obj)
                } else if (info == "browser_screen_share_supported") {
                    $(".video-source").prop("disabled", false);
                    console.log("browser screen share supported");
                    browser_screen_share_doesnt_support.style.display = "none";
                } else if (info == "screen_share_stopped") {
                    //choose the first video source. It may not be correct for all cases.
                    $(".video-source").first().prop("checked", true);
                    console.log("screen share stopped");
                } else if (info == "closed") {
                    //console.log("Connection closed");
                    if (typeof obj != "undefined") {
                        console.log("Connecton closed: " + JSON.stringify(obj));
                        //alert("Connecton closed: " + JSON.stringify(obj));
                    }
                } else if (info == "pong") {
                    //ping/pong message are sent to and received from server to make the connection alive all the time
                    //It's especially useful when load balancer or firewalls close the websocket connection due to inactivity
                } else if (info == "refreshConnection") {
                    me.checkAndRepublishIfRequired();
                } else if (info == "ice_connection_state_changed") {
                    console.log("iceConnectionState Changed: ", JSON.stringify(obj));
                } else if (info == "updated_stats") {
                    //obj is the PeerStats which has fields
                    //averageOutgoingBitrate - kbits/sec
                    //currentOutgoingBitrate - kbits/sec
                    console.log("Average outgoing bitrate " + obj.averageOutgoingBitrate + " kbits/sec"
                        + " Current outgoing bitrate: " + obj.currentOutgoingBitrate + " kbits/sec"
                        + " video source width: " + obj.resWidth + " video source height: " + obj.resHeight
                        + "frame width: " + obj.frameWidth + " frame height: " + obj.frameHeight
                        + " video packetLost: " + obj.videoPacketsLost + " audio packetsLost: " + obj.audioPacketsLost
                        + " video RTT: " + obj.videoRoundTripTime + " audio RTT: " + obj.audioRoundTripTime
                        + " video jitter: " + obj.videoJitter + " audio jitter: " + obj.audioJitter);


                    $("#average_bit_rate").text(obj.averageOutgoingBitrate);
                    if (obj.averageOutgoingBitrate > 0) {
                        $("#average_bit_rate_container").show();
                    } else {
                        $("#average_bit_rate_container").hide();
                    }

                    $("#latest_bit_rate").text(obj.currentOutgoingBitrate);
                    if (obj.currentOutgoingBitrate > 0) {
                        $("#latest_bit_rate_container").show();
                    } else {
                        $("#latest_bit_rate_container").hide();
                    }
                    var packetLost = parseInt(obj.videoPacketsLost) + parseInt(obj.audioPacketsLost);

                    $("#packet_lost_text").text(packetLost);
                    if (packetLost > -1) {
                        $("#packet_lost_container").show();
                    } else {
                        $("#packet_lost_container").hide();
                    }
                    var jitter = ((parseFloat(obj.videoJitter) + parseInt(obj.audioJitter)) / 2).toPrecision(3);
                    $("#jitter_text").text(jitter);
                    if (jitter > 0) {
                        $("#jitter_container").show();
                    } else {
                        $("#jitter_container").hide();
                    }

                    var rtt = ((parseFloat(obj.videoRoundTripTime) + parseFloat(obj.audioRoundTripTime)) / 2).toPrecision(3);
                    $("#round_trip_time").text(rtt);
                    if (rtt > 0) {
                        $("#round_trip_time_container").show();
                    } else {
                        $("#round_trip_time_container").hide();
                    }

                    $("#source_width").text(obj.resWidth);
                    $("#source_height").text(obj.resHeight);
                    if (obj.resWidth > 0 && obj.resHeight > 0) {
                        $("#source_resolution_container").show();
                    } else {
                        $("#source_resolution_container").hide();
                    }

                    $("#ongoing_width").text(obj.frameWidth);
                    $("#ongoing_height").text(obj.frameHeight);
                    if (obj.frameWidth > 0 && obj.frameHeight > 0) {
                        $("#ongoing_resolution_container").show();
                    } else {
                        $("#ongoing_resolution_container").hide();
                    }

                    $("#on_going_fps").text(obj.currentFPS);
                    if (obj.currentFPS > 0) {
                        $("#on_going_fps_container").show();
                    } else {
                        $("#on_going_fps_container").hide();
                    }

                    $("#stats_panel").show();

                } else if (info == "data_received") {
                    console.log("Data received: " + obj.event.data + " type: " + obj.event.type + " for stream: " + obj.streamId);
                    $("#dataMessagesTextarea").append("Received: " + obj.event.data + "\r\n");
                } else if (info == "available_devices") {
                    var videoHtmlContent = "";
                    var audioHtmlContent = "";
                    obj.forEach(function (device) {
                        if (device.kind == "videoinput") {
                            videoHtmlContent += me.getCameraRadioButton(device.label, device.deviceId);
                        } else if (device.kind == "audioinput") {
                            audioHtmlContent += me.getAudioRadioButton(device.label, device.deviceId);
                        }
                    });
                    //$(videoHtmlContent).insertAfter(".video-source-legend");
                    $('#videoSourceOption').prepend(videoHtmlContent);
                    $(".video-source").first().prop("checked", true);

                    //$(audioHtmlContent).insertAfter(".audio-source-legend");
                    $('#audioSourceOption').prepend(audioHtmlContent);
                    $(".audio-source").first().prop("checked", true);

                    if (document.querySelector('input[name="videoSource"]')) {
                        document.querySelectorAll('input[name="videoSource"]').forEach((elem) => {
                            elem.addEventListener("change", function (event) {
                                var item = event.target;
                                me.switchVideoMode(item)
                            });
                        });
                    }
                    if (document.querySelector('input[name="audioSource"]')) {
                        document.querySelectorAll('input[name="audioSource"]').forEach((elem) => {
                            elem.addEventListener("change", function (event) {
                                var item = event.target;
                               me.switchAudioMode(item)
                            });
                        });
                    }
                } else {
                    console.log(info + " notification received");
                }
            },
            callbackError: function (error, message) {
                //some of the possible errors, NotFoundError, SecurityError,PermissionDeniedError

                console.log("error callback: " + JSON.stringify(error));
                var errorMessage = JSON.stringify(error);
                if (typeof message != "undefined") {
                    errorMessage = message;
                }
                var errorMessage = JSON.stringify(error);
                if (error.indexOf("NotFoundError") != -1) {
                    //errorMessage = "Camera or Mic are not found or not allowed in your device";
                    errorMessage = me.errorMessage.NotFoundError;
                } else if (error.indexOf("NotReadableError") != -1 || error.indexOf("TrackStartError") != -1) {
                   // errorMessage = "Camera or Mic is being used by some other process that does not let read the devices";
                    errorMessage = me.errorMessage.NotReadableError;
                } else if (error.indexOf("OverconstrainedError") != -1 || error.indexOf("ConstraintNotSatisfiedError") != -1) {
                    //errorMessage = "There is no device found that fits your video and audio constraints. You may change video and audio constraints"
                    errorMessage = me.errorMessage.OverconstrainedError;
                } else if (error.indexOf("NotAllowedError") != -1 || error.indexOf("PermissionDeniedError") != -1) {
                    //errorMessage = "You are not allowed to access camera and mic.";
                    errorMessage = me.errorMessage.NotAllowedError;
                    if(typeof window.warningMgs !== 'undefined'){
                        window.warningMgs( me.errorMessage.allowAccessToCamera,me.errorMessage.NotAllowedError,true);
                        return;
                    }
                } else if (error.indexOf("TypeError") != -1) {
                   // errorMessage = "Video/Audio is required";
                    errorMessage = me.errorMessage.TypeError;
                } else if (error.indexOf("ScreenSharePermissionDenied") != -1) {
                    //errorMessage = "You are not allowed to access screen share";
                    errorMessage = me.errorMessage.ScreenSharePermissionDenied;
                    $(".video-source").first().prop("checked", true);
                } else if (error.indexOf("WebSocketNotConnected") != -1) {
                    //errorMessage = "WebSocket Connection is disconnected.";
                    errorMessage = me.errorMessage.WebSocketNotConnected;
                }
                alert(errorMessage);
            }
        });
    }

    start_cron(){
        var uri = this.api.get_count ;//+ '/' + this.streamId + '.json';
        init_cron_statistics(uri,this.callback_statistics,this.jwt);
    }

    stop_cron(){
        destroy_cron()
    }

    start_countdown(seconds,elementName){
        var countDownDate = new Date();
        var me = this;
        countDownDate.setSeconds(countDownDate.getSeconds() + seconds);
        this.countdownX = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            var time = "";
            if (days > 0){
                time += days + "d ";
            }
            if (hours > 0){
                time += hours + "h ";
            }
            time += minutes + "m " + seconds + "s ";
            document.getElementById(elementName).innerHTML = time;
            console.log(distance);
            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(me.countdownX);
                document.getElementById(elementName).innerHTML = "EXPIRED";
                me.stopPublishing();
            }
        }, 1000);
    }
}
