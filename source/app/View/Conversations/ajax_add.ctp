<?php $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGlobal"], function($,mooGlobal) {
        mooGlobal.initConversationAjaxAdd();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooGlobal'), 'object' => array('$', 'mooGlobal'))); ?>
mooGlobal.initConversationAjaxAdd();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __('Send New Message')?>
    </div>
</div>

<div class="create_form">
    <form id="sendMessage" class="form-horizontal">
        <div class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for=""><?php echo __('Friends')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('friends', array('class' => 'form-control')); ?>
                            <div class="help-block">
                                <?php echo __('People you add will see all previous messages in this conversation')?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
            <?php echo $this->Form->hidden('msg_id', array('value' => $msg_id)) ?>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-modal_save" id="sendButton"><?php echo __('Add People')?></a>
            <button class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close'); ?></button>
        </div>
    </form>
</div>