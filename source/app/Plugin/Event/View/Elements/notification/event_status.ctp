<?php
    $event = MooCore::getInstance()->getItemByType('Event_Event', $notification['Notification']['params']);
?>
<?php echo __('posted a status into event') ?> <?php echo $event ? $event['Event']['moo_title'] : __('Deleted item'); ?>
