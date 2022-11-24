<?php
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooEvent', 'hideshare'), 'object' => array('$', 'mooEvent'))); ?>
mooEvent.initOnView();
$(".sharethis").hideshare({media: '<?php echo $eventHelper->getImage($event, array('prefix' => '300_square'));?>', linkedin: false});
<?php $this->Html->scriptEnd(); ?>

<?php //$this->setNotEmpty('west');?>
<?php //$this->start('west'); ?>
<?php //$this->end();?>

<!--Bengin center-->
<!--<div class=bar-content">-->
    <div class="box2 bar-content-warp">
        <a href="<?php echo $eventHelper->getImage($event, array('' => ''));?>" style="background-image:url('<?php echo $eventHelper->getImage($event, array('prefix' => '300_square'));?>')" class="event-detail-thumb">
            <div class="event_gradient_bg"></div>
        </a>
    </div>
    <div class="box2 box_view bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo $event['Event']['title'] ?></h1>
                <div class="box_action">
                    <div class="box-dropdown">
                        <div class="dropdown">
                            <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                                <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- New hook -->
                                <?php $this->getEventManager()->dispatch(new CakeEvent('events.view.renderMenuAction', $this,array('event'=>$event))); ?>
                                <!-- New hook -->
                                <?php
                                // invite only available for public event and owner
                                if ( ( !empty($uid) && $event['Event']['type'] == PRIVACY_PUBLIC ) || ( $uid == $event['User']['id'] ) ): ?>
                                    <li>
                                        <a class="inviteMore" href="javascript:void(0);" data-url="<?php echo $this->request->base?>/events/invite/<?php echo $event['Event']['id']?>" title="<?php echo __( 'Invite Friends to Attend')?>">
                                            <span class="dropdown-menu-icon material-icons moo-icon moo-icon-mail">mail</span> <span class="dropdown-menu-text"><?php echo __( 'Invite Friends')?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( $event['Event']['user_id'] == $uid || ( $uid && !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                <li>
                                    <a href="<?php echo $this->request->base?>/events/create/<?php echo $event['Event']['id']?>">
                                        <span class="dropdown-menu-icon material-icons moo-icon moo-icon-mode_edit">mode_edit</span> <span class="dropdown-menu-text"><?php echo __( 'Edit Event')?></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" data-id="<?php echo $event['Event']['id']?>" class="deleteEvent">
                                        <span class="dropdown-menu-icon material-icons moo-icon moo-icon-delete">delete</span> <span class="dropdown-menu-text"><?php echo __( 'Delete Event')?></span>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <li class="seperate"></li>

                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "reports",
                                            "action" => "ajax_create",
                                            "plugin" => false,
                                            'event_event',
                                            $event['Event']['id'],
                                        )),
                                        'title' => __( 'Report Event'),
                                        'innerHtml'=> __( 'Report Event'),
                                    ));
                                    ?>
                                </li>
                                <?php if ($event['Event']['type'] != PRIVACY_PRIVATE): ?>
                                <li>
                                    <a href="javascript:void(0);" share-url="<?php echo $this->Html->url(array(
                                        'plugin' => false,
                                        'controller' => 'share',
                                        'action' => 'ajax_share',
                                        'Event_Event',
                                        'id' => $event['Event']['id'],
                                        'type' => 'event_item_detail'
                                    ), true); ?>" class="shareFeedBtn"><?php echo __('Share'); ?></a>
                                </li>
                                <?php endif; ?>
								<?php if (!empty($my_rsvp)):?>
									<?php if (in_array($my_rsvp['EventRsvp']['rsvp'],array(RSVP_ATTENDING,RSVP_MAYBE))):?>
										<?php
											$settingModel = MooCore::getInstance()->getModel("Event.EventNotificationSetting");
											$checkStatus = $settingModel->getStatus($event['Event']['id'],$uid);
										?>
										<li><a href="<?php echo $this->request->base?>/events/stop_notification/<?php echo $event['Event']['id']?>"><?php if ($checkStatus) echo __( 'Turn Off Notification'); else echo __('Turn On Notification');?></a></li>
									<?php endif;?>
								<?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box_content">
            <div class="event_detail-wrap">
                <div class="core-list-info event-info">
                    <div class="core-list-info-item">
                        <div class="core-list-heading">
                            <?php echo __( 'Information')?>
                        </div>
                    </div>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __('Privacy') ?>:
                        </div>
                        <div class="core-list-info-r">
                            <?php if ($event['Event']['type'] == PRIVACY_PUBLIC): ?>
                                <?php echo __('Public')?>
                            <?php elseif ($event['Event']['type'] == PRIVACY_PRIVATE): ?>
                                <?php echo __('Private')?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Time')?>:
                        </div>
                        <div class="core-list-info-r">
                            <?php echo $this->Time->event_format($event['Event']['from'])?> <?php echo $event['Event']['from_time']?> -
                            <?php echo $this->Time->event_format($event['Event']['to'])?> <?php echo $event['Event']['to_time']?>
                            (<?php if (!empty($event['Event']['timezone'])) echo $this->Moo->getTimeZoneByKey($event['Event']['timezone']); else echo Configure::read('core.timezone');?>)
                        </div>
                    </div>
                    <!-- New hook -->
                    <?php $this->getEventManager()->dispatch(new CakeEvent('Plugin.View.Event.renderMoreInfo', $this, array('event' => $event, 'view_type' => 'event_view'))); ?>
                    <!-- New hook -->
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Location')?>:
                        </div>
                        <div class="core-list-info-r">
                            <?php echo h($event['Event']['location'])?>
                        </div>
                    </div>
                    <?php if ( !empty( $event['Event']['address'] ) ): ?>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Address')?>:
                        </div>
                        <div class="core-list-info-r">
                            <?php echo h($event['Event']['address'])?> (<a target="_blank" href="https://maps.google.com/maps?q=<?php echo urlencode($event['Event']['address'])?>"><?php echo __('View Map');?></a>)
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ( !empty( $event['Event']['category_id'] ) ): ?>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Category')?>:
                        </div>
                        <div class="core-list-info-r">
                            <a href="<?php echo $this->request->base?>/events/index/<?php echo $event['Event']['category_id']?>/<?php echo seoUrl($event['Category']['name'])?>"><?php echo $event['Category']['name']?></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Created by')?>:
                        </div>
                        <div class="core-list-info-r">
                            <?php echo $this->Moo->getName($event['User'], false)?>
                        </div>
                    </div>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __( 'Info')?>:
                        </div>
                        <div class="core-list-info-r">
                            <div class="post_content">
                                <div class="video-description truncate" data-more-text="<?php echo __( 'Show More')?>" data-less-text="<?php echo __( 'Show Less')?>">
                                    <?php echo $this->Moo->cleanHtml($this->Text->convert_clickable_links_for_hashtags( $event['Event']['description'] , Configure::read('Event.event_hashtag_enabled')))?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="core-info-rating">
                    <?php $this->Html->rating($event['Event']['id'],'events','Event'); ?>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->
