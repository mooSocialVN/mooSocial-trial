<?php 
	$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
	$currencyModel = MooCore::getInstance()->getModel('Currency');
	$currency = Configure::read('Config.currency');
?>
<?php if ($subscribe && in_array($subscribe['Subscribe']['status'], array('cancel','active'))):?>
	<form method="post" id="form_upgrade">
		<input type="hidden" id="select-plan" name="plan_id">
	</form>
	<div class="current_pack_title"><?php echo __('Current Package')?></div>
	<div class="current_pack_name"><?php echo $subscribe['SubscriptionPackage']['name'];?></div>
	<?php $currency = $currencyModel->findByCurrencyCode($subscribe['Subscribe']['currency_code'])?>
	<div class="package_info">
		<div>
			<?php if ($subscribe['SubscriptionTransaction']['amount']):?>
				<span><?php echo __('Price');?>:</span> <?php echo $currency['Currency']['symbol'].$subscribe['SubscriptionTransaction']['amount'];?>
			<?php else:?>
				<?php echo __('Free');?>
			<?php endif;?>
		</div>
		<?php if ($subscribe['Subscribe']['status'] == 'cancel' || ($subscribe['SubscriptionTransaction'] && $subscribe['SubscriptionTransaction']['admin']) || !$helper->isRecurring($subscribe)):?>
			<div><span><?php echo __('Expire Date').': </span>'.($subscribe['Subscribe']['expiration_date'] ? $this->Moo->getTime( $subscribe['Subscribe']['expiration_date'], Configure::read('core.date_format'), $utz ) : __('Forever'))?></span></div>
		<?php elseif ($helper->isRecurring($subscribe)):?>
			<div><span><?php echo __('Duration').': </span>'.$helper->getTextDuration($subscribe['SubscriptionPackagePlan']['plan_duration'],$subscribe['SubscriptionPackagePlan']['plan_type']) ?></span></div>
			<div><span><?php echo __('Billing Cycle').': </span>'.$helper->getTextDuration($subscribe['SubscriptionPackagePlan']['billing_cycle'],$subscribe['SubscriptionPackagePlan']['billing_cycle_type']) ?></span></div>
		<?php endif;?>
	</div>
	<div>
		<?php echo $subscribe['SubscriptionPackage']['description'];?>
	</div>
	<div id="content_package" style="display:none;">
		<div class="modal-dialog">
			<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span></button>
                    <div class="title-modal"><?php echo __('Subscription Plans')?></div>
                </div>
                <div class="modal-body">
				<?php 
					$element = (Configure::read('Subscription.select_theme_subscription_packages') ? 'Subscription.theme_compare' : 'Subscription.theme_default');
				?>
				<?php echo $this->element($element,array('compares'=>$compares,'columns'=>$columns,'type'=>'update'));?>
                </div>
			</div>
		</div>
	</div>
	<?php $this->Html->scriptStart(array('inline' => false)); ?>							
		$('#plan-view').html($('#content_package').html());
		var first = false;
		$('#content_package').remove();
		
		$('.button_select').click(function(){			
			package_id = $(this).attr('ref');		
			$('#select-plan').val($('.package_update_'+package_id).val());
			
			if ($(".package_update_"+package_id + " option[value='"+$('.package_update_'+package_id).val()+"']").attr('ref') > 0)
			{
				/*if(!confirm('<?php echo addslashes(__('Are you sure you would like to change your membership? If you click "Select" button then your current membership will be inactived and you can not be undone.'));?>'))
					return;*/
			}
			$('#plan-view').modal('hide');
			$('#form_upgrade').submit();
		});
		$('#plan-view').on('shown.bs.modal',function (e) {
			if (first)
				return;
			first = true;
			
			<?php 
				$package_exit = array();
				foreach ($columns as $column): if (!count($column['SubscriptionPackagePlan'])) continue;
					$package_exit[] = $column;
				endforeach;
			?>
			<?php foreach ($package_exit as $package):?>
				$('.package_update_<?php echo $package['SubscriptionPackage']['id'];?>').change(function(){
					$('.package_update_content_<?php echo $package['SubscriptionPackage']['id'];?>').html(plans[$('.package_update_<?php echo $package['SubscriptionPackage']['id'];?>').val()]);
				});
			<?php endforeach?>
			
			/*$('.compare-update .content').attr('style','');
			max = 0;
			$('.compare-update .content').each(function(e){
				if ($(this).height() > max)
				 	max = $(this).height();
			});
			$('.compare-update .content').each(function(e){
				if ($(this).css('padding-top'))
				{
					$(this).css('height',parseInt($(this).css('padding-top').replace("px", "")) + parseInt($(this).css('padding-bottom').replace("px", "")) + max + 10);
				}
			});*/

            setTimeout(
                function() {
                    $('.compare-item-title').css('height', 'auto');
                    var titleHeight = 0;
                    $('.compare-item-title').each(function (index) {
                        if ($(this).height() > titleHeight){
                            titleHeight = $(this).height();
                        }
                    });
                    $('.compare-item-title').css('height', parseInt(titleHeight)+'px');
                }
            , 500);

		});
	<?php $this->Html->scriptEnd(); ?>
	<div class="pull-left">
		<?php
        echo $this->Html->link(__('Change'),
                '#',
                array(
                    'data-target' => '#plan-view',
                    'data-toggle' => 'modal',
					'class' => 'btn btn-action'
                ));
        ?> 
	</div>
	<div>
		<?php if ( $helper->canCancel($subscribe) || $helper->canRefunded($subscribe)):?>
			<div class="package_action">
				<?php if ($helper->canCancel($subscribe)):?>
					<a class="btn btn-default" href="javascript:void(0);" onclick="cancelRecurring();"><?php echo __('Cancel this recurring');?></a>
					<div style="display:none;" id="content_cancel_recurring">
                        <form>
                            <div class="form-group">
                                <?php echo __('Are you sure to cancel your subscription? Your subscription will end on %s if canceled',$this->Moo->getTime( $subscribe['Subscribe']['expiration_date'], Configure::read('core.date_format'), $utz ));?>
                            </div>
                            <div class="form-group">
                                <b><?php echo __('Please provide reasons for canceling your subscription');?></b>
                            </div>
                            <div class="form-group">
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
						        title: '<?php echo addslashes(__('Cancel this recurring'))?>',
						        contents: $('#content_cancel_recurring').html(),
						        model: 'content'
						    }).addButton('<?php echo addslashes(__('Ok'));?>', "btn btn-primary btn-action", function(e){
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
											title: '<?php echo addslashes(__('Warning'));?>',
											contents: '<?php echo addslashes(__('Error when canceling subscription'));?>'
										}).showModal();
									}
								},'json');
							}).addButton('<?php echo addslashes(__('Cancel'));?>', "btn btn-default").showModal();
                                                        if( (navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {
                                                            $('body').addClass("modal-phone");
                                                            $('#simpleModal .button.button-action').click(function () {
                                                                $('body').removeClass("modal-phone");
                                                            });
                                                        }
						}
					</script>
				<?php endif;?>
				<?php if ($helper->canRefunded($subscribe)):?>
					<?php
						$has_account = true;
						if (isset($subscribe['Gateway']['plugin']))
						{
							$helperGateway = MooCore::getInstance()->getHelper($subscribe['Gateway']['plugin'].'_'.$subscribe['Gateway']['plugin']);
							if (method_exists($helperGateway,'hasAccountRefund') && !$helperGateway->hasAccountRefund())
								$has_account = false;
						}


					?>
					<a class="btn btn-default" href="javascript:void(0);" onclick="requestRefund();"><?php echo __('Request a refund');?></a>
					<div style="display:none;" id="content_refund">
                        <form>
                            <div class="form-group">
                                <?php echo __('Are you sure to request a refund for your subscription?');?>
                            </div>
                            <?php if ($has_account): ?>
                                <div class="alert alert-danger error-message hide" style=""><?php echo __('Account is required'); ?></div>
                                <div class="form-group">
                                    <label><?php echo __('Account');?></label>
                                    <input id="account" type="text" class="form-control">
                                </div>
                            <?php endif; ?>
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
							<?php if ($has_account): ?>
								$('.simple-modal-body .error-message').addClass('hide');
								if ($('.simple-modal-body #account').val().trim() == '')
								{
									$('.simple-modal-body .error-message').removeClass('hide');
									return;
								}
							<?php endif;?>
							$('.simple-modal-footer .btn.btn-action').addClass('disabled');
							$('.simple-modal-footer .btn.btn-action').spin('small');
							$.post(mooConfig.url.base + "/subscription/subscribes/request_refund", {<?php if ($has_account): ?>account:$('.simple-modal-body #account').val(),<?php endif; ?>reason:$('.simple-modal-body #reason').val()}, function(data){
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
	</div>
	<div class="clear"></div>
<?php endif;?>