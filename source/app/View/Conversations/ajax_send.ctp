<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGlobal"], function($,mooGlobal) {
        mooGlobal.initConversationSendBtn();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooGlobal'), 'object' => array('$', 'mooGlobal'))); ?>
mooGlobal.initConversationSendBtn();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if(empty($notAllow)): ?>
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
                    <?php if (!empty($to)): ?>
                    <input type="hidden" name="data[friends]" value="<?php echo $to['User']['id']?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for=""><?php echo __('To')?></label>
                        <div class="col-sm-10">
                            <div class="form-control-static"><?php echo $to['User']['name']?></div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="friends"><?php echo __('To')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('friends', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Subject')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('subject', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Message')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->textarea('message', array('class' => 'form-control', 'style' => 'height:120px')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-modal_save" id="sendButton"><?php echo __('Send Message')?></a>
            <button class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close'); ?></button>
        </div>
    </form>
</div>
<?php else: ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <div class="title-modal">
            <?php echo __('Warning')?>
        </div>
    </div>
<div class="modal-body">
    <div class="modal-form-content">
        <div class="form-content">
            <div><?php echo __('This person is receiving messages from Friends only') ?></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close'); ?></button>
</div>
<?php endif; ?>