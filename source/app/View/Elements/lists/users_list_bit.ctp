<?php
if (count($users) > 0)
{
	foreach ($users as $user):
        $eleId = '';
        if ( isset($type) && $type == 'home' ){
            $eleId = 'friend_'.$user['Friend']['friend_id'];
        }
        if ( isset($group) ){
            $eleId = 'member_'.$user['GroupUser']['id'];
        }
?>
	<div id="<?php echo $eleId; ?>" class="user-list-item">
        <div class="user-item-warp">
            <div class="user-item-main">
                <div class="user-item-figure">
                    <!--<a href="<?php //echo $this->request->base?>/<?php //echo (!empty( $user['User']['username'] )) ? '-' . $user['User']['username'] : 'users/view/'.$user['User']['id']?>"></a>-->
                    <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square', 'class' => 'user-item-picture'), array('class' => 'user-item-img'))?>
                </div>

                <div class="user-item-info">
                    <div class="user-item-holder">
                        <div class="user-item-name">
                            <?php echo $this->Moo->getName($user['User'])?>
                            <!--<?php //if ( $user['User']['featured'] ): ?><a class="user-item-name-act" href="javascript:void(0);"><span class="user-item-name-act-icon material-icons moo-icon moo-icon-stars">stars</span></a><?php //endif; ?>-->
                            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.userListItem.afterRenderUserName', $this, array('user' => $user))); ?>
                        </div>
                        <div class="user-item-date">
                            <span class="item-count"><?php echo __n( '%s friend', '%s friends', $user['User']['friend_count'], $user['User']['friend_count'] )?></span> . <span class="item-count"><?php echo __n( '%s photo', '%s photos', $user['User']['photo_count'], $user['User']['photo_count'] )?></span>
                        </div>
                        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.userListItem.afterRenderUserInfo', $this, array('user' => $user))); ?>
                    </div>
                    <div class="user-item-action">
                        <?php if ( isset($friends_request) && in_array($user['User']['id'], $friends_request) && $user['User']['id'] != $uid): ?>
                            <a class="btn btn-primary btn-xs btn-cs btn-user-act add_people" href="<?php echo $this->request->base?>/friends/ajax_cancel/<?php echo $user['User']['id']?>" id="cancelFriend_<?php echo $user['User']['id']?>" title="<?php echo __('Cancel a friend request');?>">
                            <span class="btn-cs-main">
                                <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                <span class="btn-text"><?php echo __('Cancel Request') ?></span>
                            </span>
                            </a>
                        <?php elseif ( !empty($respond) && in_array($user['User']['id'], $respond ) && $user['User']['id'] != $uid): ?>
                            <div class="dropdown">
                                <a class="btn btn-primary btn-xs btn-cs btn-user-act add_people" href="#" id="respond" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" title="<?php echo __('Respond to Friend Request');?>">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                                    <span class="btn-text"><?php echo __('Respond to Friend Request') ?></span>
                                </span>
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="respond">
                                    <li><a class="respondRequest" data-id="<?php echo $request_id[$user['User']['id']]; ?>" data-status="1" href="javascript:void(0)"><?php echo __('Accept'); ?></a></li>
                                    <li><a class="respondRequest" data-id="<?php echo $request_id[$user['User']['id']]; ?>" data-status="0" href="javascript:void(0)"><?php echo __('Delete'); ?></a></li>
                                </ul>
                            </div>
                        <?php elseif (isset($friends) && in_array($user['User']['id'], $friends) && $user['User']['id'] != $uid): ?>
                            <?php $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_remove", "plugin" => false, $user['User']['id'])),
                                'title' => __('Remove'),
                                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_remove">person_remove</span><span class="btn-text">'.__('Remove Friend').'</span></span>',
                                'id' => 'removeFriend_'.$user['User']['id'],
                                'class' => 'btn btn-primary btn-xs btn-cs btn-user-act add_people'
                            )); ?>
                        <?php elseif(isset($friends) && isset($friends_request) && !in_array($user['User']['id'], $friends) && !in_array($user['User']['id'], $friends_request) && $user['User']['id'] != $uid): ?>
                            <?php $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_add", "plugin" => false, $user['User']['id'])),
                                'title' => sprintf( __('Send %s a friend request'), $user['User']['name'] ),
                                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span><span class="btn-text">'.__('Add Friend').'</span></span>',
                                'id' => 'addFriend_'. $user['User']['id'],
                                'class'=> 'btn btn-primary btn-xs btn-cs btn-user-act add_people'
                            )); ?>
                        <?php endif; ?>

                        <?php if(isset($user_block)){
                            $this->MooPopup->tag(array('href'=>$this->Html->url(array("controller" => "user_blocks", "action" => "ajax_remove", "plugin" => false, $user['User']['id'])),
                                'title' => __('Unblock'),
                                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span><span class="btn-text">'.__('Unblock').'</span></span>',
                                'id' => 'unblock_'.$user['User']['id'],
                                'class' => 'btn btn-primary btn-xs btn-cs btn-user-act add_people unblock'
                            ));
                        } ?>

                        <?php if ( isset($group) && isset($admins) && $user['User']['id'] != $uid && $group['User']['id'] != $user['User']['id'] && ( !empty($cuser['Role']['is_admin']) || in_array($uid, $admins) ) ): ?>
                            <a class="btn btn-primary btn-xs btn-cs btn-user-act removeMember" href="javascript:void(0)" data-id="<?php echo $user['GroupUser']['id']?>">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                    <span class="btn-text"><?php echo __('Remove Member')?></span>
                                </span>
                            </a>
                        <?php endif; ?>

                        <?php if ( isset($group) && isset($admins) && !in_array($user['User']['id'], $admins) && ( !empty($cuser['Role']['is_admin']) || $uid == $group['User']['id'] ) ): ?>
                            <a class="btn btn-primary btn-xs btn-cs btn-user-act changeAdmin" href="javascript:void(0)" data-id="<?php echo $user['GroupUser']['id']?>" data-type="make">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-security">security</span>
                                    <span class="btn-text"><?php echo __('Make Admin')?></span>
                                </span>
                            </a>
                        <?php endif; ?>

                        <?php if ( isset($group) && isset($admins) && in_array($user['User']['id'], $admins) && $user['User']['id'] != $group['User']['id'] && ( !empty($cuser['Role']['is_admin']) || $uid == $group['User']['id'] ) ): ?>
                            <a class="btn btn-primary btn-xs btn-cs btn-user-act changeAdmin" href="javascript:void(0)" data-id="<?php echo $user['GroupUser']['id']?>" data-type="remove">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                    <span class="btn-text"><?php echo __('Remove Admin')?></span>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $this->Html->rating($user['User']['id'],'users'); ?>
        </div>
	</div>
<?php
	endforeach;
}
else
	echo '<div class="no-more-results">' . __('No more results found') . '</div>';
?>
    