<?php if ( !empty($activity['Content']['Video']) ): ?>
<div class="activity_item">
	<div id="video_teaser_<?php echo $activity['Activity']['id']?>">
		<a href="javascript:void(0)" onclick="showFeedVideo('<?php echo $activity['Content']['Video']['source']?>', '<?php echo $activity['Content']['Video']['source_id']?>', <?php echo $activity['Activity']['id']?>)" class="vid_thumb" style="background-image:url(<?php echo $activity['Content']['Video']['thumb']?>)"></a>
		<a href="javascript:void(0)" onclick="showFeedVideo('<?php echo $activity['Content']['Video']['source']?>', '<?php echo $activity['Content']['Video']['source_id']?>', <?php echo $activity['Activity']['id']?>)"><b><?php echo h($activity['Content']['Video']['title'])?></b></a><br />
		<div class="date comment_message">
			<?php echo h($this->Text->truncate($activity['Content']['Video']['description'], 200, array('exact' => false)))?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if ( !empty($activity['Content']['Photo']) ): ?>
<div class="comment_message">
	<?php echo $this->Moo->formatText( $activity['Activity']['content'] )?>
</div>
<div class="activity_item">
    <a href="<?php echo $this->request->base?>/photos/view/<?php echo $activity['Content']['Photo']['id']?>#content"><img src="<?php echo $this->request->webroot?><?php echo $activity['Content']['Photo']['thumb']?>" class="wall_photo"></a>
</div>
<?php endif; ?>