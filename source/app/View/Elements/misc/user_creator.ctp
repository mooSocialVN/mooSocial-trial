<div class="user-summary">
    <div class="user-summary-avatar">
        <?php echo $this->Moo->getItemPhoto(array('User' => $user),array('class' => 'user-summary-avatar-link', 'prefix' => '200_square'), array('class' => 'user_avatar ava_home'))?>
        <?php //echo $this->Moo->getImage(array('User' => $blog['User']), array("prefix" => "50_square", "alt"=>$blog['User']['name'], 'class' => 'user_avatar')); ?>
    </div>
    <div class="user-summary-info">
        <?php echo $this->Moo->getUserName($user, 'user-summary-name')?>
        <div class="user-summary-counter">
            <span class="item-count"><?php echo __n( '%s friend', '%s friends', $user['friend_count'], $user['friend_count'] )?></span> . <span class="item-count"><?php echo __n( '%s photo', '%s photos', $user['photo_count'], $user['photo_count'] )?></span>
        </div>
    </div>
</div>