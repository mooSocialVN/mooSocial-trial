<script>
$(document).ready(function(){    
    $("#changePassBut").click(function(){
        $("#changePassBut").spin('small');
        disableButton('changePassBut');
        $.post("<?php echo $this->request->base?>/admin/users/do_password", $("#changePassForm").serialize(), function(data){
            enableButton('changePassBut');
            var json = $.parseJSON(data);
            $("#changePassBut").spin(false);
            if ( json.result == 1 )
            {
                $('#ajax').modal('hide');
                $('#themeModal').modal('hide');
                mooAlert('Password has been changed');
            }
            else
            {
                $(".error-message").show();
                $(".error-message").html(json.message);
            }       
        });
    });
});
</script>
<div class="modal-body">
<form id="changePassForm">
<?php echo $this->Form->hidden('id', array('value' => $id)); ?>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo __('New Password')?></label>
        <div class="col-md-9">
            <?php echo $this->Form->password('password', array('class'=>'form-control')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo __('Verify Password')?></label>
        <div class="col-md-9">
            <?php echo $this->Form->password('password2', array('class'=>'form-control')); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label"><?php echo __('Notify User')?></label>
        <div class="col-md-9">
           <?php echo $this->Form->checkbox('notify'); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-9">
           <a href="#" id="changePassBut" class="btn btn-action"><?php echo __("Change Password");?></a>
        </div>
        <div class="clear"></div>
    </div>

</form>

<div class="error-message Metronic-alerts alert alert-danger" style="display:none;margin-top:10px;"></div>
</div>