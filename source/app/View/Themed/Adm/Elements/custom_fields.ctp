<?php if (!isset($show_profile_type) || $show_profile_type):?>
<?php if($this->request->is('ajax')): ?>
	<script>
<?php else: ?>
	<?php $this->Html->scriptStart(array('inline' => false)); ?>
<?php endif;?>
   		$('#profile_type_id').unbind('change');
   		$('#profile_type_id').change(function(){
            var profile_type_id = $('#profile_type_id').val();
            $.get( mooConfig.url.base + "/admin/users/ajax_loadfields/" + profile_type_id + '/profile', function( data ) {
                $( ".custom-field" ).html( data );
            });
        });
<?php if($this->request->is('ajax')): ?>
	</script>
<?php else: ?>
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<!-- custom profle type -->
<div class="form-group" <?php if(count($profile_type) <= 1):?> style="display: none;" <?php endif;?>>
    <div class="col-sm-3  control-label">
        <label><?php echo __('Profile type');?></label>
    </div>
    <div class="col-sm-9">
        <?php 
        	$params = array(
            	'class' => 'form-control',
            	'empty' => false,
        	);
        	if (isset($profile_type_id))
        		$params['value'] = $profile_type_id;
        	
        	echo $this->Form->select('profile_type_id', $profile_type, $params); 
        	?>
    </div>
    <div class="clear"></div>
</div>
<!-- end -->
<?php endif;?>

<?php if (!isset($show_profile_type) || $show_profile_type):?><div class="custom-field"><?php endif;?>
<?php
if ( !empty( $custom_fields ) )
{
	$helper = MooCore::getInstance()->getHelper("Core_Moo");
	foreach ( $custom_fields as $field )
	{
		$val = ( isset( $values[$field['ProfileField']['id']]['value'] ) ) ? $values[$field['ProfileField']['id']]['value'] : '';

		if (!in_array($field['ProfileField']['type'],$helper->profile_fields_default))
		{
			$options = array();
			if ($field['ProfileField']['plugin'])
			{
				$options = array('plugin' => $field['ProfileField']['plugin']);
			}

			echo $this->element('profile_field/' . $field['ProfileField']['type'], array('field' => $field,'show_require'=>isset($show_require) ? $show_require : null,'val'=>$val),$options);
			continue;
		}

		if ( $field['ProfileField']['type'] == 'heading' && !empty( $show_heading ) )
        {
            echo '<hr><h4>' . $field['ProfileField']['name'] . '</h4>';
            continue;
        }
		
		echo '<div class="form-group"> <label class="col-md-3 control-label">' .$field['ProfileField']['name'];
        if ( !empty( $show_require ) && $field['ProfileField']['required'] )
            echo ' *';

		echo '</label><div class="col-md-9">';
		
		switch ( $field['ProfileField']['type'] )
		{                
			case 'hyperlink':
			case 'textfield':
				echo $this->Form->text( 'field_' .$field['ProfileField']['id'], array( 'class' => 'form-control','value' => $val ) );
				break;
			
			case 'textarea':
				echo $this->Form->textarea( 'field_' .$field['ProfileField']['id'], array( 'class' => 'form-control','value' => $val ) );
				break;
				
			case 'list':
				$field_values = $helper->getProfileFieldOption($field['ProfileField']['id']);
				echo $this->Form->select( 'field_' .$field['ProfileField']['id'], $field_values, array( 'class' => 'form-control','value' => $val ) );
				break;
				
			case 'multilist':
				$field_values = $helper->getProfileFieldOption($field['ProfileField']['id']);
				echo $this->Form->select( 'field_' .$field['ProfileField']['id'], $field_values, array('value' => explode(', ', $val), 'multiple' => 'multiple', 'class' => 'multi form-control' ) );
				break;
		}

        if ( !empty( $field['ProfileField']['description'] ) )
            echo ' <span class="help-block">' . $field['ProfileField']['description'] . '</span>';
		
		echo '</div></div>';
	}
}

?>
<?php if (!isset($show_profile_type) || $show_profile_type):?></div><?php endif;?>