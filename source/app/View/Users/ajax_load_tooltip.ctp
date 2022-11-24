<div class="qtip_body">
    <div class="qtip_user_main">
        <?php //if($type == 'User'): ?>
        <!--<div class="cover-photo"><img width="100%" src="<?php //echo $this->storage->getUrl($object['User']["id"], '', $object['User']['cover'], "moo_covers"); ?>" /></div>-->
        <?php //endif; ?>
        <div class="qtip_user_avatar">
            <?php echo $this->Moo->getItemPhoto(array($type => $object[$type]), array('prefix' => '100_square'), array('class'=>'user_avatar'))?>
            <?php if (Configure::read("core.enable_show_birthday_profile_popup") && !empty( $object['User']['birthday'] ) && $object['User']['birthday'] != '0000-00-00'): ?>
                <div class="qtip_user_date"><?php echo __('Born on')?>: <?php echo $this->Time->format($object['User']['birthday'], '%B %d', false, 'UTC')?></div>
            <?php endif; ?>
        </div>
        <div class="qtip_user_info">
            <div class="qtip_user_title">
                <?php echo $this->Text->truncate(isset($object[$type]['name'])?$object[$type]['name']:$object[$type]['title'], 30, array('exact' => false))?>
                <?php if ( !empty($is_online)): ?><span class="online-stt"></span><?php endif; ?>
                <!--<?php //if($type == 'User'): ?><?php //if ( $object['User']['featured'] ): ?><a class="profile-user-name-act" href="javascript:void(0);"><span class="profile-user-icon material-icons moo-icon moo-icon-stars">stars</span></a><?php //endif; ?><?php //endif; ?>-->
                <?php $this->getEventManager()->dispatch(new CakeEvent('View.Activities.ajaxLoadTooltip.afterRenderUserName', $this)); ?>
            </div>
            <?php if($type == 'User'): ?>
            	<?php $gender = $this->Moo->getGenderTxt($object['User']['gender'],true);?>
            	<?php if ($gender && Configure::read("core.enable_show_gender_profile_popup")):?>
                	<div class="qtip_user_extra"><span class="qtip_user_extra_label"><?php echo __('Gender')?>:</span> <?php echo $gender; ?></div>
                <?php endif;?>
                <?php if (Configure::read("core.enable_show_join_profile_popup")):?>
                    <div class="qtip_user_extra"><span class="qtip_user_extra_label"><?php echo __('Joined on %s', $this->Time->format($object['User']['created'],'%B %Y', null, $utz))?></span></div>
                <?php endif;?>
            <?php endif; ?> 
            <?php if($type == 'User'): ?>
            <div class="qtip_user_stat">
                <div class="qtip_start_block">
                    <div class="qtip_start_left">
                        <span class="qtip_start_icon material-icons moo-icon moo-icon-people">people</span>
                    </div>
                    <div class="qtip_start_right">
                        <?php  echo __n( 'Friend', 'Friends', $object['User']['friend_count'], $object['User']['friend_count'] ); ?> <span><?php echo $object['User']['friend_count'] ?></span>
                    </div>
                </div>
                <div class="qtip_start_block">
                    <div class="qtip_start_left">
                        <span class="qtip_start_icon material-icons moo-icon moo-icon-photo">photo</span>
                    </div>
                    <div class="qtip_start_right">
                        <?php echo __n( 'Photo', 'Photos', $object['User']['photo_count'], $object['User']['photo_count'] ); ?> <span><?php echo $object['User']['photo_count'] ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="qtip_user_adding_info">
                <?php $this->getEventManager()->dispatch(new CakeEvent('View.Activities.ajaxLoadTooltip.loadItemInfo', $this)); ?>
            </div>
        </div>
    </div>
    <?php if($type == 'User' && $object['User']['id'] != $uid && !empty($uid)): ?>   
    <div class="qtip_user_actions">
         <?php if ( isset($friends_request) && in_array($object['User']['id'], $friends_request) && $object['User']['id'] != $uid): ?>
                <a href="<?php echo $this->request->base?>/friends/ajax_cancel/<?php echo $object['User']['id']?>" id="cancelFriend_<?php echo $object['User']['id']?>" class="btn btn-user_tip btn-cs" title="<?php echo __('Cancel friend request');?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                        <span class="btn-text"><?php echo __('Cancel friend request');?></span>
                    </span>
                </a>
        <?php elseif ( !empty($respond) && in_array($object['User']['id'], $respond ) && $object['User']['id'] != $uid): ?>
                <div class="dropdown btn-tip_dropdown">
                    <a class="btn btn-user_tip btn-cs" data-target="#themeModal" data-toggle="modal" onclick="$('#photoModal').modal('hide');" data-dismiss="" data-backdrop="true" href="<?php echo $this->request->base?>/friends/ajax_request/<?php echo $object['User']['id']?>" title="<?php echo __('Respond to Friend Request');?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                            <span class="btn-text"><?php echo __('Respond to Friend Request');?></span>
                        </span>
                    </a>

                    <ul class="dropdown-menu" role="menu" aria-labelledby="respond">
                        <li><a class="respondRequest" data-id="<?php echo  $request_id[$object['User']['id']]; ?>" data-status="1" href="javascript:void(0)"><?php echo  __('Accept'); ?></a></li>
                        <li><a class="respondRequest" data-id="<?php echo  $request_id[$object['User']['id']]; ?>" data-status="0" href="javascript:void(0)"><?php echo  __('Delete'); ?></a></li>
                    </ul>
                </div>

        <?php elseif (isset($friends) && in_array($object['User']['id'], $friends) && $object['User']['id'] != $uid): ?>
            <?php
                $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_remove", "plugin" => false, $object['User']['id'])),
                    'title' => sprintf( __('Remove %s from your friends list'), h($object['User']['name']) ),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_remove">person_remove</span><span class="btn-text">'.__('Remove friend').'</span></span>',
                    'id' => 'removeFriend_'.$object['User']['id'],
                    'class' => 'btn btn-cs btn-user_tip',
                    'onclick' => "$('#photoModal').modal('hide');"
               ));
            ?>

        <?php elseif(isset($friends) && isset($friends_request) && !in_array($object['User']['id'], $friends) && !in_array($object['User']['id'], $friends_request) && $object['User']['id'] != $uid): ?>
            <?php
                $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_add", "plugin" => false, $object['User']['id'])),
                    'title' => sprintf( __('Send %s a friend request'), h($object['User']['name']) ),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span><span class="btn-text hidden-xs hidden-sm">'.__('Add Friend').'</span></span>',
                    'id' => 'addFriend_'. $object['User']['id'],
                    'class'=> 'btn btn-cs btn-user_tip',
                    'onclick' => "$('#photoModal').modal('hide');"
                ));
            ?>
        <?php endif; ?>

        <?php
            $this->MooPopup->tag(array(
                'href'=>$this->Html->url(array("controller" => "conversations", "action" => "ajax_send", "plugin" => false, $object['User']['id'])),
                'title' => __('Send New Message'),
                'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-chat">chat</span><span class="btn-text hidden-xs hidden-sm">'.__('Send Message').'</span></span>',
                'class'=>'btn btn-cs btn-user_tip',
                'onclick' => "$('#photoModal').modal('hide');"
            ));
        ?>

      <?php if (Configure::read("core.enable_follow")): ?>
          <?php
          $followModel = MooCore::getInstance()->getModel("UserFollow");
          $follow = $followModel->checkFollow($uid,$object['User']['id']);
          ?>
          <?php if (!$follow): ?>
              <a href="javascript:void(0);" class="btn btn-cs btn-user_tip usertip_action_follow core_user_follow" data-uid="<?php echo $object['User']['id']; ?>" data-follow="0" >
                  <span class="btn-cs-main">
                      <span class="btn-icon material-icons moo-icon moo-icon-rss_feed">rss_feed</span>
                      <span class="btn-text hidden-xs hidden-sm"><?php echo __('Follow')?></span>
                  </span>
              </a>
          <?php else : ?>
              <a href="javascript:void(0);" class="btn btn-cs btn-user_tip usertip_action_follow core_user_follow" data-uid="<?php echo $object['User']['id']; ?>" data-follow="1" >
                  <span class="btn-cs-main">
                      <span class="btn-icon material-icons moo-icon moo-icon-check">check</span>
                      <span class="btn-text hidden-xs hidden-sm"><?php echo __('Unfollow')?></span>
                  </span>
              </a>
          <?php endif; ?>
      <?php endif; ?>

      <?php $this->getEventManager()->dispatch(new CakeEvent('View.Users.ajaxLoadTooltip.afterRenderButton', $this)); ?>
    </div>
    <?php endif; ?>
</div>