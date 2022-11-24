<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/photos/profile_user_photo/<?php echo $user['User']['id']?>" rel="profile-content" id="user_photos" href="#albums" data-anchor="#albums" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">collections</span>
		<span class="horizontal-menu-text"><?php echo __('Albums')?></span>
		<span class="badge_counter"><?php echo $albums_count?></span>
	</a>
</li>