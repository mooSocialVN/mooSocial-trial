<?php if (!$columns):?>
<?php echo __('No package found');?> 
<?php  return;?>
<?php endif;?>
<?php $helper = MooCore::getInstance()->getHelper('Subscription_Subscription');?>
<?php $plan_exit = array();?>
<?php $package_exit = array();?>
<form method="post">
	<input type="hidden" name="plan_id" id="plan_id">
	<div class="compare-table">
		<?php foreach ($columns as $column): if (!count($column['SubscriptionPackagePlan'])) continue;?>
			<?php $package_exit[] = $column;?>
			<div class="compare-item compare-<?php echo $type;?>">
				<div class="content <?php if ($column['SubscriptionPackage']['recommended']): ?>plan-recommend<?php endif;?>">
					<?php if ($column['SubscriptionPackage']['recommended']): ?>
						<span class="recommend-label"><?php echo __('Recommended');?></span>
					<?php endif;?>
					<div class="compare-item-title">
                        <div class="title">
                            <?php echo $column['SubscriptionPackage']['name']?>
                        </div>
					</div>
					<div class="info package_<?php echo $type;?>_content_<?php echo $column['SubscriptionPackage']['id'];?>">					
					</div>
					<select class="form-control package_<?php echo $type;?>_<?php echo $column['SubscriptionPackage']['id'];?>">
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
					<ul class="description">
						<?php echo $column['SubscriptionPackage']['description'];?>
					</ul>
					<div class="action">
						<a class="btn btn-primary button_select" href="javascript:void(0);" ref="<?php echo $column['SubscriptionPackage']['id'];?>"><?php echo __('Select');?></a>
					</div>
				</div>
			</div>
		<?php endforeach;?>	
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
		$('.package_<?php echo $type?>_content_<?php echo $package['SubscriptionPackage']['id'];?>').html(plans[$('.package_<?php echo $type?>_<?php echo $package['SubscriptionPackage']['id'];?>').val()]);
	});
	
	$('.package_<?php echo $type?>_<?php echo $package['SubscriptionPackage']['id'];?>').trigger("change");
<?php endforeach?>
/*

if(typeof max == "undefined")
	max = 0;
$('.compare-<?php echo $type;?> .content').each(function(e){
	if ($(this).height() > max)
	 max = $(this).height();
});
$('.compare-<?php echo $type;?> .content').each(function(e){
	if ($(this).css('padding-top'))
	{
		$(this).css('height',parseInt($(this).css('padding-top').replace("px", "")) + parseInt($(this).css('padding-bottom').replace("px", "")) + max + 10);
	}
});
*/

var titleHeight = 0;
$('.compare-item-title').each(function (index) {
    if ($(this).height() > titleHeight){
        titleHeight = $(this).height();
    }
});
$('.compare-item-title').css('height', parseInt(titleHeight)+'px');


<?php if($this->request->is('ajax')): ?>
</script>
<?php else:?>
<?php $this->Html->scriptEnd(); ?>
<?php endif;?>