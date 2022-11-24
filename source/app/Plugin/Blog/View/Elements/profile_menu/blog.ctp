<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/blogs/profile_user_blog/<?php echo $user['User']['id']?>" rel="profile-content" href="#blogs" data-anchor="#blogs" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">library_books</span>
		<span class="horizontal-menu-text"><?php echo __('Blogs')?></span>
		<span class="badge_counter"><?php echo $user['User']['blog_count']?></span>
	</a>
</li>