<?php
$subject = isset($data['subject']) ? $data['subject'] : MooCore::getInstance()->getSubject();
$historyModel = MooCore::getInstance()->getModel('CommentHistory');
$is_owner = 0;

if(!isset($is_close_comment)) {
    if (!empty($subject)) {
        //close comment
        $closeCommentModel = MooCore::getInstance()->getModel('CloseComment');
        $item_close_comment = $closeCommentModel->getCloseComment($subject[key($subject)]['id'], $subject[key($subject)]['moo_type']);
        if(!empty($item_close_comment)){
            $is_close_comment = 1;
        }else{
            $is_close_comment = 0;
        }

    }else{
        $is_close_comment = 0;
    }
}

if ( ( $this->request->controller != Inflector::pluralize(APP_CONVERSATION) ) && ((!empty($subject) && $subject[key($subject)]['user_id'] == $uid) || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $data['admins_reply'] ) && in_array( $uid, $data['admins_reply'] ) ) ) ) {
    $is_owner = 1;
}

if ( !empty( $data['comments'] ) ):
	foreach ($data['comments'] as $comment):
        $link = json_decode($comment['Comment']['params'],true);
        $url = (isset($link['url']) ? $link['url'] : '#');
?>
	<div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
		<?php // delete link available for commenter, site admin and item author (except convesation)
            if ($uid && ( $this->request->controller != Inflector::pluralize(APP_CONVERSATION) ) && ((!empty($subject) && $subject[key($subject)]['user_id'] == $uid) ||  $comment['Comment']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $data['admins'] ) && in_array( $uid, $data['admins'] ) ) ) ):?>
        <div class="comment-option">
            <div class="dropdown">
                <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                    <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($comment['Comment']['user_id'] == $uid || $cuser['Role']['is_admin'] ):?>
                    <li>
                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="0" class="editItemComment">
                            <?php echo __('Edit Comment'); ?>
                        </a>
                    </li>
                    <?php endif;?>
                    <li>
                        <?php $isTheaterMode = (!empty($blockCommentId) && $blockCommentId == 'theaterComments')? 1 : 0; ?>
                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="<?php echo $isTheaterMode; ?>" class="removeItemComment" >
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
                    <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']), array('prefix' => '100_square'), array('class' => 'user_avatar'))?>
                <?php endif;?>
            </div>
            <div class="comment-inner">
                <div class="comment-user-name">
                    <?php if(!empty($comment_reply_creator->result['name'])):?>
                        <?php echo $comment_reply_creator->result['name'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                    <?php endif;?>
                </div>
                <div class="comment-content-text" id="item_feed_comment_text_<?php echo $comment['Comment']['id']?>">
                    <?php echo $this->viewMore( h($comment['Comment']['message']),null, null, null, true, array('no_replace_ssl' => 1))?>
                    <?php if ($comment['Comment']['thumbnail']):?>
                    <div class="comment_thumb">
                        <a data-dismiss="modal" href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
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
                                <?php if(!empty($activity)):?>
                                    <a href="<?php echo $this->request->base?>/users/view/<?php echo $activity['Activity']['user_id']?>/activity_id:<?php echo $activity['Activity']['id']?>/comment_id:<?php echo $comment['Comment']['target_id']?>/reply_id:<?php echo $comment['Comment']['id']?>">
                                        <?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?>
                                    </a>
                                <?php else:?>
                                    <?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?>
                                <?php endif;?>
                            </div>
                            <?php if (empty($comment_type)): ?>
                                <?php if(empty($hide_like)): ?>
                                    <div class="act-item act-item-like">
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="1" id="comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $data['comment_likes'][$comment['Comment']['id']] ) ): ?>active<?php endif; ?>">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                        </a>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                            'title' => __('People Who Like This'),
                                            'innerHtml'=> '<span id="comment_like_' . $comment['Comment']['id'] . '" class="act-item-txt">' . $comment['Comment']['like_count'] . '</span>',
                                            'data-dismiss' => 'modal',
                                            'class' => 'act-item-text'
                                        ));
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(empty($hide_dislike)): ?>
                                    <div class="act-item act-item-dislike">
                                        <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="0" id="comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $data['comment_likes'][$comment['Comment']['id']] ) && $data['comment_likes'][$comment['Comment']['id']] == 0 ): ?>active<?php endif; ?>">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                        </a>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'],1)),
                                            'title' => __('People Who Dislike This'),
                                            'innerHtml'=> '<span id="comment_dislike_' . $comment['Comment']['id'] . '" class="act-item-txt">' .  $comment['Comment']['dislike_count'] . '</span>',
                                            'data-dismiss' => 'modal',
                                            'class' => 'act-item-text'
                                        ));
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => $comment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                            <?php endif; ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment['Comment'], 'item_type' => 'comment' ))); ?>
                            <?php if(!$is_close_comment || $is_owner):?>
                                <?php if ($comment['Comment']['type'] != APP_CONVERSATION):?>
                                    <div class="act-item act-item-reply">
                                        <?php if (!in_array($comment['Comment']['type'],array('comment','core_activity_comment'))):?>
                                            <a href="javascript:void(0);" class="reply_action item_reply_comment_button" data-id="<?php echo $comment['Comment']['id']?>">
                                                <span class="act-item-symbol">
                                                    <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                                </span>
                                                <span class="act-item-text">
                                                    <span class="act-item-txt"><?php echo __('Reply');?></span>
                                                </span>
                                            </a>
                                        <?php else:?>
                                            <a href="javascript:void(0);" class="reply_action reply_reply_comment_button <?php echo $uid == $comment['Comment']['user_id'] ? 'owner' : '';?>" data-type='<?php echo $blockCommentId;?>' data-user="<?php echo $comment['Comment']['user_id'];?>" data-id="<?php echo $comment['Comment']['target_id']?>">
                                                <span class="act-item-symbol">
                                                    <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                                </span>
                                                <span class="act-item-text">
                                                    <span class="act-item-txt"><?php echo __('Reply');?></span>
                                                </span>
                                            </a>
                                            <span style="display: none;"><?php echo $comment['User']['moo_title']?></span>
                                        <?php endif;?>
                                    </div>
                                <?php endif;?>
                            <?php endif;?>
                            <div id="history_item_comment_<?php echo $comment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['Comment']['edited']) ? 'display:none' : ''; ?>">
                                <?php $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                    'title' => __('Show edit history'),
                                    'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_item_comment-text">'.$historyModel->getText('comment',$comment['Comment']['id']).'</span></span>',
                                    'class'=>'edit-btn',
                                    'data-dismiss'=>'modal'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($comment['Comment']['type'] == APP_CONVERSATION): ?>
                <div class="comment-conversion-seen">
                    <div class="user-seen-list conversation_comment_id_<?php echo $comment['Comment']['id']; ?>" data-comment_id="<?php echo $comment['Comment']['id']; ?>">
                        <?php
                        $seenModel = MooCore::getInstance()->getModel("ConversationSeen");
                        $seen_cmt = array();
                        $list_seen_cmt = array();
                        ?>
                            <?php
                            $seen_cmt = $seenModel->find('all', array('conditions' => array('ConversationSeen.user_id !=' => $uid, 'ConversationSeen.comment_id' => $comment['Comment']['id'])));
                            $count = count($seen_cmt);
                            foreach ($seen_cmt as $key => $val):
                                if ($key == 2)
                                {
                                    break;
                                }
                                $list_seen_cmt[] = $val['User']['id'];

                                ?>
                                <div class="user-seen-item">
                                    <?php echo $this->Moo->getItemPhoto(array('User' => $val['User']),array( 'prefix' => '50_square'), array('class' => 'user_avatar')); ?>
            </div>
                            <?php
                            endforeach;
                            ?>
                            <?php if ($count > 2): ?>
                                <div class="user-seen-item">
                                    <a href="<?php echo $this->request->base?>/conversations/ajax_seen/<?php echo $comment['Comment']['id']; ?>" data-target="#themeModal" data-toggle="modal" data-dismiss="modal" data-backdrop="true">
                                        <span class="btn-see-more-icon material-icons moo-icon moo-icon-add">add</span>
                                    </a>
        </div>
                            <?php endif; ?>
                            <div class="user-seen-ids lis_user_seen_cmt_<?php echo $comment['Comment']['id']; ?>" data-list_user_id="<?php echo implode(',', $list_seen_cmt); ?>" style="display: none;"></div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php if (!in_array($comment['Comment']['type'],array(APP_CONVERSATION,'comment','core_activity_comment'))):?>
        <div class="comment_reply-holder <?php echo !empty($comment['Replies']) ? 'isLoadNew' : '';?>" id="item_comments_reply_<?php echo $comment['Comment']['id']?>">
                <?php if(!empty($comment['RepliesIsLoadMore']) && $comment['RepliesIsLoadMore']):?>
                    <div class="comment_reply_more">
                        <a class="item_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-type="core_activity_comment" data-close="<?php echo $is_close_comment?>" href="javascript:void(0);">
                            <?php echo __('View all replies'); ?>
                        </a>
                    </div>
                <?php endif;?>

                <?php if(!$is_close_comment  || $is_owner):?>
                    <div class="new_reply_comment" style="display:none;" id="item_newComment_reply_<?php echo $comment['Comment']['id']?>">
                        <div class="comment-form">
                            <div class="comment-form-left">
                                <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                            </div>
                            <div class="comment-form-right">
                                <div class="comment-form-main">
                                    <div class="comment-form-area">
                                        <div class="post-area">
                                            <div class="post-area-text">
                                                <?php echo $this->Form->textarea("item_commentReplyForm".$comment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['Comment']['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), false) ?>
                                            </div>
                                            <div class="post-area-action">
                                                <div class="post-area-icons">
                                                    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'item_commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                                    <div id="item_commentReplyForm<?php echo $comment['Comment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                    <?php if ( !empty( $uid ) ): ?>
                                                    <div id="item_comment_reply_button_attach_<?php echo $comment['Comment']['id'];?>" class="post-area-box"></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($this->request->is('ajax')): ?>
                                            <script>
                                                require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                    mooToggleEmoji.init('item_commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                                });
                                            </script>
                                        <?php else: ?>
                                            <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                            mooToggleEmoji.init('item_commentReplyForm<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                            <?php $this->Html->scriptEnd();  ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ( !empty( $uid ) ): ?>
                                    <div class="comment-form-button commentButton" id="item_commentReplyButton_<?php echo $comment['Comment']['id']?>">
                                        <input type="hidden" id="item_comment_reply_image_<?php echo $comment['Comment']['id'];?>" />
                                        <a href="javascript:void(0)"  class="btn btn-submit_reply btn-cs item_reply_comment" data-id="<?php echo $comment['Comment']['id'];?>">
                                            <span class="btn-cs-main">
                                                <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                                <span class="btn-text"><?php echo __('Post') ?></span>
                                            </span>
                                        </a>
                                        <?php if($this->request->is('ajax')): ?>
                                            <script type="text/javascript">
                                                require(["jquery","mooAttach"], function($,mooAttach) {
                                                    mooAttach.registerAttachCommentItemReplay(<?php echo $comment['Comment']['id'];?>);
                                                });
                                            </script>
                                        <?php else: ?>
                                            <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                            mooAttach.registerAttachCommentItemReplay(<?php echo $comment['Comment']['id'];?>);
                                            <?php $this->Html->scriptEnd(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'item_commentReplyForm' ,'id'=>$comment['Comment']['id']))); ?>
                                <?php if ( empty( $uid ) ): ?>
                                <div class="comment-form-message">
                                    <?php echo __('Please login or register')?>
                                </div>
                                <?php endif; ?>
                                <div class="comment-form-attach">
                                    <div id="item_comment_reply_preview_image_<?php echo $comment['Comment']['id'];?>" class="comment_attach_image"></div>
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
                        $reply_data['comments'] = $comment['Replies'];
                        $reply_data['comment_likes'] = $comment['RepliesCommentLikes'];
                        $reply_data['bIsCommentloadMore'] = 0;
                        $reply_data['subject'] = $subject;
                        $blockCommentId = 'item_comments_reply_'. $comment['Comment']['id'];
                        ?>
                        <?php echo $this->element('comments', array('data' => $reply_data, 'uid' => $uid, 'blockCommentId' => $blockCommentId));?>
                    <?php endif;?>
                </div>

                <?php if ($comment['Comment']['count_reply'] && empty($comment['Replies'])):?>
                    <div class="comment_reply_more">
                        <a class="item_reply_comment_viewmore" data-id="<?php echo $comment['Comment']['id']?>" data-close="<?php echo $is_close_comment?>" href="javascript:void(0);">
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
        <?php endif;?>
	</div>
<?php
	endforeach;
endif;
?>

<?php if ( isset($data['cmt_id']) && $data['cmt_id'] && !empty($subject) ): ?>
    <div class="comment_view-all">
        <span class="comment_view-icon material-icons moo-icon moo-icon-comment">question_answer</span><a href="<?php echo $subject[key($subject)]['moo_href'];?>" class="showAllComments"><?php echo __('View all comments')?></a>
    </div>
<?php else:?>
    <?php if ($data['bIsCommentloadMore'] > 0): ?>
        <?php
        $more_link = '';
        if(!empty($activity)){
            $more_link = '/activity_id:'.$activity['Activity']['id'];
        }?>
            <?php if (empty($blockCommentId)): ?>
                <?php $this->Html->viewMore($data['more_comments'].'/is_close_comment:'.$is_close_comment.$more_link,'comments') ?>
            <?php else: ?>
                <?php $this->Html->viewMore($data['more_comments'].'/is_close_comment:'.$is_close_comment.'/id_content:'.$blockCommentId.$more_link,$blockCommentId) ?>
            <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooComment"], function($,mooComment) {
        mooComment.initOnCommentListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooComment'), 'object' => array('$', 'mooComment'))); ?>
mooComment.initOnCommentListing();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>