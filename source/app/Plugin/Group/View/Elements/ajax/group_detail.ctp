<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooToggleEmoji"], function($,mooToggleEmoji) {
        mooToggleEmoji.init('message', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php endif; ?>
<div id="group_details" class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo  __('Information') ?></h1>
            <div class="box_action">
                <?php if ((empty($uid) && !empty($invited_user)) || (!empty($uid) && (($group['Group']['type'] != PRIVACY_PRIVATE && empty($my_status['GroupUser']['status'])) || ($group['Group']['type'] == PRIVACY_PRIVATE && !empty($my_status) && $my_status['GroupUser']['status'] == 0 ) ) ) ): ?>
                <a class="box-btn btn btn-header_title btn-cs join-btn" href="<?php echo  $this->request->base ?>/groups/do_request/<?php echo  $group['Group']['id'] ?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-group_add">group_add</span>
                        <span class="btn-text"><?php echo  __('Join') ?></span>
                    </span>
                </a>
                <?php endif; ?>

                <!-- New hook -->
                <?php $this->getEventManager()->dispatch(new CakeEvent('groups.view.afterRenderJoinButton', $this,array('group'=>$group))); ?>
                <!-- New hook -->

                <?php if (!empty($request_count)): ?>
                    <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "groups",
                            "action" => "ajax_requests",
                            "plugin" => 'group',
                            $group['Group']['id'],

                        )),
                        'title' => __('Join Requests'),
                        'class' => 'box-btn btn btn-header_title btn-cs',
                        'id' => 'join-request',
                        'data-request' => $request_count,
                        'innerHtml'=> '<span class="btn-cs-main"><span class="btn-count">'.$request_count.'</span><span class="btn-text">'.__n('join request', 'join requests', $request_count).'</span></span>',
                    ));
                    ?>
                <?php endif; ?>

                <?php if ($uid): ?>
                <div class="box-dropdown">
                    <div class="dropdown">
                        <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                            <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ( ( !empty($my_status) && $my_status['GroupUser']['status'] == GROUP_USER_MEMBER  && $group['Group']['type'] != PRIVACY_PRIVATE) ||
                                !empty($cuser['Role']['is_admin'] ) ||
                                ( !empty($my_status) && $my_status['GroupUser']['status'] == GROUP_USER_ADMIN)
                            ): ?>
                            <li>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "groups",
                                        "action" => "ajax_invite",
                                        "plugin" => 'group',
                                        $group['Group']['id'],

                                    )),
                                    'title' => __( 'Invite Friends'),
                                    'innerHtml'=> __( 'Invite Friends'),
                                ));
                                ?>
                            </li>
                            <?php endif; ?>

                            <?php if ( ( !empty($my_status) && $my_status['GroupUser']['status'] == GROUP_USER_ADMIN && $group['Group']['user_id'] == $uid ) || !empty($cuser['Role']['is_admin'] ) ): ?>
                                <li><a href="<?php echo $this->request->base?>/groups/create/<?php echo $group['Group']['id']?>"><?php echo __( 'Edit Group')?></a></li>
                                <li><a href="javascript:void(0)" data-id="<?php echo  $group['Group']['id'] ?>" class="deleteGroup"><?php echo __( 'Delete Group')?></a></li>
                            <?php endif; ?>

                            <li>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "reports",
                                        "action" => "ajax_create",
                                        "plugin" => false,
                                        'group_group',
                                        $group['Group']['id'],
                                    )),
                                    'title' => __( 'Report Group'),
                                    'data-dismiss' => 'modal',
                                    'innerHtml'=> __( 'Report Group'),
                                ));
                                ?>
                            </li>
                            <li class="seperate"></li>
                            <?php if ( !empty($my_status) && ( $my_status['GroupUser']['status'] == GROUP_USER_MEMBER || $my_status['GroupUser']['status'] == GROUP_USER_ADMIN ) && ( $uid != $group['Group']['user_id'] ) ): ?>
                                <li><a href="javascript:void(0)" class="leaveGroup" data-id="<?php echo $group['Group']['id']?>"><?php echo __('Leave Group')?></a></li>
                            <?php endif; ?>
                            <?php if (isset($my_status['GroupUser']['status'])):?>
                                <?php
                                $settingModel = MooCore::getInstance()->getModel("Group.GroupNotificationSetting");
                                $checkStatus = $settingModel->getStatus($group['Group']['id'],$uid);
                                ?>
                                <li><a href="<?php echo $this->request->base?>/groups/stop_notification/<?php echo $group['Group']['id']?>"><?php if ($checkStatus) echo __( 'Turn Off Notification'); else echo __('Turn On Notification');?></a></li>
                            <?php endif;?>
                            <?php // do not add "Do Feature" for private group ?>
                            <?php if ( ( !empty($cuser) && $cuser['Role']['is_admin'] && $group['Group']['type'] != PRIVACY_PRIVATE ) ): ?>
                                <?php if ( !$group['Group']['featured'] ): ?>
                                    <li><a href="<?php echo $this->request->base?>/groups/do_feature/<?php echo $group['Group']['id']?>"><?php echo __( 'Feature Group')?></a></li>
                                <?php else: ?>
                                    <li><a href="<?php echo $this->request->base?>/groups/do_unfeature/<?php echo $group['Group']['id']?>"><?php echo __( 'Unfeature Group')?></a></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($group['Group']['type'] != PRIVACY_PRIVATE && $group['Group']['type'] != PRIVACY_RESTRICTED): ?>
                                <li>
                                    <a href="javascript:void(0);" share-url="<?php echo $this->Html->url(array(
                                        'plugin' => false,
                                        'controller' => 'share',
                                        'action' => 'ajax_share',
                                        'Group_Group',
                                        'id' => $group['Group']['id'],
                                        'type' => 'group_item_detail'
                                    ), true); ?>" class="shareFeedBtn"><?php echo __('Share'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div class="core-list-info group-info">
            <div class="core-list-info-item">
                <div class="core-list-info-l">
                    <?php echo  __('Category') ?>:
                </div>
                <div class="core-list-info-r">
                    <a href="<?php echo $this->request->base ?>/groups/index/<?php echo $group['Group']['category_id'] ?>/<?php echo seoUrl($group['Category']['name']) ?>"><?php echo $group['Category']['name'] ?></a>
                </div>
            </div>
            <div class="core-list-info-item">
                <div class="core-list-info-l">
                    <?php echo  __('Type') ?>:
                </div>
                <div class="core-list-info-r">
                <?php
                    switch ($group['Group']['type']) {
                        case PRIVACY_PUBLIC:
                            echo __('Public (anyone can view and join)');
                            break;

                        case PRIVACY_PRIVATE:
                            echo __('Private (only group members can view details)');
                            break;

                        case PRIVACY_RESTRICTED:
                            echo __('Restricted (anyone can join upon approval)');
                            break;
                    }
                ?>
                </div>
            </div>
            <?php
            if ($group['Group']['type'] != PRIVACY_PRIVATE || (!empty($cuser) && $cuser['Role']['is_admin'] ) ||
                (!empty($my_status) && ( $my_status['GroupUser']['status'] == GROUP_USER_MEMBER || $my_status['GroupUser']['status'] == GROUP_USER_ADMIN ) )
            ):
                ?>
            <div class="core-list-info-item">
                <div class="core-list-info-l">
                    <?php echo  __('Description') ?>:
                </div>
                <div class="core-list-info-r">
                    <div class="post_content">
                        <div class="group-description truncate" data-more-text="<?php echo __( 'Show More')?>" data-less-text="<?php echo __( 'Show Less')?>">
                            <?php echo $this->Moo->cleanHtml($this->Text->convert_clickable_links_for_hashtags( $group['Group']['description'] , Configure::read('Group.group_hashtag_enabled')))?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php $this->Html->rating($group['Group']['id'],'groups', 'Group'); ?>
    </div>
