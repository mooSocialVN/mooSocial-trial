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
            <?php echo $this->Moo->renderMenu('Subscription', __('Bulk Edit Membership'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">                           
                           <form class="form-horizontal intergration-setting" method="post" enctype="multipart/form-data">                           	   
							   <div class="form-body">
                                   <div class="form-group">
                                       <div class="col-md-7">
                                           <p>
                                               <?php echo __('If subscribtion module is enabled, existing members who have not subscribed to any pakages before will be asked to select a package to continue using site. Do you want to assign a ONE-TIME package to them so that they can continue using site without being asking to select package? Importance: User role of existing members will not change after the above ONE-TIME package is assigned to them so that they will have the same permissions as they have before.');?>
                                           </p>
                                           <select id="plan_id" name="plan_id" class="form-control">
                                               <option value="0"><?php echo __('Which one time package do you want to assign?');?></option>
                                            <?php foreach($packages as $index => $package): ?>
                                            	<?php if ($package['SubscriptionPackage']['deleted']) continue;?>
                                               <optgroup label="<?php echo $package['SubscriptionPackage']['name'];?>">
                                                   <?php foreach($package['SubscriptionPackagePlan'] as $key => $plan): ?>
                                                       <?php $plan = $plan['SubscriptionPackagePlan'];?>
                                                       <?php if($plan['type'] == SUBSCRIPTION_ONE_TIME && $plan['enable_plan'] && !$plan['deleted']) :?>
                                                            <option value="<?php echo $plan['id']?>"><?php echo $plan['title']?> - (<?php echo $helper->getPlanDescription($plan,$currency['Currency']['currency_code'])?>)</option>
                                                       <?php endif;?>
                                                   <?php endforeach; ?>
                                               </optgroup>
                                            <?php endforeach; ?>
                                           </select>
                                       </div>
                                   </div>
							    </div>
							    <div class="form-actions">
							        <div class="row">
							            <div class=" col-md-9">
							                <input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Update');?>">
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