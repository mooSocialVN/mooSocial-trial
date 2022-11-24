<?php if ($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooActivities", "mooShare"], function($, mooActivities, mooShare) {
        mooActivities.init();
        mooShare.init();
    });

    require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
        mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', "mooActivities", 'mooShare'), 'object' => array('$', "mooActivities", 'mooShare'))); ?>
mooActivities.init();
mooShare.init();
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
mooToggleEmoji.init('commentForm_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
<?php $this->Html->scriptEnd();  ?>

<?php endif; ?>

<?php $this->setCurrentStyle(4);?>
<?php if (!empty($activity)): ?>
<?php 
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
?>
    
<div id="activity_<?php echo $activity['Activity']['id']?>" class="feed-entry-item slide">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_header">
                <div class="activity_feed_image">
                    <?php $event_feed_actor = $this->getEventManager()->dispatch(new CakeEvent('Activities.renderFeedActor', $this, array('activity' => $activity))); ?>
                    <?php if(!empty($event_feed_actor->result['image'])):?>
                        <?php echo $event_feed_actor->result['image'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getItemPhoto(array('User' => $activity['User']),array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
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

                                <div class="feed-option-item">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" data-toggle="dropdown">
                                            <span class="feed-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- New hook -->
                                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.beforeRenderMenuAction', $this,array('activity'=>$activity))); ?>
                                            <!-- New hook -->
                                            <li>
                                                <?php
                                                $this->MooPopup->tag(array(
                                                    'href'=>$this->Html->url(array("controller" => "notifications", "action" => "stop", "plugin" => false, 'activity', $activity['Activity']['id'])),
                                                    'title' => __('Stop Notifications'),
                                                    'innerHtml'=> __('Stop Notifications'),
                                                    'id' => 'stop_notification_activity' . $activity['Activity']['id']
                                                ));
                                                ?>
                                            </li>
                                            <?php if(!empty($activity['UserTagging']['users_taggings']) && $activity['Activity']['user_id'] == $uid): ?>
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

                                            <?php if (isset($activity['UserTagging']['users_taggings']) && in_array($uid, explode(',', $activity['UserTagging']['users_taggings']))): ?>
                                                <li>
                                                    <a href=""><?php echo __('Remove Tags'); ?></a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($activity['Activity']['user_id'] == $uid && $activity['Activity']['action'] == 'wall_post'):?>
                                                <li>
                                                    <a class="editActivity" data-activity-id="<?php echo $activity['Activity']['id']?>" href="javascript:void(0)" >
                                                        <?php echo __('Edit Post'); ?>
                                                    </a>
                                                </li>
                                            <?php endif;?>
                                            <li>
                                                <a class="removeActivity" data-activity-id="<?php echo $activity['Activity']['id']?>" href="javascript:void(0)">
                                                    <?php echo __('Delete Post'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <?php if ( $activity['Activity']['params'] == 'item' && (isset($object[$name]['like_count']))): ?>
                                                    <?php
                                                    $item_close_comment = $this->Moo->getCloseComment($item_id, $item_type);
                                                    if($item_close_comment['status']){
                                                        $title =  __('Open Comment');
                                                        $is_close_comment = 1;
                                                    }else{
                                                        $title =   __('Close Comment');
                                                        $is_close_comment = 0;
                                                    }
                                                    ?>
                                                    <a class="closeComment" data-id="<?php echo $item_id?>" data-type="<?php echo $item_type?>" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
                                                        <?php echo $title; ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php
                                                    $item_close_comment = $this->Moo->getCloseComment($activity['Activity']['id'], 'activity', $activity);
                                                    if($item_close_comment['status']){
                                                        $title =  __('Open Comment');
                                                        $is_close_comment = 1;
                                                    }else{
                                                        $title =   __('Close Comment');
                                                        $is_close_comment = 0;
                                                    }
                                                    ?>
                                                    <a class="closeComment" data-id="<?php echo  $activity['Activity']['id']?>" data-type="activity" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
                                                        <?php echo $title; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                            <?php if (( (!empty($admins) && in_array($uid, $admins) && strtolower($activity['Activity']['type']) != 'user') || $cuser['Role']['is_admin'])): ?>
                                                <?php
                                                $pin_type = '';
                                                if (strtolower($subject_type) != 'user')
                                                {
                                                    $pin_type = 'activity';
                                                    if ($subject_type)
                                                    {
                                                        $pin_type = 'item';
                                                    }
                                                }
                                                ?>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="feed_time">
                        <a class="feed_time-txt" href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>"><?php echo __('Just now')?></a>
                        <?php
                        $this->MooPopup->tag(array(
                            'href'=>$this->Html->url(array("controller" => "histories",
                                "action" => "ajax_show",
                                "plugin" => false,
                                'activity',
                                $activity['Activity']['id']
                            )),
                            'title' => __('Show edit history'),
                            'innerHtml'=> __('Edited'),
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
                            <?php if(($activity['Activity']['user_id'] == $uid || $cuser['Role']['is_admin']) && $activity['Activity']['action'] == 'wall_post'): ?>
                            <span class="feed_time-txt">
                                <div class="dropdown">
                                    <a id="permission_<?php echo $activity['Activity']['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="tip" href="javascript:void(0);" original-title="<?php echo $text;?>"><span class="feed_time-icon material-icons moo-icon moo-icon-<?php echo $icon;?>"><?php echo $icon;?></span>
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
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: %s\'Friends instead of %s\'Friends of friends',$target['User']['moo_title'],$target['User']['moo_title']);?>"><span class="feed_time-icon material-icons moo-icon moo-icon-people">people</span></a>
                            <?php else:?>
                                <a class="feed_time-txt tip" href="javascript:void(0);" original-title="<?php echo __('Shared with: Everyone');?>"><span class="feed_time-icon material-icons moo-icon moo-icon-public">public</span></a>
                            <?php endif;?>

                        <?php endif;?>
                    </div>
                </div>
            </div>

             <div class="activity_feed_content_text" id="activity_feed_content_text_<?php echo $activity['Activity']['id'];?>">
                <?php echo $this->element('activity/content/' . $activity['Activity']['action'], array('activity' => $activity,'object'=>$object),$options); ?>
             </div>
        </div>
        <div class="feed_comment_info">
            <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeReview', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['id'], 'like_count' => 0), 'item_type' => 'activity' ))); ?>
            <div class="feed-action">
                <?php if ( $activity['Activity']['params'] == 'mobile' ) echo __('via mobile'); ?>
                <div class="like-action">
                    <?php if(empty($hide_like)): ?>
                    <div class="act-item act-item-like">
                        <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['id']?>" data-type="activity" data-status="1" id="activity_l_<?php echo $activity['Activity']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                        </a>
                        <span class="act-item-text">
                            <span id="activity_like_<?php echo $activity['Activity']['id']?>" class="act-item-txt">0</span>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if(empty($hide_dislike)): ?>
                    <div class="act-item act-item-dislike">
                        <a href="javascript:void(0)" data-id="<?php echo $activity['Activity']['id']?>" data-type="activity" data-status="0" id="activity_d_<?php echo $activity['Activity']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                        </a>
                        <span class="act-item-text">
                            <span id="activity_dislike_<?php echo $activity['Activity']['id']?>" class="act-item-txt">0</span>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.renderLikeButton', $this,array('uid' => $uid,'activity' => array('id' => $activity['Activity']['id'], 'like_count' => 0), 'item_type' => 'activity' ))); ?>
                    <div class="act-item act-item-comment">
                        <a href="javascript:void(0)" class="showCommentForm" data-id="<?php echo $activity['Activity']['id']?>">
                            <span class="act-item-symbol">
                                <span class="act-item-icon material-icons moo-icon moo-icon-comment">comment</span>
                            </span>
                            <span class="act-item-text">
                                <span class="act-item-txt"><?php echo __('Comment')?></span>
                            </span>
                        </a>
                    </div>
                    <?php echo $this->element('share', array('activity' => $activity)); ?>
                    <?php $this->getEventManager()->dispatch(new CakeEvent('element.activities.afterRenderShareButton', $this,array('uid' => $uid, 'activity' => $activity, 'item' => $object, 'item_name' => $name, 'item_type' => 'activity' ))); ?>
                </div>
            </div>
            <div class="comment_holder activity_comments" style="display:none" id="comments_<?php echo $activity['Activity']['id']?>">
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
                                            <textarea class="post-area-input commentBox showCommentBtn" data-id="<?php echo $activity['Activity']['id']?>" placeholder="<?php echo __('Write a comment...')?>" id="commentForm_<?php echo $activity['Activity']['id']?>"></textarea>
                                        </div>
                                        <div class="post-area-action">
                                            <div class="post-area-icons">
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentForm' ,'id'=>$activity['Activity']['id']))); ?>
                                                <div id="commentForm_<?php echo $activity['Activity']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                <div data-id="<?php echo $activity['Activity']['id'];?>" id="comment_button_attach_<?php echo $activity['Activity']['id'];?>" class="post-area-box"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-form-button commentButton" id="commentButton_<?php echo $activity['Activity']['id']?>">
                                    <input type="hidden" id="comment_image_<?php echo $activity['Activity']['id'];?>" />
                                    <a class="btn btn-submit_comment btn-cs viewer-submit-comment" data-activity-id="<?php echo $activity['Activity']['id']?>" href="javascript:void(0)"  class="btn btn-action ">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                            <span class="btn-text"><?php echo __('Post') ?></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentForm' ,'id'=>$activity['Activity']['id']))); ?>
                            <div class="comment-form-attach">
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
                <div class="comment_lists comment_parent_lists"></div>
            </div>
        </div>
        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
        mooAttach.registerAttachComment(<?php echo $activity['Activity']['id'];?>);
        <?php $this->Html->scriptEnd(); ?>
    </div>
</div>
<?php endif;?>