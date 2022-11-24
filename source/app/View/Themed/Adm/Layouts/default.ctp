<?php
/**
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 */
?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8"/>
        <title>
            <?php if (Configure::read('core.site_offline')) echo __('[OFFLINE]'); ?>
            <?php echo $title_for_layout; ?> | <?php echo Configure::read('core.site_name'); ?>
        </title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta name="description"
              content="<?php echo $title_for_layout ?> | <?php echo Configure::read('core.site_name') ?> | <?php echo Configure::read('core.site_description') ?>"/>
        <meta name="keywords" content="<?php echo Configure::read('core.site_keywords'); ?>"/>
        <meta property="og:image" content="<?php echo FULL_BASE_URL . $this->request->webroot ?>img/og-image.png"/>
        <meta content="" name="author"/>
        
        <link rel="shortcut icon" href="<?php echo FULL_BASE_URL.$this->request->webroot ?>favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <?php
        echo $this->Html->meta('icon',$this->Moo->faviconImage());
        echo $this->Html->css(array(
            'font-awesome/css/font-awesome.min.css?' . Configure::read('core.version'),
            'simple-line-icons/simple-line-icons.min.css?' . Configure::read('core.version'),
            'bootstrap/css/bootstrap.min.css?' . Configure::read('core.version'),
            'uniform/css/uniform.default.css?' . Configure::read('core.version'),
            'bootstrap-switch/css/bootstrap-switch.min.css?' . Configure::read('core.version'),
            'fontello/css/animation.css?' . Configure::read('core.version'),
            'fontello/css/fontello.css?' . Configure::read('core.version'),
            'fontello/css/fontello-codes.css?' . Configure::read('core.version'),
            'fontello/css/fontello-embedded.css?' . Configure::read('core.version'),
            'fontello/css/fontello-ie7.css?' . Configure::read('core.version'),
            'fontello/css/fontello-ie7-codes.css?' . Configure::read('core.version'),
            'bootstrap-toastr/toastr.min.css?' . Configure::read('core.version'),
            'select2/select2.css?' . Configure::read('core.version'),
            'datatables/plugins/bootstrap/dataTables.bootstrap.css?' . Configure::read('core.version'),
            'components.css?' . Configure::read('core.version'),
            'plugins.css?' . Configure::read('core.version'),
            'layout/css/layout.css?' . Configure::read('core.version'),
            'layout/css/themes/default.css?' . Configure::read('core.version'),
            'layout/css/custom.css?' . Configure::read('core.version'),
        ));
              
        echo $this->fetch('meta');
        echo $this->fetch('css');
        if(!empty($site_rtl)){
            echo $this->Html->css(array('layout/css/rtl.css?' . Configure::read('core.version'),
                ));
        }
        ?>
    </head>
        <?php if ($this->request->action != 'admin_login') { ?>
        <body class="page-header-fixed page-quick-sidebar-over-content ">
    <?php echo $this->element('misc/fb_include'); ?>
            <div class="page-header navbar navbar-fixed-top">
                <div class="page-header-inner">
            <?php echo $this->element('misc/logo'); ?>
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    </a>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
    <?php echo $this->element('userbox'); ?>
                            <li class="dropdown dropdown-quick-sidebar-toggler hide">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <i class="icon-logout"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="page-container" >
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
    <?php echo $this->fetch('sidebar-menu'); ?>
                    </div>
                </div>
                        <?php echo html_entity_decode(Configure::read('core.header_code')) ?>
    
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Modal title</h4>
                                    </div>
                                    <div class="modal-body">
                                        Widget settings form goes here
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Config -->
                                        <button type="button" class="btn blue ok"><?php echo __('OK'); ?></button>
                                        <button type="button" class="btn default" data-dismiss="modal"><?php echo __('Close'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
                            <div class="page-loading page-loading-boxed">
                                <span>
                                    &nbsp;&nbsp;<?php echo __('Loading...'); ?> </span>
                            </div>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax-translate" role="basic" aria-hidden="true">
                            <div class="page-loading page-loading-boxed">
                                <span>
                                    &nbsp;&nbsp;<?php echo __('Loading...'); ?></span>
                            </div>
                            <div class="modal-dialog">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax-large" role="basic" aria-hidden="true">
                            <div class="page-loading page-loading-boxed">
                                <span>
                                    &nbsp;&nbsp;<?php echo __('Loading...'); ?> </span>
                            </div>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="ajax-small" role="basic" aria-hidden="true">
                            <div class="page-loading page-loading-boxed">
                                <span>
                                    &nbsp;&nbsp;<?php echo __('Loading...'); ?> </span>
                            </div>
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                </div>
                            </div>
                        </div>
                        <h3 class="page-title">
    <?php echo $title_for_layout ?>
                        </h3>
                        <div class="page-bar">
    <?php
    echo $this->Html->getCrumbList(
            array(
        'class' => 'page-breadcrumb',
        'firstClass' => 'first',
        'lastClass' => 'last',
        'separator' => '<i class="fa fa-angle-right"></i>',
        'escape' => true
            ), array('url' => '/admin/home'));
    ?>
                            <?php echo $this->fetch('page-toolbar'); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <?php echo $this->element('right_column'); ?>
                            <?php echo $this->element('left_column'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
            </div>
    
            <div class="page-footer">
                <div class="page-footer-tools">
                    <span class="go-top">
                        <i class="fa fa-angle-up"></i>
                    </span>
                </div>
                <div class="page-footer-inner">
    <?php echo $this->element('footer'); ?>
                </div>
            </div>
            <!--[if lt IE 9]>
            <script src="<?php echo FULL_BASE_URL . $this->request->webroot ?>assets/global/plugins/respond.min.js"></script>
            <script src="<?php echo FULL_BASE_URL . $this->request->webroot ?>assets/global/plugins/excanvas.min.js"></script>
            <![endif]-->
    <?php
    echo $this->Html->script(array(
        'global/jquery-1.11.0.min.js?' . Configure::read('core.version'),
        'global/jquery-migrate-1.2.1.min.js?' . Configure::read('core.version'),
        'global/jquery-ui/jquery-ui-1.10.3.custom.min.js?' . Configure::read('core.version'),
        'global.js?' . Configure::read('core.version'),
        'global/bootstrap/js/bootstrap.min.js?' . Configure::read('core.version'),
        'global/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js?' . Configure::read('core.version'),
        'global/jquery-slimscroll/jquery.slimscroll.min.js?' . Configure::read('core.version'),
        'global/uniform/jquery.uniform.min.js?' . Configure::read('core.version'),
        'global/jquery.blockui.min.js?' . Configure::read('core.version'),
        'global/jquery.cokie.min.js?' . Configure::read('core.version'),
        'global/bootstrap-switch/js/bootstrap-switch.min.js?' . Configure::read('core.version'),
        'moocore/ajax.js?' . Configure::read('core.version'),
        'moocore/phrase.js?' . Configure::read('core.version'),
        'global/select2/select2.min.js?' . Configure::read('core.version'),
        'admin/pages/scripts/ui-toastr.js?' . Configure::read('core.version'),
        'global/scripts/metronic.js?' . Configure::read('core.version'),
        'admin/layout/scripts/layout.js?' . Configure::read('core.version'),
        'admin/layout/scripts/quick-sidebar.js?' . Configure::read('core.version'),
        'admin/layout/scripts/demo.js?' . Configure::read('core.version'),
        'admin/layout/scripts/moo.js?' . Configure::read('core.version'),
    ));
    $this->loadLibarary('mooAdmin');
    $this->loadLibrary(array('adm'));
    echo $this->fetch('config');
    echo $this->fetch('mooPhrase');
    echo $this->fetch('mooInit');
    echo $this->fetch('script');
    ?>
            <?php $this->MooPopup->html(); ?>
            <script>
                jQuery(document).ready(function () {
                    Metronic.init(); // init metronic core components
                    Layout.init(); // init current layout
                    QuickSidebar.init(); // init quick ajax_createsidebar
                    Demo.init(); // init demo features
                    //TableManaged.init();
                    moo.init();
                });
            </script>
            <?php echo $this->element('sql_dump'); ?>
        </body>
        <?php } else { ?>
        <body class="login">
            <div class="logo">
                <a href="<?php echo $this->request->base ?>/" alt="logo" class="logo-default hide">
                    <img src="<?php echo $this->Moo->logo(); ?>"
                         alt="<?php echo Configure::read('core.site_name'); ?> Admin">
    <?php echo Configure::read('core.site_name'); ?> <span class="slogan"> Admin</span>
                </a>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
        <?php echo $this->element('right_column'); ?>
    <?php echo $this->element('left_column'); ?>
                    </div>
                </div>
            </div>
        </body>
<?php } ?>

</html>