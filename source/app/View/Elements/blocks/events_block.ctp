<?php 
if (!empty($events)): 
?>
<ul class="list6">
<?php foreach ($events as $event): ?>
	<li><a href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>"><img src="<?php echo $this->Moo->getItemPicture($event['Event'], 'events', true)?>" class="img_wrapper2" style="width:40px"></a>
		<div style="margin-left: 50px;">
			<a href="<?php echo $this->request->base?>/events/view/<?php echo $event['Event']['id']?>/<?php echo seoUrl($event['Event']['title'])?>"><?php echo h($this->Text->truncate($event['Event']['title'], 40, array('exact' => false)))?></a><br />
			<span class="date"><?php echo __('%s attending', $event['Event']['event_rsvp_count'])?></span>
		</div>
	</li>
<?php endforeach; ?>
</ul>
<?php 
else:
	echo __('Nothing found');
endif; 
?>