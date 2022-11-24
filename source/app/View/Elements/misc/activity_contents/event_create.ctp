<div class="activity_item">
	<a href="<?php echo $this->request->base?>/events/view/<?php echo $activity['Content']['Event']['id']?>/<?php echo seoUrl($activity['Content']['Event']['title'])?>"><img src="<?php echo $this->Moo->getItemPicture($activity['Content']['Event'], 'events', true)?>" class="img_wrapper2 img_feed" ></a>
	<a href="<?php echo $this->request->base?>/events/view/<?php echo $activity['Content']['Event']['id']?>/<?php echo seoUrl($activity['Content']['Event']['title'])?>"><b><?php echo h($activity['Content']['Event']['title'])?></b></a><br />
	<div class="date comment_message">
		<?php echo $this->Time->event_format($activity['Content']['Event']['from'])?> <?php echo $activity['Content']['Event']['from_time']?> -
		<?php echo $this->Time->event_format($activity['Content']['Event']['to'])?> <?php echo $activity['Content']['Event']['to_time']?><br />
		<?php echo __('Location')?>: <?php echo h($activity['Content']['Event']['location'])?>
	</div>
</div>