<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<?php echo $this->element('profilenav', array("cmenu" => "notification_settings"));?>
<?php $this->end(); ?>
<?php
    $array = array(
        'comment_item' => __('When people comment on things I post such as status, blogs, events....'),
        'reply_comment'=> __('When people reply to things I comment on'),
        'reply_of_reply' => __('When people reply to things I reply on'),
        'like_item' => __('When people like things I post such as status, topics, blogs...'),
        'comment_of_comment' => __('When people comment on things I comment on such as status, blogs, events....'),
        'share_item' => __('When people share things I post such as status, topics, blogs...'),
        'post_profile' => __('When people post on my profile'),
        'tag_photo' => __('When people are tagged in photos'),
        'comment_tag_photo' => __('When people comment on a photo that someone has tagged me in'),
        'like_tag_photo' => __('When people like photo that someone has tagged me in'),
        'mention_user' => __('When people mention me'),
        'like_comment_mention' => __('When people like comment that someone has mentioned me in'),
        'comment_mention_status' => __('When people comment on a status that someone mentioned me in'),
        'like_mention_status' => __('When people like a status that someone mentioned me in'),
        'tag_user' => __('When people have tagged me in something'),
        'like_tag_user' => __('When people like a status that someone has tagged me in'),
        'comment_tag_user' => __('When people comment on a status that someone tagged me in')
    );
    
    if (Configure::read('core.time_notify_message_unread'))
    {
    	$array['notify_message_user'] = __('When people send me a message but I have not read it in %s minutes',Configure::read('core.time_notify_message_unread'));
    }
?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Notification Settings')?></h1>
            </div>
        </div>
        <div class="box_content profile-info-edit">
            <div class="create_form">
                <form class="form-horizontal" method="post">
                    <p><?php echo __('Which of the these do you want to receive notification alerts about?')?></p>
                    <p>(<?php echo __('Tick the items you want to receive.')?>)</p>
                    <?php foreach ($array as $key=>$text): ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php echo $this->Form->checkbox($key, array('checked' => isset($notification_setting[$key]) ? $notification_setting[$key] : true)); ?>
                                <?php echo $text?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php $this->getEventManager()->dispatch(new CakeEvent('User.NotificationSettings.View', $this)); ?>

                    <div class="create-form-actions">
                        <input class="btn btn-primary" type="submit" value="<?php echo __('Save Changes'); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>