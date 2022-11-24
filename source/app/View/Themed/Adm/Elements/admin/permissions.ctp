<?php if($this->request->is('ajax')): ?>
<script>
<?php else: ?>
<?php  $this->Html->scriptStart(array('inline' => false));   ?>
<?php endif; ?>
$(document).ready(function(){
    $('#everyone').click(function(){
        if ( $('#everyone').is(':checked') )
        {
            $('#permission_list div.form-group').hide();
            $('#permission_list div.form-group').first().show();
        }
        else
            $('#permission_list div.form-group').show();
    });
});
<?php if($this->request->is('ajax')): ?>
</script>
<?php else: ?>
<?php $this->Html->scriptEnd();  ?>
<?php endif; ?>
<div class="list6" id="permission_list">
    <div class="form-group"><label class="col-md-3 control-label"><?php echo __('Everyone')?></label>
        <div class="col-md-9">
          <label class="checkbox-inline">
        <?php echo $this->Form->checkbox('everyone', array('checked' => ( $permission === '' ) ) ); ?>
          </label>
        </div>
    </div>
    <?php
    foreach ( $roles as $role ):
    ?>
    <div style="<?php if ( $permission === '' ) echo 'display:none'; ?>" class="form-group">
        <div class="col-md-3 control-label">
        <label><?php echo $role['Role']['name']?></label>
        </div>
        
        <div class="col-md-9">
        <label class="checkbox-inline">
        <input type="checkbox" name="permissions[]" value="<?php echo $role['Role']['id']?>" <?php if ( in_array($role['Role']['id'], explode(',', $permission))) echo 'checked';?>>
        </label>
        </div>
        </div>
    <?php 
    endforeach; 
    ?>
    <div class="clear"></div>
</div>