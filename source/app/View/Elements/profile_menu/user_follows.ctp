<?php if (Configure::read("core.enable_follow") && $user['User']['id'] == $uid): ?>
	<?php
	$followModel = MooCore::getInstance()->getModel("UserFollow");
	?>
	<li>
		<a id="profile_follow" class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/follows/user_follows" rel="profile-content" href="#following" data-anchor="#following" autoload="false">
			<span class="horizontal-menu-icon material-icons follow_icon hidden">group</span>
			<span class="horizontal-menu-text"><?php echo __('Following')?></span>
			<span class="badge_counter"><?php echo $followModel->find('count',array('conditions'=>array('UserFollow.user_id'=>$uid)));?></span>
		</a>
	</li>
<?php endif; ?>