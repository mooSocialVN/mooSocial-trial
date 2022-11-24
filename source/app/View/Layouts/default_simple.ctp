<?php
/**
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 */
?>
<!DOCTYPE html>
<html<?php if(!empty($site_rtl)): ?> dir="rtl"<?php endif;?>>
    <head>
        <meta charset="utf-8">
        <title>
            <?php if (Configure::read('core.site_offline')) echo __('[OFFLINE]'); ?>

            <?php
            if (isset($title_for_layout) && $title_for_layout) {
                echo $title_for_layout;
            } else if (isset($mooPageTitle) && $mooPageTitle) {
                echo $mooPageTitle;
            }
            ?> | <?php echo Configure::read('core.site_name'); ?>
        </title>
        <meta name="description" content="<?php
        if (isset($description_for_layout) && $description_for_layout) {
            echo $description_for_layout;
        } else if (isset($mooPageDescription) && $mooPageDescription) {
            echo $mooPageDescription;
        } else if (Configure::read('core.site_description')) {
            echo Configure::read('core.site_description');
        }
        ?>"/>
        <meta name="keywords" content="<?php
        if (isset($mooPageKeyword) && $mooPageKeyword) {
            echo $mooPageKeyword;
        } else if (Configure::read('core.site_keywords')) {
            echo Configure::read('core.site_keywords');
        }
        ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <meta property="og:url" content="<?php echo $this->Html->url(null, true); ?>" />
        <link rel="canonical" href="<?php echo $this->Html->url(null, true); ?>" /> 
<?php if (isset($og_image)): ?>
            <meta property="og:image" content="<?php echo $og_image ?>" />
<?php else: ?>
            <meta property="og:image" content="<?php echo FULL_BASE_URL . $this->request->webroot ?>img/og-image.png" />
<?php endif; ?>

        <?php echo $this->addBodyFont('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap'); ?>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined">
<?php
echo $this->Html->meta('icon');
$this->loadLibarary('mooCore');
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->Minify->render();
echo $this->fetch('css_after_minify');
?>
    </head>
    <?php
        if (empty($uid)){
            $this->setBodyClass('guest-page');
        }
        $bodyClass = ($this->isThemeDarkMode()) ? 'body-dark '.$this->getBodyClass():$this->getBodyClass();
    ?>
    <body class="page_simple <?php echo $bodyClass; ?>" id="<?php echo $this->getPageId(); ?>">
        <div class="container " id="content-wrapper" <?php $this->getNgController() ?>>
            <?php echo html_entity_decode(Configure::read('core.header_code')) ?>
            <?php echo $this->fetch('content'); ?>
        </div>
        <?php
        echo $this->fetch('config');
        echo $this->fetch('mooPhrase');
        echo $this->fetch('mooScript');
        echo $this->fetch('script');
        ?>
<?php echo html_entity_decode(Configure::read('core.analytics_code')) ?>
    </body>
</html>