<?php 
$event = $object; 
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>
<div class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_content_text">
                <div class="activity_item activity_item_share_popup">
                    <div class="activity_left">
                        <a target="_blank" class="activity_img_thumb" href="<?php echo $event['Event']['moo_href']?>" >
                            <img class="activity-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '850'));?>"/>
                            <div class="activity-date"><?php echo $this->Time->event_format($event['Event']['from'])?></div>
                        </a>
                    </div>
                    <div class="activity_right">
                        <a class="activity_item_title" target="_blank" href="<?php echo $event['Event']['moo_href']?>"><?php echo $event['Event']['moo_title']?></a>
                        <div class="activity-item-list">
                            <div class="activity-list-idx">
                                <div class="activity-list-idx-l">
                                    <?php echo __('Time')?>:
                                </div>
                                <div class="activity-list-idx-r">
                                    <?php echo $this->Time->event_format($event['Event']['from'])?> <?php echo $event['Event']['from_time']?> - <?php echo $this->Time->format($event['Event']['to'], '%B %d, %Y', null, $utz)?> <?php echo $event['Event']['to_time']?>
                                </div>
                            </div>
                            <div class="activity-list-idx">
                                <div class="activity-list-idx-l">
                                    <?php echo __('Location')?>:
                                </div>
                                <div class="activity-list-idx-r">
                                    <?php echo h($event['Event']['location'])?>
                                </div>
                            </div>
                            <div class="activity-list-idx">
                                <div class="activity-list-idx-l">
                                    <?php echo __('Address')?>:
                                </div>
                                <div class="activity-list-idx-r">
                                    <?php echo h($event['Event']['address'])?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>