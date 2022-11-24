<script>
$(document).ready(function(){    
    $('#createButton').click(function(){
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/roles/ajax_save", $("#createForm").serialize(), function(data){
            enableButton('createButton');
            var json = $.parseJSON(data);
            
            if ( json.result == 1 )
                location.reload();
            else
            {
                $(".error-message").show();
                $(".error-message").html(json.message);
            }
        });
        return false;
    });  
    
    $('.perm_tab').click(function(){
        $(this).next().slideToggle();
        return false; 
    });
    
    initTabs('role_create');
});
</script> 
<style>
.perm_tab:hover {
    text-decoration: none;
}
</style>

<form id="createForm">
<?php echo $this->Form->hidden('id', array('value' => $role['Role']['id']))?>

<div id="role_create">
    <div class="tabs-wrapper">
        <ul class="tabs">
            <li id="settings" class="active">Settings</li>
            <li id="permissions">Permissions</li>
        </ul>
    </div>
    <div id="settings_content" class="tab" style="display:block">
        <ul class="list6 list6sm2">
            <li><label>Name</label>
                <?php echo $this->Form->text('name', array('value' => $role['Role']['name'])); ?>
            </li>
            <li><label>Admin</label>
                <?php echo $this->Form->checkbox('is_admin', array( 'checked' => $role['Role']['is_admin'] ) ); ?>
            </li>
            <li><label>Super Admin</label>
                <?php echo $this->Form->checkbox('is_super', array( 'checked' => $role['Role']['is_super'] ) ); ?>
            </li>
        </ul>
    </div>
    <div id="permissions_content" class="tab">
        <?php if ( $role['Role']['id'] == ROLE_GUEST ): ?>
        <em>Guests cannot create/edit/delete items regardless of the selections below</em>
        <?php endif; ?>
        
        <?php foreach ( $aco_groups as $group => $acos ): ?>
        <a href="#" class="perm_tab"><h2><?php echo Inflector::humanize($group)?> Permissions</h2></a>
        <ul class="list6">
            <?php foreach ( $acos as $aco ): ?>
            <li><?php echo $this->Form->checkbox('param_' . $group . '_' . $aco['Aco']['key'], array('checked' => in_array($group . '_' . $aco['Aco']['key'], $permissions)))?> <?php echo $aco['Aco']['description']?></li>
            <?php endforeach; ?>
        </ul>
        <?php
        endforeach;
        ?>
    </div>
    
    <div class="regSubmit">
        <a href="#" id="createButton" class="button button-action"><i class="icon-save"></i> Save Changes</a>
    </div>
</div>
</form>
<div class="error-message" style="display:none;margin-top: 10px;"></div>