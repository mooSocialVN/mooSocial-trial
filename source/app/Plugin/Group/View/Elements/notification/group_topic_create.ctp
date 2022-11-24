<?php
$group = MooCore::getInstance()->getItemByType('Group_Group', $notification['Notification']['params']);
?>
<?php echo __('posted a topic into group') ?> <?php echo $group['Group']['moo_title']; ?>
