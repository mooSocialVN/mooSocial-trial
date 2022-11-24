<?php if ( $activity['Activity']['item_type'] == APP_PHOTO ): ?>
<div class="activity_item">
    <a href="<?php echo $this->request->base?>/photos/view/<?php echo $activity['Activity']['item_id']?>"><img src="<?php echo $this->request->webroot . $activity['Content']['Photo']['thumb']?>" class="img_wrapper2" style="margin-right:10px;width:200px;"></a>
</div>
<?php else: ?>
<div class="comment_message"></div>
<?php endif; ?>