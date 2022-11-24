<?php
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Plugin Settings Manager'), array('controller' => 'pluginsettings', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Create New Plugin Setting'), array('controller' => 'pluginsettings', 'action' => 'admin_create'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "pluginsettings"));
$this->end();


?>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-edit"></i><?php if (empty($page['Page']['id'])) echo 'Create Plugin Setting'; else echo 'Edit Plugin Setting';?>
        </div>
        <div class="actions">
            <div class="portlet-input input-inline input-small">
                <div class="input-icon right">
                    <?php if (!empty($page['Page']['id'])): ?>
                        <a href="<?php echo $this->request->base?>/pages/<?php echo $page['Page']['alias']?>" target="_blank" class="btn purple"><i class="fa fa-external-link"></i> View Page</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="portlet-body form">
        <form id="createForm" class="form-horizontal" method="post" action="/admin/pluginsettings/add">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Plugin</label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('id', array(
                                'options' => $cbPlugins,
                                'empty' => '(Choose one)',
                                'class' => 'form-control',
                                'label' => false
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Type</label>
                    <div class="col-md-4">
                        <?php
                            echo $this->Form->input('type', array(
                                'options' => $types,
                                'class' => 'form-control',
                                'label' => false
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Label</label>
                    <div class="col-md-4">
                        <?php 
                            echo $this->Form->text('label', array(
                                'placeholder'=>'Enter text',
                                'class'=>'form-control ',
                            )); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-4">
                        <?php 
                            echo $this->Form->text('name', array(
                                'placeholder'=>'Enter text',
                                'class'=>'form-control ',
                            )); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Value</label>
                    <div class="col-md-6">
                        <div id="value-text" class="value-option">
                            <?php 
                                echo $this->Form->text('text', array(
                                    'placeholder'=>'Enter text',
                                    'class'=>'form-control ',
                                )); 
                            ?>
                        </div>
                        <div id="value-select" class="value-option option-holder">
                            <div class="form-group option-item">
                                <div class="col-md-4">
                                    <?php 
                                        echo $this->Form->text('multi.name.', array(
                                            'placeholder'=>'Enter name',
                                            'class'=>'form-control ',
                                        )); 
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    <?php 
                                        echo $this->Form->text('multi.value.', array(
                                            'placeholder'=>'Enter value',
                                            'class'=>'form-control ',
                                        )); 
                                    ?>
                                </div>
                                <div class="col-md-1">
                                    <span class="value-checkbox">
                                    <?php 
                                        echo $this->Form->checkbox('multi.checkbox.', array('id' => false));
                                    ?>
                                    </span>
                                    <span class="value-radio">
                                    <?php 
                                        echo $this->Form->radio('multi.radio.', array('1' => ''), array('id' => false));
                                    ?>
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <a class="option-remove" href="#" onclick="return jQuery.option.remove(this)"><?php echo __('Remove');?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <button id="createButton" class="btn btn-circle blue" onclick="return jQuery.option.add(this)">Add</button>
                                </div>
                            </div>
                        </div>
                        <div id="value-textarea" class="value-option">
                            <?php 
                                echo $this->Form->textarea('textarea', array(
                                    'placeholder'=>'Enter text',
                                    'class'=>'form-control',
                                )); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button id="createButton" class="btn btn-circle blue"><i class="icon-save"></i> Save Settings</button>
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


