<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooActivities"], function($, mooActivities) {
        mooActivities.initOnAjaxLoadActivityEdit();
    });
    require(["jquery","mooToggleEmoji"], function($, mooToggleEmoji) {
        mooToggleEmoji.init('message_edit_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooToggleEmoji'),  'object' => array('$', 'mooToggleEmoji'))); ?>
    mooToggleEmoji.init('message_edit_<?php echo $activity['Activity']['id'];?>', '<span class="post-area-icon material-icons moo-icon moo-icon-mood">mood</span>');
    <?php $this->Html->scriptEnd();  ?>
<?php endif; ?>

<div id="activity_edit_<?php echo $activity['Activity']['id']?>" class="comment-form activity-feed-edit-form">
    <div class="comment-form-main">
        <div class="comment-form-area">
            <div class="post-area">
                <div class="post-area-text">
                    <?php echo $this->Form->textarea("message_edit_".$activity['Activity']['id']."",array('name' => "message", 'value' => $activity['Activity']['content'], 'class' => 'post-area-input commentBox'),true ); ?>
                </div>
                <div class="post-area-action">
                    <div class="post-area-icons">
                        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Activities.renderEditActivityToolbar', $this,array('activity' => $activity))); ?>
                        <div id="message_edit_<?php echo $activity['Activity']['id'];?>-emoji" class="post-area-box emoji-toggle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->getEventManager()->dispatch(new CakeEvent('View.Activities.afterRenderEditActivityForm', $this,array('activity' => $activity))); ?>
    <div class="edit-post-action">
        <a class="btn btn-cancel_edit cancelEditActivity" data-activity-id="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);" ><?php echo __('Cancel');?></a>
        <a class="btn btn-submit_edit confirmEditActivity" data-activity-id="<?php echo $activity['Activity']['id'];?>" href="javascript:void(0);" ><?php echo __('Done Editing');?></a>
	</div>
</div>