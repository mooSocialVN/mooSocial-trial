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
                            <div class="plugin_site-bg_gray">
                                Billing and account information
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputCountry">Country <span class="required">*</span></label>
                            <select id="inputCountry" class="form-control">
                                <option>United State(Us)</option>
                            </select>
                        </div>

                        <div class="row form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputFirstName">First name <span class="required">*</span></label>
                                    <input id="inputFirstName" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputLastName">Last Name <span class="required">*</span></label>
                                    <input id="inputLastName" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputCompanyName">Company Name</label>
                            <input id="inputCompanyName" type="text" class="form-control" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input id="inputAddress" type="text" class="form-control" placeholder="Street Address">
                        </div>
                        <div class="form-group">
                            <input id="" type="text" class="form-control" placeholder="Appartment, suit, unit etc (optional)">
                        </div>

                        <div class="form-group">
                            <label for="inputTownCity">Town / City</label>
                            <input id="inputTownCity" type="text" class="form-control" placeholder="">
                        </div>

                        <div class="row form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input id="inputEmailAddress" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="inputPhone">Phone</label>
                                    <input id="inputPhone" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-dashboard table-striped">
                                    <thead>
                                    <tr>
                                        <th width="50">&nbsp;</th>
                                        <th><?php echo __('Product') ?></th>
                                        <th>&nbsp;</th>
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
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right">
                                            <?php echo __('Total') ?>
                                        </td>
                                        <td>
                                            $20
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="plugin_site-radio">
                                <label>
                                    <input type="radio" name="" id="" value="" checked>
                                    <img src="<?php $this->request->webroot ?>/img/paypal.png">
                                    <div class="plugin_site-radio-help">
                                        Pay via paypal: you can pay with your credit card if you don’t have a paypal account
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <div>
                                    <input type="checkbox"> I’ve read and accepted the <a href="#">terms & conditions</a>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-block btn-lg"><?php echo __('Proceed') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
