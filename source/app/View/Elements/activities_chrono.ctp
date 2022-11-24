<?php
$activitiesParams = array(
    'request_base'=>((!empty($this->request->base))? $this->request->base : ''),
    );

$this->addPhraseJs(array(
    'confirm'=>__('Confirm'),
    'remove_tags'=>__('Remove Tags'),
    'remove_tags_contents'=>__('You wont be tagged in this post anymore. It may appear in other places like New Feed or search.'),
    'ok'=>__('Ok'),
    'cancel'=>__('Cancel'),
    'please_confirm'=>__('Please Confirm'),
    'please_confirm_remove_this_activity'=>__('Are you sure you want to remove this activity?'),
));
?>

<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooActivities", "mooToggleEmoji", "mooComment"], function($, mooActivities, mooToggleEmoji, mooComment) {
        var activitiesParams = '<?php echo json_encode($activitiesParams,true); ?>';
        mooActivities.init(activitiesParams);
        mooComment.initParseComment()
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery', 'mooActivities', 'mooToggleEmoji', 'mooComment'),'object'=>array('$', 'mooActivities', 'mooToggleEmoji', 'mooComment'))); ?>
    var activitiesParams = '<?php echo json_encode($activitiesParams,true); ?>';
    mooActivities.init(activitiesParams);
    mooComment.initParseComment()
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if (!empty($activities)): ?>
<?php
$historyModel = MooCore::getInstance()->getModel('CommentHistory');
$subject_type = MooCore::getInstance()->getSubjectType();
$pin_type = '';
if (strtolower($subject_type) != 'user')
{
	$pin_type = 'activity';
	if ($subject_type)
	{
		$pin_type = 'item';
	}
}
foreach ($activities as $index => $activity):
    $check_privacy_type = true; // Event, Group ....
	$admins_current = (isset($admins) ? array_merge($admins,array($activity['Activity']['user_id'])) : array($activity['Activity']['user_id']));
	$item_type = $activity['Activity']['item_type'];
	if ($activity['Activity']['plugin'])
	{
		$options = array('plugin'=>$activity['Activity']['plugin']);
	}
	else
	{
		$options = array();
	}

	if ($item_type)
	{
		list($plugin, $name) = mooPluginSplit($item_type);
		$object = MooCore::getInstance()->getItemByType($item_type,$activity['Activity']['item_id']);

	}
	else
	{
		$plugin = '';
		$name ='';
		$object = null;
	}

    $item_type =  empty($activity['Activity']['item_type']) ? 'activity' : $activity['Activity']['item_type'];
    $item_id = !empty($activity['Activity']['item_id']) ? $activity['Activity']['item_id'] : $activity['Activity']['id'];

    if( $activity['Activity']['params'] == 'item' && (isset($object[$name]['like_count'])) && ($activity['Activity']['item_type'] != 'Photo_Photo' || $activity['Activity']['action'] != 'photos_add') && ($activity['Activity']['item_type'] != 'Photo_Album' || $activity['Activity']['action'] != 'wall_post')){
        $item_close_comment = $this->Moo->getCloseComment($item_id, $item_type, $activity);
        $close_item_type = $item_type;
        $close_item_id = $item_id;
    }else{
        $item_close_comment = $this->Moo->getCloseComment($item_id, 'activity', $activity);
        $close_item_type = 'activity';
        $close_item_id = $activity['Activity']['id'];
    }

    if($item_close_comment['status']){
        $is_close_comment = 1;
    }else{
        $is_close_comment = 0;
    }

    if($activity['Activity']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || (!empty($admins_current) && in_array($uid, $admins_current)) ){
        $is_owner = 1;
    }else{
        $is_owner = 0;
    }

    $can_reply = 0;
    if((!$is_close_comment && (!isset($is_member) || $is_member)) || $is_owner){
        $can_reply = 1;
    }
        ?>
