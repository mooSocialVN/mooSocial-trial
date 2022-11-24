<script>
    $(document).ready(function () {
        $('#createButton').click(function () {
            disableButton('createButton');
            $.post("<?php echo $this->request->base?>/admin/plugins/ajax_save", $("#createForm").serialize(), function (data) {
                location.reload();
            });
        });


    });
</script>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Plugin Info');?></h4>
</div>
<?php if(!isset($error)):?>
<div class="modal-body">

    <form id="createForm" class="form-horizontal" role="form">
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Name');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $plugin['name'] ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Key');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $plugin['key'] ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Version');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $plugin['version'] ?> <?php if ($info->version > $plugin['version']): ?>(
                            <a href="<?php echo  $this->request->base ?>/admin/plugins/do_upgrade/<?php echo  $plugin['id'] ?>">Upgrade</a>)<?php endif; ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Author');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $info->author ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Website');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $info->website ?>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3"><?php echo __('Description');?>:</label>
                <div class="col-md-9">
                    <p class="form-control-static">
                        <?php echo  $info->description ?>
                    </p>
                </div>
            </div>

        </div>
    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>

</div>
<?php else:?>
    <div class="Metronic-alerts alert alert-success fade in" id="flashMessage"><?php echo $error;?></div>
<?php endif;?>