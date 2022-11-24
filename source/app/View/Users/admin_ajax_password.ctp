<script>
$(document).ready(function(){    
    $("#changePassBut").click(function(){
        disableButton('changePassBut');
        $.post("<?php echo $this->request->base?>/admin/users/do_password", $("#changePassForm").serialize(), function(data){
            enableButton('changePassBut');
            var json = $.parseJSON(data);
            
            if ( json.result == 1 )
            {
                sModal.hideModal();
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

<form id="changePassForm">
<?php echo $this->Form->hidden('id', array('value' => $id)); ?>
<ul class="list6 list6sm2">
    <li><label>New Password</label><?php echo $this->Form->password('password'); ?></li>         
    <li><label>Verify Password</label><?php echo $this->Form->password('password2'); ?></li>
    <li><label>Notify User</label><?php echo $this->Form->checkbox('notify'); ?></li>
    <li><label>&nbsp;</label>
        <a href="#" id="changePassBut" class="button button-action"><i class="icon-ok"></i> Change Password</a>
    </li>
</ul>
</form>
<div class="error-message" style="display:none;margin-top:10px;"></div>