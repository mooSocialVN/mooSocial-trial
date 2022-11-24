<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "subscription"));
$this->end();

$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
$subscribeModel = MooCore::getInstance()->getModel('Subscription.Subscribe');
$list_status = $helper->getListStatus('Subscribe');
$currency = Configure::read('Config.currency');
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
	$('.footable').footable();
});
<?php $this->Html->scriptEnd(); ?>
<?php echo $this->Moo->renderMenu('Subscription', __('Manage Subscribers'));?>
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
				<th><?php echo __('Subscribed Date'); ?></th>
				<th><?php echo __('Plan'); ?></th>
				<th><?php echo __('Member Level'); ?></th>
				<th><?php echo __('Status'); ?></th>
				<th><?php echo __('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (count($subscribes)):?>
				<?php $array_last = array();?>
				<?php foreach ($subscribes as $subscribe): ?>
				<tr>
					<td>
						<a href="<?php echo $subscribe['User']['moo_href'];?>"><?php echo $subscribe['User']['name'];?></a>
					</td>
					<td><?php echo $this->Time->format('m/d/Y',$subscribe['Subscribe']['created']);?></td>
					<td>
						<p><?php echo $subscribe['SubscriptionPackage']['name']; ?> - <?php echo $subscribe['SubscriptionPackagePlan']['title']; ?></p>
						<p><?php echo $helper->getPlanDescription($subscribe['SubscriptionPackagePlan'],$subscribe['Subscribe']['currency_code']);	?></p>
					</td>
					<td>
						<?php 
							$level = MooCore::getInstance()->getItemByType('Core_Role',$subscribe['User']['role_id']);
							echo $level['Role']['name']
						?>
					</td>
					<td><?php echo $helper->getTextStatus($subscribe);?></td>
					<td>
						<?php 							
							if (!isset($array_last[$subscribe['User']['id']]))
							{
								$array_last[$subscribe['User']['id']] = $subscribeModel->find('first',array(
									'conditions' => array('User.id'=>$subscribe['User']['id']),
									'order' => array(
						                'Subscribe.created' => 'DESC'
						            )
								));
							}
							
							$last = $array_last[$subscribe['User']['id']];
						
							$array_status = array(
								'active' => __('Active'),
								'cancel' => __('Cancel Recurring'),								
								'expired' => __('Expire'),
								'refunded' => __('Refunded'),
								'inactive' => __('Inactive'),
							);
							
						?>
						<a href="<?php echo $this->base.'/admin/subscription/subscribes/detail/'.$subscribe['Subscribe']['id']?>"><?php echo __('Detail');?></a>
						<?php if ($last['Subscribe']['id'] == $subscribe['Subscribe']['id']):?>
							<select class="form-control input-small input-inline" id="action_<?php echo $subscribe['Subscribe']['id'];?>" onclick="changeAction(<?php echo $subscribe['Subscribe']['id'];?>)">
								<option></option>
								<?php foreach ($array_status as $status=>$name):?>									
									<?php if ($status != $subscribe['Subscribe']['status']):?>
										<?php
											$method = 'can'.ucfirst($status);
											
											if (method_exists($helper, $method))
											{
												if (!$helper->{$method}($subscribe))
													continue;
											}
										?>
										<option value="<?php echo $status ?>"><?php echo $name;?></option>
									<?php endif;?>
								<?php endforeach;?>
							</select>
						<?php endif;?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php else:?>
				<tr>
					<td colspan="6">
						<?php echo __('No subscriber found');?>
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
<div class="modal fade" id="content_active" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Activate subscription');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to activate this subscription?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" name="active" class="button_action btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="content_cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Cancel subscription');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to cancel this subscription?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" name="cancel" class="button_action btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="content_expired" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Expire subscription');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to expire this subscription?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" name="expired" class="button_action btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="content_inactive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Inactivate subscription');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to inactivate this subscription?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" name="inactive" class="button_action btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="content_refunded" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel"><?php echo __('Refund subscription');?></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <span><?php echo __('Are you sure to refund this subscription?');?></span><br>								
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close'); ?></button>
        <button type="button" name="refunded" class="button_action btn btn-primary"><?php echo __('Ok');?></button>
      </div>
    </div>
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
        <p><?php echo __('Error when changing status of subsciption');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Close');?></button>        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
$('.button_action').click(function(){		
		var e = $(this);
		var name = e.attr('name');
		e.addClass('disabled');
		e.spin('small');
		$.post(mooConfig.url.base + "/admin/subscription/subscribes/"+name,{'id':window.subscribe_id}, function(data){
			$('#content_'+name).modal('hide');			
			if (data.status)
			{
				window.location=window.location;
			}
			else
			{
				 e.spin(false);
				 $('#content_error').modal('show');
			}
		},'json');
});
<?php $this->Html->scriptEnd(); ?>

<script>
function changeAction(id)
{
	name = $('#action_' + id).val();
	if (name != '')
	{
		window.subscribe_id = id;
		$('[name="'+name+'"]').removeClass('disabled');
		$('#content_'+name).modal('show');

		$('#content_'+name).on('hide.bs.modal', function () {
			$('#action_' + id).val('');
		})
	}
}
</script>