<div id="activity_<?php echo $activity['Activity']['id']?>" class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_header">
                <div class="activity_feed_image">
                    <?php $event_feed_actor = $this->getEventManager()->dispatch(new CakeEvent('Activities.renderFeedActor', $this, array('activity' => $activity))); ?>
                    <?php if(!empty($event_feed_actor->result['image'])):?>
                        <?php echo $event_feed_actor->result['image'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getItemPhoto(array('User' => $activity['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
                    <?php endif;?>
                </div>
                <div class="activity_feed_content">
                    <div class="activity_content_head">
                        <div class="activity_author">
                            <?php if(!empty($event_feed_actor->result['name'])):?>
                                <?php echo $event_feed_actor->result['name'];?>
                            <?php else:?>
                                <?php echo $this->Moo->getName($activity['User'])?>
                            <?php endif;?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderUserNameFeed', $this,array('user'=>$activity['User']))); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderFeelingFeed', $this,array('user'=>$activity['User'], 'activity' => $activity['Activity']))); ?>
                            <?php
                            echo $this->element('activity/text/' . $activity['Activity']['action'], array('activity' => $activity,'object'=>$object),$options);
                            ?>
                        </div>
                        <div class="activity_option">
                            <div class="feed-option">
                            <!-- New hook -->
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.beforeRenderButtonAction', $this,array('activity'=>$activity))); ?>
                            <!-- New hook -->

                            <?php if ($pin_type): ?>
                                <?php
                                if ($pin_type == 'activity')
                                {
                                    $show_pin = $activity['Activity']['activity_pin'];
                                }
                                else
                                {
                                    $show_pin = $activity['Activity']['pin'];
                                }
                                ?>
                                <?php if ($show_pin):?>
                                <div class="feed-option-item">
                                    <a class="pin-feed-icon tip" title="<?php echo  __( 'Pinned') ?>">
                                        <span class="feed-option-icon material-icons moo-icon moo-icon-offline_pin">offline_pin</span>
                                    </a>
                                </div>
                                <?php endif;?>
                            <?php endif;?>

                            <?php
                            // delete link available for activity poster, site admin and item admins
                            if ( $activity['Activity']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $admins_current ) && in_array( $uid, $admins_current ) || (!empty($activity['UserTagging']) && in_array($uid, explode(',', $activity['UserTagging']['users_taggings']) ) ) || $this->MooPeople->isMentioned($uid, $activity['Activity']['id'])  ) ):
                                ?>
                                <div class="feed-option-item">
                                    <div class="dropdown">
                                        <?php if (!empty($uid)): ?>
                                            <a href="javascript:void(0)" data-toggle="dropdown">
                                                <span class="feed-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- New hook -->
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.beforeRenderMenuAction', $this,array('activity'=>$activity))); ?>
                                                <!-- New hook -->

                                                <?php if (($uid == $activity['Activity']['user_id']) || $this->MooPeople->isTagged($uid, $activity['Activity']['id'], 'activity'/*$item_type*/) || $this->MooPeople->isMentioned($uid, $activity['Activity']['id'])): ?>
                                                    <li>
                                                        <?php if ( $activity['Activity']['params'] == 'item' && (isset($object[$name]['like_count']))): ?>
                                                            <?php
                                                            $title = $this->Moo->isNotificationStop($item_id, $item_type) ? __('Turn on notifications') : __('Stop Notifications');
                                                            $this->MooPopup->tag(array(
                                                                'href'=>$this->Html->url(array("controller" => "notifications", "action" => "stop", "plugin" => false, $item_type, $item_id)),
                                                                'title' => $title,
                                                                'innerHtml'=> $title,
                                                                'id' => 'stop_notification_' . $item_type. $item_id
                                                            ));
                                                            ?>
                                                        <?php else: ?>
                                                            <?php
                                                            $title = $this->Moo->isNotificationStop($activity['Activity']['id'], 'activity') ? __('Turn on notifications') : __('Stop Notifications');
                                                            $this->MooPopup->tag(array(
                                                                'href'=>$this->Html->url(array("controller" => "notifications", "action" => "stop", "plugin" => false, 'activity', $activity['Activity']['id'])),
                                                                'title' => $title,
                                                                'innerHtml'=> $title,
                                                                'id' => 'stop_notification_' . 'activity'. $activity['Activity']['id']
                                                            ));
                                                            ?>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($activity['UserTagging']['users_taggings']) && $activity['Activity']['user_id'] == $uid ): ?>
                                                    <li>
                                                        <?php
                                                        $this->MooPopup->tag(array(
                                                            'href'=>$this->Html->url(array("controller" => "friends", "action" => "tagged", "plugin" => false, $activity['Activity']['id'])),
                                                            'title' => __('Tag Friends'),
                                                            'innerHtml'=> __('Tag Friends'),
                                                        ));
                                                        ?>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (isset($activity['UserTagging']['users_taggings']) && in_array($uid, explode(',', $activity['UserTagging']['users_taggings']) ) || $this->MooPeople->isMentioned($uid, $activity['Activity']['id']) ): ?>
                                                    <li>
                                                        <a class="removeTags" data-activity-id="<?php echo $activity['Activity']['id']; ?>" data-activity-item-type="activity" href="javascript:void(0)" ><?php echo __('Remove Tags'); ?></a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (($activity['Activity']['user_id'] == $uid || $cuser['Role']['is_admin']) &&  $activity['Activity']['action'] == 'wall_post'):?>
                                                    <li>
                                                        <a class="editActivity" data-activity-id="<?php echo $activity['Activity']['id']?>" href="javascript:void(0)" >
                                                            <?php echo __('Edit Post'); ?>
                                                        </a>
                                                    </li>
                                                <?php endif;?>

                                                <?php if (( (!empty($admins_current) && in_array($uid, $admins_current)) || $activity['Activity']['user_id'] == $uid || $cuser['Role']['is_admin'])): ?>
                                                    <li>
                                                        <a class="removeActivity" data-activity-id="<?php echo $activity['Activity']['id']?>" href="javascript:void(0)" >
                                                            <?php echo __('Delete Post'); ?>
                                                        </a>
                                                    </li>
                                                    <?php if ($activity['Activity']['params'] != 'no-comments'):?>
                                                        <li>
                                                            <?php
                                                            if($is_close_comment){
                                                                $title =  __('Open Comment');
                                                            }else{
                                                                $title =   __('Close Comment');
                                                            }
                                                            ?>
                                                            <a class="closeComment" data-id="<?php echo $close_item_id?>" data-type="<?php echo $close_item_type;?>" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
                                                                <?php echo $title; ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <li class="">
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "reports", "action" => "ajax_create", "plugin" => false, 'activity', $activity['Activity']['id'])),
                                                        'title' =>  __( 'Report Activity'),
                                                        'innerHtml'=>  __( 'Report Activity'),
                                                    ));
                                                    ?>
                                                </li>
                                                <?php if (( (!empty($admins) && in_array($uid, $admins)) || $cuser['Role']['is_admin'])): ?>
                                                    <?php if ($pin_type):?>
                                                        <?php
                                                        $action_pin = 'ajax_activity_pin';
                                                        $text_pin = __('Pin to top');
                                                        if ($pin_type == 'activity')
                                                        {
                                                            if ($activity['Activity']['activity_pin'])
                                                            {
                                                                $text_pin = __('Unpin from top');
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $action_pin = 'ajax_pin';
                                                            if ($activity['Activity']['pin'])
                                                            {
                                                                $text_pin = __('Unpin from top');
                                                            }
                                                        }
                                                        ?>
                                                        <li class="">
                                                            <a href="<?php echo $this->request->base?>/activities/<?php echo $action_pin?>/<?php echo $activity['Activity']['id']?>"><?php echo $text_pin?></a>
                                                        </li>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php elseif ($uid) : ?>
                                <div class="feed-option-item">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown">
                                            <span class="feed-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu" for="activity_menu_edit_<?php echo $activity['Activity']['id']?>">
                                            <!-- New hook -->
                                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.beforeRenderMenuAction', $this,array('activity'=>$activity))); ?>
                                            <!-- New hook -->
                                            <li class="">
                                                <?php
                                                $this->MooPopup->tag(array(
                                                    'href'=>$this->Html->url(array("controller" => "reports", "action" => "ajax_create", "plugin" => false, 'activity', $activity['Activity']['id'])),
                                                    'title' =>  __( 'Report Activity'),
                                                    'innerHtml'=>  __( 'Report Activity'),
                                                ));
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="feed_time">
                        <?php if ( $activity['Activity']['params'] != 'no-comments' ): ?>
                            <a class="feed_time-txt" href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>"><?php echo $this->Moo->getTime( $activity['Activity']['created'], Configure::read('core.date_format'), $utz )?></a>
                        <?php else: ?>
                            <span class="feed_time-txt"><?php echo $this->Moo->getTime( $activity['Activity']['created'], Configure::read('core.date_format'), $utz )?></span>
                        <?php endif; ?>
                        <?php
                        $this->MooPopup->tag(array(
                            'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'activity', $activity['Activity']['id'])),
                            'title' => __('Show edit history'),
                            'innerHtml'=> $historyModel->getText('activity',$activity['Activity']['id']),
                            'style' => empty($activity['Activity']['edited']) ? 'display:none' : '',
                            'id' => 'history_activity_'. $activity['Activity']['id'],
                            'class' => 'feed_time-txt feed_time_history-btn',
                            'data-dismiss'=>'modal'
                        ));
                        ?>

                        <?php if (!$activity['Activity']['target_id']):?>
                            <?php
                            switch ($activity['Activity']['privacy']) {
                                case '1':
                                    $text = __('Shared with: Everyone');
                                    $icon = 'public';
                                    break;
                                case '2':
                                    $text = __('Shared with: Friends');
                                    $icon = 'people';
                                    break;
                                case '3':
                                    $text = __('Shared with: Only Me');
                                    $icon = 'lock';
                                    break;
                            }
                            ?>
                            <?php if(!empty($uid) && ($activity['Activity']['user_id'] == $uid || $cuser['Role']['is_admin']) && $activity['Activity']['action'] == 'wall_post'): ?>
                            <span class="feed_time-txt">
                                <div class="dropdown">
                                    <a id="permission_<?php echo $activity['Activity']['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="tip" href="javascript:void(0);" original-title="<?php echo $text;?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-<?php echo $icon;?>"><?php echo $icon;?></span>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="permission_<?php echo $activity['Activity']['id'] ?>">
                                        <li><a data-privacy="1" data-activity-id="<?php echo $activity['Activity']['id']; ?>" class="change-activity-privacy<?php if($activity['Activity']['privacy'] == 1) echo ' n52'; ?>" href="javascript:void(0)"><?php echo __('Everyone'); ?></a></li>
                                        <li><a data-privacy="2" data-activity-id="<?php echo $activity['Activity']['id']; ?>" class="change-activity-privacy<?php if($activity['Activity']['privacy'] == 2) echo ' n52'; ?>" href="javascript:void(0)"><?php echo __('Friends Only'); ?></a></li>
                                    </ul>
                                </div>
                            </span>
                            <?php else: ?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo $text;?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-<?php echo $icon;?>"><?php echo $icon;?></span></a>
                            <?php endif; ?>
                        <?php elseif (strtolower($activity['Activity']['type']) == 'user'):?>
                            <?php
                            $target = MooCore::getInstance()->getItemByType($activity['Activity']['type'],$activity['Activity']['target_id']);
                            ?>
                            <?php if ($activity['Activity']['privacy'] == PRIVACY_FRIENDS) :?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: %s\'s friends of friends',$target['User']['moo_title']);?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-people">people</span></a>
                            <?php else:?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: Everyone');?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-public">public</span></a>
                            <?php endif;?>
                        <?php else:?>
                            <?php
                            $target = MooCore::getInstance()->getItemByType($activity['Activity']['type'],$activity['Activity']['target_id']);
                            list($plugin_target, $name_target) = mooPluginSplit($activity['Activity']['type']);
                            $show_subject = MooCore::getInstance()->checkShowSubjectActivity($target);
                            if ($show_subject):
                                ?>
                                <?php
                                $plugin_helper = MooCore::getInstance()->getHelper($plugin_target.'_'.$plugin_target);
                                $is_public = true;
                                if (method_exists($plugin_helper,'isPublicFeedIcon'))
                                {
                                    $is_public = $plugin_helper->isPublicFeedIcon($target);
                                }

                                if (method_exists($plugin_helper,'checkPrivacyFeedHome'))
                                {
                                    $check_privacy_type = $plugin_helper->checkPrivacyFeedHome($target);
                                }
                                ?>
                                <?php if ($is_public): ?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: Everyone');?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-public">public</span></a>
                            <?php else:?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: member of %s ',$target[$name_target]['moo_title']);?>"> <span class="feed_time-icon material-icons moo-icon moo-icon-people">people</span></a>
                            <?php endif; ?>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>

            <div class="activity_feed_content_text" id="activity_feed_content_text_<?php echo $activity['Activity']['id'];?>">
                <?php echo $this->element('activity/content/' . $activity['Activity']['action'], array('activity' => $activity,'object'=>$object),$options); ?>
            </div>
        </div>
        <?php if($activity['Activity']['params'] != 'no-comments'): ?>
        <div class="feed_comment_info">
            <?php if ( (!($activity['Activity']['item_type'] == 'Topic_Topic' && isset($object['Topic']) && $object['Topic']['locked']) ) || (!empty($cuser) && $cuser['Role']['is_admin']) ): ?>
                <?php if ( !isset($is_member) || $is_member || ($uid && $cuser['Role']['is_admin']) ): ?>
                    <?php if($check_privacy_type && ((isset($groupTypeItem) && $groupTypeItem['is_member']) || (!isset($groupTypeItem)) )) : ?>
                        <?php if ( $activity['Activity']['params'] == 'item' && (isset($object[$name]['like_count']))): ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeReview', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['item_id'], 'like_count' => $object[$name]['like_count']), 'item_type' => $item_type ))); ?>
                        <?php else: ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeReview', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['id'], 'like_count' => $activity['Activity']['like_count']), 'item_type' => 'activity' ))); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="feed-action">
                    <?php if ( $activity['Activity']['params'] == 'mobile' ) echo __('via mobile'); ?>
                    <?php if ( !isset($is_member) || $is_member || ($uid && $cuser['Role']['is_admin'] )): ?>
                        <?php if($check_privacy_type && ((isset($groupTypeItem) && $groupTypeItem['is_member']) || (!isset($groupTypeItem)) )) : ?>
                        <div class="like-action">
                            <?php if ( $activity['Activity']['params'] == 'item' && (isset($object[$name]['like_count']))): ?>
                                <?php $activity_item_type = $item_type ?>
                                <?php if(empty($hide_like)): ?>
                                <div class="act-item act-item-like">
                                    <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['item_id']?>" data-type="<?php echo $item_type?>" data-status="1" id="<?php echo $item_type?>_l_<?php echo $activity['Activity']['item_id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity['Likes'][$uid] ) ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                    </a>
                                    <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, $item_type, $activity['Activity']['item_id'])),
                                            'title' => __('People Who Like This'),
                                            'innerHtml'=> '<span id="'. $item_type . '_like_' . $activity['Activity']['item_id'] . '" class="act-item-txt">' . $object[$name]['like_count'] . '</span>',
                                            'data-dismiss' => 'modal',
                                            'class' => 'act-item-text'
                                        ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if(empty($hide_dislike)): ?>
                                <div class="act-item act-item-dislike">
                                    <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['item_id']?>" data-type="<?php echo $item_type?>" data-status="0" id="<?php echo $item_type?>_d_<?php echo $activity['Activity']['item_id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $activity['Likes'][$uid] ) && $activity['Likes'][$uid] == 0 ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                    </a>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, $item_type, $activity['Activity']['item_id'],1)),
                                        'title' => __('People Who Dislike This'),
                                        'innerHtml'=> '<span id="'.  $item_type . '_dislike_' . $activity['Activity']['item_id'] . '" class="act-item-txt">' . $object[$name]['dislike_count'] . '</span>',
                                        'class' => 'act-item-text'
                                    ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeButton', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['item_id'], 'like_count' => $object[$name]['like_count']), 'item_type' => $item_type ))); ?>
                            <?php else: ?>
                                <?php $activity_item_type = 'activity' ?>
                                <?php if(empty($hide_like)): ?>
                                <div class="act-item act-item-like">
                                    <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['id']?>" data-type="activity" data-status="1" id="activity_l_<?php echo $activity['Activity']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity_likes['activity_likes'][$activity['Activity']['id']] ) ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                    </a>
                                    <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'activity', $activity['Activity']['id'])),
                                            'title' => __('People Who Like This'),
                                            'innerHtml'=> '<span id="activity_like_'. $activity['Activity']['id']. '" class="act-item-txt">' . $activity['Activity']['like_count'] . '</span>',
                                            'data-dismiss' => 'modal',
                                            'class' => 'act-item-text'
                                        ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if(empty($hide_dislike)): ?>
                                <div class="act-item act-item-dislike">
                                    <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['id']?>" data-type="activity" data-status="0" id="activity_d_<?php echo $activity['Activity']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $activity_likes['activity_likes'][$activity['Activity']['id']] ) && $activity_likes['activity_likes'][$activity['Activity']['id']] == 0 ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                    </a>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'activity', $activity['Activity']['id'],1)),
                                        'title' => __('People Who Dislike This'),
                                        'innerHtml'=> '<span id="activity_dislike_' . $activity['Activity']['id'] . '" class="act-item-txt">' .  $activity['Activity']['dislike_count'] . '</span>',
                                        'class' => 'act-item-text'
                                    ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeButton', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['id'], 'like_count' => $activity['Activity']['like_count']), 'item_type' => 'activity' ))); ?>
                            <?php endif; ?>
                            <?php if(!$is_close_comment || $is_owner):?>
                                <div class="act-item act-item-comment">
                                    <a <?php if (isset($is_search) && $is_search): ?> href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>"<?php else:?>href="javascript:void(0)" class="showCommentForm"<?php endif;?> data-id="<?php echo $activity['Activity']['id']?>">
                                    <span class="act-item-symbol">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-comment">comment</span>
                                    </span>
                                        <span class="act-item-text">
                                        <span class="act-item-txt"><?php echo __('Comment')?></span>
                                    </span>
                                    </a>
                                </div>
                            <?php endif;?>
                            <?php echo $this->element('share', array('activity' => $activity)); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderShareButton', $this,array('uid' => $uid, 'activity' => $activity, 'item' => $object, 'item_name' => $name, 'item_type' => $activity_item_type ))); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if( (isset($groupTypeItem) && $groupTypeItem['is_member']) || (!isset($groupTypeItem)) ) : ?>
                <?php $showFormComment = true; ?>
                <div class="comment_holder comment_chrono activity_comments" id="comments_<?php echo $activity['Activity']['id']?>" <?php if (empty($activity['ActivityComment']) && empty($activity['PhotoComment']) && empty($activity['Activity']['like_count']) && empty($activity['ItemComment']) && ( $activity['Activity']['params'] != 'item' || empty($object[$name]['like_count']) )  && (!$is_close_comment || (isset($is_member) && !$is_member && !empty($cuser) && !$cuser['Role']['is_admin']) || empty($uid) )) {echo 'style="display:none"';$showFormComment = false;} ?>>

                <?php // item comments
                    if ( !empty($activity['ItemComment']) ):
                ?>
                    <?php if ( !empty( $activity['CommentIsLoadMore'] )): ?>
                    <div id="all_comments_<?php echo $activity['Activity']['id']?>" class="comment_view-all">
                        <span class="comment_view-icon material-icons moo-icon moo-icon-comment">comment</span><a href="javascript:void(0)" class="showAllComments" data-id="<?php echo $activity['Activity']['id']?>" data-target="<?php echo $activity['Activity']['item_id']?>" data-type="<?php echo $activity['Activity']['item_type']?>"  data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-page="1" data-total="<?php echo $activity['CommentIsLoadMore']?>"><?php echo __('View more comments')?></a>
                    </div>
                    <?php endif; ?>
                    <div class="comment_lists comment_parent_lists">
                        <?php
                            $ItemComment = $activity['ItemComment'];
                            foreach ($ItemComment as $comment):
                                $link = json_decode($comment['Comment']['params'],true);
                                $url = (isset($link['url']) ? $link['url'] : '#');
                        ?>
                        <div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
                            <?php // delete link available for activity poster, site admin and admins array
                                if ( $comment['Comment']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $admins_current ) && in_array( $uid, $admins_current ) ) ):
                            ?>
                            <div class="comment-option">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                                        <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($comment['Comment']['user_id'] == $uid || $cuser['Role']['is_admin']):?>
                                            <li>
                                                <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="0" class="editItemComment">
                                                    <?php echo __('Edit Comment'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="admin-or-owner-confirm-delete-item-comment removeItemComment" href="javascript:void(0)" data-photo-comment="0" data-id="<?php echo $comment['Comment']['id']?>" >
                                                <?php echo __('Delete Comment'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="comment-outer">
                                <div class="comment-avatar">
                                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $comment))); ?>
                                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                                        <?php echo $comment_reply_creator->result['image'];?>
                                    <?php else:?>
                                        <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']), array( 'prefix' => '50_square', 'tooltip' => true, 'class' => 'user_avatar_link'), array('class' => 'user_avatar'))?>
                                    <?php endif;?>
                                </div>
                                <div class="comment-inner">
                                    <div class="comment-user-name">
                                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                                            <?php echo $comment_reply_creator->result['name'];?>
                                        <?php else:?>
                                            <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                                        <?php endif;?>
                                    </div>
                                    <div class="comment-content-text" id="item_feed_comment_text_<?php echo $comment['Comment']['id']?>">
                                        <?php echo $this->viewMore(h($comment['Comment']['message']),null,null,null,true,array('no_replace_ssl'=>1)); ?>

                                        <?php if ($comment['Comment']['thumbnail']):?>
                                            <div class="comment_thumb">
                                                <a href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
                                                    <?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
                                                        <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                                    <?php else: ?>
                                                        <?php echo $this->Moo->getImage($comment,array('class' => 'comment-img','prefix'=>'200'));?>
                                                    <?php endif; ?>
                                                </a>
                                            </div>
                                        <?php endif;?>
                                        <?php if ( !empty( $link['title'] ) ):?>
                                            <div class="activity_item comment_item">
                                                <?php if ( !empty( $link['image'] ) ): ?>
                                                    <div class="activity_left">
                                                    <?php
                                                    if ( strpos( $link['image'], 'http' ) === false ):
                                                        $link_image = $this->storage->getUrl($comment['Comment']["id"],'',$link['image'],"links") ;
                                                    else:
                                                        $link_image = $link['image'];
                                                    endif;
                                                    ?>
                                                    <img src="<?php echo $link_image ?>" class="activity-img">
                                                </div>
                                                <?php endif; ?>
                                                <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right <?php endif; ?>">
                                                    <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                                                        <?php echo h($link['title'])?>
                                                    </a>
                                                    <?php
                                                    if ( !empty( $link['description'] ) )
                                                        echo '<div class="activity_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                                                    ?>
                                                </div>
                                            </div>
                                        <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
                                            <div class="comment_thumb">
                                                <a data-dismiss="modal" href="<?php echo $link['image'] ?>"><img src="<?php echo $link['image'] ?>" class="comment-img"></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('uid' => $uid,'comment' => $comment))); ?>
                                    </div>
                                    <div class="comment-action-list">
                                        <div class="comment-action">
                                            <div class="like-action">
                                                <div class="act-item comment-time">
                                                    <a href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>/comment_id:<?php echo $comment['Comment']['id']?>">
                                                        <?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?>
                                                    </a>
                                                </div>
                                                <?php if(empty($hide_like)): ?>
                                                <div class="act-item act-item-like">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="1"  id="comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity_likes['item_comment_likes'][$comment['Comment']['id']] ) ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                                    </a>
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                                        'title' => __('People Who Like This'),
                                                        'innerHtml'=> '<span id="comment_like_'.  $comment['Comment']['id'] . '" class="act-item-txt">' . $comment['Comment']['like_count'] . '</span>',
                                                        'data-dismiss' => 'modal',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if(empty($hide_dislike)): ?>
                                                <div class="act-item act-item-dislike">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="0" id="comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $activity_likes['item_comment_likes'][$comment['Comment']['id']] ) && $activity_likes['item_comment_likes'][$comment['Comment']['id']] == 0 ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                                    </a>
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'],1)),
                                                        'title' => __('People Who Dislike This'),
                                                        'innerHtml'=> '<span id="comment_dislike_' .  $comment['Comment']['id'] . '" class="act-item-txt">' . $comment['Comment']['dislike_count'] . '</span>',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment['Comment'], 'item_type' => 'comment' ))); ?>
                                                <?php if($can_reply && $check_privacy_type):?>
                                                    <div class="act-item act-item-reply">
                                                        <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-activity="<?php echo $activity['Activity']['id'];?>">
                                                        <span class="act-item-symbol">
                                                            <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                                        </span>
                                                            <span class="act-item-text">
                                                            <span class="act-item-txt"><?php echo __('Reply');?></span>
                                                        </span>
                                                        </a>
                                                    </div>
                                                <?php endif;?>
                                                <div id="history_item_comment_<?php echo $comment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['Comment']['edited']) ? 'display:none;' : ''; ?>">
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                                        'title' => __('Show edit history'),
                                                        'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_item_comment-text">'.$historyModel->getText('comment',$comment['Comment']['id']).'</span></span>',
                                                        'class' => 'edit-btn',
                                                        'data-dismiss'=>'modal'
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment_reply-holder <?php echo ! empty($comment['Replies']) ? 'isLoadNew' : '';?>" id="comments_reply_<?php echo $comment['Comment']['id']?>">
                                <?php if(!empty($comment['RepliesIsLoadMore']) && $comment['RepliesIsLoadMore']):?>
                                    <div class="comment_reply_more">
                                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment"  data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                            <?php echo __('View all replies'); ?>
                                        </a>
                                    </div>
                                <?php endif;?>

                                <?php if($can_reply && $check_privacy_type):?>
                                <div class="new_reply_comment" style="display:none;" id="newComment_reply_<?php echo $comment['Comment']['id']?>">
                                    <div class="comment-form">
                                        <div class="comment-form-left">
                                            <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                        </div>
                                        <div class="comment-form-right">
                                            <div class="comment-form-main">
                                                <div class="comment-form-area">
                                                    <div class="post-area">
                                                        <div class="post-area-text">
                                                            <?php echo $this->Form->textarea("commentReplyForm".$comment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['Comment']['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), true) ?>
                                                        </div>
                                                        <div class="post-area-action">
                                                            <div class="post-area-icons">
                                                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                                                <div id="commentReplyForm<?php echo $comment['Comment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                                <?php if ( !empty( $uid ) ): ?>
                                                                    <div id="comment_reply_button_attach_<?php echo $comment['Comment']['id'];?>" class="post-area-box"></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($this->request->is('ajax')): ?>
                                                        <script>
                                                            require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                                mooToggleEmoji.init('commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                            });
                                                        </script>
                                                    <?php else: ?>
                                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                                        mooToggleEmoji.init('commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                        <?php $this->Html->scriptEnd();  ?>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ( !empty( $uid ) ): ?>
                                                <div class="comment-form-button commentButton" id="commentReplyButton_<?php echo $comment['Comment']['id']?>">
                                                    <a href="javascript:void(0)"  class="btn btn-submit_reply btn-cs activity_reply_comment" data-id="<?php echo $comment['Comment']['id'];?>" data-type="comment">
                                                        <span class="btn-cs-main">
                                                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                                            <span class="btn-text"><?php echo __('Post') ?></span>
                                                        </span>
                                                    </a>
                                                    <?php if($this->request->is('ajax')): ?>
                                                        <script type="text/javascript">
                                                            require(["jquery","mooAttach"], function($,mooAttach) {
                                                                mooAttach.registerAttachCommentReplay(<?php echo $comment['Comment']['id'];?>);
                                                            });
                                                        </script>
                                                    <?php else: ?>
                                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                                        mooAttach.registerAttachCommentReplay(<?php echo $comment['Comment']['id'];?>);
                                                        <?php $this->Html->scriptEnd(); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                            <?php if ( empty( $uid ) ): ?>
                                            <div class="comment-form-message">
                                                <?php echo __('Please login or register')?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="comment-form-attach">
                                                <input type="hidden" id="comment_reply_image_<?php echo $comment['Comment']['id'];?>">
                                                <div id="comment_reply_preview_image_<?php echo $comment['Comment']['id'];?>" class="comment_attach_image"></div>
                                                <div class="userTagging-ReplyLink-<?php echo $comment['Comment']['id']?>" style="display: none;">
                                                    <input type="hidden" name="data[userCommentLink]" id="userReplyLink<?php echo $comment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                                </div>
                                                <div class="userTagging-ReplyVideo-<?php echo $comment['Comment']['id']?>" style="display: none;">
                                                    <input type="hidden" name="data[userCommentVideo]" id="userReplyVideo<?php echo $comment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class="comment_lists comment_reply_lists">
                                    <?php if(!empty($comment['Replies'])):
                                        $data['comments'] = $comment['Replies'];
                                        $data['comment_likes'] = $comment['RepliesCommentLikes'];
                                        $data['bIsCommentloadMore'] = 0;
                                        $data['subject'] = $activity;
                                        $blockCommentId = 'comments_reply_'. $comment['Comment']['id'];
                                        ?>
                                        <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => (($can_reply && $check_privacy_type) ? 0 : 1)));?>
                                    <?php endif;?>
                                </div>

                                <?php if ($comment['Comment']['count_reply'] && empty($comment['Replies'])):?>
                                <div class="comment_reply_more">
                                    <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                        <?php
                                        if ($comment['Comment']['count_reply'] == 1)
                                            echo $comment['Comment']['count_reply']. ' '. __('Reply');
                                        else
                                            echo $comment['Comment']['count_reply']. ' '. __('Replies');
                                        ?>
                                    </a>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php // photo comments
                    elseif(!empty($activity['PhotoComment'])):
                ?>
                    <?php if ( !empty( $activity['CommentIsLoadMore'] )): ?>
                    <div id="all_comments_<?php echo $activity['Activity']['id']?>" class="comment_view-all">
                        <span class="comment_view-icon material-icons moo-icon moo-icon-comment">comment</span><a href="javascript:void(0)" class="showAllComments" data-id="<?php echo $activity['Activity']['id']?>" data-target="<?php echo $activity['Activity']['items']?>" data-type="Photo_Photo"  data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-page="1" data-total="<?php echo $activity['CommentIsLoadMore']?>"><?php echo __('View more comments')?></a>
                    </div>
                    <?php endif; ?>
                    <div class="comment_lists comment_parent_lists">
                        <?php foreach ($activity['PhotoComment'] as $key => $comment):
                            $link = json_decode($comment['Comment']['params'], true);
                            $url = (isset($link['url']) ? $link['url'] : '#');
                        ?>
                        <div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
                            <?php // delete link available for activity poster, site admin and admins array
                                if ( $comment['Comment']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $admins_current ) && in_array( $uid, $admins_current ) ) ):
                            ?>
                            <div class="comment-option">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                                        <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($comment['Comment']['user_id'] == $uid || $cuser['Role']['is_admin']):?>
                                        <li>
                                            <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="1" class="editItemComment">
                                                <?php echo __('Edit Comment'); ?>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="removeItemComment" href="javascript:void(0)" data-photo-comment="1" data-id="<?php echo $comment['Comment']['id']?>" >
                                                <?php echo __('Delete Comment'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="comment-outer">
                                <div class="comment-avatar">
                                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $comment))); ?>
                                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                                        <?php echo $comment_reply_creator->result['image'];?>
                                    <?php else:?>
                                        <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array('class' => 'user_avatar_link', 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                    <?php endif;?>
                                </div>
                                <div class="comment-inner">
                                    <div class="comment-user-name">
                                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                                            <?php echo $comment_reply_creator->result['name'];?>
                                        <?php else:?>
                                            <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                                        <?php endif;?>
                                    </div>
                                    <div class="comment-content-text" id="photo_feed_comment_text_<?php echo $comment['Comment']['id']?>">
                                        <?php echo $this->viewMore(h($comment['Comment']['message']),null,null,null,true,array('no_replace_ssl'=>1)); ?>

                                        <?php if ($comment['Comment']['thumbnail']):?>
                                        <div class="comment_thumb">
                                            <a href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
                                                <?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
                                                    <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                                <?php else: ?>
                                                    <?php echo $this->Moo->getImage($comment,array('class' => 'comment-img', 'prefix'=>'200'));?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <?php endif;?>

                                        <?php if ( !empty( $link['title'] ) ):?>
                                            <div class="activity_item comment_item">
                                                <?php if ( !empty( $link['image'] ) ): ?>
                                                    <div class="activity_left">
                                                    <?php
                                                    if ( strpos( $link['image'], 'http' ) === false ):
                                                        $link_image = $this->storage->getUrl($comment['Comment']["id"],'',$link['image'],"links") ;
                                                    else:
                                                        $link_image = $link['image'];
                                                    endif;
                                                    ?>
                                                    <img src="<?php echo $link_image ?>" class="activity-img">
                                                </div>
                                                <?php endif; ?>
                                                <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right <?php endif; ?>">
                                                    <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                                                        <?php echo h($link['title'])?>
                                                    </a>
                                                    <?php
                                                    if ( !empty( $link['description'] ) )
                                                        echo '<div class="activity_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                                                    ?>
                                                </div>
                                            </div>
                                        <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
                                            <div class="comment_thumb">
                                                <a data-dismiss="modal" href="<?php echo $link['image'] ?>"><img src="<?php echo $link['image'] ?>" class="comment-img"></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('comment' => $comment))); ?>
                                    </div>
                                    <div class="comment-action-list">
                                        <div class="comment-action">
                                            <div class="like-action">
                                                <div class="act-item comment-time">
                                                    <a href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>/comment_id:<?php echo $comment['Comment']['id']?>">
                                                        <?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?>
                                                    </a>
                                                </div>
                                                <?php if(empty($hide_like)): ?>
                                                <div class="act-item act-item-like">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="photo_comment" data-status="1" id="photo_comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity_likes['photo_comment_likes'][$comment['Comment']['id']] ) ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                                    </a>
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                                        'title' => __('People Who Like This'),
                                                        'innerHtml'=> '<span id="photo_comment_like_'.  $comment['Comment']['id'] . '" class="act-item-txt">' . $comment['Comment']['like_count'] . '</span>',
                                                        'data-dismiss' => 'modal',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if(empty($hide_dislike)): ?>
                                                <div class="act-item act-item-dislike">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="photo_comment" data-status="0" id="photo_comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $comment['Comment']['dislike_count'] ) ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                                    </a>
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'],1)),
                                                        'title' => __('People Who Dislike This'),
                                                        'innerHtml'=> '<span id="photo_comment_dislike_' .  $comment['Comment']['id'] . '" class="act-item-txt">' . $comment['Comment']['dislike_count'] . '</span>',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'photo_comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'photo_comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment['Comment'], 'item_type' => 'photo_comment' ))); ?>
                                                <?php if($can_reply && $check_privacy_type):?>
                                                    <div class="act-item act-item-reply">
                                                        <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-activity="<?php echo $activity['Activity']['id'];?>">
                                                        <span class="act-item-symbol">
                                                            <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                                        </span>
                                                            <span class="act-item-text">
                                                            <span class="act-item-txt"><?php echo __('Reply');?></span>
                                                        </span>
                                                        </a>
                                                    </div>
                                                <?php endif;?>
                                                <div id="history_item_comment_<?php echo $comment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['Comment']['edited']) ? 'display:none;' : ''; ?>">
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                                        'title' => __('Show edit history'),
                                                        'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_item_comment-text">'.$historyModel->getText('comment',$comment['Comment']['id']).'</span></span>',
                                                        'class' => 'edit-btn',
                                                        'data-dismiss'=>'modal'
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment_reply-holder <?php echo ! empty($comment['Replies']) ? 'isLoadNew' : '';?>"  id="comments_reply_<?php echo $comment['Comment']['id']?>">
                                <?php if(!empty($comment['RepliesIsLoadMore']) && $comment['RepliesIsLoadMore']):?>
                                <div class="comment_reply_more">
                                    <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                        <?php echo __('View all replies'); ?>
                                    </a>
                                </div>
                                <?php endif;?>

                                <?php if($can_reply && $check_privacy_type):?>
                                    <div class="new_reply_comment" style="display:none;" id="newComment_reply_<?php echo $comment['Comment']['id']?>">
                                        <div class="comment-form">
                                            <div class="comment-form-left">
                                                <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                            </div>
                                            <div class="comment-form-right">
                                                <div class="comment-form-main">
                                                    <div class="comment-form-area">
                                                        <div class="post-area">
                                                            <div class="post-area-text">
                                                                <?php echo $this->Form->textarea("commentReplyForm".$comment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['Comment']['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), true) ?>
                                                            </div>
                                                            <div class="post-area-action">
                                                                <div class="post-area-icons">
                                                                    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                                                    <div id="commentReplyForm<?php echo $comment['Comment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                                    <?php if ( !empty( $uid ) ): ?>
                                                                        <div id="comment_reply_button_attach_<?php echo $comment['Comment']['id'];?>" class="post-area-box"></div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if($this->request->is('ajax')): ?>
                                                            <script>
                                                                require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                                    mooToggleEmoji.init('commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                                });
                                                            </script>
                                                        <?php else: ?>
                                                            <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                                            mooToggleEmoji.init('commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                            <?php $this->Html->scriptEnd();  ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if ( !empty( $uid ) ): ?>
                                                    <div class="comment-form-button commentButton" id="commentReplyButton_<?php echo $comment['Comment']['id']?>">
                                                        <a href="javascript:void(0)" class="btn btn-submit_reply btn-cs activity_reply_comment" data-id="<?php echo $comment['Comment']['id'];?>" data-type="comment">
                                                            <span class="btn-cs-main">
                                                                <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                                                <span class="btn-text"><?php echo __('Post') ?></span>
                                                            </span>
                                                        </a>
                                                        <?php if($this->request->is('ajax')): ?>
                                                            <script type="text/javascript">
                                                                require(["jquery","mooAttach"], function($,mooAttach) {
                                                                    mooAttach.registerAttachCommentReplay(<?php echo $comment['Comment']['id'];?>);
                                                                });
                                                            </script>
                                                        <?php else: ?>
                                                            <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                                            mooAttach.registerAttachCommentReplay(<?php echo $comment['Comment']['id'];?>);
                                                            <?php $this->Html->scriptEnd(); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                                <?php if ( empty( $uid ) ): ?>
                                                <div class="comment-form-message">
                                                    <?php echo __('Please login or register')?>
                                                </div>
                                                <?php endif; ?>
                                                <div class="comment-form-attach">
                                                    <input type="hidden" id="comment_reply_image_<?php echo $comment['Comment']['id'];?>">
                                                    <div id="comment_reply_preview_image_<?php echo $comment['Comment']['id'];?>" class="comment_attach_image"></div>
                                                    <div class="userTagging-ReplyLink-<?php echo $comment['Comment']['id']?>" style="display: none;">
                                                        <input type="hidden" name="data[userCommentLink]" id="userReplyLink<?php echo $comment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                                    </div>
                                                    <div class="userTagging-ReplyVideo-<?php echo $comment['Comment']['id']?>" style="display: none;">
                                                        <input type="hidden" name="data[userCommentVideo]" id="userReplyVideo<?php echo $comment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>

                                <div class="comment_lists comment_reply_lists">
                                    <?php if(!empty($comment['Replies'])):
                                        $data['comments'] = $comment['Replies'];
                                        $data['comment_likes'] = $comment['RepliesCommentLikes'];
                                        $data['bIsCommentloadMore'] = 0;
                                        $data['subject'] = $activity;
                                        $blockCommentId = 'comments_reply_'.$comment['Comment']['id'];
                                        ?>
                                        <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => (($can_reply && $check_privacy_type) ? 0 : 1)));?>
                                    <?php endif;?>
                                </div>

                                <?php if ($comment['Comment']['count_reply'] && empty($comment['Replies'])):?>
                                <div class="comment_reply_more">
                                    <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                        <?php
                                        if ($comment['Comment']['count_reply'] == 1)
                                            echo $comment['Comment']['count_reply']. ' '. __('Reply');
                                        else
                                            echo $comment['Comment']['count_reply']. ' '. __('Replies');
                                        ?>
                                    </a>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (!empty($activity['ActivityComment'])): ?>
                    <?php if ( !empty( $activity['CommentIsLoadMore'] )): ?>
                        <div id="all_comments_<?php echo $activity['Activity']['id']?>" class="comment_view-all">
                            <span class="comment_view-icon material-icons moo-icon moo-icon-comment">comment</span><a href="javascript:void(0)" class="showAllComments" data-id="<?php echo $activity['Activity']['id']?>" data-target="0" data-type="activity"  data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-page="1" data-total="<?php echo $activity['CommentIsLoadMore']?>"><?php echo __('View more comments')?></a>
                        </div>
                    <?php endif; ?>
                    <div class="comment_lists comment_parent_lists">
                        <?php
                            foreach ($activity['ActivityComment'] as $key => $comment):
                                $link = json_decode($comment['params'],true);
                                $url = (isset($link['url']) ? $link['url'] : '#');
                        ?>
                        <div id="comment_<?php echo $comment['id']?>" class="comment-item">
                            <?php // delete link available for activity poster, site admin and admins array
                                if ( ($comment['user_id'] == $uid) || ($activity['Activity']['user_id'] == $uid) || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $admins_current ) && in_array( $uid, $admins_current ) ) ):
                            ?>
                            <div class="comment-option">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                                        <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($comment['user_id'] == $uid || $cuser['Role']['is_admin']):?>
                                        <li>
                                            <a href="javascript:void(0)" class="editActivityComment" data-activity-comment-id="<?php echo $comment['id']?>" >
                                                <?php echo __('Edit Comment'); ?>
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="removeActivityComment" data-activity-comment-id="<?php echo $comment['id']?>" href="javascript:void(0)"  >
                                                <?php echo __('Delete Comment'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="comment-outer">
                                <div class="comment-avatar">
                                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $comment))); ?>
                                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                                        <?php echo $comment_reply_creator->result['image'];?>
                                    <?php else:?>
                                        <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array('class' => 'user_avatar_link', 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                    <?php endif;?>
                                </div>
                                <div class="comment-inner">
                                    <div class="comment-user-name">
                                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                                            <?php echo $comment_reply_creator->result['name'];?>
                                        <?php else:?>
                                            <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                                        <?php endif;?>
                                    </div>
                                    <div class="comment-content-text" id="activity_feed_comment_text_<?php echo $comment['id']?>">
                                        <?php echo $this->viewMore(h($comment['comment']),null,null,null,true,array('no_replace_ssl'=>1)); ?>

                                        <?php if ($comment['thumbnail']):?>
                                        <div class="comment_thumb">
                                            <a href="<?php echo $this->Moo->getImageUrl(array('ActivityComment'=>$comment),array());?>">
                                                <?php if($this->Moo->isGifImage($this->Moo->getImageUrl(array('ActivityComment'=>$comment),array()))) :  ?>
                                                    <?php echo $this->Moo->getImage(array('ActivityComment'=>$comment),array('class'=>'comment-img gif_image'));?>
                                                <?php else: ?>
                                                    <?php echo $this->Moo->getImage(array('ActivityComment'=>$comment),array('class' => 'comment-img', 'prefix'=>'200'));?>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <?php endif;?>

                                        <?php if ( !empty( $link['title'] ) ):?>
                                            <div class="activity_item comment_item">
                                                    <?php if ( !empty( $link['image'] ) ): ?>
                                                        <div class="activity_left">
                                                            <?php
                                                            if ( strpos( $link['image'], 'http' ) === false ):
                                                                $link_image = $this->storage->getUrl($comment["id"],'',$link['image'],"links") ;
                                                            else:
                                                                $link_image = $link['image'];
                                                            endif;
                                                            ?>
                                                            <img src="<?php echo $link_image ?>" class="activity-img">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right <?php endif; ?>">
                                                        <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                                                            <?php echo h($link['title'])?>
                                                        </a>
                                                        <?php
                                                        if ( !empty( $link['description'] ) )
                                                            echo '<div class="activity_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                                                        ?>
                                                    </div>
                                                </div>
                                        <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
                                            <div class="comment_thumb">
                                                    <a data-dismiss="modal" href="<?php echo $link['image'] ?>"><img src="<?php echo $link['image'] ?>" class="comment-img"></a>
                                                </div>
                                        <?php endif; ?>
                                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('comment' => $comment))); ?>
                                    </div>
                                    <div class="comment-action-list">
                                        <div class="comment-action">
                                            <div class="like-action">
                                                <div class="act-item comment-time">
                                                    <a href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>/comment_id:<?php echo $comment['id']?>">
                                                        <?php echo $this->Moo->getTime( $comment['created'], Configure::read('core.date_format'), $utz )?>
                                                    </a>
                                                </div>
                                                <?php if(empty($hide_like)): ?>
                                                <div class="act-item act-item-like">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-status="1" id="core_activity_comment_l_<?php echo $comment['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity_likes['comment_likes'][$comment['id']] ) ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                                    </a>

                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'core_activity_comment', $comment['id'])),
                                                        'title' => __('People Who Like This'),
                                                        'innerHtml'=> '<span id="core_activity_comment_like_'. $comment['id'] . '" class="act-item-txt">' . $comment['like_count'] . '</span>',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if(empty($hide_dislike)): ?>
                                                <div class="act-item act-item-dislike">
                                                    <a href="javascript:void(0)" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-status="0" id="core_activity_comment_d_<?php echo $comment['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $activity_likes['comment_likes'][$comment['id']] ) && $activity_likes['comment_likes'][$comment['id']] == 0 ): ?>active<?php endif; ?>">
                                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                                    </a>
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'core_activity_comment', $comment['id'],1)),
                                                        'title' => __('People Who Dislike This'),
                                                        'innerHtml'=> '<span id="core_activity_comment_dislike_'. $comment['id'] . '" class="act-item-txt">' .  $comment['dislike_count'] . '</span>',
                                                        'class' => 'act-item-text'
                                                    ));
                                                    ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['id'], 'like_count' => $comment['like_count']), 'item_type' => 'core_activity_comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['id'], 'like_count' => $comment['like_count']), 'item_type' => 'core_activity_comment' ))); ?>
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment, 'item_type' => 'core_activity_comment' ))); ?>
                                                <?php if($can_reply && $check_privacy_type):?>
                                                    <div class="act-item act-item-reply">
                                                        <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-activity="<?php echo $activity['Activity']['id'];?>">
                                                        <span class="act-item-symbol">
                                                            <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                                        </span>
                                                            <span class="act-item-text">
                                                            <span class="act-item-txt"><?php echo __('Reply');?></span>
                                                        </span>
                                                        </a>
                                                    </div>
                                                <?php endif;?>
                                                <div id="history_activity_comment_<?php echo $comment['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['edited']) ? 'display:none;' : ''; ?>">
                                                    <?php
                                                    $this->MooPopup->tag(array(
                                                        'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'core_activity_comment', $comment['id'])),
                                                        'title' => __('Show edit history'),
                                                        'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_activity_comment-text">'.$historyModel->getText('core_activity_comment',$comment['id']).'</span></span>',
                                                        'class' => 'edit-btn',
                                                        'data-dismiss'=>'modal'
                                                    ));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="comment_reply-holder <?php echo ! empty($comment['Replies']) ? 'isLoadNew' : '';?>" id="activitycomments_reply_<?php echo $comment['id']?>">
                                <?php if(!empty($comment['RepliesIsLoadMore']) && $comment['RepliesIsLoadMore']):?>
                                <div class="comment_reply_more">
                                    <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1 ?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                        <?php echo __('View all replies'); ?>
                                    </a>
                                </div>
                                <?php endif;?>

                                <?php if($can_reply && $check_privacy_type):?>
                                <div class="new_reply_comment" style="display:none;"  id="activitynewComment_reply_<?php echo $comment['id']?>">
                                    <div class="comment-form">
                                        <div class="comment-form-left">
                                            <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                        </div>
                                        <div class="comment-form-right">
                                            <div class="comment-form-main">
                                                <div class="comment-form-area">
                                                    <div class="post-area">
                                                        <div class="post-area-text">
                                                            <?php echo $this->Form->textarea("activitycommentReplyForm".$comment['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), true) ?>
                                                        </div>
                                                        <div class="post-area-action">
                                                            <div class="post-area-icons">
                                                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'activitycommentReplyForm' ,'id'=>$comment['id']))); ?>
                                                                <div id="activitycommentReplyForm<?php echo $comment['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                                <?php if ( !empty( $uid ) ): ?>
                                                                <div id="activitycomment_reply_button_attach_<?php echo $comment['id'];?>" class="post-area-box"></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($this->request->is('ajax')): ?>
                                                        <script>
                                                            require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                                mooToggleEmoji.init('activitycommentReplyForm<?php echo $comment['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                            });
                                                        </script>
                                                    <?php else: ?>
                                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                                        mooToggleEmoji.init('activitycommentReplyForm<?php echo $comment['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                        <?php $this->Html->scriptEnd();  ?>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ( !empty( $uid ) ): ?>
                                                <div class="comment-form-button commentButton" id="activity_commentReplyButton_<?php echo $comment['id']?>">
                                                    <a href="javascript:void(0)"  class="btn btn-submit_reply btn-cs activity_reply_comment" data-id="<?php echo $comment['id'];?>" data-type="core_activity_comment">
                                                        <span class="btn-cs-main">
                                                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                                            <span class="btn-text"><?php echo __('Post') ?></span>
                                                        </span>
                                                    </a>
                                                    <?php if($this->request->is('ajax')): ?>
                                                        <script type="text/javascript">
                                                            require(["jquery","mooAttach"], function($,mooAttach) {
                                                                mooAttach.registerAttachActivityCommentReplay(<?php echo $comment['id'];?>);
                                                            });
                                                        </script>
                                                    <?php else: ?>
                                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                                        mooAttach.registerAttachActivityCommentReplay(<?php echo $comment['id'];?>);
                                                        <?php $this->Html->scriptEnd(); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'activitycommentReplyForm' ,'id'=>$comment['id']))); ?>
                                            <?php if ( empty( $uid ) ): ?>
                                            <div class="comment-form-message">
                                                <?php echo __('Please login or register')?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="comment-form-attach">
                                                <input type="hidden" id="activitycomment_reply_image_<?php echo $comment['id'];?>">
                                                <div id="activitycomment_reply_preview_image_<?php echo $comment['id'];?>" class="comment_attach_image"></div>
                                                <div class="userTagging-ReplyLink-<?php echo $comment['id']?>" style="display: none;">
                                                    <input type="hidden" name="data[userCommentLink]" id="userReplyLink<?php echo $comment['id']?>" value="" autocomplete="off" type="text">
                                                </div>
                                                <div class="userTagging-ReplyVideo-<?php echo $comment['id']?>" style="display: none;">
                                                    <input type="hidden" name="data[userCommentVideo]" id="userReplyVideo<?php echo $comment['id']?>" value="" autocomplete="off" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class="comment_lists comment_reply_lists">
                                    <?php if(!empty($comment['Replies'])):
                                        $data['comments'] = $comment['Replies'];
                                        $data['comment_likes'] = $comment['RepliesCommentLikes'];
                                        $data['bIsCommentloadMore'] = 0;
                                        $data['subject'] = $activity;
                                        $blockCommentId = 'activitycomments_reply_'. $comment['id'];
                                        ?>
                                        <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => (($can_reply && $check_privacy_type) ? 0 : 1)));?>
                                    <?php endif;?>
                                </div>

                                <?php if ($comment['count_reply'] && empty($comment['Replies'])):?>
                                <div class="comment_reply_more">
                                    <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-close="<?php echo ($can_reply && $check_privacy_type) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                                        <?php
                                            if ($comment['count_reply'] == 1)
                                                echo $comment['count_reply']. ' '. __('Reply');
                                            else
                                                echo $comment['count_reply']. ' '. __('Replies');
                                        ?>
                                    </a>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="comment_lists comment_parent_lists"></div>
                <?php endif; ?>

                <!-- Begin Comment Form -->
                <?php if (isset($check_post_status) && $check_post_status): ?>
                    <?php // comment form
                        if ($activity['Activity']['params'] != 'no-comments' && $check_privacy_type && ( (isset($is_member) && $is_member) || (!empty($cuser) && $cuser['Role']['is_admin']) || !($activity['Activity']['item_type'] == 'Topic_Topic' && isset($object['Topic']) && $object['Topic']['locked']))):
                    ?>
                        <?php if($is_close_comment && !$is_owner) :?>
                        <div class="closed-comment"><?php echo __('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User']));?></div>
                        <?php else:?>
                            <?php if($is_close_comment && $is_owner) :?>
                            <div class="closed-comment"><?php echo __('%s turned off commenting for this post. However, you and admin can still post or change it back.', $this->Moo->getName($item_close_comment['User']));?></div>
                            <?php endif;?>
                            <div id="newComment_<?php echo $activity['Activity']['id']?>" class="comment-form-warp">
                                <div class="comment-form">
                                    <div class="comment-form-left">
                                        <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                                    </div>
                                    <div class="comment-form-right">
                                        <div class="comment-form-main">
                                            <div class="comment-form-area">
                                                <div class="post-area">
                                                    <div class="post-area-text">
                                                        <?php echo $this->Form->textarea("commentForm_".$activity['Activity']['id'],array('class' => "post-area-input commentBox showCommentBtn", 'data-id' => $activity['Activity']['id'], 'placeholder' => __('Write a comment...') ), true) ?>
                                                    </div>
                                                    <div class="post-area-action">
                                                        <div class="post-area-icons">
                                                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentForm' ,'id'=>$activity['Activity']['id']))); ?>
                                                            <div id="commentForm_<?php echo $activity['Activity']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                            <?php if ( !empty( $uid ) ): ?>
                                                            <div id="comment_button_attach_<?php echo $activity['Activity']['id'];?>" class="post-area-box"></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($this->request->is('ajax')): ?>
                                                    <script>
                                                        require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                            mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                        });
                                                    </script>
                                                <?php else: ?>
                                                    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                                    mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                    <?php $this->Html->scriptEnd();  ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ( !empty( $uid ) ): ?>
                                            <div class="comment-form-button commentButton" id="commentButton_<?php echo $activity['Activity']['id']?>">
                                                <a href="javascript:void(0)"  <?php if ( $activity['Activity']['params'] == 'item' && isset($object[$name]['comment_count'])): ?> class="btn btn-submit_comment btn-cs viewer-submit-item-comment" data-item-type="<?php echo $item_type?>" data-activity-item-id="<?php echo $activity['Activity']['item_id']?>" data-activity-id="<?php echo $activity['Activity']['id']?>" <?php else: ?> class="btn btn-submit_comment btn-cs viewer-submit-comment" data-activity-id="<?php echo $activity['Activity']['id']?>" <?php endif; ?>>
                                                    <span class="btn-cs-main">
                                                        <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                                        <span class="btn-text"><?php echo __('Post') ?></span>
                                                    </span>
                                                </a>
                                                <?php if($this->request->is('ajax')): ?>
                                                    <script type="text/javascript">
                                                        require(["jquery","mooAttach"], function($,mooAttach) {
                                                            mooAttach.registerAttachComment(<?php echo $activity['Activity']['id'];?>);
                                                        });
                                                    </script>
                                                <?php else: ?>
                                                    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                                    mooAttach.registerAttachComment(<?php echo $activity['Activity']['id'];?>);
                                                    <?php $this->Html->scriptEnd(); ?>
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentForm' ,'id'=>$activity['Activity']['id']))); ?>
                                        <?php if ( empty( $uid ) ): ?>
                                        <div class="comment-form-message">
                                            <?php echo __('Please login or register')?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="comment-form-attach">
                                            <input type="hidden" id="comment_image_<?php echo $activity['Activity']['id'];?>">
                                            <div id="comment_preview_image_<?php echo $activity['Activity']['id'];?>" class="comment_attach_image"></div>
                                            <div class="userTagging-CommentLink-<?php echo $activity['Activity']['id']?>" style="display: none;">
                                                <input type="hidden" name="data[userCommentLink]" id="userCommentLink<?php echo $activity['Activity']['id']?>" value="" autocomplete="off" placeholder="Share link" type="text">
                                            </div>
                                            <div class="userTagging-CommentVideo-<?php echo $activity['Activity']['id']?>" style="display: none;">
                                                <input type="hidden" name="data[userCommentVideo]" id="userCommentVideo<?php echo $activity['Activity']['id']?>" value="" autocomplete="off" placeholder="Share link" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($showFormComment && (!isset($profile_has_activity) || (isset($profile_has_activity) && !$profile_has_activity))): ?>
                                <?php if($this->request->is('ajax')): ?>
                                    <script type="text/javascript">
                                            require(["jquery","mooMention","mooToggleEmoji"], function($, mooMention,mooToggleEmoji) {
                                            mooMention.init('commentForm_<?php echo $activity['Activity']['id']?>');
                                            mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id']?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                        });
                                    </script>
                                <?php else: ?>
                                    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooMention','mooToggleEmoji'), 'object' => array('$', 'mooMention','mooToggleEmoji'))); ?>
                                        mooMention.init('commentForm_<?php echo $activity['Activity']['id']?>');
                                        mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id']?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                    <?php $this->Html->scriptEnd(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif;?>
                    <?php endif; // end comment form ?>
                <?php endif; ?><!-- End Begin Comment Form -->
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderOneFeed', $this,array('index'=>$index))); ?>
<?php
endforeach;
?>
<?php else: ?>
<div class="no-feed"><?php echo __('There are no new feeds to view at this time.')?></div>
<?php endif; ?>

<?php if (isset($bIsACtivityloadMore) && $bIsACtivityloadMore > 0 && count($activities)) :?>
	<?php if (!isset($page)) $page = 1;?>
    <?php $this->Html->viewMore($more_url,'list-content',null,true,$page) ?>
<?php endif; ?>