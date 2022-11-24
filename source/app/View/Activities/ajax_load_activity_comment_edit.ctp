<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooComment"], function($, mooComment) {
        mooComment.initOnAjaxLoadActivityCommentEdit();
        mooComment.initParseComment();
    });

    require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
        mooToggleEmoji.init('message_activity_comment_edit_<?php echo $activity_comment['ActivityComment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
    mooToggleEmoji.init('message_activity_comment_edit_<?php echo $activity_comment['ActivityComment']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    <?php $this->Html->scriptEnd();  ?>
<?php endif; ?>
<?php
$link = json_decode($activity_comment['ActivityComment']['params'],true);
$url = (isset($link['url']) ? $link['url'] : '');
?>

<div id="activity_comment_edit_<?php echo $activity_comment['ActivityComment']['id']?>" class="comment-form">
    <div class="comment-form-main">
        <div class="comment-form-area">
            <div class="post-area">
                <div class="post-area-text">
                    <textarea id="message_activity_comment_edit_<?php echo $activity_comment['ActivityComment']['id']?>" name="message" class="post-area-input commentBox showCommentBtn" data-id="<?php echo $activity_comment['ActivityComment']['id']?>"><?php echo $activity_comment['ActivityComment']['comment']?></textarea>
                </div>
                <div class="post-area-action">
                    <div class="post-area-icons">
                        <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'activity_comment_edit' ,'id'=>$activity_comment['ActivityComment']['id']))); ?>
                        <div id="message_activity_comment_edit_<?php echo $activity_comment['ActivityComment']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                        <div <?php if ($activity_comment['ActivityComment']['thumbnail']) echo "style='display:none;'";?> id="activity_comment_attach_<?php echo $activity_comment['ActivityComment']['id'];?>" class="post-area-box"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'activity_comment_edit' ,'id'=>$activity_comment['ActivityComment']['id']))); ?>
    <div class="comment-form-attach">
        <input type="hidden" value="<?php echo $activity_comment['ActivityComment']['thumbnail'];?>" name="comment_attach" id="activity_comment_attach_id_<?php echo $activity_comment['ActivityComment']['id']?>">

        <div id="activity_comment_preview_attach_<?php echo $activity_comment['ActivityComment']['id'];?>">
            <?php
            if ($activity_comment['ActivityComment']['thumbnail']):
                ?>
                <span style="background-image:url(<?php echo $this->Moo->getImageUrl($activity_comment);?>)"><a class="removePhotoComment" data-type="activity" data-id="<?php echo $activity_comment['ActivityComment']['id']?>" href="javascript:void(0);"><span class="material-icons moo-icon moo-icon-clear thumb-review-delete">clear</span></span></a>
            <?php endif;?>
        </div>
        <div class="userTagging-CommentEditLink-<?php echo $activity_comment['ActivityComment']['id']?>">
            <input type="hidden" name="userCommentLink" id="userCommentEditLink<?php echo $activity_comment['ActivityComment']['id']?>" value="<?php echo $url?>" autocomplete="off" placeholder="Share link" type="text">
            <?php if ( !empty( $link['title'] ) ):?>
                <div class="activity_item cmt_preview_link">
                    <?php if ( !empty( $link['image'] ) ): ?>
                        <div class="activity_left">
                            <?php
                            if ( strpos( $link['image'], 'http' ) === false ):
                                $link_image = $this->storage->getUrl($activity_comment['ActivityComment']["id"],'',$link['image'],"links") ;
                            else:
                                $link_image = $link['image'];
                            endif;
                            ?>
                            <img src="<?php echo $link_image ?>" class="activity-img">
                        </div>
                    <?php endif; ?>
                    <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right <?php endif; ?>">
                        <a class="removePreviewlink removeCommentContent" href="javascript:void(0)" data-id="<?php echo $activity_comment['ActivityComment']['id']?>"><i class="icon-delete material-icons moo-icon moo-icon-clear">clear</i></a>
                        <a class="feed_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                            <strong><?php echo h($link['title'])?></strong>
                        </a>
                        <?php
                        if ( !empty( $link['description'] ) )
                            echo '<div class="comment_message feed_detail_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                        ?>
                    </div>
                </div>
            <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
                <div class="activity_item cmt_preview_link" id="cmt_preview_link_img_<?php echo $activity_comment['ActivityComment']['id']?>">
                    <div class="comment_thumb">
                        <a class="removePreviewlink removeCommentContent" href="javascript:void(0)" data-id="<?php echo $activity_comment['ActivityComment']['id']?>"><span class="icon-delete material-icons moo-icon moo-icon-clear">clear</span></a>
                        <img src="<?php echo $link['image'] ?>" class="comment-img">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="userTagging-CommentEditVideo-<?php echo $activity_comment['ActivityComment']['id']?>">
            <input type="hidden" name="userCommentVideo" id="userCommentEditVideo<?php echo $activity_comment['ActivityComment']['id']?>" value="" autocomplete="off" placeholder="Share link" type="text">
        </div>
    </div>
	<div class="edit-post-action">
		<a class="btn btn-cancel_edit cancelEditActivityComment" href="javascript:void(0);" data-id="<?php echo $activity_comment['ActivityComment']['id'];?>"><?php echo __('Cancel');?></a>
        <a class="btn btn-submit_edit confirmEditActivityComment" href="javascript:void(0);" data-id="<?php echo $activity_comment['ActivityComment']['id'];?>"><?php echo __('Done Editing');?></a>
	</div>
</div>