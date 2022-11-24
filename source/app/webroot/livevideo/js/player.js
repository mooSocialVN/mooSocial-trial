import {WebRTCAdaptor} from "./webrtc_adaptor.js"
import {getUrlParameter} from "./fetch.stream.js"
import {destroy_cron, init_cron_statistics} from "./statistics.js";

export class Player {
    constructor(initialValues) {


        //this.send = document.getElementById("send");
        //this.send.addEventListener("click", this.sendData.bind(this), false);

        this.token = getUrlParameter("token");
        this.rtmpForward = getUrlParameter("rtmpForward");
        this.webRTCAdaptor = null;
        this.streamId = null;
        this.path = null;

        this.pc_config = {
            'iceServers' : [ {
                'urls' : 'stun:stun1.l.google.com:19302'
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

        this.api = {start_stream:null,stop_stream:null,no_stream_exist:null,get_count:null};

        // Support native app
        this.initWebRTCAdaptorAuto = true;
        this.accessToken = null;

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

        // For user behavior
        this.stopByUser = false;
        if(this.initWebRTCAdaptorAuto){
            this.initActionButton();
            this.initWebRTCAdaptor();
        }

        console.log(this);
    }

    initActionButton(){
        this.start_play_button = document.getElementById("start_play_button");
        this.start_play_button.addEventListener("click", this.startPlaying.bind(this), false);
        this.stop_play_button = document.getElementById("stop_play_button");
        this.stop_play_button.addEventListener("click", this.stopPlaying.bind(this), false);
        this.options = document.getElementById("options");
        this.options.addEventListener("click", this.toggleOptions.bind(this), false);
    }
    toggleOptions() {
        $(".options").toggle();
    }

    sendData() {
        console.log("Disable senddata");
        try {
            var iceState = this.webRTCAdaptor.iceConnectionState(this.streamId);
            if (iceState != null && iceState != "failed" && iceState != "disconnected") {

                this.webRTCAdaptor.sendData(this.streamId, $("#dataTextbox").val());
                $("#dataMessagesTextarea").append("Sent: " + $("#dataTextbox").val() + "\r\n");
                $("#dataTextbox").val("");
            }
            else {
                alert("WebRTC playing is not active. Please click Start Playing first")
            }
        }
        catch (exception) {
            console.error(exception);
            alert("Message cannot be sent. Make sure you've enabled data channel and choose the correct player distribution on server web panel");
        }
    }

    startPlaying() {
        this.webRTCAdaptor.play(this.streamId, this.token);
        this.stopByUser = false;
    }

    stopPlaying() {
        this.webRTCAdaptor.stop(this.streamId);
        this.stopByUser = true;
    }


    callback_play_finished(){
        //leaved the stream
        console.log("play finished");
        if (!this.stopByUser){
            $('#live-video').hide();
            $('#options').hide();
            $('#player-action').hide();
            //$('#livevideoTitle .livevideo-title').html('');
            $('#message-end-video').show();
        }
        this.start_play_button.disabled = false;
        this.stop_play_button.disabled = true;
        $("#stats_panel").hide();
        this.stop_cron();
        // Reset stream resolutions in dropdown
        document.getElementById("dropdownMenuLive").innerHTML = '<li><a class="dropdown-item-live active" href="#">Automatic</a></li>';
    }

    callback_no_stream_exist(){
        //leaved the stream
        console.log("callback_no_stream_exist");
        $.post( this.api.no_stream_exist, { streamId: this.streamId })
            .done(function( data ) {
                console.log( "Data Loaded: " + data );
                location.reload();
            });
    }
    callback_statistics(data){
        //console.log("callback_statistics",data);
        if(data["totalWebRTCWatchersCount"] !== undefined){
            if (data["totalWebRTCWatchersCount"] !== -1){
                $('#view-count-number').text(data["totalWebRTCWatchersCount"]);
            }else{
                // Do nothing
            }
        }
    }

    start_cron(){
        var uri = this.api.get_count ;//+ '/' + this.streamId + '.json';
        if(this.accessToken != null){
            uri += '?access_token='+this.accessToken;
        }
        init_cron_statistics(uri,this.callback_statistics,this.jwt)
    }

    stop_cron(){
        destroy_cron()
    }
    startAnimation() {

        $("#bitrateInfo").fadeIn(800, function () {
            $("#bitrateInfo").fadeOut(800, function () {
                $("#bitrateInfo").html("Weak Network Connection");
            });
        });
    }

    initWebRTCAdaptor(){
        var me = this;
        let currentTotalBytesReceivedCount = -1;
        let counterCurrentTotalByteReceivedIsSame = 0;
        this.webRTCAdaptor = new WebRTCAdaptor({
            websocket_url : me.websocketURL,
            mediaConstraints : me.mediaConstraints,
            peerconnection_config : me.pc_config,
            sdp_constraints : me.sdpConstraints,
            remoteVideoId : "remoteVideo",
            isPlayMode : true,
            debug : true,
            candidateTypes: ["tcp", "udp"],
            callback : function(info, obj) {

                if (info == "initialized") {
                    console.log("initialized");
                    me.start_play_button.disabled = false;
                    me.stop_play_button.disabled = true;
                    me.startPlaying();
                } else if (info == "play_started") {
                    //joined the stream
                    console.log("play started");
                    me.start_play_button.disabled = true;
                    me.stop_play_button.disabled = false;
                    me.webRTCAdaptor.getStreamInfo(me.streamId);
                    me.webRTCAdaptor.enableStats(obj.streamId);
                    me.start_cron();
                    $('#view-count-container').show();
                } else if (info == "play_finished") {
                    me.callback_play_finished();

                } else if (info == "closed") {
                    //console.log("Connection closed");
                    if (typeof obj != "undefined") {
                        console.log("Connecton closed: "
                            + JSON.stringify(obj));
                    }
                } else if (info == "streamInformation") {

                    var streamResolutions = new Array();

                    obj["streamInfo"].forEach(function(entry) {
                        //It's needs to both of VP8 and H264. So it can be dublicate
                        if(!streamResolutions.includes(entry["streamHeight"])){
                            streamResolutions.push(entry["streamHeight"]);
                        }
                    });
                    // Sort stream resolutions for good UI :)
                    streamResolutions = streamResolutions.sort(function(a, b){return a-b});

                    // Add stream resolutions in dropdown menu
                    const dropdownMenu = document.querySelector('.dropdown-menu-live');

                    streamResolutions.forEach(streamResolution => {
                        dropdownMenu.innerHTML += '<li><a class="dropdown-item dropdown-item-live" href="#">'+streamResolution+'p</a></li>';
                    });

                    $('.dropdown-menu-live a').click(function(){
                        var dropdownSelectedItem = $(this).text();

                        if(dropdownSelectedItem == "Automatic"){
                            dropdownSelectedItem = 0;
                        }else{
                            dropdownSelectedItem = dropdownSelectedItem.replace('p', '');
                        }

                        // Remove p character in stream resolution


                        // Call set stream resolution
                        me.webRTCAdaptor.forceStreamQuality(me.streamId, Number(dropdownSelectedItem));
                        // Remove current active item
                        $('#dropdownMenuLive >li.active').removeClass("active");
                        // Add active in new item
                        $(this).parent().addClass("active");
                    });
                }
                else if (info == "ice_connection_state_changed") {
                    console.log("iceConnectionState Changed: ",JSON.stringify(obj));
                }
                else if (info == "updated_stats") {
                    //obj is the PeerStats which has fields
                    //averageIncomingBitrate - kbits/sec
                    //currentIncomingBitrate - kbits/sec
                    //packetsLost - total number of packet lost
                    //fractionLost - fraction of packet lost
                   // Android issue when finishing a live stream . It doesn't make a call "play_finished"
                    // similar to web version and ios . So we will detect it was being hang by check the
                    // totalBytesReceivedCount.
                    if(obj.totalBytesReceivedCount == currentTotalBytesReceivedCount){
                        counterCurrentTotalByteReceivedIsSame++
                    }else{
                        counterCurrentTotalByteReceivedIsSame = 0;
                    }
                    if(counterCurrentTotalByteReceivedIsSame > 5){
                        // Maybe android closed issue
                        me.callback_play_finished();
                        return
                    }
                    currentTotalBytesReceivedCount = obj.totalBytesReceivedCount;
                    $("#average_bit_rate").text(obj.averageIncomingBitrate);
                    if (obj.averageIncomingBitrate > 0)  {
                        $("#average_bit_rate_container").show();
                    }
                    else {
                        $("#average_bit_rate_container").hide();
                    }
                    $("#latest_bit_rate").text(obj.currentIncomingBitrate);
                    if (obj.currentIncomingBitrate > 0) {
                        $("#latest_bit_rate_container").show();
                    }
                    else {
                        $("#latest_bit_rate_container").hide();
                    }

                    var packetLost = parseInt(obj.videoPacketsLost) + parseInt(obj.audioPacketsLost);
                    $("#packet_lost_text").text(packetLost);
                    if (packetLost > -1) {
                        $("#packet_lost_container").show();
                    }
                    else {
                        $("#packet_lost_container").hide();
                    }

                    var jitterAverageDelay = ((parseFloat(obj.videoJitterAverageDelay) + parseFloat(obj.audioJitterAverageDelay)) / 2).toPrecision(3);
                    $("#jitter_text").text(jitterAverageDelay);
                    if (jitterAverageDelay > 0) {
                        $("#jitter_container").show();
                    }
                    else {
                        $("#jitter_container").hide();
                    }

                    $("#audio_level").text(obj.audioLevel.toPrecision(3));
                    if (obj.audioLevel > -1) {
                        $("#audio_level_container").show();
                    }
                    else {
                        $("#audio_level_container").hide();
                    }


                    $("#frame_width").text(obj.frameWidth);
                    $("#frame_height").text(obj.frameHeight);
                    if (obj.frameWidth > 0 && obj.frameHeight > 0) {
                        $("#incoming_resolution_container").show();
                    }
                    else {
                        $("#incoming_resolution_container").hide();
                    }
                    $("#frame_received").text(obj.framesReceived);
                    if (obj.framesReceived > -1) {
                        $("#frame_received_container").show();
                    }
                    else {
                        $("#frame_received_container").hide();
                    }

                    $("#frame_decoded").text(obj.framesDecoded);
                    if (obj.framesDecoded > -1) {
                        $("#frame_decoded_container").show();
                    }
                    else {
                        $("#frame_decoded_container").hide();
                    }
                    $("#frame_dropped").text(obj.framesDropped);
                    if (obj.framesDropped > -1) {
                        $("#frame_dropped_container").show();
                    }
                    else {
                        $("#frame_dropped_container").hide();
                    }

                    $("#stats_panel").show();



                    console.debug("Average incoming kbits/sec: " + obj.averageIncomingBitrate
                        + " Current incoming kbits/sec: " + obj.currentIncomingBitrate
                        + " video packetLost: " + obj.videoPacketsLost
                        + " audio packetLost: " + obj.audioPacketsLost
                        + " frame width: " + obj.frameWidth
                        + " frame height: " + obj.frameHeight
                        + " frame received: " + obj.framesReceived
                        + " frame decoded: " + obj.framesDecoded
                        + " frame dropped: " + obj.framesDropped
                        + " video jitter average delay: " + obj.videoJitterAverageDelay
                        + " audio jitter average delay: " + obj.audioJitterAverageDelay
                        + " audio level: " + obj.audioLevel);

                }
                else if (info == "data_received") {
                    console.log("Data received: " + obj.event.data + " type: " + obj.event.type + " for stream: " + obj.streamId);
                    $("#dataMessagesTextarea").append("Received: " + obj.event.data + "\r\n");
                }
                else if (info == "bitrateMeasurement") {

                    console.debug(obj);
                    return;
                    if(obj.audioBitrate+obj.videoBitrate > obj.targetBitrate) {
                        startAnimation();
                    }
                    $("#video_bit_rate").text(parseInt(obj.audioBitrate) + parseInt(obj.videoBitrate));
                }
                else {
                    console.log( info + " notification received");
                }
            },
            callbackError : function(error) {
                //some of the possible errors, NotFoundError, SecurityError,PermissionDeniedError

                console.log("error callback: " + JSON.stringify(error));
                console.log(JSON.stringify(error).includes("no_stream_exist") );
                if ( JSON.stringify(error).includes("no_stream_exist")){
                    //alert(JSON.stringify(error));
                    me.callback_no_stream_exist();
                }else{
                    //alert(JSON.stringify(error));
                }

            }
        });
    }
}
