<?php $this->setCurrentStyle(4);
$historyModel = MooCore::getInstance()->getModel('CommentHistory');
?>
<?php if (!empty($comments)): ?>
    <?php if($type == 'activity'):?>
        <?php foreach ($comments as $key => $cmt):
            $comment = $cmt['ActivityComment'];
            $comment['User'] = $cmt['User'];
            $link = json_decode($comment['params'], true);
            $url = (isset($link['url']) ? $link['url'] : '#');
        ?>
            <div id="comment_<?php echo $comment['id']?>" class="comment-item">
                <?php
                    // delete link available for activity poster, site admin and admins array
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
                            <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array('class' => 'user_avatar_small', 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
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
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('uid' => $uid,'comment' => $comment))); ?>
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
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-status="1" id="core_activity_comment_l_<?php echo $comment['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $comment_likes[$comment['id']] ) ): ?>active<?php endif; ?>">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                        </a>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes",
                                                "action" => "ajax_show",
                                                "plugin" => false,
                                                'core_activity_comment',
                                                $comment['id'],
                                            )),
                                            'title' => __('People Who Like This'),
                                            'innerHtml'=> '<span id="core_activity_comment_like_'. $comment['id'] . '" class="act-item-txt">' . $comment['like_count'] . '</span>',
                                            'class' => 'act-item-text'
                                        ));
                                        ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(empty($hide_dislike)): ?>
                                    <div class="act-item act-item-dislike">
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-status="0" id="core_activity_comment_d_<?php echo $comment['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $comment_likes[$comment['id']] ) && $comment_likes[$comment['id']] == false ): ?>active<?php endif; ?>">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                        </a>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes",
                                                "action" => "ajax_show",
                                                "plugin" => false,
                                                'core_activity_comment',
                                                $comment['id'],1
                                            )),
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
                                    <?php if($can_reply):?>
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
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-close="<?php echo ($can_reply) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                            <?php echo __('View all replies'); ?>
                        </a>
                    </div>
                    <?php endif;?>

                    <?php if($can_reply):?>
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
                            <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => (($can_reply) ? 0 : 1)));?>
                        <?php endif;?>
                    </div>

                    <?php if ($comment['count_reply'] && empty($comment['Replies'])):?>
                    <div class="comment_reply_more">
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['id']?>" data-type="core_activity_comment" data-close="<?php echo ($can_reply) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
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

    <?php elseif($type == 'Photo_Photo'): ?>
        <?php foreach ($comments as $key => $comment):
            $link = json_decode($comment['Comment']['params'],true);
            $url = (isset($link['url']) ? $link['url'] : '#');
            ?>
            <div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
                <?php
                // delete link available for activity poster, site admin and admins array
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
                            <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array('class' => 'user_avatar_small', 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
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
                                <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right<?php endif; ?>">
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
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="photo_comment" data-status="1" id="photo_comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $comment_likes[$comment['Comment']['id']] ) ): ?>active<?php endif; ?>">
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
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="photo_comment" data-status="0" id="photo_comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $comment_likes[$comment['Comment']['id']]) && !$comment_likes[$comment['Comment']['id']] ): ?>active<?php endif; ?>">
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
                                    <?php if($can_reply):?>
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
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo $can_reply ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                            <?php echo __('View all replies'); ?>
                        </a>
                    </div>
                    <?php endif;?>

                    <?php if($can_reply):?>
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
                            <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => ($can_reply ? 0 : 1)));?>
                        <?php endif;?>
                    </div>

                    <?php if ($comment['Comment']['count_reply'] && empty($comment['Replies'])):?>
                    <div class="comment_reply_more">
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo $can_reply ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
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

    <?php else: //item comment?>
        <?php
        foreach ($comments as $comment):
            $link = json_decode($comment['Comment']['params'],true);
            $url = (isset($link['url']) ? $link['url'] : '#');
            ?>
            <div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
                <?php
                // delete link available for activity poster, site admin and admins array
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
                            <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
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
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('uid' => $uid,'comment' => $comment))); ?>
                        </div>
                        <div class="comment-action-list">
                            <div class="comment-action">
                                <div class="like-action">
                                    <div class="act-item comment-time">
                                        <a href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>/comment_id:<?php echo $comment['Comment']['id']?>"><?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?></a>
                                    </div>
                                    <?php if(empty($hide_like)): ?>
                                    <div class="act-item act-item-like">
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="1"  id="comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $comment_likes[$comment['Comment']['id']] ) ): ?>active<?php endif; ?>">
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
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="0" id="comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $comment_likes[$comment['Comment']['id']] ) && $comment_likes[$comment['Comment']['id']] == false ): ?>active<?php endif; ?>">
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
                                    <?php if($can_reply):?>
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
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo ($can_reply) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
                            <?php echo __('View all replies'); ?>
                        </a>
                    </div>
                    <?php endif;?>

                    <?php if($can_reply):?>
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
                                        <div id="comment_reply_button_attach_<?php echo $comment['Comment']['id'];?>"></div>
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
                            $blockCommentId = 'comments_reply_'. $comment['Comment']['id'];
                            ?>
                            <?php echo $this->element('comments_chrono', array('data' => $data, 'uid' => $uid, 'blockCommentId' => $blockCommentId, 'is_close_comment' => (($can_reply) ? 0 : 1)));?>
                        <?php endif;?>
                    </div>

                    <?php if ($comment['Comment']['count_reply'] && empty($comment['Replies'])):?>
                    <div class="comment_reply_more">
                        <a class="activity_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-close="<?php echo ($can_reply) ? 0 : 1?>" data-activity="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);">
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
    <?php endif; ?>

    <?php if($this->request->is('ajax')): ?>
        <script type="text/javascript">
            require(["jquery","mooComment"], function($,mooComment) {
                mooComment.initOnCommentListing();
                mooComment.initEditActivityComment();
            });
        </script>
    <?php else: ?>
        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooComment'), 'object' => array('$', 'mooComment'))); ?>
        mooComment.initOnCommentListing();
        mooComment.initEditActivityComment();
        <?php $this->Html->scriptEnd(); ?>
    <?php endif; ?>

<?php endif;?>