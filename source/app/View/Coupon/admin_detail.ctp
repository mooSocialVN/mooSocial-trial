<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));
$this->Paginator->options(array('url' => $this->passedArgs));
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Coupons Manager'), array('controller' => 'coupon', 'action' => 'admin_index'));

$helperSubscription = MooCore::getInstance()->getHelper("Subscription_Subscription");

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "coupon"));
$this->end();
?>
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <a href="<?php echo $this->request->base?>/admin/coupon" class="btn btn-gray"><?php echo __('Back');?></a>
                    </div>
                </div>    
                <div class="col-md-6">
                	<div id="sample_1_filter" class="dataTables_filter">
	                    <form method="post" action="<?php echo $this->request->base?>/admin/coupon/detail/<?php echo $id;?>">
	                    	<label>
	                        <input name="data[name]" value="<?php echo isset($this->request->named['name']) ? $this->request->named['name'] : ''?>" class="form-control input-medium input-inline" placeholder="<?php echo __('Search by buyer name');?>" type="text" id="keyword">                       
	                        <div class="submit"><input style="display:none" type="submit" value=""></div>
	                        </label>                    
	                    </form>
	                </div>
                </div>            
            </div>            
        </div>

        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr class="tbl_head">
                <th width="150px"><?php echo  __('Order');?></th>
                <th width="150px"><?php echo  __('Purchased');?></th>
                <th width="150px"><?php echo  __('Date');?></th>
                <th width="250px"><?php echo  __('Total');?></th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($items as $item): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <td>
                    	<?php if (isset($item['User']) && $item['User']['id']):?>
                    		<?php echo __('By')?> <a href="<?php echo $item['User']['moo_href']?>"><?php echo $item['User']['moo_title']?></a>
                    	<?php endif;?>
                    </td>  
                    <td>
                    	<?php 
                    		$object = MooCore::getInstance()->getItemByType($item['CouponUse']['type'], $item['CouponUse']['type_id']);
                    		if ($item['CouponUse']['type'] == 'Subscription_Subscription_Package_Plan')
                    		{
                    			echo $object['SubscriptionPackage']['name'].' - '. $helperSubscription->getPlanDescription($object['SubscriptionPackagePlan'],$item['CouponUse']['currency']);
                    		}
                    		else
                    		{
                    			echo $item[key($item)]['moo_title'];
                    		}
                    	?>
                    </td>
                    <td>
                    	<?php echo  $this->Time->format('m/d/Y',$item['CouponUse']['created']);?>
                    </td>
                    <td>
                    	<?php echo $item['CouponUse']['amount'];?> <?php echo $item['CouponUse']['currency'];?>
                    </td>

                </tr>
            <?php endforeach ?>

            </tbody>
        </table>
		<div class="pagination pull-right">
            <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(); ?>
			<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
        </div>
</div>