</div>

<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
if ($group['Group']['type'] != PRIVACY_PRIVATE || (!empty($cuser) && $cuser['Role']['is_admin'] ) ||
        (!empty($my_status) && ($my_status['GroupUser']['status'] == GROUP_USER_MEMBER || $my_status['GroupUser']['status'] == GROUP_USER_ADMIN ) )
):
    ?>
    <?php if (!empty($photos)): ?>
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo  __('Photos') ?></h1>
            </div>
        </div>
        <div class="box_content">
            <div class="photo-lists">
                <?php foreach ($photos as $photo): ?>
                <div class="photo-item">
                    <div class="photo-item-warp">
                        <a class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href']?>" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '150_square'));?>)" href="<?php echo  $this->request->base ?>/photos/view/<?php echo  $photo['Photo']['id'] ?>#content"></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php
            if ($photo_count > Configure::read('Photo.photo_item_per_pages')):
                ?>
            <div class="view-all-bottom">
                <a class="btn btn-default photo-more-btn" href="<?php echo $this->request->base; ?>/groups/view/<?php echo $group['Group']['id']; ?>/tab:photos"><?php echo __('View More'); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="bar-feed-warp">
        <div class="feed_breadcrumb">
            <h1 class="feed_breadcrumb_title"><?php echo  __('Recent Activities') ?></h1>
        </div>
        <?php $this->MooActivity->wall($groupActivities)?>
    </div>
<?php endif; ?>

