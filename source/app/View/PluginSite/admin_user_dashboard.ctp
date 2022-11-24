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
            <div class="container">
                <div class="plugin_site-container">
                    <form class="form-plugin_site" action="">
                        <div class="form-group">
                            <div>
                                Hello mooadmin (not mooadmin? Sign out). From your account dashboard you can view your recent orders, manage your shipping and billing addresses and edit your password and account detail
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <h3 class="plugin_site-heading">My Network website</h3>
                                <a href="">Buy cloud service</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-dashboard table-striped">
                                    <thead>
                                    <tr>
                                        <th width="50"><?php echo __('Plan') ?></th>
                                        <th><?php echo __('Site name') ?></th>
                                        <th><?php echo __('Site Url') ?></th>
                                        <th><?php echo __('Status') ?></th>
                                        <th><?php echo __('Action') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Sportbook
                                            </td>
                                            <td>
                                                Mark Community
                                            </td>
                                            <td>
                                                <a href="">https://moosoocial-zpuvik.bk.cloud.moosocial.com</a>
                                            </td>
                                            <td>
                                                Active
                                            </td>
                                            <td>
                                                <a href="">View Detail</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <h3 class="plugin_site-heading">Billing and Payment</h3>
                        </div>

                        <div class="form-group">
                            <div>
                                <h3 class="plugin_site-heading plugin_site-bold">My Adress</h3>
                                <div>
                                    The following addresses will be used on the checkout page by default
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <h3 class="plugin_site-heading plugin_site-bold">Billing Address <a class="plugin_site-heading-edit" href="">Edit</a></h3>
                            <div>
                                Andree Bui<br>
                                23232<br>
                                264E Le Van Sy<br>
                                HCMC<br>
                                Vietnam
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
