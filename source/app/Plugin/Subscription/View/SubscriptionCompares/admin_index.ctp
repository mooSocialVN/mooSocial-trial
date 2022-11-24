<?php
echo $this->Html->script(array('admin/layout/scripts/compare.js?'.Configure::read('core.version')), array('inline' => false));
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "packagecompare"));
$this->end();
?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Subscription', __('Manage Comparison Table'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php if($columns != null):?>
                            <?php echo $this->Form->create('SubscriptionCompare', array(
                                    'class' => 'form-horizontal',
                                    'url' => '/admin/subscription/subscription_compares/save/'
                                ));
                            ?>
                            	<div class="form-group">
					                <label class="col-md-3 control-label"><?php echo __('Language Pack');?>(<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Select a language to translate for page title and page content only'); ?>" data-placement="top">?</a>)</label>
					                <div class="col-md-6">
					                    <?php echo $this->Form->select('language', $languages, array('id'=>'language','class'=>'form-control language','value'=>$language,'empty'=>false)); ?>
					                </div>
					            </div>
                                <table id="sample_1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="20%"></th>
                                            <?php foreach($columns as $column):
                                                $column = $column['SubscriptionPackage'];
                                            ?>
                                                <th width="<?php echo (80 / count($columns));?>%" class="text-center">
                                                    <?php echo  $column['name'] ?>
                                                </th>
                                            <?php endforeach;?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="compare compare_blank">
                                            <td class="reorder">
                                                <div class="col-md-10">
                                                    <?php echo $this->Form->input('name.', array(
                                                            'class' => 'form-control',
                                                            'label' => false,
                                                            'value' => ''
                                                        ));
                                                    ?>
                                                    <input type="hidden" name="data[SubscriptionCompare][id][]" value="0">
                                                </div>
                                                <div class="col-md-1">
                                                    <i title="<?php echo __('Disable');?>" style="font-size: 25px;line-height: 25px;;cursor: pointer" class="fa fa-trash-o" onclick="jQuery.compare.remove($(this))"></i>
                                                </div>
                                            </td>
                                            <?php
                                            foreach($columns as $column):
                                            $column = $column['SubscriptionPackage'];
                                            ?>
                                            <td class="reorder">
                                                <?php echo $this->Form->hidden('compare_type.'.$column['id'].'.', array('class' => 'compare_type', 'value' => 'text'));?>
                                                <?php echo $this->Form->hidden('yesno_value.'.$column['id'].'.', array('class' => 'yesno_value', 'value' =>  1));?>
                                                <div class="col-md-1">
                                                    <i title="<?php echo __('Random');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-random" onclick="jQuery.compare.switchType($(this))"></i>
                                                </div>
                                                <div style="float: right;text-align: right" class="col-md-9">
                                                    <i title="<?php echo __('Yes');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-check type_yesno type_yes compare_type_value" onclick="jQuery.compare.switchYesNo($(this), 0)"></i>
                                                    <i title="<?php echo __('No');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-times type_yesno type_no compare_type_value" onclick="jQuery.compare.switchYesNo($(this), 1)"></i>
                                                    <?php echo $this->Form->input('text_value.'.$column['id'].'.', array(
                                                        'class' => 'form-control type_text compare_type_value',
                                                        'label' => false,
                                                        'value' => ''
                                                    ));
                                                    ?>
                                                </div>
                                            </td>
                                            <?php endforeach;?>

                                        </tr>
                                        <?php foreach($compares as $compare):
                                            $compare = $compare['SubscriptionCompare'];
                                        ?>
                                        <tr class="compare">
                                            <td class="reorder">
                                                <div class="col-md-10">
                                                    <?php echo $this->Form->input('name.', array(
                                                            'class' => 'form-control',
                                                            'label' => false,
                                                            'value' => $compare['compare_name']
                                                        ));
                                                    ?>
                                                    <input type="hidden" name="data[SubscriptionCompare][id][]" value="<?php echo $compare['id'];?>">
                                                </div>
                                                <div class="col-md-1">
                                                    <i title="<?php echo __('Disable');?>" style="font-size: 25px;line-height: 25px;;cursor: pointer" class="fa fa-trash-o" onclick="jQuery.compare.remove($(this))"></i>
                                                </div>
                                            </td>
                                            <?php $compare_values = $compare['compare_value']; ?>
                                            <?php
                                            foreach($columns as $column):
                                                $column = $column['SubscriptionPackage'];
                                                $value = isset($compare_values[$column['id']]) ? $compare_values[$column['id']] : '';
                                            ?>
                                                <td class="reorder">
                                                    <?php echo $this->Form->hidden('compare_type.'.$column['id'].'.', array('class' => 'compare_type', 'value' => $value != '' ? $value['type'] : 'text'));?>
                                                    <?php echo $this->Form->hidden('yesno_value.'.$column['id'].'.', array('class' => 'yesno_value', 'value' => ($value != '' && $value['type'] == 'yesno') ? $value['value'] : 1));?>
                                                    <div class="col-md-1">
                                                        <i title="<?php echo __('Random');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-random" onclick="jQuery.compare.switchType($(this))"></i>
                                                    </div>
                                                    <div style="float: right;text-align: right" class="col-md-9">
                                                        <i title="<?php echo __('Yes');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-check type_yesno type_yes compare_type_value" onclick="jQuery.compare.switchYesNo($(this), 0)"></i>
                                                        <i title="<?php echo __('No');?>" style="font-size: 25px;line-height: 25px;cursor: pointer" class="fa fa-times type_yesno type_no compare_type_value" onclick="jQuery.compare.switchYesNo($(this), 1)"></i>
                                                        <?php echo $this->Form->input('text_value.'.$column['id'].'.', array(
                                                                'class' => 'form-control type_text compare_type_value',
                                                                'label' => false,
                                                                'value' => $value != '' ? $value['value'] : ''
                                                            ));
                                                        ?>
                                                    </div>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <?php endforeach;?>
                                        <tr>
                                            <td colspan="<?php echo (count($columns) + 1);?>"  onclick="return jQuery.compare.add()" style="background-color: #F1F1F1;text-align: center;cursor: pointer">
                                                <?php echo  __('Add new feature'); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-actions">
                                    <div class="row">                                     
                                        <div class="col-md-1">
                                            <button id="removeAll" class="btn btn-circle btn-action" onclick="return jQuery.compare.removeAll()"><i class="icon-save"></i> <?php echo __( 'Delete All');?></button>
                                        </div>
                                        <div class="col-md-1">
                                            <button id="createButton" class="btn btn-circle btn-action"><i class="icon-save"></i> <?php echo __( 'Save');?></button>
                                        </div>                                        
                                    </div>
                                </div>
                            <?php echo $this->Form->end();?>
                            <?php else:?>
                                <?php echo __( "Please create package first.");?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('#language').change(function(e){
	window.location.href = "<?php echo $this->request->base;?>/admin/subscription/subscription_compares/index/" +$('#language').val();
});
<?php $this->Html->scriptEnd(); ?>