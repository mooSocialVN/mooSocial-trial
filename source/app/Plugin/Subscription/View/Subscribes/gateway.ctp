<?php 
	$helperSubscription = MooCore::getInstance()->getHelper('Subscription_Subscription');
	$currency = Configure::read('Config.currency');
?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __( 'Select Payment Gateway')?></h1>
        </div>
    </div>
    <div class="box_content">
        <div class="gateway_content">
            <?php echo $this->Session->flash('subscription');?>
            <p>
                <?php echo __('Your selected plan');?>: <b><?php echo $plan['SubscriptionPackage']['name'].' - '. $helperSubscription->getPlanDescription($plan['SubscriptionPackagePlan'],$currency['Currency']['currency_code']) ?></b>. <a href="<?php echo $this->request->base?>/subscription/subscribes?cancel=1"><?php echo __('Switch to another package?');?></a>
            </p>
            <?php
            $first_amount= $helperSubscription->getFirstAmount($plan['SubscriptionPackagePlan']);
            ?>
            <?php if ($first_amount && Configure::read("core.enable_show_coupon")):?>
                <?php $currency = Configure::read('Config.currency');?>
                <?php  if ($coupon):?>
                    <p>
                        <?php echo __('Coupon');?>: <strong><?php echo $coupon['Coupon']['code'];?></strong> <a href="<?php echo $this->request->base?>/subscription/subscribes/gateway?remove_coupon=1"><?php echo __('remove');?></a>
                        <?php
                        if ($coupon['Coupon']['type'])
                        {
                            $first_amount = round($first_amount - ($coupon['Coupon']['value'] * $first_amount) / 100,2);
                        }
                        else
                        {
                            $first_amount = round($first_amount - $coupon['Coupon']['value'],2);
                        }
                        if ($first_amount < 0)
                            $first_amount = 0;
                        ?>
                    </p>
                <?php endif;?>
                <p>
                    <?php echo __('Total');?>: <?php echo $first_amount.' '.$currency['Currency']['currency_code'];?>
                </p>
                <div class="form_gateway">
                    <form method="post" class="form-inline">
                        <div class="form-group">
                            <input name="code" type="text" class="form-control">
                        </div>
                        <input type="submit" name="coupon" class="btn btn-primary" value="<?php echo __('Apply Coupon')?>" />
                    </form>
                    <p><?php echo __('For recurring or trial plan, discount coupon only applies for first invoice. You will pay full amount for next billing cycles.');?></p>
                </div>
            <?php endif;?>
            <div>
                <?php foreach($gateways as $gateway):
                    $gateway = $gateway['Gateway'];
                    $helper = MooCore::getInstance()->getHelper($gateway['plugin'].'_'.$gateway['plugin']);
                    $is_recurring = $helperSubscription->isRecurring($plan);
                    $is_trial = $helperSubscription->isTrial($plan);
                    if ($helper->checkSupportCurrency($currency_code) && (!$is_trial || ($is_trial && $helper->supportTrial()) ) && (!$is_recurring || ($is_recurring && $helper->supportRecurring()) )):
                        ?>
                        <?php 
                            $check = true;
                            if ($is_trial && $is_recurring)
                            {
                                $check = false;
                                if (method_exists($helper,'supportTrialRecurring'))
                                {
                                    $check = $helper->supportTrialRecurring();
                                }
                            }

                            if ($check):
                        ?>
                        <form onSubmit="return submitGateway();" id="formGateway" method="post" action="<?php echo $this->request->base.$furl;?>gateway/">
                            <?php echo $this->Form->hidden('gateway_id', array('id' => 'gateway_id','value'=>$gateway['id'])); ?>
                            <div class="form-group">
                                <p><?php echo $gateway['description'];?></p>
                                <input type="submit" class="btn btn-primary btnGateway" value="<?php echo __( 'Pay with').' '.$gateway['name'];?>" />
                            </div>
                        </form>
                        <?php endif; ?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>

            <div id="formPayment"></div>
        </div>
    </div>
</div>
<script>
function submitGateway()
{
	<?php if ($subscribe_active) :?>
		/*if(!confirm('<?php echo addslashes(__('Are you sure you would like to change your membership? If you click "Pay" button then your current membership will be inactived and you can not be undone.'));?>'))
			return false;*/
	<?php endif;?>
	return true;
}
</script>