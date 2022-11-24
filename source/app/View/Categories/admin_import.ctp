<script>
    $(document).ready(function () {
        $('#createButton').click(function () {
            disableButton('createButton');
            $.post("<?php echo  $this->request->base ?>/admin/categories/do_import", $("#createForm").serialize(), function (data) {
                enableButton('createButton');
                var json = $.parseJSON(data);

                if (json.result == 1)
                    location.reload();
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });

            return false;
        });

    });
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Import categories');?></h4>
</div>
<div class="modal-body">
    <form id="createForm" class="form-horizontal" role="form">
        <?php echo $this->Form->hidden('type', array('value' => $type)); ?>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Import categories from');?></label>
                <div class="col-md-9">
                    <?php echo $this->Form->select('plugin', $plugins, array('class' => 'form-control', 'default' => '0', 'empty' => false)); ?>

                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <?php echo __('After copy button clicked, all categories from your selected plugin will import into this plugin');?>
                </div>
            </div>
        </div>
    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
    </div>
</div>
<div class="modal-footer">
    <a href="#" id="createButton" class="btn btn-action"><?php echo  __('Copy') ?></a>
    <button type="button" class="btn default" data-dismiss="modal"><?php echo  __('Cancel') ?></button>
</div>