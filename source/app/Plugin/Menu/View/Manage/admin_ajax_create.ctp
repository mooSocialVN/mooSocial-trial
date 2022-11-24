<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo  __( 'Create a new menu'); ?></h4>
</div>
<script type="text/javascript">
    function createMenu() {
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/menu/manage/ajax_create", $("#createForm").serialize(), function (data) {
            enableButton('createButton');
            var json = $.parseJSON(data);
            if (json.result == 1) {
                $('#ajax').modal('hide');
                window.location = '<?php echo $this->request->base?>/admin/menu/manage/edit_menu/' + json.id;
            }
            else {
                $(".error-message").show();
                $(".error-message").html(json.message);
            }
        });
    }
</script>
<div class="modal-body">
    <form id="createForm" class="form-horizontal" role="form">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo  __( 'Menu Name'); ?></label>

                <div class="col-md-9">
                    <?php echo $this->Form->text('name', array('placeholder' => __('Name'), 'class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo  __( 'Menu Style'); ?></label>

                <div class="col-md-9">
                    <?php echo $this->Form->input('style', array('options' => array('horizontal' => __( 'Horizontal'),
                        'vertical' => __( 'Vertical')
                    ),'label' => false)); ?>
                </div>
            </div>
        </div>

    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo  __( 'Close'); ?></button>
    <a href="javascript:void(0);" id="createButton" class="btn blue" onclick="createMenu()"><i
            class="icon-save"></i> <?php echo  __( 'Create'); ?></a>
</div>
