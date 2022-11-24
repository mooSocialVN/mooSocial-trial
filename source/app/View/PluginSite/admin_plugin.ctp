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
        <div class="plugin_site-header">
            <div class="plugin_site-header-l">
                <ul class="plugin_site-tab">
                    <li class="active">
                        <a href="<?php echo $this->request->base ?>/admin/plugin_site/plugin"><?php echo __('Plugins') ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->request->base ?>/admin/plugin_site/theme"><?php echo __('Themes') ?></a>
                    </li>
                    <li>
                        <a href="<?php echo $this->request->base ?>/admin/plugin_site/app"><?php echo __('App supported') ?></a>
                    </li>
                </ul>
            </div>
            <div class="plugin_site-header-r">
                <div class="plugin_site-action-bar">
                    <div class="plugin_site-search">
                        <input class="plugin_site-search-input" type="text" value="" placeholder="<?php echo __('Search') ?>">
                        <button class="plugin_site-search-submit" type="button">
                            <span class="global-search-icon-submit material-icons">search</span>
                        </button>
                    </div>
                    <div class="plugin_site-cart-total">
                        <span class="plugin_site-cart-icon material-icons">shopping_cart</span>
                        <span class="plugin_site-cart-price">$392</span>
                    </div>
                    <div class="plugin_site-cart-checkout">
                        <a class="btn-cart-checkout btn btn-success" href="">Checkout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="plugin_site-content">
            <div class="plugin_site-plugin_lists">
                <div class="plugin-list-item">
                    <div class="plugin-list-warp">
                        <div class="plugin-list-thumb">
                            <img class="plugin-list-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                        </div>
                        <div class="plugin-list-info">
                            <div class="plugin-list-title">
                                Magic Page Plugin
                            </div>
                            <div class="plugin-list-price">
                                $50
                            </div>
                            <div class="plugin-list-desc">
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                            </div>
                            <div class="plugin-list-action">
                                <button class="btn btn-default"><?php echo __('Add to cart') ?></button>
                                <button class="btn btn-default"><?php echo __('Checkout') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plugin-list-item">
                    <div class="plugin-list-warp">
                        <div class="plugin-list-thumb">
                            <img class="plugin-list-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                        </div>
                        <div class="plugin-list-info">
                            <div class="plugin-list-title">
                                Magic Page Plugin
                            </div>
                            <div class="plugin-list-price">
                                $50
                            </div>
                            <div class="plugin-list-desc">
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                            </div>
                            <div class="plugin-list-action">
                                <button class="btn btn-default"><?php echo __('Add to cart') ?></button>
                                <button class="btn btn-default"><?php echo __('Checkout') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plugin-list-item">
                    <div class="plugin-list-warp">
                        <div class="plugin-list-thumb">
                            <img class="plugin-list-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                        </div>
                        <div class="plugin-list-info">
                            <div class="plugin-list-title">
                                Magic Page Plugin
                            </div>
                            <div class="plugin-list-price">
                                $50
                            </div>
                            <div class="plugin-list-desc">
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                            </div>
                            <div class="plugin-list-action">
                                <button class="btn btn-default"><?php echo __('Add to cart') ?></button>
                                <button class="btn btn-default"><?php echo __('Checkout') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plugin-list-item">
                    <div class="plugin-list-warp">
                        <div class="plugin-list-thumb">
                            <img class="plugin-list-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                        </div>
                        <div class="plugin-list-info">
                            <div class="plugin-list-title">
                                Magic Page Plugin
                            </div>
                            <div class="plugin-list-price">
                                $50
                            </div>
                            <div class="plugin-list-desc">
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                            </div>
                            <div class="plugin-list-action">
                                <button class="btn btn-default"><?php echo __('Add to cart') ?></button>
                                <button class="btn btn-default"><?php echo __('Checkout') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="plugin-list-item">
                    <div class="plugin-list-warp">
                        <div class="plugin-list-thumb">
                            <img class="plugin-list-img" src="<?php echo $this->request->webroot ?>img/og-image.png">
                        </div>
                        <div class="plugin-list-info">
                            <div class="plugin-list-title">
                                Magic Page Plugin
                            </div>
                            <div class="plugin-list-price">
                                $50
                            </div>
                            <div class="plugin-list-desc">
                                Magic Page is the best plugin to create static pages on moosocial website. It’s has all the features you need to create a page: layout managers, widgets manager… You can also create a landing page with Magic Page.
                            </div>
                            <div class="plugin-list-action">
                                <button class="btn btn-default"><?php echo __('Add to cart') ?></button>
                                <button class="btn btn-default"><?php echo __('Checkout') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
