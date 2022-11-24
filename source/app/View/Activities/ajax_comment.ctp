<?php $this->setCurrentStyle(4);?>
<?php if (!empty($comment)):?>
    <?php if(empty($photoComment)):
        $link = json_decode($comment['ActivityComment']['params'], true);
        $url = (isset($link['url']) ? $link['url'] : '#');
    ?>
    <div id="comment_<?php echo $comment['ActivityComment']['id']?>" class="comment-item">
        <div class="comment-option">
            <div class="dropdown">
                <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                    <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0)" data-activity-comment-id="<?php echo $comment['ActivityComment']['id']?>" class="editActivityComment" >
                            <?php echo __('Edit Comment'); ?>
                        </a>
                    </li>
                    <li>
                        <a class=" removeActivityComment" data-activity-comment-id="<?php echo $comment['ActivityComment']['id']?>" href="javascript:void(0)"  >
                            <?php echo __('Delete Comment'); ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
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
                        <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                    <?php endif;?>
                </div>
                <div class="comment-content-text" id="activity_feed_comment_text_<?php echo $comment['ActivityComment']['id']?>">
                    <?php echo $this->viewMore(h($comment['ActivityComment']['comment']),null, null, null, true, array('no_replace_ssl' => 1));?>
                    <?php if ($comment['ActivityComment']['thumbnail']):?>
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
                                $link_image = $this->storage->getUrl($comment['ActivityComment']["id"],'',$link['image'],"links") ;
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
                                <?php echo __('Just now')?>
                            </div>
                            <?php if(empty($hide_like)): ?>
                            <div class="act-item act-item-like">
                                <a href="javascript:void(0)" data-id="<?php echo $comment['ActivityComment']['id']?>" data-type="core_activity_comment" data-status="1" id="core_activity_comment_l_<?php echo $comment['ActivityComment']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                </a>
                                <span class="act-item-text">
                                    <span id="core_activity_comment_like_<?php echo $comment['ActivityComment']['id']?>" class="act-item-txt">0</span>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if(empty($hide_dislike)): ?>
                            <div class="act-item act-item-dislike">
                                <a href="javascript:void(0)" data-id="<?php echo $comment['ActivityComment']['id']?>" data-type="core_activity_comment" data-status="0" id="core_activity_comment_l_<?php echo $comment['ActivityComment']['id']?>" class="act-item-symbol comment-thumb likeActivity">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                </a>
                                <span class="act-item-text">
                                    <span id="core_activity_comment_dislike_<?php echo $comment['ActivityComment']['id']?>" class="act-item-txt">0</span>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['ActivityComment']['id'], 'like_count' => 0), 'item_type' => 'core_activity_comment' ))); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $comment['ActivityComment']['id'], 'like_count' => 0), 'item_type' => 'core_activity_comment' ))); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $comment['ActivityComment'], 'item_type' => 'core_activity_comment' ))); ?>
                            <div class="act-item act-item-reply">
                                <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $comment['ActivityComment']['id']?>" data-type="core_activity_comment">
                                    <span class="act-item-symbol">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                    </span>
                                    <span class="act-item-text">
                                        <span class="act-item-txt"><?php echo __('Reply');?></span>
                                    </span>
                                </a>
                            </div>
                            <div id="history_activity_comment_<?php echo $comment['ActivityComment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['ActivityComment']['edited']) ? 'display:none;' : ''; ?>">
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "histories",
                                        "action" => "ajax_show",
                                        "plugin" => false,
                                        'core_activity_comment',
                                        $comment['ActivityComment']['id']
                                    )),
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
        <div class="comment_reply-holder" id="activitycomments_reply_<?php echo $comment['ActivityComment']['id']?>">
            <div class="new_reply_comment" style="display:none;" id="activitynewComment_reply_<?php echo $comment['ActivityComment']['id']?>">
                <div class="comment-form">
                    <div class="comment-form-left">
                        <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                    </div>
                    <div class="comment-form-right">
                        <div class="comment-form-main">
                            <div class="comment-form-area">
                                <div class="post-area">
                                    <div class="post-area-text">
                                        <?php echo $this->Form->textarea("activitycommentReplyForm".$comment['ActivityComment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $comment['ActivityComment']['id'], 'placeholder' => __('Write a reply...'), 'rows' => 3 ), true) ?>
                                    </div>
                                    <div class="post-area-action">
                                        <div class="post-area-icons">
                                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'activitycommentReplyForm' ,'id'=>$comment['ActivityComment']['id']))); ?>
                                            <div id="activitycommentReplyForm<?php echo $comment['ActivityComment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                            <?php if ( !empty( $uid ) ): ?>
                                                <div id="activitycomment_reply_button_attach_<?php echo $comment['ActivityComment']['id'];?>" class="post-area-box"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if($this->request->is('ajax')): ?>
                                    <script>
                                        require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                            mooToggleEmoji.init('activitycommentReplyForm<?php echo $comment['ActivityComment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                        });
                                    </script>
                                <?php else: ?>
                                    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                    mooToggleEmoji.init('activitycommentReplyForm<?php echo $comment['ActivityComment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                    <?php $this->Html->scriptEnd();  ?>
                                <?php endif; ?>
                            </div>
                            <?php if ( !empty( $uid ) ): ?>
                            <div class="comment-form-button commentButton" id="activity_commentReplyButton_<?php echo $comment['ActivityComment']['id']?>">
                                <a href="javascript:void(0)"  class="btn btn-submit_reply btn-cs activity_reply_comment" data-id="<?php echo $comment['ActivityComment']['id'];?>" data-type="core_activity_comment">
                                    <span class="btn-cs-main">
                                        <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                        <span class="btn-text"><?php echo __('Post') ?></span>
                                    </span>
                                </a>
                                <?php if($this->request->is('ajax')): ?>
                                    <script type="text/javascript">
                                        require(["jquery","mooAttach"], function($,mooAttach) {
                                            mooAttach.registerAttachActivityCommentReplay(<?php echo $comment['ActivityComment']['id'];?>);
                                        });
                                    </script>
                                <?php else: ?>
                                    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                    mooAttach.registerAttachActivityCommentReplay(<?php echo $comment['ActivityComment']['id'];?>);
                                    <?php $this->Html->scriptEnd(); ?>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'activitycommentReplyForm' ,'id'=>$comment['ActivityComment']['id']))); ?>
                        <?php if ( empty( $uid ) ): ?>
                        <div class="comment-form-message">
                            <?php echo __('Please login or register')?>
                        </div>
                        <?php endif; ?>
                        <div class="comment-form-attach">
                            <input type="hidden" id="activitycomment_reply_image_<?php echo $comment['ActivityComment']['id'];?>">
                            <div id="activitycomment_reply_preview_image_<?php echo $comment['ActivityComment']['id'];?>" class="comment_attach_image"></div>
                            <div class="userTagging-ReplyLink-<?php echo $comment['ActivityComment']['id']?>" style="display: none;">
                                <input type="hidden" name="data[userCommentLink]" id="userReplyLink<?php echo $comment['ActivityComment']['id']?>" value="" autocomplete="off" type="text">
                            </div>
                            <div class="userTagging-ReplyVideo-<?php echo $comment['ActivityComment']['id']?>" style="display: none;">
                                <input type="hidden" name="data[userCommentVideo]" id="userReplyVideo<?php echo $comment['ActivityComment']['id']?>" value="" autocomplete="off" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment_lists comment_reply_lists"></div>
        </div>
    </div>
    <?php else:
        $link = json_decode($photoComment['Comment']['params'],true);
        $url = (isset($link['url']) ? $link['url'] : '#');
    ?>
        <div id="itemcomment_<?php echo $photoComment['Comment']['id']?>" class="comment-item">
            <div class="comment-option">
                <div class="dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                        <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0)" data-id="<?php echo $photoComment['Comment']['id']?>" data-photo-comment="1" class="editItemComment">
                                <?php echo __('Edit Comment'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="removeItemComment" href="javascript:void(0)" data-photo-comment="1" data-id="<?php echo $photoComment['Comment']['id']?>" >
                                <?php echo __('Delete Comment'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="comment-outer">
                <div class="comment-avatar">
                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $photoComment))); ?>
                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                        <?php echo $comment_reply_creator->result['image'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getItemPhoto(array('User' => $photoComment['User']),array('prefix' => '50_square'), array('class' => 'user_avatar'))?>
                    <?php endif;?>
                </div>
                <div class="comment-inner">
                    <div class="comment-user-name">
                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                            <?php echo $comment_reply_creator->result['name'];?>
                        <?php else:?>
						    <?php echo $this->Moo->getName($photoComment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterRenderUserNameComment', $this,array('user'=>$photoComment['User']))); ?>
                        <?php endif;?>
                    </div>
                    <div class="comment-content-text" id="photo_feed_comment_text_<?php echo $photoComment['Comment']['id']?>">
                        <?php echo $this->viewMore(h($photoComment['Comment']['message'])); ?>

                        <?php if ($photoComment['Comment']['thumbnail']):?>
                            <div class="comment_thumb">
                                <a href="<?php echo $this->Moo->getImageUrl($photoComment,array());?>">
                                    <?php if($this->Moo->isGifImage($this->Moo->getImageUrl($photoComment,array()))) :  ?>
                                        <?php echo $this->Moo->getImage($photoComment,array('class' => 'comment-img gif_image'));?>
                                    <?php else: ?>
                                        <?php echo $this->Moo->getImage($photoComment,array('class' => 'comment-img','prefix'=>'200'));?>
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
                                            $link_image = $this->storage->getUrl($photoComment['Comment']["id"],'',$link['image'],"links") ;
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
                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('comment' => $photoComment))); ?>
                    </div>
                    <div class="comment-action-list">
                        <div class="comment-action">
                            <div class="like-action">
                                <div class="act-item comment-time">
                                    <?php echo __('Just now')?>
                                </div>
                                <?php if(empty($hide_like)): ?>
                                <div class="act-item act-item-like">
                                    <a href="javascript:void(0)" data-id="<?php echo $photoComment['Comment']['id']?>" data-type="comment" data-status="1" id="comment_l_<?php echo $photoComment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && !empty( $activity_likes['item_comment_likes'][$photoComment['Comment']['id']] ) ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                    </a>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $photoComment['Comment']['id'])),
                                        'title' => __('People Who Like This'),
                                        'innerHtml'=> '<span id="comment_like_'.  $photoComment['Comment']['id'] . '" class="act-item-txt">' . $photoComment['Comment']['like_count'] . '</span>',
                                        'data-dismiss' => 'modal',
                                        'class' => 'act-item-text'
                                    ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if(empty($hide_dislike)): ?>
                                <div class="act-item act-item-dislike">
                                    <a href="javascript:void(0)" data-id="<?php echo $photoComment['Comment']['id']?>" data-type="comment" data-status="0" id="comment_d_<?php echo $photoComment['Comment']['id']?>" class="act-item-symbol comment-thumb likeActivity <?php if ( !empty( $uid ) && isset( $activity_likes['item_comment_likes'][$photoComment['Comment']['id']] ) && $activity_likes['item_comment_likes'][$photoComment['Comment']['id']] == 0 ): ?>active<?php endif; ?>">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                    </a>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "likes", "action" => "ajax_show", "plugin" => false, 'comment', $photoComment['Comment']['id'],1)),
                                        'title' => __('People Who Dislike This'),
                                        'innerHtml'=> '<span id="comment_dislike_' .  $photoComment['Comment']['id'] . '" class="act-item-txt">' . $photoComment['Comment']['dislike_count'] . '</span>',
                                        'class' => 'act-item-text'
                                    ));
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeButton', $this,array('uid' => $uid, 'comment' => array('id' =>  $photoComment['Comment']['id'], 'like_count' => $photoComment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.renderLikeReview', $this,array('uid' => $uid,'comment' => array('id' =>  $photoComment['Comment']['id'], 'like_count' => $photoComment['Comment']['like_count']), 'item_type' => 'comment' ))); ?>
                                <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.beforeRenderReply', $this,array('uid' => $uid, 'comment' => $photoComment['Comment'], 'item_type' => 'comment' ))); ?>
                                <div class="act-item act-item-reply">
                                    <a href="javascript:void(0);" class="reply_action activity_reply_comment_button" data-id="<?php echo $photoComment['Comment']['id']?>" data-type="comment">
                                        <span class="act-item-symbol">
                                            <span class="act-item-icon material-icons moo-icon moo-icon-reply">reply</span>
                                        </span>
                                        <span class="act-item-text">
                                            <span class="act-item-txt"><?php echo __('Reply');?></span>
                                        </span>
                                    </a>
                                </div>
                                <div id="history_item_comment_<?php echo $photoComment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($photoComment['Comment']['edited']) ? 'display:none;' : ''; ?>">
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'comment', $photoComment['Comment']['id'])),
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
            <div class="comment_reply-holder" id="comments_reply_<?php echo $photoComment['Comment']['id']?>">
                <div class="new_reply_comment" style="display:none;" id="newComment_reply_<?php echo $photoComment['Comment']['id']?>">
                    <div class="comment-form">
                        <div class="comment-form-left">
                            <?php echo $this->Moo->getItemPhoto(array('User' => $cuser), array( 'prefix' => '50_square'), array('class' => 'user_avatar'))?>
                        </div>
                        <div class="comment-form-right">
                            <div class="comment-form-main">
                                <div class="comment-form-area">
                                    <div class="post-area">
                                        <div class="post-area-text">
                                            <?php echo $this->Form->textarea("commentReplyForm".$photoComment['Comment']['id'],array('class' => "post-area-input commentBox commentForm showCommentReplyBtn", 'data-id' => $photoComment['Comment']['id'], 'placeholder' => __('Write a reply...') ), true) ?>
                                        </div>
                                        <div class="post-area-action">
                                            <div class="post-area-icons">
                                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentReplyForm' ,'id'=>$photoComment['Comment']['id']))); ?>
                                                <div id="commentReplyForm<?php echo $photoComment['Comment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                                                <?php if ( !empty( $uid ) ): ?>
                                                    <div id="comment_reply_button_attach_<?php echo $photoComment['Comment']['id'];?>" class="post-area-box"></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($this->request->is('ajax')): ?>
                                        <script>
                                            require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
                                                mooToggleEmoji.init('commentReplyForm<?php echo $photoComment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                            });
                                        </script>
                                    <?php else: ?>
                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
                                        mooToggleEmoji.init('commentReplyForm<?php echo $photoComment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
                                        <?php $this->Html->scriptEnd();  ?>
                                    <?php endif; ?>
                                </div>
                                <?php if ( !empty( $uid ) ): ?>
                                <div class="comment-form-button commentButton" id="commentReplyButton_<?php echo $photoComment['Comment']['id']?>">
                                    <a href="javascript:void(0)"  class="btn btn-submit_reply btn-cs activity_reply_comment" data-id="<?php echo $photoComment['Comment']['id'];?>" data-type="comment">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                                            <span class="btn-text"><?php echo __('Post') ?></span>
                                        </span>
                                    </a>
                                    <?php if($this->request->is('ajax')): ?>
                                        <script type="text/javascript">
                                            require(["jquery","mooAttach"], function($,mooAttach) {
                                                mooAttach.registerAttachCommentReplay(<?php echo $photoComment['Comment']['id'];?>);
                                            });
                                        </script>
                                    <?php else: ?>
                                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery','mooAttach'), 'object' => array('$', 'mooAttach'))); ?>
                                        mooAttach.registerAttachCommentReplay(<?php echo $photoComment['Comment']['id'];?>);
                                        <?php $this->Html->scriptEnd(); ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentReplyForm' ,'id'=>$photoComment['Comment']['id']))); ?>
                            <?php if ( empty( $uid ) ): ?>
                            <div class="comment-form-message">
                                <?php echo __('Please login or register')?>
                            </div>
                            <?php endif; ?>
                            <div class="comment-form-attach">
                                <input type="hidden" id="comment_reply_image_<?php echo $photoComment['Comment']['id'];?>" />
                                <div id="comment_reply_preview_image_<?php echo $photoComment['Comment']['id'];?>" class="comment_attach_image"></div>
                                <div class="userTagging-ReplyLink-<?php echo $photoComment['Comment']['id']?>" style="display: none;">
                                    <input type="hidden" name="data[userCommentLink]" id="userReplyLink<?php echo $photoComment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                </div>
                                <div class="userTagging-ReplyVideo-<?php echo $photoComment['Comment']['id']?>" style="display: none;">
                                    <input type="hidden" name="data[userCommentVideo]" id="userReplyVideo<?php echo $photoComment['Comment']['id']?>" value="" autocomplete="off" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment_lists comment_reply_lists"></div>
            </div>
        </div>
    <?php endif; ?>
<?php endif;?>