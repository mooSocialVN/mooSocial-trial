<?php
$ids = explode(',',$activity['Activity']['items']);
$eventModel = MooCore::getInstance()->getModel('Event_Event');	
$events = $eventModel->find( 'all', array( 'conditions' => array( 'Event.id' => $ids ), 'limit' => 3));
$events_count = $eventModel->find( 'count', array( 'conditions' => array( 'Event.id' => $ids )));
$eventModel->cacheQueries = false;
$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>
<div class="activity_list_items">
<?php foreach ( $events as $event ): ?>
    <div class="activity_item">
        <div class="activity_left">
            <a class="activity_img_thumb" href="<?php echo $event['Event']['moo_href']?>">
                <img class="activity-img" src="<?php echo $eventHelper->getImage($event, array('prefix' => '850'))?>">
            </a>
        </div>
        <div class="activity_right">
            <a class="activity_item_title" href="<?php echo $event['Event']['moo_href']?>"><?php echo $event['Event']['moo_title']?></a>
            <div class="activity_item_text">
                <?php echo $this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $event['Event']['description'])), 200, array('exact' => false)); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php if ($events_count > 3): ?>
    <div class="activity_item_view-more">
        <?php
            $this->MooPopup->tag(array(
                'href'=>$this->Html->url(array("controller" => "events", "action" => "ajax_event_joined", "plugin" => 'event', 'activity_id:' . $activity['Activity']['id'])),
                'title' => __('View more events'),
                'innerHtml'=> __('View more events'),
            ));
        ?>
    </div>
<?php endif; ?>
</div>

