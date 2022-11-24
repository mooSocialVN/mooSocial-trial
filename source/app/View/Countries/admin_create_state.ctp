<script>
    $(document).ready(function () {
        $('#createButton').click(function () {
            disableButton('createButton');
            $.post("<?php echo  $this->request->base ?>/admin/countries/save_state", $("#createForm").serialize(), function (data) {
                enableButton('createButton');
                var json = $.parseJSON(data);

                if (json.result == 1) {
                    window.location.href = '<?php echo  $this->request->base ?>/admin/countries/state/<?php echo $country['Country']['id'] ?>';
                }else{
                    $(".error-message").show();
                    $(".error-message").html('<strong>Error!</strong>' + json.message);
                }
            });

            return false;
        });

        $('#type').change(function () {
            MooAjax.post({
                url: '<?php echo  $this->request->base ?>/admin/categories/load_parent_categories/' + $('#type').val(),
            }, function (data) {
                console.log(data);
                $('#parent_id').html(data);
            });
        });

    });

    function toggleField()
    {
        $('.opt_field').toggle();
    }
</script>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <?php if (!$bIsEdit) : ?>
        <h4 class="modal-title"><?php echo __('Add New State/Province');?></h4>
    <?php else: ?>
        <h4 class="modal-title"><?php echo __('Edit State/Province');?></h4>
    <?php endif;?>
</div>
<div class="modal-body">
    <form id="createForm" class="form-horizontal" role="form">
        <?php echo $this->Form->hidden('country_id', array('value' => $country['Country']['id'])); ?>
        <?php echo $this->Form->hidden('id', array('value' => $state['State']['id'])); ?>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                <div class="col-md-9">
                    <?php echo $this->Form->text('name', array('placeholder' => __('Enter text'), 'class' => 'form-control', 'value' => $state['State']['name'])); ?>

                </div>
                <?php if (!$bIsEdit) : ?>
                    <div class="tips" style="margin-left: 165px;">*<?php echo  __('You can add translation language after adding new state/province') ?></div>
                <?php else : ?>
                    <div class="tips" style="margin-left: 165px;">
                        <?php
                                $this->MooPopup->tag(array(
                                       'href'=>$this->Html->url(array("controller" => "countries",
                                                                      "action" => "admin_translate",
                                                                      "plugin" => false,
                                                                      $state['State']['id'],
                                                                      'State'

                                                                  )),
                                       'title' => __('Translation'),
                                       'innerHtml'=> __('Translation'),
                               ));
                           ?>
                       
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal"><?php echo  __('Close') ?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo  __('Save') ?></a>

</div>