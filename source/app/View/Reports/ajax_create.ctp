<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<script type="text/javascript">
    require(["jquery","mooBehavior"], function($,mooBehavior) {
        mooBehavior.initOnReportItem();
    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __('Report')?></div>
</div>

<div class='create_form'>
    <form id="reportForm" class="form-horizontal">
        <div class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                    <?php echo $this->Form->hidden('type', array( 'value' => $type ) ); ?>
                    <?php echo $this->Form->hidden('target_id', array( 'value' => $target_id ) ); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Reason')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->textarea('reason', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-alert">
                    <div class="alert alert-danger error-message" style="display:none;"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a id="reportButton" class="btn btn-modal_save" href="javascript:void(0);"><?php echo __('Report')?></a>
        </div>
    </form>
</div>