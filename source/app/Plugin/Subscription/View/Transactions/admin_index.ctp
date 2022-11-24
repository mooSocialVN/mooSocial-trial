<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "transactions"));
$this->end();

$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
$list_status = $helper->getListStatus('SubscriptionTransaction');
$this->Paginator->options(array('url' => $data_search));

$currency = Configure::read('Config.currency');
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).on('loaded.bs.modal', function (e) {
        Metronic.init();
    });
    $(document).on('hidden.bs.modal', function (e) {
        $(e.target).removeData('bs.modal');
    });
<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Moo->renderMenu('Subscription', __('Manage Transactions'));?>
<div id="center">
	<form method="post" action="<?php echo $this->base.$url;?>" >
		<div style="padding-bottom: 15px;" class="dataTables_filter">
			<div class="search_inline_item">
				<?php echo __('Search');?>
				<input class="form-control input-small input-inline" value="<?php if (isset($name)) echo $name;?>" type="text" name="name">
			</div>
			<div class="search_inline_item">
				<?php echo __('Plan');?>
				<select class="form-control input-small input-inline" name="plan_id">
					<option></option>
					<?php foreach ($plans as $plan):?>
						<option <?php if (isset($plan_id) && $plan_id ==  $plan['SubscriptionPackagePlan']['id']) echo 'selected="selected"';?> value="<?php echo $plan['SubscriptionPackagePlan']['id'];?>"><?php echo $helper->getPlanDescription($plan['SubscriptionPackagePlan'],$currency['Currency']['currency_code']);?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="search_inline_item">
				<?php echo __('Gateway');?>
				<select class="form-control input-small input-inline" name="gateway_id">
					<option></option>
					<?php foreach ($gateways as $gateway):?>
						<option <?php if (isset($gateway_id) && $gateway_id ==  $gateway['Gateway']['id']) echo 'selected="selected"';?> value="<?php echo $gateway['Gateway']['id'];?>"><?php echo $gateway['Gateway']['name'];?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="search_inline_item">
				<?php echo __('Status');?>
				<select class="form-control input-small input-inline" name="status">
					<option></option>
					<?php foreach ($list_status as $key=>$name):?>
						<option <?php if (isset($status) && $status ==  $key) echo 'selected="selected"';?> value="<?php echo $key?>"><?php echo $name;?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="search_inline_item">
				<?php echo __('Start date');?>
				<input class="datepicker form-control input-small input-inline" value="<?php if (isset($start_date)) echo $start_date;?>" type="text" name="start_date">
			</div>
			<div class="search_inline_item">
				<?php echo __('End date');?>
				<input class="datepicker form-control input-small input-inline" value="<?php if (isset($end_date)) echo $end_date;?>" type="text" name="end_date">
			</div>
			<button class="btn btn-gray" id="sample_editable_1_new" type="submit">
				<?php echo __('Search');?>
            </button>
		</div>
	</form>	
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
				<th><?php echo __('Subscriber'); ?></th>				
				<th><?php echo __('Plan'); ?></th>
				<th><?php echo __('Gateway'); ?></th>
                <th><?php echo __('Coupon code'); ?></th>
				<th><?php echo $this->Paginator->sort('SubscriptionTransaction.status', __('Status')); ?></th>
				<th><?php echo $this->Paginator->sort('SubscriptionTransaction.type', __('Type')); ?></th>
				<th><?php echo $this->Paginator->sort('SubscriptionTransaction.created', __('Created date')); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (count($transactions)):?>
				<?php foreach ($transactions as $transaction): ?>
				<tr>
					<td>
						<a href="<?php echo $transaction['User']['moo_href'];?>"><?php echo $transaction['User']['name'];?></a>
					</td>					
					<td>
						<p><?php echo $transaction['SubscriptionPackagePlan']['title']; ?></p>
						<p><?php echo $helper->getPlanDescription($transaction['SubscriptionPackagePlan'],$transaction['Subscribe']['currency_code']);	?></p>						
					</td>
					<td>
						<?php 							
							echo $transaction['Gateway']['name'];
						?>
					</td>
                    <td><?php echo $transaction['SubscriptionTransaction']['coupon_code']; ?></td>
					<td><?php echo $helper->getTextStatusTransaction($transaction);?></td>
					<td><?php echo $helper->getTextTypeTransaction($transaction);?></td>
					<td><?php echo $this->Time->format('m/d/Y',$transaction['SubscriptionTransaction']['created']);?></td>
					<td>
						<a href="<?php echo $this->base.'/admin/subscription/subscribes/detail/'.$transaction['Subscribe']['id']?>"><?php echo __('Detail');?></a>						
					</td>
				</tr>
				<?php endforeach ?>
			<?php else:?>
				<tr>
					<td colspan="7">
						<?php echo __('No transaction found');?>
					</td>
				</tr>
			<?php endif;?>
		</tbody>
	</table>
	
	<div class="pagination">
        <?php echo $this->Paginator->first('First');?>&nbsp;
        <?php echo $this->Paginator->hasPage(2) ? $this->Paginator->prev(__('Prev')) : '';?>&nbsp;
		<?php echo $this->Paginator->numbers();?>&nbsp;
		<?php echo $this->Paginator->hasPage(2) ?  $this->Paginator->next(__('Next')) : '';?>&nbsp;
		<?php echo $this->Paginator->last('Last');?>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$('.datepicker').pickadate({
    monthsFull: ['<?php echo addslashes(__( 'January'))?>', '<?php echo addslashes(__( 'February'))?>', '<?php echo addslashes(__( 'March'))?>', '<?php echo addslashes(__( 'April'))?>', '<?php echo addslashes(__( 'May'))?>', '<?php echo addslashes(__( 'June'))?>', '<?php echo addslashes(__( 'July'))?>', '<?php echo addslashes(__( 'August'))?>', '<?php echo addslashes(__( 'September'))?>', '<?php echo addslashes(__( 'October'))?>', '<?php echo addslashes(__( 'November'))?>', '<?php echo addslashes(__( 'December'))?>'],
    monthsShort: ['<?php echo addslashes(__( 'Jan'))?>', '<?php echo addslashes(__( 'Feb'))?>', '<?php echo addslashes(__( 'Mar'))?>', '<?php echo addslashes(__( 'Apr'))?>', '<?php echo addslashes(__( 'May'))?>', '<?php echo addslashes(__( 'Jun'))?>', '<?php echo addslashes(__( 'Jul'))?>', '<?php echo addslashes(__( 'Aug'))?>', '<?php echo addslashes(__( 'Sep'))?>', '<?php echo addslashes(__( 'Oct'))?>', '<?php echo addslashes(__( 'Nov'))?>', '<?php echo addslashes(__( 'Dec'))?>'],
    weekdaysFull: ['<?php echo addslashes(__( 'Sunday'))?>', '<?php echo addslashes(__( 'Monday'))?>', '<?php echo addslashes(__( 'Tuesday'))?>', '<?php echo addslashes(__( 'Wednesday'))?>', '<?php echo addslashes(__( 'Thursday'))?>', '<?php echo addslashes(__( 'Friday'))?>', '<?php echo addslashes(__( 'Saturday'))?>'],
    weekdaysShort: ['<?php echo addslashes(__( 'Sun'))?>', '<?php echo addslashes(__( 'Mon'))?>', '<?php echo addslashes(__( 'Tue'))?>', '<?php echo addslashes(__( 'Wed'))?>', '<?php echo addslashes(__( 'Thu'))?>', '<?php echo addslashes(__( 'Fri'))?>', '<?php echo addslashes(__( 'Sat'))?>'],
    today:"<?php echo addslashes(__( 'Today'))?>",
    clear:"<?php echo addslashes(__( 'Clear'))?>",
    close: "<?php echo addslashes(__( 'Close'))?>",
	format: 'yyyy-mm-dd'
});
<?php $this->Html->scriptEnd(); ?>