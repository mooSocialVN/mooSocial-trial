<script>
    $(document).ready(function(){
        $('#createButton').click(function(){
            disableButton('createButton');
            $.post("<?php echo $this->request->base?>/admin/roles/ajax_save", $("#createForm").serialize(), function(data){
                enableButton('createButton');
                var json = $.parseJSON(data);

                if ( json.result == 1 )
                    location.reload();
                else
                {
                    $(".error-message").show();
                    $(".error-message").html('<strong>Error!</strong>'+json.message);
                }
            });
            return false;
        });

        $('#is_super').click(function () {
            if($(this).is(':checked')){
                $('#is_admin').attr('checked', 'checked');
                $('#is_admin').parent().addClass('checked');
                $('#wrap_is_admin').hide();
            }else{
                $('#wrap_is_admin').show();
            }
        });

    });
</script>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo __('Add New');?></h4>
</div>
<div class="modal-body">

    <form id="createForm" class="form-horizontal" role="form">
        <?php echo $this->Form->hidden('id', array('value' => $role['Role']['id']))?>
        <div class="form-body">
            <h4><?php echo __('Settings');?></h4>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                <div class="col-md-9">
                    <?php echo $this->Form->text('name', array('placeholder'=>__('Enter text'),'class'=>'form-control','value' => $role['Role']['name'])); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo __('Super Admin');?></label>
                <div class="col-md-9">
                    <div class="checkbox-list">
                        <label class="checkbox-inline">
                            <?php echo $this->Form->checkbox('is_super', array( 'checked' => $role['Role']['is_super'] ) ); ?>
                        </label>


                    </div>
                </div>
            </div>
            <div class="form-group" id="wrap_is_admin" style="<?php echo $role['Role']['is_super'] ? 'display:none' : '';?>">
                <label class="col-md-3 control-label"><?php echo __('Admin');?></label>
                <div class="col-md-9">
                    <div class="checkbox-list">
                        <label class="checkbox-inline">
                            <?php echo $this->Form->checkbox('is_admin', array( 'checked' => ($role['Role']['is_super'] ? 1 : $role['Role']['is_admin']) ) ); ?>

                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <h4><?php echo __('Permissions');?></h4>
            <div class="form-group">
                <?php if ( $role['Role']['id'] == ROLE_GUEST ): ?>
                    <em><?php echo __('Guests cannot create/edit/delete items regardless of the selections below');?></em>
                <?php endif; ?>
            </div>
            <?php foreach ( $aco_groups as $group => $acos ): ?>

                <div class="form-group">
                    <div class="col-md-12">
                        <label><?php echo  __d('permission',Inflector::humanize($group)) != Inflector::humanize($group) ? __d('permission',Inflector::humanize($group)) : __d(Inflector::underscore($group),Inflector::humanize($group) != Inflector::humanize($group) ? __d(Inflector::underscore($group),Inflector::humanize($group)) : Inflector::humanize($group)) ?> - <?php echo __('Permissions');?></label>

                        <div class="checkbox-list">


                            <?php foreach ($acos as $aco): ?>
                            	<?php $des = __d('permission',trim($aco['Aco']['hint_text'])) != trim($aco['Aco']['hint_text']) ? __d('permission',trim($aco['Aco']['hint_text'])) : (__d(Inflector::underscore($group),trim($aco['Aco']['hint_text'])) != trim($aco['Aco']['hint_text']) ? __d(Inflector::underscore($group),trim($aco['Aco']['hint_text'])) : $aco['Aco']['hint_text']);  ?>
                                <label><?php echo  $this->Form->checkbox('param_' . $group . '_' . $aco['Aco']['key'], array('checked' => in_array($group . '_' . $aco['Aco']['key'], $permissions))) ?> <?php echo  __d('permission',trim($aco['Aco']['description'])) != trim($aco['Aco']['description']) ? __d('permission',trim($aco['Aco']['description'])) : (__d(Inflector::underscore($group),trim($aco['Aco']['description'])) != trim($aco['Aco']['description']) ? __d(Inflector::underscore($group),trim($aco['Aco']['description'])) : $aco['Aco']['description']);  ?> <?php if ($aco['Aco']['hint_text']):?>(<a data-html="true"  href="javascript:void(0)" class="tooltips" data-original-title="<?php echo (str_replace('"','\'',$des));?>" data-placement="top">?</a>)<?php endif;?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>

    </form>
    <div class="alert alert-danger error-message" style="display:none;margin-top:10px;">

    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close');?></button>
    <a href="#" id="createButton" class="btn btn-action"><?php echo __('Save');?></a>

</div>