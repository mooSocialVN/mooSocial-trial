<?php 
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
$eventModel = MooCore::getInstance()->getModel('Event_Event');
$event = $eventModel->findById($activity['Activity']['parent_id']);
?>

<div class="activity_feed_message">
<?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1)); ?>
<?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <div class="activity_feed_content_text">
            <div class="activity_item">
                <div class="activity_left">
                    <a class="activity_img_thumb" href="<?php echo $event['Event']['moo_href']?>" >
                        <img class="activity-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '850'));?>"/>
                        <div class="activity-date"><?php echo $this->Time->event_format($event['Event']['from'])?></div>
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php echo $event['Event']['moo_href']?>"><?php echo $event['Event']['moo_title']?></a>
                    <div class="activity-item-list">
                        <div class="activity-list-idx">
                            <div class="activity-list-idx-l">
                                <?php echo __('Time')?>:
                            </div>
                            <div class="activity-list-idx-r">
                                <?php echo $this->Time->event_format($event['Event']['from'])?> <?php echo $event['Event']['from_time']?> - <?php echo $this->Time->event_format($event['Event']['to'])?> <?php echo $event['Event']['to_time']?>
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