<?php 
	$block_users = array();
	if (!empty($uid))
	{
		$model = MooCore::getInstance()->getModel('UserBlock');
		$block_users = $model->getBlockedUsers($uid);
	}
?>
<div class="user-summary">
    <div class="user-summary-avatar">
        <?php echo $this->Moo->getItemPhoto(array('User' => $user),array('class' => 'user-summary-avatar-link', 'prefix' => '200_square'), array('class' => 'user_avatar ava_home'))?>
        <?php //echo $this->Moo->getImage(array('User' => $blog['User']), array("prefix" => "50_square", "alt"=>$blog['User']['name'], 'class' => 'user_avatar')); ?>
    </div>
    <div class="user-summary-info">
        <a class="user-summary-name" href="<?php echo $this->Moo->getProfileUrl( $user )?>">
            <?php echo $user['name']?>
        </a>
        <?php //echo $this->Moo->getName($user)?>
        <div class="user-summary-counter">
            <span class="item-count"><?php echo __n( '%s friend', '%s friends', $user['friend_count'], $user['friend_count'] )?></span> . <span class="item-count"><?php echo __n( '%s photo', '%s photos', $user['photo_count'], $user['photo_count'] )?></span>
        </div>
        <div class="user-summary-action">
            <?php if (!empty($remove)):?>
            <a href="javascript:void(0);" class="btn btn-primary btn-xs btn-cs user-summary-link btn-user-summary remove_user" data-id="<?php echo $user['id']?>">
                <span class="btn-cs-main">
                    <span class="btn-icon material-icons moo-icon moo-icon-person_remove">person_remove</span>
                    <span class="btn-text"><?php echo __('Remove');?></span>
                </span>
            </a>
            <?php endif;?>
        </div>
    </div>
</div>