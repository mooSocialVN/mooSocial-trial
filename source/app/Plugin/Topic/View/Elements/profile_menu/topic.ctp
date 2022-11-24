<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/topics/profile_user_topic/<?php echo $user['User']['id']?>" rel="profile-content" href="#topics" data-anchor="#topics" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">comment</span>
		<span class="horizontal-menu-text"><?php echo __('Topics')?></span>
		<span class="badge_counter"><?php echo $user['User']['topic_count']?></span>
	</a>
</li>