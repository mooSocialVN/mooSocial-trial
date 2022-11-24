<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "subscription"));
$this->end();

$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
$list_status = $helper->getListStatus('SubscriptionRefund');
$currency = Configure::read('Config.currency');
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
	$('.footable').footable();
});
<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Moo->renderMenu('Subscription', __('Manage Refund Requests'));?>
<div id="center">
	<form method="post" action="<?php echo $this->base.$url;?>" >
		<div style="padding-bottom: 15px;" class="dataTables_filter">
			<?php echo __('Search');?>
			<input class="form-control input-small input-inline" value="<?php if (isset($name)) echo $name;?>" type="text" name="name">
			<?php echo __('Plan');?>
			<select class="form-control input-small input-inline" name="plan_id">
				<option></option>
				<?php foreach ($plans as $plan):?>
					<option <?php if (isset($plan_id) && $plan_id ==  $plan['SubscriptionPackagePlan']['id']) echo 'selected="selected"';?> value="<?php echo $plan['SubscriptionPackagePlan']['id'];?>"><?php echo $helper->getPlanDescription($plan['SubscriptionPackagePlan'],$currency['Currency']['currency_code']);?></option>
				<?php endforeach;?>
			</select>
			<?php echo __('Status');?>
			<select class="form-control input-small input-inline" name="status">
				<option></option>
				<?php foreach ($list_status as $key=>$name):?>
					<option <?php if (isset($status) && $status ==  $key) echo 'selected="selected"';?> value="<?php echo $key?>"><?php echo $name;?></option>
				<?php endforeach;?>
			</select>
			
			<?php echo __('Start date');?>
			<input class="datepicker form-control input-small input-inline" value="<?php if (isset($start_date)) echo $start_date;?>" type="text" name="start_date">
			<?php echo __('End date');?>
			<input class="datepicker form-control input-small input-inline" value="<?php if (isset($end_date)) echo $end_date;?>" type="text" name="end_date">
			
			<button class="btn btn-gray" id="sample_editable_1_new" type="submit">
				<?php echo __('Search');?>
            </button>
		</div>
	</form>	
	<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
				<th><?php echo __('Request date'); ?></th>
				<th><?php echo __('User request'); ?></th>
				<th><?php echo __('Plan'); ?></th>
				<th><?php echo __('Account'); ?></th>
				<th><?php echo __('Reason'); ?></th>
				<th><?php echo __('Status'); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (count($refunds)):?>
				<?php foreach ($refunds as $refund): ?>
				<tr>
					<td><?php echo $this->Time->format('m/d/Y',$refund['SubscriptionRefund']['created']);?></td>
					<td>
						<a href="<?php echo $refund['User']['moo_href'];?>"><?php echo $refund['User']['name'];?></a>
					</td>
					<td>
						<?php 
							echo $helper->getPlanDescription($refund['SubscriptionPackagePlan'],$refund['Subscribe']['currency_code']);
						?>
					</td>
					<td><?php echo $refund['SubscriptionRefund']['account'];?></td>
					<td><?php echo $refund['SubscriptionRefund']['reason'];?></td>
					<td><?php echo $helper->getTextStatusRefund($refund);?></td>
					<td>
						<?php if ($refund['SubscriptionRefund']['status'] == 'initial'):?>
							<a href="javascript:void(0);" onclick="acceptRefund(<?php echo $refund['SubscriptionRefund']['id'];?>)"><?php echo __('Accept');?></a> | 
							<a href="javascript:void(0);" onclick="denyRefund(<?php echo $refund['SubscriptionRefund']['id'];?>)"><?php echo __('Deny');?></a>
						<?php endif;?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php else:?>
				<tr>
					<td colspan="7">
						<?php echo __('No refund found');?>
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
<div id="content_error" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Warning');?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo __('Error when denying refund');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="content_deny_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Deny request');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to deny this request?');?></span><br>
			<b><?php echo __('Please provide reasons for denying this request');?></b>												
            <textarea class="form-control" id="reason"></textarea>
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" id="deny_button" class="btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="content_deny_accept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Accept request');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to Accept this request?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" id="accept_button" class="btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>
<script>
function denyRefund(id)
{
	$('#deny_button').removeClass('disabled');
	$('#content_deny_request').modal('show');
	$('#content_deny_request').on('shown.bs.modal', function () {
		$('#deny_button').unbind('click').click(function(e){
			$('#deny_button').addClass('disabled');
			$('#deny_button').spin('small');
			$.post(mooConfig.url.base + "/admin/subscription/refunds/deny", {'id':id,'reason':$('#content_deny_request #reason').val()}, function(data){
				$('#content_deny_request').modal('hide');
				if (data.status)
				{
					window.location=window.location;
				}
				else
				{
					$('#deny_button').spin(false);
					$('#content_error').modal('show');
				}
			},'json');
		});
	});	
}

function acceptRefund(id)
{
	$('#accept_button').removeClass('disabled');
	$('#content_deny_accept').modal('show');
	$('#content_deny_accept').on('shown.bs.modal', function () {
		$('#accept_button').unbind('click').click(function(e){
			$('#accept_button').addClass('disabled');
			$('#accept_button').spin('small');
			$.post(mooConfig.url.base + "/admin/subscription/refunds/accept",{'id':id}, function(data){
				$('#content_deny_accept').modal('hide');
				if (data.status)
				{
					window.location=window.location;
				}
				else
				{
					$('#accept_button').spin(false);
					$('#content_error').modal('show');
				}
			},'json');
		});
	});		
}
</script>
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