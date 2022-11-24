<div class="activity_feed_message">
<?php
	echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1));
?>
<?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
<?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_feed_post">
<?php if ($activity['Activity']['item_type']):?>
	<?php
		list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']); 
	?>
	<?php echo $this->element('activity/content/'.strtolower($name).'_post_feed', array('activity' => $activity,'object'=>$object, 'had_comment_message' => 1 ),array('plugin'=>$plugin));?>
<?php endif;?>
</div>