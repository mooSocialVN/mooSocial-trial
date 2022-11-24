<?php
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <?php
        $activityModel = MooCore::getInstance()->getModel('Activity');
        $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
        $event = MooCore::getInstance()->getItemByType($parentFeed['Activity']['item_type'], $parentFeed['Activity']['item_id']);
        ?>
        <div class="activity_feed_header">
            <div class="activity_feed_image">
                <?php echo $this->Moo->getItemPhoto(array('User' => $parentFeed['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
            </div>
            <div class="activity_feed_content">
                <div class="activity_content_head">
                    <div class="activity_author">
                        <?php echo $this->Moo->getName($parentFeed['User']) ?>
                        <?php echo __('created a new event'); ?>
                    </div>
                </div>
                <div class="feed_time">
                    <span class="feed_time-txt"><?php echo $this->Moo->getTime($parentFeed['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
                </div>
            </div>
        </div>
        <div class="activity_feed_content_text">
            <div class="activity_item">
                <div class="activity_left">
                    <a class="activity_img_thumb" href="<?php echo $event['Event']['moo_href'] ?>" >
                        <img class="activity-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '850')); ?>"/>
                        <div class="activity-date"><?php echo $this->Time->event_format($event['Event']['from']) ?></div>
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php echo $event['Event']['moo_href'] ?>"><?php echo $event['Event']['moo_title'] ?></a>
                    <div class="activity-item-list">
                        <div class="activity-list-idx">
                            <div class="activity-list-idx-l">
                                <?php echo __('Time') ?>:
                            </div>
                            <div class="activity-list-idx-r">
                                <?php echo $this->Time->event_format($event['Event']['from']) ?> <?php echo $event['Event']['from_time'] ?> - <?php echo $this->Time->event_format($event['Event']['to']) ?> <?php echo $event['Event']['to_time'] ?>
                            </div>
                        </div>
                        <div class="activity-list-idx">
                            <div class="activity-list-idx-l">
                                <?php echo __('Location') ?>:
                            </div>
                            <div class="activity-list-idx-r">
                                <?php echo h($event['Event']['location']) ?>
                            </div>
                        </div>
                        <div class="activity-list-idx">
                            <div class="activity-list-idx-l">
                                <?php echo __('Address') ?>:
                            </div>
                            <div class="activity-list-idx-r">
                                <?php echo h($event['Event']['address']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>