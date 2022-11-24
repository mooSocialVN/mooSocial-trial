<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initRespondRequest();
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooUser'),'object'=>array('$','mooUser'))); ?>
    mooUser.initRespondRequest();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if (!empty($user)): ?>
<div class="user-list-item">
    <div class="user-item-warp">
        <div class="user-item-main">
            <div class="user-item-figure">
                <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square', 'class' => 'user-item-picture'))?>
            </div>
            <div class="user-item-info">
                <div class="user-item-holder">
                    <div class="user-item-name">
                        <?php echo $this->Moo->getName($user['User']) ?>
                    </div>
                    <div class="user-item-date">
                        <?php echo __n('%s friend', '%s friends', $user['User']['friend_count'], $user['User']['friend_count']) ?> . <?php echo __n('%s photo', '%s photos', $user['User']['photo_count'], $user['User']['photo_count']) ?>
                    </div>
                </div>
                <div class="user-item-action">
                    <?php if (!empty($uid)): ?>
                        <?php if ( $this->MooPeople->sentFriendRequest($user['User']['id'])): ?>
                            <a class="btn btn-primary btn-xs btn-cs btn-user-act add_people" href="<?php echo $this->request->base?>/friends/ajax_cancel/<?php echo $user['User']['id']?>" id="cancelFriend_<?php echo $user['User']['id']?>" title="<?php __('Cancel a friend request');?>">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                    <span class="btn-text"><?php echo __('Cancel Request')?></span>
                                </span>
                            </a>
                        <?php elseif ($this->MooPeople->respondFriendRequest($user['User']['id'])): ?>
                            <?php
                            if(empty($request_id)) {
                                $friendRequestModel = MooCore::getInstance()->getModel('FriendRequest');
                                $respond = $friendRequestModel->getRequests($uid);
                                $request_id = Hash::combine($respond, '{n}.FriendRequest.sender_id', '{n}.FriendRequest.id');
                            }
                            ?>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-xs btn-cs btn-user-act add_people" href="#" id="respond" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" title="<?php __('Respond to Friend Request');?>">
                                    <span class="btn-cs-main">
                                        <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                                        <span class="btn-text"><?php echo __('Respond')?></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="respond">
                                    <li><a data-id="<?php echo  $request_id[$user['User']['id']]; ?>" data-status="1" class="respondRequest" href="javascript:void(0)"><?php echo  __('Accept'); ?></a></li>
                                    <li><a data-id="<?php echo  $request_id[$user['User']['id']]; ?>" data-status="0" class="respondRequest" href="javascript:void(0)"><?php echo  __('Delete'); ?></a></li>
                                </ul>
                            </div>

                        <?php elseif ($this->MooPeople->isFriend($user['User']['id'])): ?>
                            <?php
                            $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array("controller" => "friends",
                                    "action" => "ajax_remove",
                                    "plugin" => false,
                                    $user['User']['id']
                                )),
                                'title' => __('Remove'),
                                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span><span class="btn-text">'.__('Remove').'</span></span>',
                                'id' => 'removeFriend_'.$user['User']['id'],
                                'class' => 'btn btn-primary btn-xs btn-cs btn-user-act add_people'
                            ));
                            ?>
                        <?php elseif($user['User']['id'] != $uid): ?>
                            <?php
                            $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array("controller" => "friends",
                                    "action" => "ajax_add",
                                    "plugin" => false,
                                    $user['User']['id']
                                )),
                                'title' => sprintf( __('Send %s a friend request'), $user['User']['name'] ),
                                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span><span class="btn-text">'.__('Add').'</span></span>',
                                'id' => 'addFriend_'. $user['User']['id'],
                                'class' => 'btn btn-primary btn-xs btn-cs btn-user-act add_people'
                            ));
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>