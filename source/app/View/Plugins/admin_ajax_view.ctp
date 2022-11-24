<script>
$(document).ready(function(){
    $('#createButton').click(function(){
        var checked = false;
        $('#permission_list :checkbox').each(function(){
            if ($(this).is(':checked'))
               checked = true;
        })
        
        if (!checked)
        {
           $(".error-message").show();
           $('.error-message').html('Please check at least one user role in the Permissions tab');
           return;
        }
        
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/plugins/ajax_save", $("#createForm").serialize(), function(data){
            location.reload();
        });
    });
    
    initTabs('plugin_view');
});
</script>

<div id="plugin_view">
    <div class="tabs-wrapper">
        <ul class="tabs">
            <li id="plugin_info" class="active">Plugin Info</li>
            <li id="plugin_settings">Settings</li>
            <li id="plugin_permissions">Permissions</li>  
        </ul>
    </div>
    
    <form id="createForm">
    <div id="plugin_info_content" class="tab" style="display:block">	
        <ul class="list6 info">
        	<li><label>Name</label><?php echo $plugin['Plugin']['name']?></li>
        	<li><label>Key</label><?php echo $plugin['Plugin']['key']?></li>
        	<li><label>Version</label><?php echo $plugin['Plugin']['version']?> <?php if ( $info->version > $plugin['Plugin']['version'] ):?>(<a href="<?php echo $this->request->base?>/admin/plugins/do_upgrade/<?php echo $plugin['Plugin']['id']?>">Upgrade</a>)<?php endif; ?></li>
        	<li><label>Author</label><?php echo $info->author?></li>
        	<li><label>Website</label><?php echo $info->website?></li>
        	<li><label>Description</label><?php echo $info->description?></li>
        </ul>
    </div>
    <div id="plugin_settings_content" class="tab"> 
        <?php echo $this->Form->hidden('id', array('value' => $plugin['Plugin']['id'])); ?>
        <ul class="list6">
            <?php foreach ( get_object_vars($info->settings) as $key => $data ): ?>
            <li><label><?php echo $data->label?></label>
            <?php 
            switch ( $data->type )
            {
                case 'checkbox':
                    echo $this->Form->checkbox($key, array( 'checked' => $settings[$key] ));
                break;
                    
                default:
                    echo $this->Form->text($key, array( 'value' => $settings[$key] ));
            }
            
            if ( !empty( $data->description ) ):
            ?>
            (<a href="javascript:void(0)" class="tip" title="<?php echo $data->description?>">?</a>)
            <?php 
            endif;
            ?></li>
            <?php endforeach; ?>            
            <li><label>Show in menu</label><?php echo $this->Form->checkbox('menu', array( 'checked' => $plugin['Plugin']['menu'] ))?></li>
            <li><label>Menu URL</label><?php echo $this->Form->text('url', array( 'value' => $plugin['Plugin']['url'] ))?></li>
            <li><label>Enabled</label><?php echo $this->Form->checkbox('enabled', array( 'checked' => $plugin['Plugin']['enabled'] ))?></li>
            <li><label>Icon class</label><?php echo $this->Form->text('icon_class', array( 'value' => $plugin['Plugin']['icon_class'] ))?></li>
        </ul>
    </div>
    <div id="plugin_permissions_content" class="tab">
        <?php echo $this->element('admin/permissions', array('permission' => $plugin['Plugin']['permission'])); ?>
    </div>
    </form>
    
    <div class="regSubmit">
        <a href="#" id="createButton" class="button button-action"><i class="icon-save"></i> Save Changes</a>
    </div>
    
    <div class="error-message" style="display:none;margin-top:10px"></div>
</div>