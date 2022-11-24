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
            $(".error-message").html(json.message);
        }       
	});
} 
</script>
 
<form id="createForm">
<ul class="list6 list6sm2">
	<li><label>Name</label>
		<?php echo $this->Form->text('name'); ?>
	</li>
	<li><label>Key</label>
		<?php echo $this->Form->text('key'); ?>
	</li>
	<li><label>Based on</label>
		<?php echo $this->Form->select('theme', $installed_themes, array('empty' => false)); ?>
	</li>
		<li><label>Version</label>
		<?php echo $this->Form->text('version'); ?>
	</li>
	<li><label>Description</label>
		<?php echo $this->Form->text('description'); ?>
	</li>
	<li><label>Author</label>
		<?php echo $this->Form->text('author'); ?>
	</li>
	<li><label>Website</label>
		<?php echo $this->Form->text('website'); ?>
	</li>
	<li><label>&nbsp;</label>
	    <a href="javascript:void(0)" class="button button-action" onclick="createTheme()" id="createButton"><i class="icon-save"></i> Create</a>
	</li>
</ul>
</form>
<div class="error-message" style="display:none;margin-top:10px;"></div>