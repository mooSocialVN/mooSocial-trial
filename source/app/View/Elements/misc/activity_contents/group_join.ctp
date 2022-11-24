<ul class="list5 activity_content">
<?php foreach ( $activity['Content'] as $group ): ?>
	<li><a href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>"><img src="<?php echo $this->Moo->getItemPicture($group['Group'], 'groups', true)?>" class="img_wrapper2 tip" style="width:25px;height:25px" title="<?php echo str_replace(array('<','>'), '', $group['Group']['name'])?>"></a></li>
<?php endforeach; ?>
</ul>