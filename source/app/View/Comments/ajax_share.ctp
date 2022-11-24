<?php $this->setCurrentStyle(4);?>
<?php if (!empty($comment)):
    $link = json_decode($comment['Comment']['params'], true);
    $url = (isset($link['url']) ? $link['url'] : '#');
    ?>
<div class="comment-item slide" id="itemcomment_<?php echo $comment['Comment']['id']?>">
	<?php if ($this->request->is('ajax')): ?>
	<script type="text/javascript">
	    require(["jquery","mooComment", "mooActivities"], function($, mooComment, mooActivities) {
	        mooActivities.init();
	        mooComment.initEditItemComment();
	        mooComment.initRemoveItemComment();
	    });
	</script>
	<?php endif; ?>
	<?php if ( $comment['Comment']['type'] != APP_CONVERSATION ): ?>
    <div class="comment-option">
        <div class="dropdown">
            <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
            </a>
            <ul class="dropdown-menu">
                <?php if ($comment['Comment']['user_id'] == $uid):?>
                <li>
                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="0" class="editItemComment">
                        <?php echo __('Edit Comment'); ?>
                    </a>
                </li>
                <?php endif;?>
                <li>
                    <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="0" class="removeItemComment" class="removeItemComment">
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
                <?php
                if ( !empty( $activity ) )
                    echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array( 'prefix' => '50_square'), array('class' => 'user_avatar'));
                else
                    echo $this->Moo->getItemPhoto(array('User' => $comment['User']),array( 'prefix' => '100_square'), array('class' => 'user_avatar'));
                ?>
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
			    <?php
			    if ( !empty( $activity ) )
	                echo $this->viewMore(h($comment['Comment']['message']),null, null, null, true, array('no_replace_ssl' => 1));
	            else
	                echo $this->Moo->formatText( h($comment['Comment']['message']), false, true, array('no_replace_ssl' => 1) );
	            ?>
	            
	            <?php if ($comment['Comment']['thumbnail']):?>
	            	<div class="comment_thumb">
			            <a data-dismiss="modal" href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
		                	<?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
				                     <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                                <?php else: ?>
                                                        <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img', 'prefix'=>'200'));?>
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
                            <?php $has_reply = !in_array($comment['Comment']['type'],array(APP_CONVERSATION,'comment','core_activity_comment'));?>
                            <?php echo __('Just now')?>
                        </div>
                        <?php if ( $comment['Comment']['type'] != APP_CONVERSATION ): ?>
                            <?php if(empty($hide_like)): ?>
                            <div class="act-item act-item-like">
                                <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="1" id="comment_l_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                </a>
                                <span class="act-item-text">
                                    <span id="comment_like_<?php echo $comment['Comment']['id']?>" class="act-item-txt">0</span>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if(empty($hide_dislike)): ?>
                            <div class="act-item act-item-dislike">
                                <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment" data-status="0" id="comment_d_<?php echo $comment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                </a>
                                <span class="act-item-text">
                                    <span id="comment_dislike_<?php echo $comment['Comment']['id']?>" class="act-item-txt">0</span>
                                </span>
                            </div>
                            <?php  endif;?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => 0), 'item_type' => 'comment' ))); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['Comment']['id'], 'like_count' => 0), 'item_type' => 'comment' ))); ?>
                        <?php endif; ?>
                        <?php if ($comment['Comment']['type'] != APP_CONVERSATION):?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment['Comment'], 'item_type' => 'comment' ))); ?>
                            <div class="act-item act-item-reply">
                                <?php if ($has_reply):?>
                                    <?php if ( !empty( $activity ) ):?>
                                        <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $comment['Comment']['id']?>" data-type="comment">
                                            <span class="act-item-symbol">
                                                <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                            </span>
                                            <span class="act-item-text">
                                                <span class="act-item-txt"><?php echo __('Reply');?></span>
                                            </span>
                                        </a>
                                    <?php else:?>
                                        <a href="javascript:void(0);" class="reply_action item_reply_comment_button" data-id="<?php echo $comment['Comment']['id']?>">
                                            <span class="act-item-symbol">
                                                <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                            </span>
                                            <span class="act-item-text">
                                                <span class="act-item-txt"><?php echo __('Reply');?></span>
                                            </span>
                                        </a>
                                    <?php endif;?>
                                <?php else:
                                    if($comment['Comment']['type'] == 'core_activity_comment')    {
                                        $type = 'activitycomments_reply_';
                                    }else if(isset($on_activity)){
                                        $type = 'comments_reply_';
                                    }else{
                                        $type = 'item_comments_reply_';
                                    }
                                    ?>
                                    <a href="javascript:void(0);" class="reply_action reply_reply_comment_button <?php echo $uid == $comment['Comment']['user_id'] ? 'owner' : '';?>" data-type='<?php echo $type. $comment['Comment']['target_id'];?>' data-user="<?php echo $comment['Comment']['user_id'];?>" data-id="<?php echo $comment['Comment']['target_id']?>">
                                        <span class="act-item-symbol">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                        </span>
                                        <span class="act-item-text">
                                            <span class="act-item-txt"><?php echo __('Reply');?></span>
                                        </span>
                                    </a>
                                <?php endif;?>
                            </div>
                        <?php endif;?>
                        <div id="history_item_comment_<?php echo $comment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['Comment']['edited']) ? 'display:none;' : ''; ?>">
                            <?php
                            $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'comment', $comment['Comment']['id'])),
                                'title' => __('Show edit history'),
                                'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_item_comment-text">'.__('Edited').'</span></span>',
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

    <?php if ($has_reply):?>
        <?php if ( !empty( $activity ) ):?>
        <div class="comment_reply-holder" id="comments_reply_<?php echo $comment['Comment']['id']?>">
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
                                        <?php echo $this->Form->textarea("commentReplyForm".$comment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['Comment']['id'], 'placeholder' => __('Write a reply...') ), true) ?>
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
                                <input type="hidden" id="comment_reply_image_<?php echo $comment['Comment']['id'];?>" />
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
            <div class="comment_lists comment_reply_lists"></div>
        </div>
        <?php else:?>
        <div class="comment_reply-holder" id="item_comments_reply_<?php echo $comment['Comment']['id']?>">
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
                                        <?php echo $this->Form->textarea("item_commentReplyForm".$comment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['Comment']['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), true) ?>
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
            <div class="comment_lists comment_reply_lists"></div>
        </div>
        <?php endif;?>
    <?php endif;?>
</div>
<?php endif;?>