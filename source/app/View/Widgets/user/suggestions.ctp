<?php
if (!( empty($uid) && Configure::read('core.force_login') )):
    if (empty($num_item_show)){
        $num_item_show = 10;
    }
    if(isset($title_enable)&&($title_enable)=== ""){
        $title_enable = false; 
    }else {
        $title_enable = true;
    }

    if (!empty($friend_suggestions)) :
    ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo $title; ?></h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content suggestion_block box-region-<?php echo $region ?>">
            <div class="user-lists list-view">
            <?php foreach ($friend_suggestions as $friend): ?>
                <div class="user-list-item">
                    <div class="user-item-warp">
                        <div class="user-item-main">
                            <div class="user-item-figure">
                                <?php echo $this->Moo->getItemPhoto(array('User' => $friend['User']), array('prefix' => '200_square', 'class' => 'user-item-picture'), array('class' => 'user_avatar')) ?>
                            </div>
                            <div class="user-item-info">
                                <div class="user-item-holder">
                                    <div class="user-item-name">
                                        <?php echo  $this->Moo->getName($friend['User']) ?>
                                    </div>
                                    <div class="user-item-date">
                                        <?php echo  __n('%s mutual friend', '%s mutual friends', $friend[0]['count'], $friend[0]['count']) ?>
                                    </div>
                                </div>
                                <div class="user-item-action">
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_add", "plugin" => false, $friend['User']['id'])),
                                        'title' => sprintf(__('Send %s a friend request'), h($friend['User']['name'])),
                                        'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span><span class="btn-text">'.__('Add as friend').'</span></span>',
                                        'id' => 'addFriend_' .  $friend['User']['id'],
                                        'class' => 'btn btn-primary btn-xs btn-cs btn-user-act btn-user-suggest'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            
        </div>
    </div>
    <?php
endif;
endif;
?>