<?php if($this->request->is('ajax')): ?><script type="text/javascript">require(["jquery","mooNotification"], function($,mooNotification) {<?php else: ?><?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooNotification'), 'object' => array('$', 'mooNotification'))); ?><?php endif;?>
    mooNotification.initRemoveNotification();
    mooNotification.initMarkRead();
    <?php if (!empty($cuser['notification_count'])): ?>
    $.ajax({url: mooConfig.url.base + "/notifications/mark_all_read", success: function(result){
        }});
    <?php endif;?>
    mooNotification.friendAdd();
<?php if($this->request->is('ajax')): ?>});</script><?php else: ?><?php $this->Html->scriptEnd(); ?><?php endif;?>

<span class="arr-notify"></span>
<div class="notify_top">
    <a href="javascript:void(0);" class="clearAllNotifications"><?php echo __('Clear All Notifications'); ?></a>
    <a href="javascript:void(0);" class="markAllNotificationAsRead"><?php echo __('Mark All As Read'); ?></a>
</div>
<div class="clear"></div>
<ul class="initSlimScroll notification-group-list">
    <?php if (empty($notifications)): ?>
        <li class="notify_no_content"><?php echo __('No new notifications')?></li>
    <?php else: ?>
        <?php foreach($notifications as $noti):
            $notificationActor = $this->getEventManager()->dispatch(new CakeEvent('View.Notifications.renderNotificationActor', $this, array('notification' => $noti)));
        ?>
            <li id="noti_dropdown_<?php echo $noti['Notification']['id']?>" class="notification-group-item notification_item" rel="<?php echo $noti['Notification']['id']?>">
                <div class="notification-group-main notification_item_status <?php echo $noti['Notification']['read'] ? '' : 'unread'?>">
                    <a href="<?php echo $this->request->base ?>/notifications/ajax_view/<?php echo $noti['Notification']['id']?>">
                        <?php if (!empty($notificationActor->result['image'])): ?>
                            <?php echo $notificationActor->result['image'];?>
                        <?php elseif (!empty($noti['Sender']['id'])): ?>
                            <?php echo $this->Moo->getImage(array('User' => $noti['Sender']), array('alt'=>h($noti['Sender']['name']),'class'=> "notification-avatar user_avatar", 'prefix' => '50_square'))?>
                        <?php else: ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Notification.renderThumb', $this, array('noti' => $noti))); ?>
                        <?php endif; ?>
                    </a>
                    <div class="notification_content">
                        <a href="<?php echo $this->request->base ?>/notifications/ajax_view/<?php echo $noti['Notification']['id']?>">
                            <div class="notification-subject">
                                <span class="noti-subject-name">
                                    <?php
                                        if (!empty($notificationActor->result['name'])) {
                                            echo $notificationActor->result['name'];
                                        }
                                        else {
                                            echo $noti['Sender']['name'];
                                        }
                                    ?>
                                </span>
                                <span><?php echo $this->element('misc/notification_texts', array('noti' => $noti))?></span>
                            </div>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.notification.render', $this,array('noti' => $noti) )); ?>
                            <div class="notification-date"><?php echo $this->Moo->getTime($noti['Notification']['created'], Configure::read('core.date_format'), $utz)?></div>
                        </a>
                        <?php if(!empty($noti['Notification']['action']) && $noti['Notification']['action'] == 'friend_add'): ?>
                            <div class="request-friend">
								<div class="notification-message"><?php echo nl2br(h($noti['Notification']['params'])); ?></div>
                                <button class="btn btn-primary btn-xs reponse_request" data-id="<?php echo $noti['Notification']['id'] ?>" data-status="1"><?php echo __('Accept') ?></button>
                                <button class="btn btn-primary btn-xs reponse_request" data-id="<?php echo $noti['Notification']['id'] ?>" data-status="0"><?php echo __('Decline') ?></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="noti_option">
                    <a href="javascript:void(0)" data-id="<?php echo $noti['Notification']['id']?>" class="removeNotification p_0 delete-icon">
                        <span class="noti_option-icon material-icons moo-icon moo-icon-clear">clear</span>
                    </a>
                    <a style="<?php if ($noti['Notification']['read']) echo 'display:none;' ?>" href="javascript:void(0)" data-status="1" data-id="<?php echo $noti['Notification']['id']?>" class="markMsgStatus mark_read tip mark_section" title="<?php echo __( 'Mark as Read')?>">
                        <span class="noti_option-icon material-icons moo-icon moo-icon-check_circle">check_circle</span>
                    </a>
                    <a style="<?php if (!$noti['Notification']['read']) echo 'display:none;' ?>" href="javascript:void(0)" data-status="0" data-id="<?php echo $noti['Notification']['id']?>" class="markMsgStatus tip mark_section mark_unread" title="<?php echo __( 'Mark as unRead')?>">
                        <span class="noti_option-icon material-icons moo-icon moo-icon-check_circle">check_circle</span>
                    </a>
                </div>
                
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<div class="more-notify">
    <a id="notifications" rel="home-content" href="<?php echo $this->request->base ?>/user_info/index/notifications">
        <?php echo __('View All Notifications')?>
    </a>
</div>