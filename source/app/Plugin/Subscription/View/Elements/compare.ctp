<?php 
	$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
	$currency = Configure::read('Config.currency');
	$active = false;
?>
<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title">
                <?php if ($subscribe && $uid):?>
                    <?php echo __('Subscription Management') ?>
                <?php else: ?>
                    <?php echo __('Please select a package') ?>
                <?php endif; ?>
            </h1>
            <div class="box_action"></div>
        </div>
    </div>
    <div class="box_content">
        <div class="subscription-section">
            <div id="sub_compare_page">

                <?php if ($subscribe && $uid):?>
                    <div class="current_subscription_info">
                        <div class="items">
                            <label><?php echo __('You are using').': '; ?></label><b> <?php echo $subscribe['SubscriptionPackage']['name']?> (<?php echo $helper->getPlanDescription($subscribe['SubscriptionPackagePlan'],$currency['Currency']['currency_code']); ?>) </b>
                        </div>

                        <?php if (in_array($subscribe['Subscribe']['status'],array('active','cancel'))):?>
                            <?php $active = true;?>
                            <div class="items"><label><?php echo __('Subscription date').': ' ?></label> <?php echo $this->Time->format_date_time($subscribe['Subscribe']['pay_date'], $utz )?></div>
                            <?php if ($subscribe['Subscribe']['expiration_date'] && ($subscribe['Subscribe']['status'] == 'cancel' || ($subscribe['SubscriptionTransaction'] && $subscribe['SubscriptionTransaction']['admin']) || !$helper->isRecurring($subscribe))):?>
                                <div class="items"><label><?php echo __('Expiry date').': ' ?></label> <?php echo ($subscribe['Subscribe']['expiration_date'] ? $this->Time->format_date_time( $subscribe['Subscribe']['expiration_date'], $utz ) : __('Forever'))?></div>
                            <?php endif;?>
                        <?php endif;?>

                        <div class="items"><label><?php echo __('Status'). ':' ?></label><span class="status" ><?php echo $helper->getTextStatus($subscribe);?></span></div>
                    </div>
                    <?php if ( $helper->canCancel($subscribe) || $helper->canRefunded($subscribe)):?>
                        <div class="package-btn package_action">
                            <?php if ($helper->canCancel($subscribe)):?>
                                <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="cancelRecurring();"><?php echo __('Cancel Subscription');?></a>
                                <div style="display:none;" id="content_cancel_recurring">
                                    <form>
                                        <div class="form-group">
                                            <?php echo __('Are you sure to cancel your subscription? Your subscription will end on %s if canceled',$this->Time->format_date_time( $subscribe['Subscribe']['expiration_date'], $utz ));?>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo __('Please provide reasons for canceling your subscription');?></label>
                                            <textarea class="form-control" id="reason" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <script>
                                    function cancelRecurring()
                                    {
                                        $.fn.SimpleModal({
                                            btn_ok: '<?php echo addslashes(__('OK'))?>',
                                            btn_cancel: '<?php echo addslashes(__('Cancel'))?>',
                                            title: '<?php echo addslashes(__('Cancel Subscription'))?>',
                                            contents: $('#content_cancel_recurring').html(),
                                            model: 'content'
                                        }).addButton('<?php echo __('Ok');?>', "btn btn-primary btn-action", function(e){
                                            $('.simple-modal-footer .btn.btn-action').addClass('disabled');
                                            $('.simple-modal-footer .btn.btn-action').spin('small');
                                            var popup = this;
                                            $.post(mooConfig.url.base + "/subscription/subscribes/cancel_recurring", {text_reason:$('.simple-modal-body #reason').val()}, function(data){
                                                popup.hideModal();
                                                if (data.status)
                                                {
                                                    window.location=window.location;
                                                }
                                                else
                                                {
                                                    $.fn.SimpleModal({
                                                        btn_ok : '<?php echo addslashes(__('OK'))?>',
                                                        model: 'modal',
                                                        title: '<?php echo __('Warning');?>',
                                                        contents: '<?php echo __('Error when canceling subscription');?>'
                                                    }).showModal();
                                                }
                                            },'json');
                                        }).addButton('<?php echo __('Cancel');?>', "btn btn-default").showModal();
                                    }
                                </script>
                            <?php endif;?>
                            <?php if ($helper->canRefunded($subscribe)):?>
                                <a class="btn btn-warning btn-sm" href="javascript:void(0);" onclick="requestRefund();"><?php echo __('Request a refund');?></a>
                                <div style="display:none;" id="content_refund">
                                    <form>
                                        <div class="form-group">
                                            <?php echo __('Are you sure to request a refund for your subscription?');?>
                                        </div>
                                        <div class="alert alert-danger error-message hide" style=""><?php echo __('Account is required'); ?></div>
                                        <div class="form-group">
                                            <label><?php echo __('Account');?></label>
                                            <input id="account" class="form-control" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo __('Please provide reasons for requesting a refund');?></label>
                                            <textarea class="form-control" id="reason" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <script>
                                    function requestRefund()
                                    {
                                        $.fn.SimpleModal({
                                            btn_ok: '<?php echo addslashes(__('OK'))?>',
                                            btn_cancel: '<?php echo addslashes(__('Cancel'))?>',
                                            title: '<?php echo addslashes(__('Request a refund'))?>',
                                            contents: $('#content_refund').html(),
                                            model: 'content'
                                        }).addButton('<?php echo addslashes(__('Ok'));?>', "btn btn-primary btn-action", function(e){
                                            var popup = this;
                                            $('.simple-modal-body .error-message').addClass('hide');
                                            if ($('.simple-modal-body #account').val().trim() == '')
                                            {
                                                $('.simple-modal-body .error-message').removeClass('hide');
                                                return;
                                            }
                                            $('.simple-modal-footer .btn.btn-action').addClass('disabled');
                                            $('.simple-modal-footer .btn.btn-action').spin('small');
                                            $.post(mooConfig.url.base + "/subscription/subscribes/request_refund", {account:$('.simple-modal-body #account').val(),reason:$('.simple-modal-body #reason').val()}, function(data){
                                                popup.hideModal();
                                                if (data.status)
                                                {
                                                    window.location=window.location;
                                                }
                                                else
                                                {
                                                    $.fn.SimpleModal({
                                                        btn_ok : '<?php echo addslashes(__('OK'))?>',
                                                        model: 'modal',
                                                        title: '<?php echo addslashes(__('Warning'));?>',
                                                        contents: '<?php echo addslashes(__('Error when canceling subscription'));?>'
                                                    }).showModal();
                                                }
                                            },'json');
                                        }).addButton('<?php echo addslashes(__('Cancel'));?>', "btn btn-default").showModal();
                                    }
                                </script>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                    <div class="subscription_text">
                        <?php echo __('Select the below package to renew or switch to another subscription.');?>
                    </div>
                <?php endif;?>
                <?php if (!$uid):?>
                    <div class="subscription_text">
                        <?php echo __('Select the below package to subscribe');?>
                    </div>
                <?php endif;?>
            </div>

            <?php
            $element = (Configure::read('Subscription.select_theme_subscription_packages') ? 'Subscription.theme_compare' : 'Subscription.theme_default');
            ?>
            <?php echo $this->element($element,array('type'=>'manage'));?>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    <?php 
        $tmp = array();
        if ($this->request->is('androidApp'))
        {
            foreach ($plans as $key=>$plan)
            {
                $tmp[$key] = trim($plan['android_product_id']);
            }
        }
        if ($this->request->is('iosApp'))
        {
            foreach ($plans as $key=>$plan)
            {
                $tmp[$key] = trim($plan['ios_product_id']);
            }
        }
    ?>
    var plans_product = <?php echo json_encode($tmp); ?>;
	$('.button_select').click(function(e){
        <?php if ($this->request->is('androidApp') || $this->request->is('iosApp')):?>
            package_id = $(this).attr('ref');
            if ($(".package_manage_"+package_id + " option[value='"+$('.package_manage_'+package_id).val()+"']").attr('ref') > 0)
		    {

            }
            else
            {
                e.stopPropagation();
                window.mobileAction.pay('subscription_subscribe',plans_product[$('.package_manage_'+package_id).val()],'');
                return;
            }
        <?php endif; ?>
            $(this).addClass('disabled');
		package_id = $(this).attr('ref');
		$('#plan_id').val($('.package_manage_'+package_id).val());
		<?php if ($active):?>
		if ($(".package_manage_"+package_id + " option[value='"+$('.package_manage_'+package_id).val()+"']").attr('ref') > 0)
		{
			/*if(!confirm('<?php echo addslashes(__('Are you sure you would like to change your membership? If you click "Select" button then your current membership will be inactived and you can not be undone.'));?>'))
				return;*/
		}
		<?php endif;?>
		$('#plan_id').parent().submit();
	});
<?php $this->Html->scriptEnd(); ?>

<?php 
if ($this->request->is('androidApp') || $this->request->is('iosApp'))
{
    $this->MooGzip->script(array('zip'=>'mobile.action.bundle.js.gz','unzip'=>'MooApp.mobile.action.bundle'),true);
}
?>