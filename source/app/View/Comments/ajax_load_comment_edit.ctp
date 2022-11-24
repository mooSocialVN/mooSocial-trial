<?php
$link = json_decode($comment['Comment']['params'],true);
$url = (isset($link['url']) ? $link['url'] : '');
?>
<script type="text/javascript">
    require(["jquery","mooComment"], function($, mooComment) {
        mooComment.initOnAjaxLoadCommentEdit();
        mooComment.initParseComment();
    });
    require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
        mooToggleEmoji.init('message_item_comment_edit_<?php echo $comment['Comment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>

<div id="item_comment_edit_<?php echo $comment['Comment']['id']?>" class="comment-form item_comment_edit">
    <div class="comment-form-main">
        <div class="comment-form-area">
            <div class="post-area">
                <div class="post-area-text">
                    <textarea id="message_item_comment_edit_<?php echo $comment['Comment']['id']?>" name="message" class="post-area-input commentBox commentFormEdit showCommentBtn" data-id="<?php echo $comment['Comment']['id']?>"><?php echo $comment['Comment']['message']?></textarea>
                </div>
                <div class="post-area-action">
                    <div class="post-area-icons">
                        <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'item_comment_edit' ,'id'=>$comment['Comment']['id']))); ?>
                        <div id="message_item_comment_edit_<?php echo $comment['Comment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                        <div id="item_comment_attach_<?php echo $comment['Comment']['id'];?>" class="post-area-box" <?php if ($comment['Comment']['thumbnail']) echo "style='display:none;'";?>></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'item_comment_edit' ,'id'=>$comment['Comment']['id']))); ?>
    <div class="comment-form-attach">
        <input type="hidden" value="<?php echo $comment['Comment']['thumbnail'];?>" name="comment_attach" id="item_comment_attach_id_<?php echo $comment['Comment']['id']?>">
        <div id="item_comment_preview_attach_<?php echo $comment['Comment']['id'];?>">
            <?php
            if ($comment['Comment']['thumbnail']):
                ?>
                <span style="background-image:url(<?php echo $this->Moo->getImageUrl($comment);?>)"><a class="removePhotoComment" data-type="item" data-id="<?php echo $comment['Comment']['id']?>" href="javascript:void(0);"><span class="material-icons moo-icon moo-icon-clear thumb-review-delete">clear</span></span></a>
            <?php endif;?>
        </div>
        <div class="userTagging-CommentEditLink-<?php echo $comment['Comment']['id']?>">
            <input type="hidden" name="userCommentLink" id="userCommentEditLink<?php echo $comment['Comment']['id']?>" value="<?php echo $url?>" autocomplete="off" placeholder="Share link" type="text">
            <?php if ( !empty( $link['title'] ) ):?>
                <div class="activity_item cmt_preview_link">
                    <?php if ( !empty( $link['image'] ) ): ?>
                        <div class="activity_left">
                            <?php
                            if ( strpos( $link['image'], 'http' ) === false ):
                                $link_image = $this->storage->getUrl($comment['Comment']["id"],'',$link['image'],"links") ;
                            else:
                                $link_image = $link['image'];
                            endif;
                            ?>
                            <img class="activity-img" src="<?php echo $link_image ?>">
                        </div>
                    <?php endif; ?>
                    <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right<?php endif; ?>">
                        <a class="removeCommentPreviewlink removeCommentContent" href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>"><span class="icon-delete material-icons moo-icon moo-icon-clear">clear</span></a>
                        <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                            <?php echo h($link['title'])?>
                        </a>
                        <?php
                        if ( !empty( $link['description'] ) )
                            echo '<div class="activity_item_text comment_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                        ?>
                    </div>
                </div>
            <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
                <div class="activity_item cmt_preview_link" id="cmt_preview_link_img_<?php echo $comment['Comment']['id']?>">
                    <div class="comment_thumb">
                        <a class="removePreviewlink removeCommentContent" href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>"><span class="icon-delete material-icons moo-icon moo-icon-clear">clear</span></a>
                        <img src="<?php echo $link['image'] ?>" class="comment-img">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="userTagging-CommentEditVideo-<?php echo $comment['Comment']['id']?>">
            <input type="hidden" name="userCommentVideo" id="userCommentEditVideo<?php echo $comment['Comment']['id']?>" value="" autocomplete="off" placeholder="Share link" type="text">
        </div>
    </div>
	<div class="edit-post-action">
		<a class="btn btn-cancel_edit cancelEditItemComment" href="javascript:void(0);" data-id="<?php echo $comment['Comment']['id'];?>" data-photo-comment="<?php echo $isPhotoComment; ?>"><?php echo __('Cancel');?></a>
        <a class="btn btn-submit_edit confirmEditItemComment" href="javascript:void(0);" data-id="<?php echo $comment['Comment']['id'];?>" data-photo-comment="<?php echo $isPhotoComment; ?>"><?php echo __('Done Editing');?></a>
	</div>
</div>