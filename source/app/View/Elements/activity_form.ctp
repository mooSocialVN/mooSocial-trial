<?php if($this->request->is('ajax')):?>
<script type="text/javascript">
    require(["jquery","mooActivities","mooToggleEmoji"], function($,mooActivities,mooToggleEmoji) {
        mooActivities.initActivityForm();
        //mooToggleEmoji.init('message', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooActivities', 'mooToggleEmoji'), 'object' => array('$', 'mooActivities', 'mooToggleEmoji'))); ?>
mooActivities.initActivityForm();
mooToggleEmoji.init('message', '<span class="emoji-toggle-icon material-icons moo-icon moo-icon-mood">mood</span>');
<?php $this->Html->scriptEnd(); ?>

<?php endif; ?>

<form id="wallForm">
	<?php
	echo $this->Form->hidden('type', array('value' => $type));
	echo $this->Form->hidden('target_id', array('value' => $target_id));
	echo $this->Form->hidden('action', array('value' => 'wall_post'));
	echo $this->Form->hidden('wall_photo');
	
	$subject_type = MooCore::getInstance()->getSubjectType();
	echo $this->Form->hidden('subject_type', array('value' => $subject_type));
	?>
    <div class="form-feed-area">
        <div class="form-feed-holder">
            <?php if ( !empty( $cuser ) ): ?>
                <div class="form-feed-avatar">
                    <div class="user_avatar_img">
                        <?php echo $this->Moo->getImage(array('User' => $cuser), array("class" => "user_avatar", "alt" => $cuser['name'], 'prefix' => '50_square')) ?>
                    </div>
                    <div class="user_avatar_name">
                        <?php echo $cuser['name'] ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="post-status">
                <div class="post-status-box">
                    <div class="post-status-message">
                        <?php echo $this->Form->textarea('message', array('name' => 'messageText', 'placeholder' => $text),true); ?>
                    </div>
                    <div id="message-emoji" class="emoji-toggle"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-feed-toolbar"><div class="form-feed-toolbar-main"></div></div>

    <div class="form-feed-share">
        <div class="userTagging-userShareLink hidden">
            <input type="hidden" name="data[userShareLink]" id="userShareLink" value="" autocomplete="off" placeholder="Share link" type="text">
        </div>
        <div class="userTagging-userShareVideo hidden">
            <input type="hidden" name="data[userShareVideo]" id="userShareVideo" value="" autocomplete="off" placeholder="Share link" type="text">
        </div>
    </div>

	<div id="formFeedReview" class="form-feed-review">
        <div id="formFeedReviewMain" class="form-feed-review-main">
            <div id="wall_photo_preview" class="form-feed-review-item" style="display:none">
                <div id="addMoreImage" style="display:none;" class="photo-review-thumb addMoreImage"><span class="add-more-img-icon material-icons moo-icon moo-icon-add">add</span></div>
            </div>
            <!-- Hook for plugin -->
            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.activityForm.renderReviewItems', $this, array('type' => $type, 'target_id' => $target_id))); ?>
            <?php echo $this->Form->userTagging('','userTagging',true); ?>
        </div>
	</div>

    <input type="hidden" name="data[shareImage]" id="shareImage" value="1">

    <div class="stt-action">
        <div id="AddPhotoFeed" class="stt-action-item add-photo-feed">
            <div id="select-2" <?php if (!$isMobile):?>data-toggle="tooltip" title="<?php echo __('Add photos to your post');?>"<?php endif;?>></div>
        </div>
        <div id="UserTaggingFeed" class="stt-action-item user-tagging-container">
            <div class="stt-action-btn" <?php if (!$isMobile):?>data-toggle="tooltip" title="<?php echo __('Tag people in your post');?>"<?php endif;?> onclick="$('#userTagging-id-userTagging').toggleClass('hidden');$('.userTagging-userTagging input').focus()">
                <div class="stt-action-w">
                    <span class="stt-action-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                </div>
            </div>
        </div>

        <!-- Hook for plugin -->
        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.activityForm.afterRenderItems', $this, array('type' => $type, 'target_id' => $target_id))); ?>
        <div id="commentButton_0" class="post-stt-btn">
            <div class="wall-post-action">
                <?php if (strtolower($type) == 'user' && !$target_id):?>
                    <?php echo $this->Form->select('privacy', array( PRIVACY_EVERYONE => __('Everyone'), PRIVACY_FRIENDS => __('Friends Only') ), array('empty' => false, 'class' => 'post-feed-privacy')); ?>
                <?php else:?>
                    <?php echo $this->Form->hidden('privacy', array('value' => PRIVACY_EVERYONE));?>
                <?php endif;?>
                <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.activityForm.renderOptions', $this, array('type' => $type, 'target_id' => $target_id))); ?>
                <a id="status_btn" class="btn btn-post_feed" href="javascript:void(0)"> <?php echo __('Share')?></a>
            </div>
        </div>
    </div>
</form>