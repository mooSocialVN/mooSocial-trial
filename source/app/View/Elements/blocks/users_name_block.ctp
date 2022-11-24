<ul class="list3 friends">	
	<?php foreach ($users as $u): ?>
	<li><?php echo $this->Moo->getItemPhoto(array('User' => $u['User']),array('prefix' => '100_square'), array('class' => 'img_wrapper2 user_avatar_large'))?><br><?php echo $this->Moo->getName($u['User'], false)?></li>
	</li>
	<?php endforeach; ?>
</ul>