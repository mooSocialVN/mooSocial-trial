<?php
	$ids = explode(',',$activity['Activity']['items']);
	$userModel = MooCore::getInstance()->getModel('User');	
	$users = $userModel->find( 'all', array( 'conditions' => array( 'User.id' => $ids ), 'limit'=>10
													 ) ); 
	$userModel->cacheQueries = false;
?>
<div class="activity_content activity_friend_add">
    <div class="user-scroll-box">
        <div class="user-lists grid-view">
            <?php foreach ( $users as $u ): ?>
                <?php echo $this->element('user/item', array('user' => $u)); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>