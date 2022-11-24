<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooNotification"], function($,mooNotification) {
        mooNotification.initRemoveNotification();
        mooNotification.initMarkRead();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooNotification'), 'object' => array('$', 'mooNotification'))); ?>
mooNotification.initRemoveNotification();
mooNotification.initMarkRead();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>

<span class="arr-notify"></span>
<div class="notify_top">
    <a href="javascript:void(0);" class="clearAllNotifications"><?php echo __('Clear All Notifications'); ?></a>
    <a href="javascript:void(0);" class="markAllNotificationAsRead"><?php echo __('Mark All As Read'); ?></a>
</div>
<div class="clear"></div>
<ul class="initSlimScroll notification-group-list">
    <li class="notify_no_content"><?php echo __('No new notifications')?></li>
</ul>
<div class="more-notify">
    <a id="notifications" rel="home-content" href="<?php echo $this->request->base ?>/user_info/index/notifications">
        <?php echo __('View All Notifications')?>
    </a>
</div>