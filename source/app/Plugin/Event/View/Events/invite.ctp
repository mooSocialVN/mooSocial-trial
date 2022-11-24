<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooEvent"], function($,mooEvent) {
        mooEvent.initOnInvitePopup();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooEvent'), 'object' => array('$', 'mooEvent'))); ?>
mooEvent.initOnInvitePopup();
<?php $this->Html->scriptEnd();  ?>
<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __( 'Invite Friends')?></div>
</div>
<div class="create_form">
    <form id="sendInvite" class="form-horizontal">
        <div class="modal-body" id="simple-modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('event_id', array('value' => $event_id)); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __( 'Type')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select('invite_type_event',array('1'=>__('Friends'),'2' => __('Emails')),array('empty' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div id="invite_friend">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __( 'Friend')?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->text('friends'); ?>
                            </div>
                        </div>
                    </div>
                    <div id="invite_email" style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __( 'Emails')?></label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->textarea('emails', array('class' => 'form-control')); ?>
                                <div class="help-block">
                                    <?php echo __( 'Not on your friends list? Enter their emails below (separated by commas)<br />Limit 10 email addresses per request')?>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->Moo->isRecaptchaEnabled() && !$isMobile): ?>
                        <div id="recaptcha_content" class="form-group">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-10">
                                <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                    <!--<div class="message" style="display:none;"></div>-->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-modal_save" class="sendButton" id="sendButton"><?php echo __( 'Send Invitations')?></a>
            <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __( 'Close')?></button>
        </div>
    </form>
</div>