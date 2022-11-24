
<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Subscription'), '/admin/subscription/subscription_settings');

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "subscribes"));
$this->end();

$helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
$subscribeModel = MooCore::getInstance()->getModel('Subscription.Subscribe');
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo  __( 'Subscription Details'); ?></h4>
</div>
<div class="modal-body form-horizontal">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Subscription ID'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  $subscribeDetail['id']; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Member'); ?>
            </div>
            <div class="col-md-8">
                <?php echo  $user['name'] ?> (<?php echo  $user['email'] ?>)
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Package'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  $package['name'] ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Coupon code'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  !empty($transactions[0]['SubscriptionTransaction']['coupon_code']) ? $transactions[0]['SubscriptionTransaction']['coupon_code'] : 'N/A' ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Plan Title'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  $plan['title'] ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Plan Description'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $helper->getPlanDescription($plan,$subscribeDetail['currency_code']);	?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Package User Role'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  $group['name'] ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Subscription Status'); ?>
            </div>
            <div class="col-md-4">
                <?php echo  $helper->getTextStatus(array('Subscribe'=>$subscribeDetail));?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Created'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $this->Time->format('m/d/Y',$subscribeDetail['created']); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <?php echo  __( 'Expires'); ?>
            </div>
            <div class="col-md-4">
                <?php echo $subscribeDetail['expiration_date'] ? $this->Time->format('m/d/Y H:m:i',$subscribeDetail['expiration_date']) : __('Forever'); ?>
            </div>
        </div>
        <?php $last = $subscribeModel->find('first',array(
            'conditions' => array('User.id'=>$user['id']),
            'order' => array(
                'Subscribe.created' => 'DESC'
            )
        ));

        $array_status = array(
            'active' => __('Active'),
            'cancel' => __('Cancel Recurring'),
            'expired' => __('Expire'),
            'refunded' => __('Refunded'),
            'inactive' => __('Inactive'),
        );

        if ($last['Subscribe']['id'] == $subscribeDetail['id']) :
            ?>
            <div class="form-group">
                <div class="col-md-4">
                    <?php echo  __( 'Action'); ?>
                </div>
                <div class="col-md-4">
                    <?php foreach ($array_status as $status => $value):?>
                        <?php if ($status != $subscribeDetail['status']):?>
                            <?php
                            $method = 'can'.ucfirst($status);

                            if (method_exists($helper, $method))
                            {
                                if (!$helper->{$method}($subscribe))
                                    continue;
                            }
                            ?>
                            <a href="javascript:void(0);" onclick="doAction('<?php echo $status?>');"><?php echo $value?></a> |
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>
<div class="modal-header">
    <h4 class="modal-title"><?php echo  __( 'Related Transactions'); ?></h4>
</div>

<div class="tab-pane active" id="portlet_tab1">
    <?php if($transactions != null):?>
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <th><?php echo __( 'ID')?></th>
                <th><?php echo __( 'Amount')?></th>
                <th><?php echo __( 'Status')?></th>
                <th><?php echo __( 'Type')?></th>
                <th><?php echo __( 'Date')?></th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 0;
            foreach ($transactions as $transaction):
                ?>
                <tr id="<?php echo $transaction['SubscriptionTransaction']['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <td class="reorder"><?php echo $transaction['SubscriptionTransaction']['id']?></td>
                    <td class="reorder"><?php echo $transaction['SubscriptionTransaction']['amount'].$transaction['SubscriptionTransaction']['currency']?></td>
                    <td class="reorder"><?php echo $helper->getTextStatusTransaction($transaction)?></td>
                    <td class="reorder"><?php echo $helper->getTextTypeTransaction($transaction)?></td>
                    <td class="reorder"><?php echo $this->Time->format('m/d/Y',$transaction['SubscriptionTransaction']['created']); ?></td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php else:?>
        <?php echo __( 'No subscriptions found');?>
    <?php endif;?>
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
    function doAction(name)
    {
        if (name != '')
        {
            window.subscribe_id = <?php echo $subscribe['Subscribe']['id'];?>;
            $('[name="'+name+'"]').removeClass('disabled');
            $('#content_'+name).modal('show');

            $('#content_'+name).on('hide.bs.modal', function () {

            })
        }
    }
</script>