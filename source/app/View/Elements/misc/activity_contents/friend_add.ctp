<?php
$activity['Content'] = array_slice($activity['Content'], 0, 10);
 $tip = 'tip';
                if (Configure::read('core.profile_popup')){
                    $tip = '';
                }
?>

<ul class="list5 activity_content">
<?php foreach ( $activity['Content'] as $u ): ?>
	<li><?php echo $this->Moo->getItemPhoto(array('User' => $u['User']), array('prefix' => '50_square'),array('class' => "user_avatar_small $tip"))?></li>
<?php endforeach; ?>
</ul>