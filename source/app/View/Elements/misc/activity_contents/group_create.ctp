<div class="activity_item">
	<a href="<?php echo $this->request->base?>/groups/view/<?php echo $activity['Content']['Group']['id']?>/<?php echo seoUrl($activity['Content']['Group']['name'])?>"><img src="<?php echo $this->Moo->getItemPicture($activity['Content']['Group'], 'groups', true)?>" class="img_wrapper2 img_feed"></a>
	<a class="feed_title" href="<?php echo $this->request->base?>/groups/view/<?php echo $activity['Content']['Group']['id']?>/<?php echo seoUrl($activity['Content']['Group']['name'])?>"><b><?php echo h($activity['Content']['Group']['name'])?></b></a>
	<div class="date comment_message feed_detail_text">
		<?php echo h($this->Text->truncate($activity['Content']['Group']['description'], 125, array('exact' => false)))?>
	</div>
</div>