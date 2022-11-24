<?php if ( !empty($event) && !empty( $event['Event']['address'] ) ): ?>
    <!-- MAPS -->
    <style>
        #mapmodals label { width: auto!important; display:inline!important; }
        #mapmodals img { max-width: none!important; }
        #map-canvas {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #map-canvas {
            width:100%;
            height: 300px;
        }
    </style>

    <div class="title-modal">
        <?php echo __('Map View'); ?>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>

    </div>
    <div class="modal-body">
        <?php echo  $this->MooGMap->loadGoogleMap($event['Event']['address'],530,300); ?>
        <?php $google_link = 'http://maps.google.com/?q='. $event['Event']['address'] ; ?>
        <a class="google_map_view" target="_blank" href="<?php echo $google_link ?>"><?php echo __('View on google map') ?></a>
    </div>

    <?php if($this->request->is('ajax')): ?>
        <script>
    <?php else: ?>
        <?php $this->Html->scriptStart(array('inline' => false)); ?>
    <?php endif; ?>
        function initialize() {
            var mapOptions = {
                center: myLatlng,
                zoom: 16,
                mapTypeControl: false,
                center:myLatlng,
                panControl:false,
                rotateControl:false,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
                map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);
            var contentString = '<div id="mapInfo">'+
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title:""
            //maxWidth: 200,
            //maxHeight: 200
            });


            google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
            });

            //start of modal google map
            //$('#mapmodals').on('shown.bs.modal', function () {
            google.maps.event.trigger(map, "resize");
            map.setCenter(myLatlng);
            //});
        }

        //google.maps.event.addDomListener(window, 'load', initialize);
        //initialize();
        google.maps.event.addDomListener(window, "resize", function() {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });


    //end of modal google map
    <?php if($this->request->is('ajax')): ?>
        </script>
    <?php else: ?>
        <?php $this->Html->scriptEnd(); ?>
    <?php endif; ?>
<?php endif; ?>