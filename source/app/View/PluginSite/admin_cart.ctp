<?php
echo $this->Html->css(array('plugin-site'), null, array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Admin Home'), array('controller' => 'home', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "dashboard"));
$this->end();
?>

<div class="col-xs-12">
    <div class="plugin_site-section">
        <div class="plugin_site-content">
            <div class="table-responsive">
                <table class="table table-dashboard table-striped">
                    <thead>
                    <tr>
                        <th width="50">&nbsp;</th>
                        <th><?php echo __('Product') ?></th>
                        <th><?php echo __('Price') ?></th>
                        <th width="200"><?php echo __('Quantity') ?></th>
                        <th><?php echo __('Total') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a class="plugin_site-remove-cart" href="javascript:void(0);">
                                    <span class="material-icons">close</span>
                                </a>
                            </td>
                            <td>
                                <span class="plugin_site-cart-thumb">
                                    <img class="plugin_site-cart-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                                </span> Forum plugin x<span class="">1</span>
                            </td>
                            <td>$20</td>
                            <td>
                                <input class="form-control" value="1">
                            </td>
                            <td>$20</td>
                        </tr>
                        <tr>
                            <td>
                                <a class="plugin_site-remove-cart" href="javascript:void(0);">
                                    <span class="material-icons">close</span>
                                </a>
                            </td>
                            <td>
                                <span class="plugin_site-cart-thumb">
                                    <img class="plugin_site-cart-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                                </span> Forum plugin x<span class="">1</span>
                            </td>
                            <td>$20</td>
                            <td>
                                <input class="form-control" value="1">
                            </td>
                            <td>$20</td>
                        </tr>
                        <tr>
                            <td>
                                <a class="plugin_site-remove-cart" href="javascript:void(0);">
                                    <span class="material-icons">close</span>
                                </a>
                            </td>
                            <td>
                                <span class="plugin_site-cart-thumb">
                                    <img class="plugin_site-cart-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                                </span> Forum plugin x<span class="">1</span>
                            </td>
                            <td>$20</td>
                            <td>
                                <input class="form-control" value="1">
                            </td>
                            <td>$20</td>
                        </tr>
                        <tr>
                            <td>
                                <a class="plugin_site-remove-cart" href="javascript:void(0);">
                                    <span class="material-icons">close</span>
                                </a>
                            </td>
                            <td>
                                <span class="plugin_site-cart-thumb">
                                    <img class="plugin_site-cart-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                                </span> Forum plugin x<span class="">1</span>
                            </td>
                            <td>$20</td>
                            <td>
                                <input class="form-control" value="1">
                            </td>
                            <td>$20</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" style="text-align: right;">
                                <button class="btn btn-default" type="button"><?php echo __('Update cart') ?></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="plugin_site-cart-info-proceed">
                <div class="form-group">
                    <div>
                        <strong><?php echo __('Cart Totals') ?></strong>
                    </div>
                    <div>
                        SUBTOTAL <span>$1,337.00</span>
                    </div>
                    <div>
                        TOTAL <span>$1,337.00</span>
                    </div>
                </div>

                <button class="btn btn-primary btn-lg"><?php echo __('Proceed to checkout') ?></button>
            </div>
        </div>
    </div>
</div>
