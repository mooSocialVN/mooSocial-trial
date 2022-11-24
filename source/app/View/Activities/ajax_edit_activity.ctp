<div class="comment_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
    <?php
    if (!empty($activity['UserTagging']['users_taggings']))
        $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']);
    ?>
    <script>
		$('#history_activity_<?php echo $activity['Activity']['id']?>').html('<?php echo addslashes(__('Edited')).(isset($other_user) ? ' '.addslashes(__('by')).' '.$other_user['name'] : '');?>');
	</script>
</div>