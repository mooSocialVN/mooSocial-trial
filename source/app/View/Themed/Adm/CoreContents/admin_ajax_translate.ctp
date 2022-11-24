<script>
    $(document).on('hidden.bs.modal', function (e) {
        $(e.target).removeData('bs.modal');
    });
    $(document).ready(function() {

        $('#tCreateButton').click(function() {

            disableButton('tCreateButton');
            $.post("<?php echo  $this->request->base ?>/admin/core_contents/ajax_translate_save", $("#tCreateForm").serialize(), function(data) {
                enableButton('tCreateButton');
                var json = $.parseJSON(data);

                if (json.result == 1){
                    window.location.reload();
                }
                else
                {
                    $(".error-message").show();
                    $(".error-message").html('<strong>Error!</strong>' + json.message);
                }
            });

            return false;
        });


    });

</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo  __("Translation") ?></h4>
</div>
<div class="modal-body">
    <form id="tCreateForm" class="form-horizontal" role="form">
        <?php echo $this->Form->hidden('id', array('value' => $core_content['CoreContent']['id'])); ?>
        <?php echo $this->Form->hidden('field_name', array('value' => $field_name)); ?>
        <?php echo $this->Form->hidden('content_value_id', array('value' => ($core_content_value != null)?$core_content_value['CoreContentValue']['id']:0)); ?>

        <?php foreach ($languages as $key => $language) : ?>
            <?php $lval = ""; ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo $language; ?></label>
                    <div class="col-md-9">
                        <?php
                        if($field_name == 'title') {
                            foreach ($core_content['nameTranslation'] as $translation) {
                                if ($translation['locale'] == $key) {
                                    $lval = $translation['content'];
                                    break;
                                }
                            }
                            if (empty($lval)) {
                                $data = json_decode($core_content['CoreContent']['params'], true);
                                $lval = isset($data['title']) ? $data['title'] : '';
                            }
                            echo $this->Form->text('name.' . $key, array('placeholder' => 'Enter text', 'class' => 'form-control', 'value' => $lval));
                        }else{
                            if($core_content_value != null){
                                foreach ($core_content_value['valueTranslation'] as $translation) {
                                    if ($translation['locale'] == $key) {
                                        $lval = $translation['content'];
                                        break;
                                    }
                                }
                            }

                            if (empty($lval)) {
                                $data = json_decode($core_content['CoreContent']['params'], true);
                                $lval = isset($data[$field_name]) ? $data[$field_name] : '';
                            }

                            echo $this->Form->input('name.' . $key, array('type' => $field_type, 'label' => false, 'placeholder' => 'Enter text', 'class' => 'form-control', 'value' => $lval));
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </form>

    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="#" id="tCreateButton" class="btn btn-action"><?php echo __('Save Change');?></a>

</div>