<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($,mooGroup) {
        mooGroup.initAjaxInvite();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initAjaxInvite();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>

<div class="modal-header">
    <div class="title-modal">
        <?php echo __( 'Invite Friends to Join')?>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    </div>
</div>
<div class="create_form">
    <form id="sendInvite" class="form-horizontal">
        <div class="modal-body" id="simple-modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('group_id', array('value' => $group_id)); ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __( 'Type')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->select('invite_type_group',array('1'=>__('Friends'),'2' => __('Emails')),array('empty' => false, 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div id="invite_friend" class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __( 'Friends')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('friends', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div id="invite_email" class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label"><?php echo __( 'Emails')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->textarea('emails', array('class' => 'form-control')); ?>
                            <div class="help-block">
                                <?php echo __( 'Not on your friends list? Enter their emails below (separated by commas)<br />Limit 10 email addresses per request')?><br />
                            </div>
                            <?php if ($this->Moo->isRecaptchaEnabled() && !$isMobile): ?>
                            <div id="recaptcha_content">
                                <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="message" style="display:none;"></div>
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-modal_save" id="sendButton"><?php echo __( 'Send Invitations')?></a>
            <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __( 'Close')?></button>
        </div>
    </form>
</div>