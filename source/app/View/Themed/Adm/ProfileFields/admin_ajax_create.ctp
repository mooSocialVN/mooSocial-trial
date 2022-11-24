<?php
    $array_type = array( 'heading'   => __('Heading'),
        'textfield' => __('Text Field'),
        'list' 	  => __('List'),
        'multilist' => __('Multi Select List'),
        'textarea'  => __('Text Area'),
        'hyperlink' => __('HyperLink')
    );

    $event = new CakeEvent('Profile.Field.getType',$this);
    $result = $this->getEventManager()->dispatch($event);
    if ($result->result)
    {
        foreach ($result->result as $key=>$item)
        {
            $array_type[$key] = $item['label'];
        }
    }
    
    $array_message_notice = array();
    $event = new CakeEvent('Profile.Field.getNoticeType',$this);
    $result = $this->getEventManager()->dispatch($event);
    if ($result->result)
    {
        foreach ($result->result as $key=>$item)
        {
            $array_message_notice[$key] = $item['label'];
        }
    }
?>
<script>
    $(document).ready(function(){
        $('#createButton').off('click');
        $('#createButton').click(function(){
            disableButton('createButton');
            $.post("<?php echo $this->request->base?>/admin/profile_fields/ajax_save", $("#createFieldForm").serialize(), function(data){
                enableButton('createButton');
                var json = $.parseJSON(data);

                if (json.redirect)
                {
                    window.location = json.redirect;
                }

                else if ( json.result == 1 )
                    location.reload();
                else
                {
                    $(".error-message").show();
                    $(".error-message").html(json.message);
                }
            });
            return false;
        });
		var message_notice = <?php echo json_encode($array_message_notice)?>;
		var checkNotice = function()
		{
			$('#bg-warning').hide();
			if (typeof message_notice[jQuery('#type').val()] != 'undefined')
			{
				$('#bg-warning').html(message_notice[jQuery('#type').val()]);
				$('#bg-warning').show();
			}
        }
        
        jQuery('#type').off('change');
		jQuery('#type').change(function(){            
			<?php if($bIsEdit) : ?>
			if ( jQuery(this).val() == 'list' || jQuery(this).val() == 'multilist' )
				jQuery('#field_values').show();
			else
				jQuery('#field_values').hide();
			<?php endif;?>

            if(jQuery(this).val() == 'hyperlink'){
                $('#hyperlink_content').show();
                $('#searchable_content').hide();
            }else{
                $('#hyperlink_content').hide();
                $('#searchable_content').show();
            }

			checkNotice();
		});

        checkNotice();
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Add New');?></h4>
</div>
<div class="modal-body">
<form id="createFieldForm" class="form-horizontal system-setting" role="form">
	<?php echo $this->Form->hidden('profile_type_id', array('value' => $profile_type_id)); ?>
    <?php echo $this->Form->hidden('id', array('value' => $field['ProfileField']['id'])); ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Field Name'); ?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('name', array('placeholder' => __('Enter text'),'class' => 'form-control','value' => $field['ProfileField']['name'])); ?>

            </div>
            <?php if(!$bIsEdit) : ?>
                <div class="tips" style="margin-left: 165px;">*<?php echo __('You can add translation language after creating profile field')?></div>
            <?php else : ?>
                <div class="tips" style="margin-left: 165px;"><?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "profile_fields",
                                            "action" => "admin_ajax_translate",
                                            "plugin" => false,
             								$field['ProfileField']['id']
                                            
                                        )),
             'title' => __('Translation'),
             'innerHtml'=> __('Translation'),
             'target' => 'ajax-translate'
     ));
 ?>
               
                </div>
            <?php  endif; ?>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Field Type');?></label>

            <div class="col-md-9">

                <?php echo $this->Form->select('type', $array_type,
                    array('class' => 'form-control','value' => $field['ProfileField']['type'])
                );
                ?>
                <div style="display:none;padding: 15px;" id="bg-warning" class="bg-warning"></div>
            </div>            
        </div>
        <div class="form-group" <?php if ( !in_array( $field['ProfileField']['type'], array( 'list', 'multilist' ) ) ) echo 'style="display:none"'; ?> id="field_values">
            <label class="col-md-3 control-label"><?php echo __('Field Values');?> (<a data-placement="top" data-original-title="<?php echo __('One value per line');?>" class="tooltips" href="javascript:void(0);">?</a>)</label>

            <div class="col-md-9">
                <div class="form-control">
                    <?php echo __('Click %s to add field values', '<a href="'.$this->base.'/admin/profile_fields/profile_field_options/'.$field['ProfileField']['id'].'">here</a>'); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label description-label"><?php echo __('Description');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->textarea('description', array('class' => 'form-control','value' => $field['ProfileField']['description'])); ?>

            </div>
        </div>
        <div style="<?php if ($field['ProfileField']['type'] != 'hyperlink') echo 'display:none;' ?>" id="hyperlink_content" class="form-group">
            <label class="col-md-3 control-label description-label"><?php echo __('Link label');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('extra', array('class' => 'form-control','value' => $field['ProfileField']['extra'])); ?>

            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Required');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'required', array( 'checked' => $field['ProfileField']['required'] ) ); ?>

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Registration');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'registration', array( 'checked' => $field['ProfileField']['registration'] ) ); ?>

            </div>
        </div>
        <div style="<?php if ($field['ProfileField']['type'] == 'hyperlink') echo 'display:none;' ?>" id="searchable_content" class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Searchable');?> (<a data-placement="top" data-original-title="<?php echo __('Only values that have 4 characters or more can be searched. If you want to make it less than 4, contact your server admin to adjust ft_min_word_len parameter');?>" class="tooltips" href="javascript:void(0);">?</a>)</label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'searchable', array( 'checked' => $field['ProfileField']['searchable'] ) ); ?>
               
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Profile');?> (<a data-placement="top" data-original-title="<?php echo __('Check this if you want to display this field on the main user profile below the full name');?>" class="tooltips" href="javascript:void(0);">?</a>)</label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'profile', array( 'checked' => $field['ProfileField']['profile'] ) ); ?>
                
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Viewable');?> (<a data-placement="top" data-original-title="<?php echo __('Only profile owner or admin can see this field at info tab in member profile');?>" class="tooltips" href="javascript:void(0);">?</a>)</label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'hide_from_info_tab', array( 'checked' => $field['ProfileField']['hide_from_info_tab'] ) ); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Active');?></label>

            <div class="col-md-9">
                <?php echo $this->Form->checkbox( 'active', array( 'checked' => $field['ProfileField']['active'] ) ); ?>

            </div>
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="javascript:void(0);" id="createButton" class="btn btn-action"><?php echo __('Save Field');?></a>

</div>