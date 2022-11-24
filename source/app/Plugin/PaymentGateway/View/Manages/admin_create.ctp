<?php
echo $this->Html->script(array('admin/layout/scripts/option.js?'.Configure::read('core.version')), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Managed Gateways'), $url);
$this->Html->addCrumb(empty($gateway['id']) ? __('Create Gateway') :  __('Edit Gateway'));


$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => 'payment_gateway'));
$this->end();
$plugin = $gateway['plugin'];
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
	$("#save").submit(function( event ) {	  
	  	event.preventDefault();
	  	disableButton('saveBtn');
	  	
	    mooAjax.post({
	        url : mooConfig.url.base + "/admin/payment_gateway/manages/save",
	        data: jQuery("#save").serialize()
	    }, function(data){
	        var json = $.parseJSON(data);
	
	        if ( json.result == 1 )
	        {
	            window.location = mooConfig.url.base + '/admin/payment_gateway/manages';
	        }
	        else
	        {
	            enableButton('saveBtn');
	            $(".error-message").show();
	            $(".error-message").html(json.message);
	        }
	    });
	});
});
<?php $this->Html->scriptEnd(); ?>
<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('PaymentGateway', __('Manage Gateways'));?>
            <?php if ($this->elementExists($plugin.'.help')):?>
            	<?php echo $this->element($plugin.'.help');?>
            <?php endif;?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab3">
                            <?php  
                                echo $this->Form->create('Gateway', array(
                                	'url' => array('controller'=>'manages','action'=>'save'),
                                    'class' => 'form-horizontal',
                                	'id' => 'save'
                                ));
                            ?>
                                <div class="form-body">
                                    <?php echo $this->Form->hidden('id', array('value' => $gateway['id'])); ?>
                                    <?php echo $this->Form->hidden('plugin', array('value' => $gateway['plugin'])); ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Name');?></label>
                                        <div class="col-md-4">
                                            <?php
                                                echo $this->Form->input('name', array(
                                                    'class' => 'form-control',
                                                    'label' => false,
                                                    'value' => $gateway['name']
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
                                                    'value' => $gateway['description']
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                   	<?php if ($this->elementExists($plugin.'.extra')):?>
						            	<?php echo $this->element($plugin.'.extra',array('extra_params_value'=>$extra_params_value));?>
						            <?php endif;?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Enable');?></label>
                                        <div class="col-md-4">
                                            <?php 
                                                echo $this->Form->checkbox('enabled', array(
                                                    'id' => false, 'value' => 1, 
                                                    'checked' => $gateway['enabled'],
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo __('Test mode');?></label>
                                        <div class="col-md-4">
                                            <?php 
                                                echo $this->Form->checkbox('test_mode', array(
                                                    'id' => false, 'value' => 1, 
                                                    'checked' => $gateway['test_mode'],
                                                ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button style="margin-bottom:10px;" id="saveBtn" class="btn btn-circle btn-action"><i class="icon-save"></i> <?php echo __('Save');?></button>                                            
                                            <div class="error-message" id="errorMessage" style="display: none;"></div>
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