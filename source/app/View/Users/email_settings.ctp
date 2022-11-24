<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<?php echo $this->element('profilenav', array("cmenu" => "email_settings"));?>
<?php $this->end(); ?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Email notification settings')?></h1>
            </div>
        </div>
        <div class="box_content profile-info-edit">
            <div class="create_form">
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php echo $this->Form->checkbox('unsubcribe_email', array('checked' => ($unsub) ? 1 : 0)); ?>
                                <?php echo __('Unsubcribe all emails (if this option is enabled, the below setttings will be ignored by system)')?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php echo $this->Form->checkbox('notification_email', array('checked' => $user['User']['notification_email'])); ?>
                                <?php echo __('Daily notification summary email')?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php echo $this->Form->checkbox('request_friend_email', array('checked' => $user['User']['request_friend_email'])); ?>
                                <?php echo __('Friend Request email')?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <?php
                    $disableMessageAction = false;
                    if (Configure::read('Chat.chat_turn_on_notification') !== NULL){
                        if(Configure::read('Chat.chat_turn_on_notification')==1){
                            $disableMessageAction = true;
                        }
                    }
                    if (!$disableMessageAction)
                    {
                        if (!Configure::read('core.time_notify_message_unread'))
                        {
                            $disableMessageAction = true;
                        }
                    }
                    ?>

                    <div class="form-group" <?php if ($disableMessageAction): ?> style="display: none;" <?php endif;?>>
                        <div class="col-xs-12">
                            <label class="checkbox-control">
                                <?php echo $this->Form->checkbox('send_email_when_send_message', array('checked' => $user['User']['send_email_when_send_message'])); ?>
                                <?php echo __('Member will get email if he does not read message at a specific time (%s)',Configure::read('core.time_notify_message_unread').' '.__('minutes'))?>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>

                    <?php
                    $this->getEventManager()->dispatch(new CakeEvent('User.EmailSetting.View', $this));
                    ?>
                    <div class="create-form-actions">
                        <input class="btn btn-primary" type="submit" value="<?php echo __('Save Changes'); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>