<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "packages"));
$this->end();

$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
$currency = Configure::read('Config.currency');	
?>

<div class="portlet-body form">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Subscription', __('Manage Settings'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                           <div class="note"><?php echo __('Make sure to enable <a href="%s">gateway</a> and create <a href="%s">plan</a> before enabling Subscription plugin',$this->base.'/admin/payment_gateway/manages',$this->base.'/admin/subscription/subscription_packages');?></div>
                           <form class="form-horizontal intergration-setting" method="post" enctype="multipart/form-data">                           	   
							   <div class="form-body">
						            <div class="form-group">
							            <label class="col-md-3 control-label">
							                <?php echo __('Enable Subscription');?>                          
							            </label>
							            <div class="col-md-7">
                                            <?php
                                            	$check = true;
                                            	$gateway = MooCore::getInstance()->getModel('PaymentGateway.Gateway');
												$subscriptionPackagePlan = MooCore::getInstance()->getModel('Subscription.SubscriptionPackagePlan');
													
										        if (!$gateway->hasAny(array('enabled' => 1))){
										            $check = false;
										        }
										        
										        if (!$subscriptionPackagePlan->hasAny(array('deleted' => 0,'enable_plan' => 1))){
										            $check = false;
										        }
                                            
                                            	echo $this->Form->input('enable', array(
			                                    'type' => 'checkbox', 
			                                    'checked' => Configure::read('Subscription.enable_subscription_packages'),
			                                    'label' => '',
                                            	'disabled' => (!$check ? 'disabled' : '')	                                    
			                                )); 
                                            ?>                                                                                    
                                        </div>								            
						            </div>
						            <div class="form-group">
							            <label class="col-md-3 control-label">
							                <?php echo __('Select Theme');?>                          
							            </label>
							            <div class="col-md-7">
                                            <?php
                                            	echo $this->Form->radio('select',array('0'=>__('Basic theme'),'1'=>__('Comparison theme')), array('value'=>Configure::read('Subscription.select_theme_subscription_packages'),'legend' => false));
                                            ?>                                                                                    
                                        </div>								            
						            </div>
							    </div>
							    <div class="form-actions">
							        <div class="row">
							            <div class="col-md-offset-3 col-md-9">
							                <input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Changes');?>">
							            </div>
							        </div>
							    </div>
						    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('<div><img style="width: 500px;" src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/plan_1.png';?>"></div>').insertAfter($('#select0').next());
$('<div><img style="width: 500px;" src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/plan_2.png';?>"></div>').insertAfter($('#select1').next());
<?php $this->Html->scriptEnd(); ?>