<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooComment"], function($,mooComment) {
        mooComment.initOnCommentForm();
        mooComment.initParseComment();
    });

    require(["jquery","mooToggleEmoji"], function($,mooToggleEmoji) {
        mooToggleEmoji.init('<?php echo empty($commentFormTextId) ? 'postComment' : $commentFormTextId; ?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooComment'), 'object' => array('$', 'mooComment'))); ?>
mooComment.initOnCommentForm();
    mooComment.initParseComment();
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
    mooToggleEmoji.init('<?php echo empty($commentFormTextId) ? 'postComment' : $commentFormTextId; ?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
<?php $this->Html->scriptEnd();  ?>

<?php endif; ?>

<form id="<?php echo empty($commentFormId) ? 'commentForm' : $commentFormId; ?>" class="comment-form-warp">
<?php
echo $this->Form->hidden('target_id', array('value' => $target_id));
echo $this->Form->hidden('type', array('value' => $type));

if ( !empty( $class ) )
    $cls = $class;
else
    $cls = 'commentForm';
?>
    <div class="comment-form">
        <div class="comment-form-left">
            <?php echo $this->Moo->getItemPhoto(array('User' => $cuser),array('prefix' => '100_square'), array('class' => 'user_avatar'))?>
        </div>
        <div class="comment-form-right">
            <div class="comment-form-main">
                <div class="comment-form-area">
                    <?php $implementMention = ($type == APP_CONVERSATION)? false : true ?>
                    <div class="post-area">
                        <div class="post-area-text">
                            <?php echo $this->Form->textarea('message', array('id'=> empty($commentFormTextId) ? 'postComment' : $commentFormTextId,'class' => $cls . " post-area-input commentBox showCommentBtn", 'placeholder' => !$implementMention ? __('Write a message') : __('Write a comment'), 'data-id' => $target_id),$implementMention);?>
                        </div>
                        <div class="post-area-action">
                            <div class="post-area-icons">
                                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.renderEditCommentToolbar', $this,array('type' => 'commentForm' ,'id'=>$target_id))); ?>
                                <div id="<?php echo empty($commentFormTextId) ? 'postComment' : $commentFormTextId; ?>-emoji" class="post-area-box emoji-toggle"></div>
                                <?php if ( $uid ): ?>
                                    <div id="comment_button_attach_<?php echo $target_id;?>" class="post-area-box"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ( $uid ): ?>
                <div class="comment-form-button commentButton" id="commentButton_0">
                    <a href="javascript:void(0)" class="btn btn-submit_comment btn-cs shareButton" data-id="<?php echo $target_id;?>">
                        <span class="btn-cs-main">
                        <?php if ($type == APP_CONVERSATION): ?>
                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                            <span class="btn-text"><?php echo __('Post') ?></span>
                        <?php else: ?>
                            <span class="btn-icon material-icons moo-icon moo-icon-send">send</span>
                            <span class="btn-text"><?php echo __('Post') ?></span>
                        <?php endif; ?>
                        </span>
                    </a>
                    <?php if($this->request->is('ajax')): ?>
                        <script type="text/javascript">
                            require(["jquery","mooAttach"], function($,mooAttach) {
                                mooAttach.registerAttachComment(<?php echo $target_id;?>,'<?php echo empty($commentFormId) ? 'commentForm' : $commentFormId; ?>');
                            });
                        </script>
                    <?php else: ?>
                        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooAttach'),'object'=>array('$','mooAttach'))); ?>
                        mooAttach.registerAttachComment(<?php echo $target_id;?>,'<?php echo empty($commentFormId) ? 'commentForm' : $commentFormId; ?>');
                        <?php $this->Html->scriptEnd(); ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterRenderCommentForm', $this,array('type' => 'commentForm' ,'id'=>$target_id))); ?>
            <?php if ( empty( $uid ) ): ?>
            <div class="comment-form-message">
                <?php echo __('Login or register to post your comment')?>
            </div>
            <?php endif; ?>
            <div class="comment-form-attach">
                <input type="hidden" name="thumbnail" id="comment_image_<?php echo $target_id;?>">
                <div id="comment_preview_image_<?php echo $target_id;?>" class="comment_attach_image"></div>

                <div class="userTagging-CommentLink-<?php echo $target_id?>" style="display: none;">
                    <input type="hidden" name="data[userCommentLink]" id="userCommentLink<?php echo $target_id?>" value="" autocomplete="off" placeholder="Share link" type="text">
                </div>
                <div class="userTagging-CommentVideo-<?php echo $target_id?>" style="display: none;">
                    <input type="hidden" name="data[userCommentVideo]" id="userCommentVideo<?php echo $target_id?>" value="" autocomplete="off" placeholder="Share link" type="text">
                </div>
            </div>
        </div>
    </div>
</form>