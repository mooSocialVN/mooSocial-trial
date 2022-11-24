<script>
    $(document).ready(function(){
        $('#copyButton').click(function(){
            disableButton('copyButton');
            $.post("<?php echo $this->request->base?>/admin/profile_fields/ajax_save_copy", $("#copyFieldForm").serialize(), function(data){
                enableButton('copyButton');
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

        $('#profile_type option').mousedown(function(e) {
            e.preventDefault();
            var originalScrollTop = $(this).parent().scrollTop();
            $(this).prop('selected', $(this).prop('selected') ? false : true);
            var self = this;
            $(this).parent().focus();
            setTimeout(function() {
                $(self).parent().scrollTop(originalScrollTop);
            }, 0);

            return false;
        });
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Copy Profile Field');?></h4>
</div>
<div class="modal-body">
<form id="copyFieldForm" class="form-horizontal system-setting" role="form">
    <?php echo $this->Form->hidden('id', array('value' => $field['ProfileField']['id'])); ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Profile Type');?></label>

            <div class="col-md-9">
                <select id="profile_type" name="data[profile_type][]" class="form-control" multiple>
                    <?php foreach ($array_type as $val=>$type):?>
                    <option title="<?php echo $type?>" value="<?php echo $val?>" <?php echo $val == $field['ProfileField']['profile_type_id'] ? 'selected': ''?>><?php echo $type?></option>
                    <?php endforeach;?>
                </select>
                <div style="display:none;padding: 15px;" id="bg-warning" class="bg-warning"></div>
            </div>            
        </div>
    </div>

</form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="javascript:void(0);" id="copyButton" class="btn btn-action"><?php echo __('Copy');?></a>

</div>
<style>
    #profile_type {
        width: 400px;
        padding: 8px 16px;
    }
    #profile_type option {
        font-size: 14px;
        padding: 5px;
    }
</style>