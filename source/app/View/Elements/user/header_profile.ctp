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

<?php
if(empty($title)) $title = "Featured Members";
if(empty($num_item_show)) $num_item_show = 10;

$friends = $this->requestAction(
    "users/friends/num_item_show:$num_item_show/user_id:$uid"
);
?>
<?php $this->setBodyClass('profile-floating-menu'); ?>
<div class="profile-header">
    <div id="profile-figure" class="profile-figure">
        <div id="cover" class="profile-cover">
            <img id="cover_img_display" class="profile-cover-img" width="100%" src="<?php echo $this->storage->getUrl($user['User']["id"],'',$user['User']['cover'],"moo_covers"); ?>" />
            <div id="cover_img_background" class="profile-cover-bg" style="background-image: url(<?php echo $this->storage->getUrl($user['User']["id"],'',$user['User']['cover'],"moo_covers"); ?>)"></div>
            <?php if ( !empty( $cover_album_id ) ): ?>
                <a href="<?php echo $this->request->base?>/albums/view/<?php echo $cover_album_id?>"></a>
            <?php endif; ?>

            <?php if ( $uid == $user['User']['id'] ): ?>
                <div id="cover_upload" class="profile-cover-upload">
                    <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "users", "action" => "ajax_cover", "plugin" => false)),
                        'title' => __('Edit Cover Picture'),
                        'innerHtml'=> '<span class="cover-upload-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>',
                        'data-backdrop' => 'static'
                    ));
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <div id="avatar" class="profile-avatar">
            <?php if ( !empty( $profile_album_id ) ): ?>
                <a href="<?php echo $this->request->base?>/albums/view/<?php echo $profile_album_id?>">
                    <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square'), array("id" => "av-img", "class" => "profile-avatar-img"))?>
                </a>
            <?php else: ?>
                <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square'), array("id" => "av-img", "class" => "profile-avatar-img"))?>
            <?php endif; ?>

            <?php if ( $uid == $user['User']['id'] ): ?>
                <div id="avatar_upload" class="profile-avatar-upload">
                    <?php if ($isMobile): ?>
                        <a href="<?php echo $this->request->base?>/users/avatar" title="<?php echo __('Edit Profile Picture'); ?>">
                            <span class="avatar-upload-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>
                        </a>
                    <?php else: ?>
                        <?php
                        $this->MooPopup->tag(array(
                            'href'=>$this->Html->url(array("controller" => "users", "action" => "ajax_avatar", "plugin" => false,)),
                            'title' => __('Edit Profile Picture'),
                            'innerHtml'=> '<span class="avatar-upload-icon material-icons moo-icon moo-icon-photo_camera">photo_camera</span>',
                            'data-backdrop' => 'static'
                        ));
                        ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
            <?php if ( !empty($is_online)): ?>
                <span class="online-stt"></span>
            <?php endif; ?>
        </div>
    </div>
    <div id="profile-scroll" class="profile-navbar">
        <div class="profile-scroll-main profile-user-info">
            <div class="profile-main">
                <div class="container">
                    <div class="profile-user-title">
                        <span class="profile-user-img">
                        <?php if ( !empty( $profile_album_id ) ): ?>
                            <a href="<?php echo $this->request->base?>/albums/view/<?php echo $profile_album_id?>">
                                <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '50_square'), array("id" => "av-img-small", "class"=>"profile-avatar-small"))?>
                            </a>
                        <?php else: ?>
                            <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '50_square'), array("id" => "av-img-small", "class"=>"profile-avatar-small"))?>
                        <?php endif; ?>
                        </span>
                        <span class="profile-user-name">
                            <?php echo $this->Text->truncate($user['User']['name'], 30, array('exact' => false, 'html'=>true))?>
                            <!--<?php //if ( $user['User']['featured'] ): ?><a class="profile-user-name-act" href="javascript:void(0);"><span class="profile-user-icon material-icons moo-icon moo-icon-stars">stars</span></a><?php //endif; ?>-->
                            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.headerProfile.afterRenderUserName', $this)); ?>
                        </span>
                    </div>
                    <?php if ( $canView ): ?>
                        <div class="profile_info">
                            <ul class="profile-info-list">
                                <?php if ( !empty( $user['User']['gender'] ) ): ?>
                                    <li><span class="date"><?php echo __('Gender')?>:</span> <?php $this->Moo->getGenderTxt($user['User']['gender']); ?></li>
                                <?php endif; ?>
                                <?php if ( !empty( $user['User']['birthday'] ) && $user['User']['birthday'] != '0000-00-00'): ?>
                                    <li><span class="date"><?php echo __('Born on')?>:</span> <?php echo $this->Time->format($user['User']['birthday'], '%B %d', false, 'UTC')?></li>
                                <?php endif; ?>
                                <?php
                                //add profile type
                                ?>
                                <?php if ($user['ProfileType']['id']):?>
                                    <?php if (Configure::read('core.enable_show_profile_type')):?>
                                        <li>
                                            <span class="date"><?php echo __('Profile type');?>: </span>
                                            <a href="<?php echo $this->request->base;?>/users/index/profile_type:<?php echo $user['ProfileType']['id'];?>"><?php echo $user['ProfileType']['name'];?></a>
                                        </li>
                                    <?php endif;?>
                                    <?php $helper = MooCore::getInstance()->getHelper("Core_Moo");?>
                                    <?php foreach ($fields as $field):
                                        if (!in_array($field['ProfileField']['type'],$helper->profile_fields_default))
                                        {
                                            $options = array();
                                            if ($field['ProfileField']['plugin'])
                                            {
                                                $options = array('plugin' => $field['ProfileField']['plugin']);
                                            }

                                            echo $this->element('profile_field/' . $field['ProfileField']['type'].'_profile', array('field' => $field,'user'=>$user),$options);
                                            continue;
                                        }
                                        if ( !empty( $field['ProfileFieldValue']['value'] ) && $field['ProfileField']['type'] != 'heading' ) :
                                            ?>
                                            <li><span class="date"><?php echo $field['ProfileField']['name']?>: </span>
                                                <?php echo $this->element( 'misc/custom_field_value', array( 'field' => $field ) ); ?>
                                            </li>
                                        <?php endif;
                                    endforeach;
                                    ?>
                                <?php endif;?>

                                <!-- Should be hook for third party -->
                                <?php $this->getEventManager()->dispatch(new CakeEvent('Elements.user.headerProfile', $this)); ?>
                                <!-- Should be hook for third party -->
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="profile-action">
                        <?php $this->Html->rating($uid,'profile'); ?>
                        <div class="profile-action-main">
                            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.headerProfile.beforeRenderSectionMenu', $this)); ?>

                            <?php if ($user['User']['id'] != $uid && !empty($uid)): ?>
                                <?php $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "conversations", "action" => "ajax_send", "plugin" => false, $user['User']['id'])),
                                    'title' => __('Send New Message'),
                                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-chat">chat</span><span class="btn-text">'.__('Send Message').'</span></span>',
                                    'class'=>'btn btn-cs btn-profile'
                                ));
                                ?>

                                <?php if ( !empty($request_sent) ): ?>
                                <a id="userCancelFriend" class="btn btn-profile btn-cs" href="<?php echo $this->request->base?>/friends/ajax_cancel/<?php echo $user['User']['id']?>" title="<?php echo __('Cancel a friend request');?>">
                                    <span class="btn-cs-main">
                                        <span class="btn-icon material-icons moo-icon moo-icon-clear">clear</span>
                                        <span class="btn-text"><?php echo __('Cancel Request')?></span>
                                    </span>
                                </a>
                                <?php endif; ?>

                                <?php if ( !empty($respond) ): ?>
                                <div class="btn-profile-dropdown btn-dropdown">
                                    <div class="dropdown" >
                                        <a id="respond" class="btn btn-profile btn-cs" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false" title="<?php echo __('Respond to Friend Request');?>">
                                            <span class="btn-cs-main">
                                                <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                                                <span class="btn-text"><?php echo __('Respond to Friend Request')?></span>
                                            </span>
                                        </a>

                                        <ul class="dropdown-menu" role="menu" aria-labelledby="respond">
                                            <li><a data-id="<?php echo  $request_id; ?>" data-status="1" class="respondRequest" href="javascript:void(0)"><?php echo  __('Accept'); ?></a></li>
                                            <li><a data-id="<?php echo  $request_id; ?>" data-status="0" class="respondRequest" href="javascript:void(0)"><?php echo  __('Delete'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ( !empty($uid) && !$areFriends && empty($request_sent) && empty($respond) ): ?>
                                    <?php
                                    $this->MooPopup->tag(array('href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_add", "plugin" => false, $user['User']['id'])),
                                        'title' => sprintf( __('Send %s a friend request'), $user['User']['name'] ),
                                        'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span><span class="btn-text">'.__('Add as Friend').'</span></span>',
                                        'id' => 'addFriend_'. $user['User']['id'],
                                        'class' => 'btn btn-profile btn-cs'
                                    ));
                                    ?>
                                <?php endif; ?>

                            <?php endif;?>

                            <?php if ($uid && Configure::read("core.enable_follow") && $uid != $user['User']['id']): ?>
                                <?php
                                $followModel = MooCore::getInstance()->getModel("UserFollow");
                                $follow = $followModel->checkFollow($uid,$user['User']['id']);
                                ?>
                                <?php if (!$follow): ?>
                                    <a href="javascript:void(0);" class="btn btn-profile btn-cs user_action_follow core_user_follow" data-uid="<?php echo $user['User']['id']; ?>" data-follow="0" >
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-rss_feed">rss_feed</span>
                                            <span class="btn-text"><?php echo __('Follow')?></span>
                                        </span>
                                    </a>
                                <?php else : ?>
                                    <a href="javascript:void(0);" class="btn btn-profile btn-cs user_action_follow core_user_follow" data-uid="<?php echo $user['User']['id']; ?>" data-follow="1" >
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-check">check</span>
                                            <span class="btn-text"><?php echo __('Unfollow')?></span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($user['User']['id'] == $uid): ?>
                                <a class="btn btn-profile btn-cs" href="<?php echo $this->request->base?>/users/profile">
                                    <span class="btn-cs-main">
                                        <span class="btn-icon material-icons moo-icon moo-icon-mode_edit">mode_edit</span>
                                        <span class="btn-text"><?php echo __('Edit Profile')?></span>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <div class="btn-profile-more">
                                <div class="dropdown">
                                    <a class="btn btn-profile btn-cs" href="#" data-toggle="dropdown">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                            <!--<span class="btn-text"><?php //echo __('More')?></span>-->
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ( !empty($cuser['role_id']) && $cuser['Role']['is_admin'] && !$user['User']['featured'] ): ?>
                                            <li><a href="<?php echo $this->request->base?>/admin/users/feature/<?php echo $user['User']['id']?>"><?php echo __('Feature User')?></a></li>
                                        <?php endif; ?>
                                        <?php if ( !empty($cuser['role_id']) && $cuser['Role']['is_admin'] && $user['User']['featured'] ): ?>
                                            <li><a href="<?php echo $this->request->base?>/admin/users/unfeature/<?php echo $user['User']['id']?>"><?php echo __('Unfeature User')?></a></li>
                                        <?php endif; ?>
                                        <?php if ( !empty($cuser['role_id']) && $cuser['Role']['is_admin'] && !$user['Role']['is_admin'] ): ?>
                                            <li><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $user['User']['id']?>"><?php echo __('Edit User')?></a></li>
                                        <?php endif; ?>
                                        <?php if ($user['User']['id'] != $uid): ?>
                                            <li>
                                                <?php
                                                $this->MooPopup->tag(array(
                                                    'href'=>$this->Html->url(array("controller" => "reports", "action" => "ajax_create", "plugin" => false, 'user', $user['User']['id'])),
                                                    'title' => __('Report User'),
                                                    'innerHtml'=> __('Report User'),
                                                ));
                                                ?>
                                            </li>
                                        <?php endif;?>
                                        <?php if ( !empty($uid) && $areFriends ): ?>
                                            <li><?php
                                                $this->MooPopup->tag(array(
                                                    'href'=>$this->Html->url(array("controller" => "friends", "action" => "ajax_remove", "plugin" => false, $user['User']['id'])),
                                                    'title' => __('Unfriend'),
                                                    'innerHtml'=> __('Unfriend'),
                                                ));
                                                ?></li>
                                        <?php endif; ?>
                                        <?php if ( !empty($uid) && ($uid != $user['User']['id'] ) && !$user['Role']['is_admin'] && !$user['Role']['is_super']): ?>
                                            <li><?php
                                                if(!$is_viewer_block){
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "user_blocks", "action" => "ajax_add", "plugin" => false, $user['User']['id'])),
                                                        'title' => __('Block'),
                                                        'innerHtml'=> __('Block'),
                                                    ));
                                                }else{
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "user_blocks", "action" => "ajax_remove", "plugin" => false, $user['User']['id'])),
                                                        'title' => __('Unblock'),
                                                        'innerHtml'=> __('Unblock'),
                                                    ));
                                                }
                                                ?></li>
                                        <?php endif; ?>
                                        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.headerProfile.afterRenderActionMenu', $this)); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile_rating">
                        <?php echo $this->Html->rating($user['User']['id'],'users'); ?>
                    </div>
                </div>
            </div>
            <?php if ( $canView ): ?>
            <div class="profile-menu">
                <div class="container">
                    <?php $menus = $this->Moo->getMenuProfiles();?>
                    <ul class="core-horizontal-menu browse-menu horizontal-menu horizontal-menu-waiting">
                        <li class="current">
                            <a class="horizontal-menu-link" href="<?php echo $this->Moo->getProfileUrl( $user['User'] )?>">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-person hidden">person</span>
                                <span class="horizontal-menu-text"><?php echo __('Profile')?></span>
                            </a>
                        </li>
                        <?php foreach ($menus as $menu):?>
                            <?php
                                $options = array();
                                if ($menu['plugin'] && $menu['plugin'] != 'Core')
                                {
                                    $options = array('plugin' => $menu['plugin']);
                                }

                                echo $this->element($menu['path'], array(),$options);
                            ?>
                        <?php endforeach;?>

                        <?php
                        //$this->getEventManager()->dispatch(new CakeEvent('profile.afterRenderMenu', $this));
                        ?>
                        <?php
                        if ( $this->elementExists('menu/user') )
                            echo $this->element('menu/user');
                        ?>
                        <li class="core-horizontal-more hasChild hidden">
                            <a class="horizontal-menu-link horizontal-menu-header no-ajax" href="javascript:void(0);">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-more_vert hidden">more_vert</span>
                                <span class="horizontal-menu-text"><?php echo __('More') ?></span>
                            </a>
                            <ul class="core-horizontal-dropdown horizontal-menu-sub"></ul>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="profile-scroll-jump"></div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooCoreMenu'), 'object' => array('$', 'mooCoreMenu'))); ?>
    $('.core-horizontal-menu').HorizontalMenu();
    $('#profile-scroll').StickyProfileMenu({asHorizontalMenuFor: '.core-horizontal-menu'});
<?php $this->Html->scriptEnd(); ?>
