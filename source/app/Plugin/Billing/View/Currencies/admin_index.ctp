<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Managed Currencies'), $url);

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "currencies"));
$this->end();
?>

<a href="<?php echo $this->request->base.$url_create;?>" class="btn green btn_create_theme" data-toggle="modal">
    <i class="fa fa-plus"></i> <?php echo __('Create Currency');?>
</a>

<div class="portlet-body">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <?php echo $this->Moo->renderMenu('Billing', __('Manage Currencies'));?>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <?php if($currencies != null):?>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->paginator->sort('name', __('Name'));?></th>
                                        <th><?php echo $this->paginator->sort('currency_code', __('Code'));?></th>
                                        <th><?php echo $this->paginator->sort('symbol', __('Symbol'));?></th>
                                        <th width="250"><?php echo $this->paginator->sort('description', __('Description'));?></th>
                                        <th class="text-center" width="80"><?php echo $this->paginator->sort('is_default', __('Default'));?></th>
                                        <th class="text-center" width="80"><?php echo $this->paginator->sort('is_active', __('Active'));?></th>
                                        <th class="text-center" width="90"><?php echo __('Actions');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0;
                                    foreach ($currencies as $currency): 
                                        $currency = $currency['Currency'];
                                    ?>
                                        <tr id="<?php echo $currency['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                                            <td class="reorder"><?php echo $currency['name']?></td>
                                            <td class="reorder"><?php echo $currency['currency_code']?></td>
                                            <td class="reorder"><?php echo $currency['symbol']?></td>
                                            <td class="reorder"><?php echo $currency['description']?></td>
                                            <td class="reorder text-center">
                                                <?php if ( $currency['is_default'] ): ?>
                                                    <a><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                <?php else: ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_default/'.$currency['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                <?php endif; ?>
                                            </td>
                                            <td class="reorder text-center">
                                                <?php if ( $currency['is_active'] ): ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_unactive/'.$currency['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                <?php else: ?>
                                                    <a href="<?php echo $this->request->base.$url.'do_active/'.$currency['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo $this->request->base.$url_create.$currency['id']?>"><?php echo __('Edit');?></a>
                                                |
                                                <a href="<?php echo $this->request->base.$url_delete.$currency['id']?>" onclick="return confirm('<?php echo addslashes(__('Are you sure?'));?>')"><?php echo __('Delete');?></a>
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
                                <?php echo __('No currencies found');?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>