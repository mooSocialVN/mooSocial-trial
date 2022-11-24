<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'),'/admin/home');
$this->Html->addCrumb(__('Managed Gateways'), $url);

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" =>'payment_gateway'));
$this->end();
?>
<div class="portlet-body">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">            
           	<?php echo $this->Moo->renderMenu('PaymentGateway', __('Manage Gateways'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab3">
                            <?php if($gateways != null):?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->paginator->sort('name', __('Name'));?></th>
                                        <th><?php echo __('Description');?></th>
                                        <th width="90" class="text-center"><?php echo $this->paginator->sort('enabled', __('Enabled'));?></th>
                                        <th width="90" class="text-center"><?php echo $this->paginator->sort('test_mode', __('Test Mode'));?></th>
                                        <th width="90" class="text-center"><?php echo $this->paginator->sort('ipn_log', __('Ipn Log'));?></th>
                                        <th width="80" class="text-center"><?php echo __('Actions');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0;
                                    foreach ($gateways as $gateway): 
                                        $gateway = $gateway['Gateway'];
                                    ?>
                                        <tr id="<?php echo $gateway['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                                            <td class="reorder"><?php echo $gateway['name']; ?></td>
                                            <td><?php echo $gateway['description'];?></td>
                                            <td class="reorder text-center">
                                                <?php if ( $gateway['enabled'] ): ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_disable/'.$gateway['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                <?php else: ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_enable/'.$gateway['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                <?php endif; ?>
                                            </td>
                                            <td class="reorder text-center">
                                                <?php if ( $gateway['test_mode'] ): ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_disabletest/'.$gateway['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                <?php else: ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_enabletest/'.$gateway['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                <?php endif; ?>
                                            </td>
                                            <td class="reorder text-center">
                                                <?php if ( $gateway['ipn_log'] ): ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_disable_ipn/'.$gateway['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                <?php else: ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_enable_ipn/'.$gateway['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                            	<a href="<?php echo $this->request->base.$url_create.$gateway['id']?>"><?php echo __('Edit');?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php echo $this->Paginator->first('First');?>&nbsp;
                            <?php echo $this->Paginator->hasPage(2) ? $this->Paginator->prev(__('Prev')) : '';?>&nbsp;
                            <?php echo $this->Paginator->numbers();?>&nbsp;
                            <?php echo $this->Paginator->hasPage(2) ?  $this->Paginator->next(__('Next')) : '';?>&nbsp;
                            <?php echo $this->Paginator->last('Last');?>
                            <?php else:?>
                                <?php echo __('No gateways found');?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>