<?php if($cuser && ($uid == $user['User']['id'] || $cuser['Role']['is_admin'])): ?>
	<?php $blockModel = MooCore::getInstance()->getModel("UserBlock"); ?>
	<li>
		<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/users/profile_user_blocks/<?php echo $user['User']['id']?>" rel="profile-content" href="#blocked_members" data-anchor="#blocked_members" autoload="false">
			<span class="horizontal-menu-icon material-icons hidden">block</span>
			<span class="horizontal-menu-text"><?php echo __('Blocked Members')?></span>
			<span class="badge_counter"><?php echo $blockModel->find('count',array('conditions'=>array('UserBlock.user_id'=>$user['User']['id'])));?></span>
		</a>
	</li>
<?php endif; ?>