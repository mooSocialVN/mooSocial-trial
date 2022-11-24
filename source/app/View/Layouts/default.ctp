<!DOCTYPE html>
<html<?php if(!empty($site_rtl)): ?> dir="rtl"<?php endif;?>>
<head>
    <meta charset="utf-8">
    <title>
        <?php if ( Configure::read('core.site_offline') ) echo __('[OFFLINE]'); ?>

        <?php if (isset($title_for_layout) && $title_for_layout){ echo $title_for_layout; } else if(isset($mooPageTitle) && $mooPageTitle) { echo $mooPageTitle; } ?> | <?php echo Configure::read('core.site_name'); ?>
    </title>
    
    <!--
    ===========META====================-->
    <?php $description = "";?>
    <?php if (isset($description_for_layout) && $description_for_layout){ $description = $description_for_layout; }else if(isset($mooPageDescription) && $mooPageDescription) {$description = $mooPageDescription;}else if(Configure::read('core.site_description')){ $description = Configure::read('core.site_description');}?>
    <meta name="description" content="<?php echo $this->Moo->convertDescriptionMeta($description);?>" />
    <meta name="keywords" content="<?php if(isset($mooPageKeyword) && $mooPageKeyword){echo $mooPageKeyword;}else if(Configure::read('core.site_keywords')){ echo Configure::read('core.site_keywords');}?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
     <meta name="robots" content="index,follow" />

    <meta property="og:site_name" content="<?php echo Configure::read('core.site_name'); ?>" />
    <meta property="og:title" content="<?php if (isset($title_for_layout) && $title_for_layout){ echo $title_for_layout; } else if(isset($mooPageTitle) && $mooPageTitle) { echo $mooPageTitle; } ?>" />
    <meta property="og:url" content="<?php echo $this->Html->url( null, true ); ?>" />
    <link rel="canonical" href="<?php echo $this->Html->url( null, true ); ?>" /> 
    <?php if(isset($og_image)): ?>
    <meta property="og:image" content="<?php echo $og_image?>" />
    <?php else: ?>
    <meta property="og:image" content="<?php echo $this->Moo->ogImage();?>" />
    <?php endif; ?>
    <!--
    ===========META====================-->

    <?php echo $this->addBodyFont('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap'); ?>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined">
    
    <!--
    ===========STYLE====================-->
    <?php
        echo $this->Html->meta('icon',$this->Moo->faviconImage());
        $this->loadLibarary('mooCore');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        if(!empty($site_rtl)){
            echo $this->Html->css('rtl');
        }
        echo $this->Minify->render();
        echo $this->fetch('css_after_minify');
    ?>
    <!--
    ===========END STYLE====================-->
    <?php
    
    ?>
</head>
<?php
    if (empty($uid)){
        $this->setBodyClass('guest-page');
    }
    $bodyClass = ($this->isThemeDarkMode()) ? 'body-dark '.$this->getBodyClass():$this->getBodyClass();
?>
<body class="default-body <?php echo $bodyClass; ?>" id="<?php echo $this->getPageId(); ?>">

<?php echo $this->element('misc/fb_include'); ?>
<?php echo $this->fetch('header'); ?>

<div id="header" class="header-section header-fixed-top">
    <?php echo $this->element('header'); ?>
</div>

<div class="content-wrapper" id="content-wrapper" <?php $this->getNgController() ?>>
    <?php echo html_entity_decode( Configure::read('core.header_code') )?>
    <div class="container page-container">
        <?php
            /*$flash_mess = $this->Session->flash();echo $flash_mess;if(empty($flash_mess)){echo $this->Session->flash('confirm_remind');}*/
            $this->setFlashMessage();
            echo $this->getFlashMessage();
        ?>
        <?php echo $this->fetch('content'); ?>
    </div>
</div>
<?php echo $this->fetch('footer'); ?>
<?php echo $this->element('footer_mobi'); ?>
<?php echo $this->element('misc/cookies'); ?>

<!-- Modal -->
<?php $this->MooPopup->html(); ?>
<section class="modal fade" id="langModal" role="basic" tabindex='-1' aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</section>
<section class="modal fade <?php if (in_array('photo_view', $uacos)) echo 'modal-fullscreen force-fullscreen'?>" tabindex='-1' id="photoModal" role="basic" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</section>

<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <!-- Config -->
                <button type="button" class="btn btn-modal_save ok"><?php echo __('OK')?></button>
                <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close')?></button>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="plan-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal_close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-modal_save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div id="shareFeedModal" data-backdrop="static" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Share') ?></h4>
            </div>
            <div class="modal-body">
                <script>

                    function ResizeIframe(id){
                        var frame = document.getElementById(id);
                        frame.height = frame.contentWindow.document.body.scrollHeight  + "px";
                    }

                </script>
                <iframe id="iframeShare" onload="ResizeIframe('iframeShare')" src="" width="99.6%" height="" frameborder="0"></iframe>
            </div>

        </div>
    </div>
</div>

<!--
===========SCRIPT====================-->
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=<?php echo Configure::read('core.google_dev_key'); ?>"></script>
<?php
echo $this->fetch('config');
echo $this->fetch('mooPhrase');
echo $this->fetch('mooScript');
echo $this->fetch('script');
?>
<!--
===========END SCRIPT================-->
    
<?php echo $this->element('sql_dump'); ?>
<?php echo html_entity_decode( Configure::read('core.analytics_code') )?>
</body>
</html>