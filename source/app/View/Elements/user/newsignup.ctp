<?php
if(empty($title)) $title = "Recently Joined";
if(empty($num_item_show)) $num_item_show = 8;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
	
if (!Configure::read('core.remove_member_landing'))
{

$userModel = MooCore::getInstance()->getModel("User");
$new_users = $userModel->getLatestUsers( $num_item_show);
?>
<?php if ( !empty( $new_users ) ): ?>
<?php
	 $tip = 'avatar_tip';
	 if (Configure::read('core.profile_popup')){
		$tip = '';
	 } 
?>
<div class="new_recent_signup">
    <div class="box-user-list">
        <?php
        foreach ($new_users as $user): ?>
            <div class="box-user-item">
                <div class="box-user-item-warp">
                    <?php echo $this->Moo->getItemPhoto($user, array( 'prefix' => '100_square') ,array('class' => $tip.' user_avatar', 'original-title' => Configure::read('core.profile_popup')?'':$user['User']['name']));?>
                </div>
            </div>
        <?php
        endforeach; ?>
    </div>
</div>
<?php endif; 
}
?>