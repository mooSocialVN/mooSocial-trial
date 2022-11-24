<ul class="list5 activity_content">
<?php foreach ( $activity['Content'] as $event ): ?>
	<li><a href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>"><img src="<?php echo $this->Moo->getItemPicture($event['Event'], 'events', true)?>" class="img_wrapper2 tip" style="width:25px" title="<?php echo str_replace(array('<','>'), '', $event['Event']['title'])?>"></a></li>
<?php endforeach; ?>
</ul>