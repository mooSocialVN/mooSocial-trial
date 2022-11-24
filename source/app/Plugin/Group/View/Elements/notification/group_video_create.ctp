<?php
$group = MooCore::getInstance()->getItemByType('Group_Group', $notification['Notification']['params']);
?>
<?php echo __('posted a video into group') ?> <?php echo $group['Group']['moo_title']; ?>
