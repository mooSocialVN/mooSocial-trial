<?php if($dir_writable == 0): ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Error!</h4>
</div>
<div class="modal-body">
    <div class="alert alert-danger error-message" style="margin-top:10px;">
        <?php echo __('The Plugin directory is not writable. Please change it to 755 first.');?>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
</div>    
<?php else: ?>
<script>
function createPlugin()
{
	disableButton('createButton');		
	$.post("<?php echo $this->request->base?>/admin/plugins/ajax_structure", $("#createForm").serialize(), function(data){
		enableButton('createButton');
		var json = $.parseJSON(data);
            
        if ( json.result == 1 )
            window.location = '<?php echo $this->request->base?>/admin/plugins';
        else
        {
            $(".error-message").show();
            $(".error-message").html('<strong>Error!</strong>'+json.message);
        }       
	});
} 
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Create New Plugin');?></h4>
</div>
<div class="modal-body">
<form id="createForm" class="form-horizontal" role="form">
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-md-3"><?php echo __('Type');?>:</label>
            <div class="col-md-9">
                <?php
                    echo $this->Form->input('plugin_type', array(
                        'options' => $pluginType,
                        'empty' => array('' => __('Default')),
                        'class' => 'form-control',
                        'label' => false,
                        'disabled' => (isset($plugin['id']) && $plugin['id']) > 0 ? 'true' : '',
                        'value' => isset($plugin['plugin_type']) ? $plugin['plugin_type'] : ''
                    ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Name');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('name',array('placeholder'=>__('Name'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Key');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('key',array('placeholder'=>__('Key'),'class'=>'form-control')); ?>
                <p><?php echo __("Key only contains letters, numbers with NO space and the underscore '_'");?></p>
                <p><?php echo __("Example: ContactManager");?></p>
            </div>
        </div>      
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Version');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('version',array('placeholder'=>__('Version'),'class'=>'form-control')); ?>
                <p><?php echo __("Version only contains number and the dot '.'");?></p>
                <p><?php echo __("Example: 1.0, 1.0.1");?></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Enabled');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->checkbox('enabled', array('value' => '1')); ?>                
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Description');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('description',array('placeholder'=>__('Description'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Author');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('author',array('placeholder'=>__('Author'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Website');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('website',array('placeholder'=>__('Website'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Bootstrap');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->checkbox('bootstrap', array('value' => '1')); ?>                
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Routes');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->checkbox('routes', array('value' => '1')); ?>                
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Add to menu');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->checkbox('add_to_menu', array('value' => '1')); ?>
            </div>
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="#" id="createButton" class="btn blue" onclick="createPlugin()"><i class="icon-save"></i> <?php echo __('Create');?></a>

</div>

<?php endif; ?>