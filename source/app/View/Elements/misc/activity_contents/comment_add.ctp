<?php if ( $activity['Activity']['item_type'] == APP_PHOTO ): ?>
<div class="activity_item">
	<a href="<?php echo $this->request->base?>/photos/view/<?php echo $activity['Activity']['item_id']?>#content"><img src="<?php echo $this->request->webroot . $activity['Content']['Photo']['thumb']?>" class="img_wrapper2 wall_photo_comment"></a>
	<div class="date comment_message"><?php echo h($activity['Activity']['content'])?></div>
</div>
<?php else: ?>
<div class="summary date"><?php echo h($activity['Activity']['content'])?></div>
<?php endif; ?>