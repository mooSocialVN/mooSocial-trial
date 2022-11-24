<script>
$(document).ready(function(){    
    $('#createButton').click(function(){
        disableButton('createButton');
        $.post("<?php echo $this->request->base?>/admin/profile_fields/ajax_save_option", $("#createFieldOptionForm").serialize(), function(data){
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
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Add New');?></h4>
</div>
<div class="modal-body">
<form id="createFieldOptionForm" class="form-horizontal system-setting" role="form">
	<?php echo $this->Form->hidden('profile_field_id', array('value' => $profile_field_id)); ?>
    <?php echo $this->Form->hidden('id', array('value' => $field['ProfileFieldOption']['id'])); ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Field Option Name'); ?></label>

            <div class="col-md-9">
                <?php echo $this->Form->text('name', array('placeholder' => __('Enter text'),'class' => 'form-control','value' => $field['ProfileFieldOption']['name'])); ?>

            </div>
            <?php if(!$bIsEdit) : ?>
                <div class="tips" style="margin-left: 165px;">*<?php echo __('You can add translation language after creating profile field')?></div>
            <?php else : ?>
                <div class="tips" style="margin-left: 165px;"><?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "profile_fields",
                                            "action" => "admin_ajax_translate_option",
                                            "plugin" => false,
                                            $field['ProfileFieldOption']['id']
                                        )),
             'title' => __('Translation'),
             'innerHtml'=> __('Translation'),
             'target' => 'ajax-translate'
     ));
 ?>
               
                </div>
            <?php  endif; ?>
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="javascript:void(0);" id="createButton" class="btn btn-action"><?php echo __('Save');?></a>

</div>