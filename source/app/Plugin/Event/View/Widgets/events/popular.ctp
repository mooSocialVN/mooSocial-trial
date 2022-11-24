<?php
if(Configure::read('Event.event_enabled') == 1):
    if(empty($title)) $title = "Popular Events";
    if(empty($num_item_show)) $num_item_show = 10;
    if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
    $eventHelper = MooCore::getInstance()->getHelper('Event_Event');
    $popular_events = $popularEventWidget;
    ?>
    <?php if (!empty($popular_events)): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __( $title)?></h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content box_popular_event box-region-<?php echo $region ?>">
            <?php
            if (!empty($popular_events)):
                ?>
                <div class="core-lists event-popular-lists list-view">
                    <?php foreach ($popular_events as $event): ?>
                        <div class="core-list-item">
                            <div class="core-item-warp">
                                <div class="core-item-figure">
                                    <a class="core-item-thumb" href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>">
                                        <img class="core-item-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '75_square'));?>" />
                                    </a>
                                </div>
                                <div class="core-item-info">
                                    <div class="core-item-head">
                                        <a class="core-item-title" href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>"><?php echo $event['Event']['title']?></a>
                                    </div>
                                    <div class="core-item-like_count">
                                        <span class="item-count"><?php echo __( '%s attending', $event['Event']['event_rsvp_count'])?></span>
                                    </div>
                                    <div class="core-item-date">
                                        <?php echo $this->Time->event_format($event['Event']['from'])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php
            else:
                echo __( 'Nothing found');
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>