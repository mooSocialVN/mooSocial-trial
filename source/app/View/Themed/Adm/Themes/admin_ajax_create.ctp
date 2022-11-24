<script>
function createTheme()
{
	disableButton('createButton');		
	$.post("<?php echo $this->request->base?>/admin/themes/ajax_save", $("#createForm").serialize(), function(data){
		enableButton('createButton');
		var json = $.parseJSON(data);
            
        if ( json.result == 1 )
            window.location = '<?php echo $this->request->base?>/admin/themes/editor/' + json.id;
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
    <h4 class="modal-title"><?php echo  __('Add New'); ?></h4>
</div>
<div class="modal-body">
<form id="createForm" class="form-horizontal" role="form">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo  __('Name');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('name',array('placeholder'=> __('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo  __('Key');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('key',array('placeholder'=>__('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo  __('Based on');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->select('theme', $installed_themes, array('placeholder'=>__('Enter text'),'class'=>'form-control','empty' => false)); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Version');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('version',array('placeholder'=>__('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Description');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('description',array('placeholder'=>__('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Author');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('author',array('placeholder'=>__('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Website');?></label>
            <div class="col-md-9">
                <?php echo $this->Form->text('website',array('placeholder'=>__('Enter text'),'class'=>'form-control')); ?>
            </div>
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="#" id="createButton" class="btn blue" onclick="createTheme()"><i class="icon-save"></i> <?php echo __('Create');?></a>

</div>