<?php
    $tip = 'tip';
    if (Configure::read('core.profile_popup')){
        $tip = '';
    }
?>
<div class="box-user-list">
<?php foreach ($users as $user): ?>
    <div class="box-user-item">
        <div class="box-user-item-warp">
            <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square'), array('class' => "user_avatar $tip", 'title' => Configure::read('core.profile_popup')?'':$user['User']['name']))?>
        </div>
    </div>
<?php endforeach; ?>
</div>