<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/groups/profile_user_group/<?php echo $user['User']['id']?>" rel="profile-content" href="#groups" data-anchor="#groups" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">group_work</span>
		<span class="horizontal-menu-text"><?php echo __('Groups')?></span>
		<span class="badge_counter"><?php echo $user['User']['group_count']?></span>
	</a>
</li>