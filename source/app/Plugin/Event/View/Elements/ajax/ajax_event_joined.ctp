<?php

$eventHelper = MooCore::getInstance()->getHelper('Event_Event');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __( 'Joined Events')?></div>
</div>

<div class="modal-body">
<ul class="activity_feed_content_text">
<?php foreach ( $events as $event ): ?>
    <div class="activity_list_items">
        <div class="activity_item">
            <div class="activity_left">
                <a class="activity_img_thumb" href="<?php echo $event['Event']['moo_href']?>">
                    <img src="<?php echo $eventHelper->getImage($event, array('prefix' => '850'))?>" class="activity-img" />
                </a>
            </div>
            <div class="activity_right">
                <a class="activity_item_title" href="<?php echo $event['Event']['moo_href']?>"><?php echo $event['Event']['moo_title']?></a>
                <div class="activity_item_text">
                    <?php echo h($this->Text->truncate($event['Event']['description'], 125, array('exact' => false)))?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</ul>
</div>
