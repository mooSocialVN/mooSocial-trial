<script>
$(document).ready(function(){
	$('#createButton').click(function(){
		disableButton('createButton');
		$.post("<?php echo $this->request->base?>/admin/languages/ajax_save", $("#createForm").serialize(), function(data){
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
});
</script>

<form id="createForm">
<?php echo $this->Form->hidden('id', array('value' => $language['Language']['id'])); ?>
<ul class="list6 list6sm2">
	<li><label>Name</label>
		<?php echo $this->Form->text('name', array('value' => $language['Language']['name'])); ?>
	</li>	
	<li><label>&nbsp;</label>
	    <a href="#" class="button button-action" id="createButton"><i class="icon-save"></i> Save Language</a>
	</li>
</ul>
</form>
<div class="error-message" style="display:none;"></div>