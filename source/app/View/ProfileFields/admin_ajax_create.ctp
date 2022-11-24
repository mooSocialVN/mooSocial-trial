<script>
$(document).ready(function(){
	$('#createButton').click(function(){
		disableButton('createButton');
		$.post("<?php echo $this->request->base?>/admin/profile_fields/ajax_save", $("#createFieldForm").serialize(), function(data){
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

	jQuery('#type').change(function(){
		if ( jQuery(this).val() == 'list' || jQuery(this).val() == 'multilist' )
			jQuery('#field_values').show();
		else
			jQuery('#field_values').hide();
	});
});
</script>

<form id="createFieldForm">
<?php echo $this->Form->hidden('id', array('value' => $field['ProfileField']['id'])); ?>

<ul class="list6 list6sm2">
	<li><label>Field Name</label>
		<?php echo $this->Form->text('name', array('value' => $field['ProfileField']['name'])); ?>
	</li>
	<li><label>Field Type</label>
		<?php echo $this->Form->select('type', array( 'heading'   => 'Heading',
		                                              'textfield' => 'Text Field', 
													  'list' 	  => 'List', 
													  'multilist' => 'Multi Select List', 
													  'textarea'  => 'Text Area'
													  ), 
											   array('value' => $field['ProfileField']['type']) 
									); 
		?>
	</li>
	<li <?php if ( !in_array( $field['ProfileField']['type'], array( 'list', 'multilist' ) ) ) echo 'style="display:none"'; ?> id="field_values"><label>Field Values</label>
		<?php echo $this->Form->textarea('values', array('value' => $field['ProfileField']['values'])); ?>
	</li>
	<li><label>Description</label>
		<?php echo $this->Form->textarea('description', array('value' => $field['ProfileField']['description'])); ?>
	</li>
	<li><label>Required</label>
		<?php echo $this->Form->checkbox( 'required', array( 'checked' => $field['ProfileField']['required'] ) ); ?>
	</li>
	<li><label>Registration</label>
		<?php echo $this->Form->checkbox( 'registration', array( 'checked' => $field['ProfileField']['registration'] ) ); ?>
	</li>
	<li><label>Searchable <a href="javascript:void(0)" class="tip" title="Only values that have 4 characters or more can be<br>searched. If you want to make it less than 4, contact<br>your server admin to adjust ft_min_word_len parameter">(?)</a></label>
		<?php echo $this->Form->checkbox( 'searchable', array( 'checked' => $field['ProfileField']['searchable'] ) ); ?>
	</li>
	<li><label>Profile <a href="javascript:void(0)" class="tip" title="Check this if you want to display this field on the main user profile tab">(?)</a></label>
        <?php echo $this->Form->checkbox( 'profile', array( 'checked' => $field['ProfileField']['profile'] ) ); ?>
    </li>
	<li><label>Active</label>
		<?php echo $this->Form->checkbox( 'active', array( 'checked' => $field['ProfileField']['active'] ) ); ?>
	</li>
	<li><label>&nbsp;</label>
	    <a href="#" id="createButton" class="button button-action"><i class="icon-save"></i> Save Field</a>
	</li>
</ul>
</form>
<div class="error-message" style="display:none;margin-top:10px;"></div>