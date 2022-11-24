<?php if (!$columns):?>
<?php echo __('No package found');?> 
<?php  return;?>
<?php endif;?>
<?php $helper = MooCore::getInstance()->getHelper('Subscription_Subscription');?>
<?php $plan_exit = array();?>
<?php $package_exit = array();?>
<form method="post">
	<input type="hidden" name="plan_id" id="plan_id">
	<div class="table-compare">
		<table class="hidden-xs">
			<tr>
				<td class="table-compare-label"><?php echo __('Choose a Package');?></td>
				<?php foreach ($columns as $column): if (!count($column['SubscriptionPackagePlan'])) continue;?>
					<?php $package_exit[] = $column;?>
					<td class="plan-header <?php if ($column['SubscriptionPackage']['recommended']): ?>plan-recommend<?php endif;?>">
						<div class="title-package ">
							<?php if ($column['SubscriptionPackage']['recommended']): ?>
								<span class="recommend-label"><?php echo __('Recommended');?></span>
							<?php endif;?>
							<div class="package-name">
                                <div class="package-name-title">
                                    <?php echo $column['SubscriptionPackage']['name'];?>
                                </div>
                            </div>
							<div class="package-des package_<?php echo $type?>_content_<?php echo $column['SubscriptionPackage']['id'];?>">							
							</div>
							<select class="form-control package_<?php echo $type?>_<?php echo $column['SubscriptionPackage']['id'];?>">
								<?php foreach ($column['SubscriptionPackagePlan'] as $plan):?>
									<?php
										$plan = $plan['SubscriptionPackagePlan'];
										$plan_exit[] = $plan;
									?>
									<option ref="<?php echo ($helper->isFreePlan(array('SubscriptionPackagePlan'=>$plan))) ? '1' : '0';?>" value="<?php  echo $plan['id']?>">
										<?php echo $plan['title'];?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
					</td>
				<?php endforeach;?>
			</tr>
			<?php foreach ($compares as $compare) :?>
			<tr>
				<td class="table-compare-label">
					<?php echo $compare['SubscriptionCompare']['compare_name']?>
				</td>
				<?php
					foreach ($package_exit as $package):
				?>
				<td>
					<?php if (isset($compare['SubscriptionCompare']['compare_value'][$package['SubscriptionPackage']['id']])):?>
						<?php $value = $compare['SubscriptionCompare']['compare_value'][$package['SubscriptionPackage']['id']];?>
						<div>
						<?php if ($value['type'] == 'text'):?>
							<?php echo $value['value'];?>
						<?php else:?>
							<?php if ($value['value']):?>
								<img src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/check.png';?>" />
							<?php else:?>
								<img src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/uncheck.png';?>" />
							<?php endif;?>
						<?php endif;?>
						</div>
					<?php endif;?>
					
				</td>
				<?php endforeach;?>
			</tr>		
			<?php endforeach;?>
			<tr>
				<td>
					&nbsp;
				</td>
				<?php
					foreach ($package_exit as $package):
				?>
				<td>
					<div class="package-btn">
						<a class="btn btn-primary button_select" href="javascript:void(0);" ref="<?php echo $package['SubscriptionPackage']['id'];?>"><?php echo __('Select');?></a>
					</div>
				</td>
				<?php endforeach;?>			
			</tr>
		</table>
		<div class="visible-xs">
			<div>

				<?php foreach ($columns as $column): ?>
					<?php if (!count($column['SubscriptionPackagePlan'])) continue; ?>
					<?php $package_exit[] = $column;?>
					<div class="plan-header package_mobile <?php if ($column['SubscriptionPackage']['recommended']): ?>plan-recommend<?php endif;?>">
						<div class="title-package ">
							<?php if ($column['SubscriptionPackage']['recommended']): ?>
								<span class="recommend-label"><?php echo __('Recommended');?></span>
							<?php endif;?>
							<div class="package-name"><?php echo $column['SubscriptionPackage']['name'];?></div>
							<div class="package-des package_<?php echo $type?>_content_<?php echo $column['SubscriptionPackage']['id'];?>">							
							</div>
							<select class="form-control package_<?php echo $type?>_<?php echo $column['SubscriptionPackage']['id'];?>">
								<?php foreach ($column['SubscriptionPackagePlan'] as $plan):?>
									<?php $plan = $plan['SubscriptionPackagePlan']?>
									<?php $plan_exit[] = $plan;?>
									<option value="<?php  echo $plan['id']?>">
										<?php echo $plan['title'];?>
									</option>
								<?php endforeach;?>
							</select>
						</div>
						<?php foreach ($compares as $compare) :?>
							<div class="compare-feature">
								<span><?php echo $compare['SubscriptionCompare']['compare_name']?></span>
								<?php if (isset($compare['SubscriptionCompare']['compare_value'][$column['SubscriptionPackage']['id']])):?>
									<div>
									<?php $value = $compare['SubscriptionCompare']['compare_value'][$column['SubscriptionPackage']['id']];?>
									<?php if ($value['type'] == 'text'):?>
										<?php echo $value['value'];?>
									<?php else:?> 
										<?php if ($value['value']):?>
											<img src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/check.png';?>" />
										<?php else:?>
											<img src="<?php echo FULL_BASE_URL . $this->request->webroot . 'subscription/img/uncheck.png';?>" />
										<?php endif;?>
									<?php endif;?>
									</div>
								<?php endif;?>
							</div>
						<?php endforeach;?>
						<div class="package-btn">
							<a class="btn btn-primary button_select" href="javascript:void(0);" ref="<?php echo $column['SubscriptionPackage']['id'];?>"><?php echo __('Select');?></a>
						</div>
					</div>					
				<?php endforeach;?>
			</div>			
		</div>		
	</div>
</form>
<script>
if(typeof plans == "undefined")
	var plans = {};
<?php foreach ($plan_exit as $plan):?>
	plans[<?php echo $plan['id']?>] = '<?php echo addslashes($helper->getPlanDescription($plan,$currency['Currency']['currency_code']));?>';
<?php endforeach?>
</script>

<?php if($this->request->is('ajax')): ?>
<script>
<?php else:?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
<?php endif;?>
<?php foreach ($package_exit as $package):?>
	$('.package_<?php echo $type?>_<?php echo $package['SubscriptionPackage']['id'];?>').change(function(){
		$('.package_<?php echo $type?>_content_<?php echo $package['SubscriptionPackage']['id'];?>').html(plans[$(this).val()]);
		$('.package_<?php echo $type?>_<?php echo $package['SubscriptionPackage']['id'];?>').val($(this).val());
	});
	
	$('.package_<?php echo $type?>_<?php echo $package['SubscriptionPackage']['id'];?>').trigger("change");
<?php endforeach?>
//var titleHeight = 0;
//$('.package-name').each(function (index) {
//    if ($(this).height() > titleHeight){
//        titleHeight = $(this).height();
//    }
//});
//$('.package-name').css('height', parseInt(titleHeight)+'px');
<?php if($this->request->is('ajax')): ?>
</script>
<?php else:?>
<?php $this->Html->scriptEnd(); ?>
<?php endif;?>