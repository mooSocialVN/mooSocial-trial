<?php
echo $this->Html->script(array('admin/layout/scripts/option.js?'.Configure::read('core.version')), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Managed Currencies'), $url);
$this->Html->addCrumb(empty($currency['id']) ? __('Create Currency') :  __('Edit Currency'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "currencies"));
$this->end();

?>

<div class="portlet-body">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Billing', __('Manage Currencies'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php  
                                echo $this->Form->create('Currency', array(
                                    'class' => 'form-horizontal',
                                    'url' => 'save/'
                                ));
                            ?>
                                <div class="form-body">
                                    <?php echo $this->Form->hidden('id', array('value' => $currency['id'])); ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->input('name', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $currency['name']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Code');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->input('currency_code', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $currency['currency_code']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Symbol');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->input('symbol', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $currency['symbol']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Description');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->textarea('description', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $currency['description']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Active');?></label>
                                        <div class="col-md-4">
                                            <?php 
                                                echo $this->Form->checkbox('is_active', array(
                                                    'id' => false, 'value' => 1, 
                                                    'checked' => $currency['is_active'],
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
                            <?php echo $this->Form->end();?>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>