<?php
echo $this->Html->script(array('admin/layout/scripts/option.js?'.Configure::read('core.version')), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Setting Groups'), array('controller' => 'setting_groups', 'action' => 'admin_index'));
$this->Html->addCrumb(empty($setting_group['id']) ? __('Create Setting Group') :  __('Edit Setting Group'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "settinggroups"));
$this->end();

?>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-edit"></i><?php echo empty($setting_group['id']) ? __('Create Setting Group') :  __('Edit Setting Group');?>
        </div>
    </div>
    <div class="portlet-body form">
        <form id="createForm" class="form-horizontal" method="post" action="<?php echo $this->request->base?>/admin/settinggroups/save">
            <div class="form-body">
                <?php echo $this->Form->hidden('id', array('value' => $setting_group['id'])); ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Group');?></label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('parent_id', array(
                                'options' => $cbSettingGroups,
                                'class' => 'form-control',
                                'label' => false,
                                'empty' => array('0' => '---Root---'),
                                'value' => $setting_group['parent_id']
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('name', array(
                                'class' => 'form-control',
                                'label' => false,
                                'value' => $setting_group['name']
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="createButton" class="btn btn-circle blue"><i class="icon-save"></i> <?php echo __('Save');?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="alert alert-danger error-message" style="display:none;margin-top:10px"></div>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>


