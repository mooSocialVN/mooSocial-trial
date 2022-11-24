<?php if (Configure::read("core.enable_follow")): ?>
	<?php
	$followModel = MooCore::getInstance()->getModel("UserFollow");
	?>
	<li>
		<a id="profile_follower" class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/follows/user_followers/<?php echo $user['User']['id'];?>" rel="profile-content" href="#followers" data-anchor="#followers" autoload="false">
			<span class="horizontal-menu-icon material-icons follow_icon hidden">group</span>
			<span class="horizontal-menu-text"><?php echo __('Followers')?></span>
			<span class="badge_counter"><?php echo $followModel->find('count',array('conditions'=>array('UserFollow.user_follow_id'=>$user['User']['id'])));?></span>
		</a>
	</li>
<?php endif;?>