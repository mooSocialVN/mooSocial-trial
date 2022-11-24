<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooNotification"], function($,mooNotification) {
        mooNotification.initAjaxShow();
        mooNotification.initMarkRead();
		mooNotification.friendAdd();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooNotification'), 'object' => array('$', 'mooNotification'))); ?>
mooNotification.initAjaxShow();
mooNotification.initMarkRead();
mooNotification.friendAdd();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>

<?php
foreach ($notifications as $noti):
	?>
	<li id="noti_<?php echo $noti['Notification']['id']?>" class="notification-group-item notification_item" rel="<?php echo $noti['Notification']['id']?>">
		<div class="notification-group-main notification_item_status <?php if (!$noti['Notification']['read']) echo 'unread';?>">
			<a href="<?php echo $this->request->base?>/notifications/ajax_view/<?php echo $noti['Notification']['id']?>">
				<?php echo $this->Moo->getImage(array('User' => $noti['Sender']), array('prefix' => '50_square', 'class' => 'notification-avatar user_avatar', 'alt' => h($noti['Sender']['name'])))?>
			</a>
			<div class="notification_content">
				<a href="<?php echo $this->request->base?>/notifications/ajax_view/<?php echo $noti['Notification']['id']?>">
					<div class="notification-subject">
						<span class="noti-subject-name"><?php echo $noti['Sender']['name']?></span>
						<span><?php echo $this->element('misc/notification_texts', array( 'noti' => $noti )); ?></span>
					</div>
					<?php $this->getEventManager()->dispatch(new CakeEvent('element.notification.render', $this,array('noti' => $noti) )); ?>
					<span class="notification-date"><?php echo $this->Moo->getTime( $noti['Notification']['created'], Configure::read('core.date_format'), $utz )?></span>
				</a>
				<?php if(!empty($noti['Notification']['action']) && $noti['Notification']['action'] == 'friend_add'): ?>
					<div class="request-friend">
						<div class="notification-message"><?php echo nl2br(h($noti['Notification']['params'])) ?></div>
						<button class="btn btn-primary btn-xs reponse_request" data-id="<?php echo $noti['Notification']['id'] ?>" data-status="1"><?php echo __('Accept') ?></button>
						<button class="btn btn-primary btn-xs reponse_request" data-id="<?php echo $noti['Notification']['id'] ?>" data-status="0"><?php echo __('Decline') ?></button>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="noti_option">
			<a href="javascript:void(0)" data-id="<?php echo $noti['Notification']['id']?>" style="padding:0" class="removeNotification"><span class="material-icons moo-icon moo-icon-clear delete-icon">clear</span></a>

			<a style="<?php if ($noti['Notification']['read']) echo 'display:none;' ?>" href="javascript:void(0)" data-status="1" data-id="<?php echo $noti['Notification']['id']?>" class="markMsgStatus mark_read tip mark_section" title="<?php echo __( 'Mark as Read')?>">
				<span class="material-icons moo-icon moo-icon-check_circle">check_circle</span>
			</a>
			<a style="<?php if (!$noti['Notification']['read']) echo 'display:none;' ?>" href="javascript:void(0)" data-status="0" data-id="<?php echo $noti['Notification']['id']?>" class="markMsgStatus mark_unread tip mark_section mark_unread" title="<?php echo __( 'Mark as unRead')?>">
				<span class="material-icons moo-icon moo-icon-check_circle">check_circle</span>
			</a>
		</div>
	</li>
<?php
endforeach;
?>
	<?php if ($view_more): ?>
		<?php $this->Html->viewMore($view_more_url,'center #notifications_list') ?>
	<?php endif; ?>