<div class="bar-feed-warp">
     <?php $this->MooActivity->wall($eventActivities)?>

    <?php if ( !empty( $event['Event']['address'] ) ): ?>
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

    <section class="modal fade in" id="mapmodals">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="title-modal">
                    <?php echo __('Map View'); ?>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
                    
                </div>
                <div class="modal-body">
                    <?php echo  $this->MooGMap->loadGoogleMap($event['Event']['address'],530,300); ?>
                    <?php $google_link = 'http://maps.google.com/?q='. urlencode($event['Event']['address']) ; ?>
                    <a class="google_map_view" target="_blank" href="<?php echo $google_link ?>"><?php echo __('View on google map') ?></a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </section><!-- /.modal -->
    <?php $this->Html->scriptStart(array('inline' => false)); ?>

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
        title:"",
        //maxWidth: 200,
        //maxHeight: 200
        });


        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    //start of modal google map
    $('#mapmodals').on('shown.bs.modal', function () {
        google.maps.event.trigger(map, "resize");
        map.setCenter(myLatlng);
    });
    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    });
    //end of modal google map
    if( !$.trim( $('#menu-event').html() ).length ) {
        $('#menu-event').parent().addClass("hidden");
    }
    
    <?php $this->Html->scriptEnd(); ?>

    <?php endif; ?>
</div>