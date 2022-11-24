<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGlobal"], function($,mooGlobal) {
        mooGlobal.initInviteFriendBtn('<?php echo $mode?>');
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooGlobal'), 'object' => array('$', 'mooGlobal'))); ?>
mooGlobal.initInviteFriendBtn('<?php echo $mode?>');
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if ($mode):?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __( 'Invite Your Friends')?>
    </div>
</div>
<div class="create_form">
    <form id="inviteForm" class="form-horizontal">
        <div id="inviteFormBody" class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php echo __("Enter your friends' emails below (separated by commas). Limit 10 email addresses per request")?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="to"><?php echo __('To')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->textarea('to', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message"><?php echo __('Message')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->textarea('message', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <?php if ($isMobile && $mode):
                    else:
                        if ($this->Moo->isRecaptchaEnabled()): ?>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                    <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif;?>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a id="inviteButton" class="btn btn-modal_save" href="javascript:void(0);"><?php echo __('Send Invitation')?></a>
            <button type="button" class="btn btn-modal_close" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
<?php else: ?>
<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Invite Your Friends')?></h3>
        </div>
    </div>
    <div class="box_content content_center_home">
        <div class="create_form">
            <form id="inviteForm" class="form-horizontal">
                <div class="form-group">
                    <div class="col-xs-12">
                        <?php echo __("Enter your friends' emails below (separated by commas). Limit 10 email addresses per request")?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="to"><?php echo __('To')?></label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->textarea('to', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="message"><?php echo __('Message')?></label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->textarea('message', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <?php if ($isMobile && $mode):
                else:
                    if ($this->Moo->isRecaptchaEnabled()): ?>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif;?>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-2">
                        <div class="alert alert-danger error-message" style="display:none;"></div>
                        <div class="create-form-actions">
                            <a id="inviteButton" class="btn btn-primary" href="javascript:void(0);"><?php echo __('Send Invitation')?></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif ?>