<?php
echo $this->Html->css(array('jquery-ui','pickadate', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui','pickadate/picker', 'pickadate/picker.date','footable'), array('inline' => false));
$this->Paginator->options(array('url' => $this->passedArgs));
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Coupons Manager'), array('controller' => 'coupon', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "coupon"));
$this->end();
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('hidden.bs.modal', function (e) {
	$(e.target).removeData('bs.modal');
});
<?php $this->Html->scriptEnd(); ?>

    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                    	<button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo  $this->request->base ?>/admin/coupon/ajax_create">
                    		<?php echo __('Add Coupon');?>
                    	</button>
                    </div>
                </div>    
                <div class="col-md-6">
                	<div id="sample_1_filter" class="dataTables_filter">
	                    <form method="post" action="<?php echo $this->request->base?>/admin/coupon">
	                    	<label>
	                        <input name="data[code]" value="<?php echo isset($this->request->named['code']) ? $this->request->named['code'] : ''?>" class="form-control input-medium input-inline" placeholder="<?php echo __('Search by code');?>" type="text" id="keyword">                       
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
                <th width="150px"><?php echo  __('Code');?></th>
                <th width="150px"><?php echo  __('Coupon type');?></th>
                <th width="150px"><?php echo  __('Coupon amount');?></th>
                <th width="250px"><?php echo  __('Description');?></th>
                <th width="150px"><?php echo  __('Usage');?></th>
                <th width="150px"><?php echo  __('Expiry date');?></th>                   
                <th width="50px" data-hide="phone"><?php echo  __('Active');?></th>
                <th width="50px" data-hide="phone"><?php echo  __('Actions');?></th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($coupons as $coupon): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <td>
                    	<a data-target="#ajax" data-toggle="modal" class="" title="Country" data-dismiss="" data-backdrop="true" style="" href="<?php echo $this->base?>/admin/coupon/ajax_create/<?php echo $coupon['Coupon']['id'];?>"><?php echo $coupon['Coupon']['code']?></a>
                    </td>
                    <td>
                    	<?php if ($coupon['Coupon']['type']):?>
                    		<?php echo __('Cart % discount');?>
                    	<?php else:?>
                    		<?php echo __('Cart discount');?>
                    	<?php endif;?>
                    </td>  
                    <td ><?php echo $coupon['Coupon']['value'];?></td>
                    <td ><?php echo $coupon['Coupon']['description'];?></td>
                    <td>
                    	<?php if ($coupon['Coupon']['count']):?>
                    		<a href="<?php echo $this->request->base?>/admin/coupon/detail/<?php echo $coupon['Coupon']['id'];?>"><?php echo $coupon['Coupon']['count'].'/'.($coupon['Coupon']['limit'] ? $coupon['Coupon']['limit'] : __('unlimited'));?></a>	
                    	<?php else:?>
                    		<p><?php echo $coupon['Coupon']['count'].'/'.($coupon['Coupon']['limit'] ? $coupon['Coupon']['limit'] : __('unlimited'));?></p>
                    	<?php endif;?>
                    </td>
                    <td><?php echo $coupon['Coupon']['expire'] != '0000-00-00' ? $this->Time->format('m/d/Y',$coupon['Coupon']['expire']) : '';?></td>
                    <td ><?php echo ($coupon['Coupon']['actived']) ? __('Yes') : __('No')?></td>
                    <td>
                    	<a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this coupon? This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/coupon/delete/<?php echo $coupon['Coupon']['id']?>')"><i class="icon-trash icon-small"></i></a>                    	
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




