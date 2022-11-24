<?php
echo $this->Html->script(array('admin/layout/scripts/option.js?'.Configure::read('core.version')), array('inline' => false));

$this->Html->addCrumb(__('System Settings'), array('controller' => 'system_settings', 'action' => 'admin_view'));
$this->Html->addCrumb(__('Create New Setting'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "settings"));
$this->end();

?>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-edit"></i><?php if (empty($page['Page']['id'])) echo __('Create Setting'); else echo __('Edit Setting');?>
        </div>
        <div class="actions">
            <div class="portlet-input input-inline input-small">
                <div class="input-icon right">
                    <?php if (!empty($page['Page']['id'])): ?>
                        <a href="<?php echo $this->request->base?>/pages/<?php echo $page['Page']['alias']?>" target="_blank" class="btn purple"><i class="fa fa-external-link"></i> <?php echo __('View Page');?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body form">
        <form id="createForm" class="form-horizontal" method="post" action="<?php echo $this->request->base?>/admin/system_settings/save">
            <div class="form-body">
                <?php echo $this->Form->hidden('id', array('value' => $setting['Setting']['id'])); ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Group');?></label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('group_id', array(
                                'options' => $cbSettingGroups,
                                'class' => 'form-control',
                                'label' => false,
                                'value' => $setting['Setting']['group_id']
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Type');?></label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('type_id', array(
                                'options' => $types,
                                'class' => 'form-control',
                                'label' => false,
                                'value' => $setting['Setting']['type_id']
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Label');?></label>
                    <div class="col-md-4">
                        <?php 
                            echo $this->Form->text('label', array(
                                'placeholder'=> __('Enter text'),
                                'class'=>'form-control ',
                                'value' => $setting['Setting']['label']
                            )); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                    <div class="col-md-4">
                        <?php 
                            echo $this->Form->text('name', array(
                                'placeholder'=>__('Enter text'),
                                'class'=>'form-control ',
                                'value' => $setting['Setting']['name']
                            )); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Description');?></label>
                    <div class="col-md-4">
                        <?php 
                            echo $this->Form->textarea('description', array(
                                'placeholder'=>__('Enter text'),
                                'class'=>'form-control',
                                'value' => $setting['Setting']['description']
                            )); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo __('Value');?></label>
                    <div class="col-md-6">
                        <div id="value-text" class="value-option">
                            <?php 
                                echo $this->Form->text('text', array(
                                    'placeholder'=>__('Enter text'),
                                    'class'=>'form-control ',
                                    'value' => isset($setting['Setting']['text']) ? $setting['Setting']['text'] : ''
                                )); 
                            ?>
                        </div>
                        <div id="value-select" class="value-option option-holder">
                            <?php echo $this->Form->hidden('checkbox_name', array('id' => 'checkbox_name', 'value' => 'data[multi][checkbox]')); ?>
                            <?php
                                if(isset($setting['Setting']['multi'])):
                                    foreach($setting['Setting']['multi'] as $item):
                            ?>
                                <div class="form-group option-item">
                                    <div class="col-md-4">
                                        <?php 
                                            echo $this->Form->text('multi.name.', array(
                                                'placeholder'=>__('Enter name'),
                                                'class'=>'form-control ',
                                                'value' => isset($item['name']) ? $item['name'] : ''
                                            )); 
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php 
                                            echo $this->Form->text('multi.value.', array(
                                                'placeholder'=>__('Enter value'),
                                                'class'=>'form-control ',
                                                'value' => isset($item['value']) ? $item['value'] : ''
                                            )); 
                                        ?>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="value-checkbox">
                                        <?php 
                                            echo $this->Form->checkbox('multi.checkbox.', array('id' => false, 'value' => 1, 'checked' => $item['select'],'hiddenField'=>false));
                                        ?>
                                        </span>
                                        <span class="value-radio">
                                        <?php 
                                            echo $this->Form->radio('multi.radio.', array('1' => ''), array('id' => false, 'label' => false, 'checked' => $item['select'],'hiddenField'=>false));
                                        ?>
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="option-remove" href="#" onclick="return jQuery.option.remove(this)"><?php echo __('Remove');?></a>
                                    </div>
                                </div>
                            <?php 
                                    endforeach;
                                else:
                            ?>
                                <div class="form-group option-item">
                                    <div class="col-md-4">
                                        <?php 
                                            echo $this->Form->text('multi.name.', array(
                                                'placeholder'=>__('Enter name'),
                                                'class'=>'form-control ',
                                            )); 
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php 
                                            echo $this->Form->text('multi.value.', array(
                                                'placeholder'=>__('Enter value'),
                                                'class'=>'form-control ',
                                            )); 
                                        ?>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="value-checkbox">
                                        <?php 
                                            echo $this->Form->checkbox('', array('id' => false,'hiddenField'=>false));
                                        ?>
                                        </span>
                                        <span class="value-radio">
                                        <?php 
                                            echo $this->Form->radio('multi.radio', array('1' => ''), array('id' => false, 'value' => 0, 'legend' => false, 'label' => false,'hiddenField'=>false));
                                        ?>
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="option-remove" href="#" onclick="return jQuery.option.remove(this)"><?php echo __('Remove');?></a>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="row">
                                <div class="col-md-9">
                                    <button id="createButton" class="btn btn-circle blue" onclick="return jQuery.option.add(this)"><?php echo __('Add');?></button>
                                </div>
                            </div>
                        </div>
                        <div id="value-textarea" class="value-option">
                            <?php 
                                echo $this->Form->textarea('textarea', array(
                                    'placeholder'=>__('Enter text'),
                                    'class'=>'form-control',
                                    'value' => isset($setting['Setting']['textarea']) ? $setting['Setting']['textarea'] : ''
                                )); 
                            ?>
                        </div>
                        <div id="value-timezone" class="value-option">
                            <?php 
                                $timezones = $this->Time->listTimezones(null, null, false);
                                asort($timezones);
                                echo $this->Form->select('timezone', $timezones, array(
                                    'value' => $setting['Setting']['value_actual'], 
                                    'empty' => false, 
                                    'class' => 'form-control'
                                )); 
                            ?>
                        </div>
                        <div id="value-language" class="value-option">
                            <?php 
                                echo $this->Form->select('language', $site_langs, array(
                                    'value' => $setting['Setting']['value_actual'], 
                                    'empty' => false, 
                                    'class' => 'form-control'
                                )); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="createButton" class="btn btn-circle btn-action"><i class="icon-save"></i> <?php echo __('Save Settings');?></button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
</div>


