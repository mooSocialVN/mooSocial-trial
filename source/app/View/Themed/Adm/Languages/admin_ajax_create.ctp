<script>
    $(document).ready(function () {
        $('#createButton').click(function () {
            disableButton('createButton');
            $.post("<?php echo $this->request->base?>/admin/languages/ajax_create_save", $("#createForm").serialize(), function (data) {
                enableButton('createButton');
                var json = $.parseJSON(data);

                if (json.result == 1)
                    location.reload();
                else {
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
    <h4 class="modal-title"><?php echo __('Create new')?></h4>
</div>
<div class="modal-body">
    <form id="createForm" class="form-horizontal" role="form">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Name');?></label>

                <div class="col-md-9">
                    <?php echo $this->Form->text('name', array('placeholder' => 'Enter text','class' => 'form-control')); ?>
                </div>
            </div>
        </div>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Key');?></label>

                <div class="col-md-9">
                    <?php echo $this->Form->text('key', array('placeholder' => 'Enter key','class' => 'form-control')); ?>
                    <div style="padding-top:5px;">
	                	<a target="_blank" href="https://www.iban.com/country-codes">https://www.iban.com/country-codes</a>
	                </div>
                </div>
                
            </div>
        </div>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('RTL');?></label>

                <div class="col-md-9">
                    <?php $options = array(
                        'class' => 'form-control',
                        'label' => false,
                        'value' => 0
                    );
                    ?>
                    <?php echo $this->Form->checkbox('rtl', $options); ?>
                </div>
            </div>
        </div>
    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close')?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo __('Save Language');?></a>

</div>