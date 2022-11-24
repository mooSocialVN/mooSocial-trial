<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <?php echo $this->Html->charset(); ?>
        <title>
        <?php echo __('Offline Mode')?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <?php echo $this->addBodyFont('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap'); ?>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined">

        <!--
        ===========STYLE====================-->
        <?php
        echo $this->Html->meta('icon');
        $this->loadLibarary('mooCore');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        if(!empty($site_rtl)){
            echo $this->Html->css('rtl');
        }
        echo $this->Minify->render();
        ?>
        <!--
        ===========END STYLE====================-->
    </head>
    <?php $bodyClass = ($this->isThemeDarkMode()) ? 'body-dark '.$this->getBodyClass():$this->getBodyClass(); ?>
    <body class="default-body body-site-offline <?php echo $bodyClass; ?>" id="<?php echo $this->getPageId(); ?>">

    <div id="header" class="header-section header-fixed-top">
        <div class="header-inner-top">
            <div class="header-bg"></div>
            <div class="container">
                <div class="header-inner-main">
                    <?php echo $this->element('misc/logo'); ?>

                    <?php if (empty($cuser)): ?>
                        <div class="login_acc_content">
                            <div class="login-popup-group">
                                <a class="dropdown-popup-toggle" href="javascript:void(0);">
                            <span class="dropdown-user-avatar">
                                <img class="login-no-img" src="<?php echo $this->request->webroot ?>user/img/noimage/Male-user-sm.png" alt="">
                            </span>
                                    <span class="dropdown-user-arrow material-icons moo-icon moo-icon-expand_more">expand_more</span>
                                </a>
                                <div class="dropdown-popup-main">
                                    <div class="popup-login-form">
                                        <div class="popup-login-title"><?php echo __('Login Now') ?></div>
                                        <?php echo $this->element('signin_offline') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooResponsive'),'object'=>array('$','mooResponsive'))); ?>
                        mooResponsive.initLoginPopup();
                        <?php $this->Html->scriptEnd(); ?>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery'),'object'=>array('$'))); ?>
        var flag_menuAccount = false;
        $('#menuAccount').find('.badge_counter').each(function(){
        if( parseInt( $(this).text() ) ){
        flag_menuAccount = true;
        }
        });
        if(flag_menuAccount){
        $('#menuAccount').addClass('hasPoint');
        }
        <?php $this->Html->scriptEnd(); ?>
    </div>

    <div class="content-wrapper" id="content-wrapper" <?php $this->getNgController() ?>>
        <?php echo html_entity_decode( Configure::read('core.header_code') )?>
        <div class="container">
            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <div class="bar-content">
                    <div class="box2 bar-content-warp">
                        <div class="box_content">
                            <h1 class="site-offline-header"><?php echo __('Sorry, our site is temporarily down for maintenance. Please check back again soon.')?></h1>
                            <div class="post_body">
                                <div class="post_content">
                                    <?php echo nl2br($offline_message)?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--
    ===========SCRIPT====================-->
    <?php
    echo $this->fetch('config');
    echo $this->fetch('mooPhrase');
    echo $this->fetch('mooScript');
    echo $this->fetch('script');
    ?>
    <!--
    ===========END SCRIPT================-->
    </body>
</html>
<?php die(); ?>