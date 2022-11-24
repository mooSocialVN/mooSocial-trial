<script>
$(document).ready(function(){
	$('#createButton').click(function(){
        disableButton('createButton');
        $(".error-message").hide();
		$.post("<?php echo $this->request->base?>/admin/users/create_user", $("#createForm").serialize(), function(data){
			enableButton('createButton');
			if (data.indexOf('mooError') > 0) {
                $(".error-message").html(data);
                $(".error-message").show();
            } else {
            	window.location = "<?php echo $this->request->base?>/admin/users";
            }
		});
        
		return false;
	});
});

</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Create New User');?></h4>
</div>
<div class="modal-body">

<form id="createForm" class="form-horizontal" role="form">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Full Name');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('name', array('placeholder'=>__('Full Name'),'class'=>'form-control')); ?>
            </div>           
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Email Address');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('email', array('placeholder'=>__('Email Address'),'class'=>'form-control')); ?>
            </div>           
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Password');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('password', array('type'=>'password','placeholder'=>__('Password'),'class'=>'form-control')); ?>
            </div>           
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">&nbsp;</label>
            <div class="col-md-9 email-credential">
                <?php echo $this->Form->input('email_credential', array('type' => 'checkbox', 'label' => __('Email credentials to user?'), 'checked' => 0)); ?>
            </div>
        </div>
    </div>
</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close')?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo __('Save')?></a>

</div>

<style>
    .email-credential label {
        margin-left: 20px;
    }
</style>