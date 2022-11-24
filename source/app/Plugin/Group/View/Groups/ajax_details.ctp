<h3><?php echo __('Information'); ?></h3>
<ul class="list6 info">
	<li><label><?php echo __('Type:');?></label><?php if ($group['Group']['type'] == 1) echo 'Public (anyone can view and join)'; else echo 'Private (only group members can view)';?></li>
	<?php if ($group['Group']['type'] == 1 || (!empty($my_membership) && ($my_membership['GroupUser']['status'] == 1 || $my_membership['GroupUser']['status'] == 3))): ?>
	<li><label><?php echo __('Description:');?></label><div><?php echo $this->Moo->cleanHtml($this->Text->convert_clickable_links_for_hashtags( $group['Group']['description'] , Configure::read('Group.group_hashtag_enabled')))?></div></li>
	<?php endif; ?>
</ul>

<?php if (!empty($photos)): ?>
<h3><?php echo __('Photos');?></h3>
<ul class="list4 trip_photos">
<?php foreach ($photos as $photo): ?>
	<li><a href="/photos/view/<?php echo $photo['Photo']['id']?>"><img src="/<?php echo $photo['Photo']['thumb']?>"></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php 
if ( $group['Group']['type'] == 1 || 
	 (!empty($my_membership) && ($my_membership['GroupUser']['status'] == 1 || $my_membership['GroupUser']['status'] == 3))
   ):
?>
	<h3><?php echo __('Comments');?></h3>
	<?php
	if (!empty($my_membership) && ($my_membership['GroupUser']['status'] == 1 || $my_membership['GroupUser']['status'] == 3)) echo 			$this->element('comment_form', array('target_id' => $group['Group']['id'], 'type' => 'group', 'text' => 'Write a comment...', 'desc' => 1));
	?>

	<ul class="list6 comment_wrapper" id="list-content">
		<?php echo $this->element('activities', array('activities' => $activities)); ?>
	</ul>
<?php endif; ?>