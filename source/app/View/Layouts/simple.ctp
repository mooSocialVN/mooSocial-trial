<!DOCTYPE html>
<html ng-app="mooApp">
<head>
    <meta charset="utf-8">
    <title>
        <?php if ( Configure::read('core.site_offline') ) echo __('[OFFLINE]'); ?>

        <?php if (isset($title_for_layout) && $title_for_layout){ echo $title_for_layout; } else if(isset($mooPageTitle) && $mooPageTitle) { echo $mooPageTitle; } ?> | <?php echo Configure::read('core.site_name'); ?>
    </title>
    <?php echo  $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:400,300,500,700'); ?>
    <?php
        echo $this->Html->meta('icon');
        $this->loadLibarary('mooCore');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->Minify->render();
    ?>
</head>
<?php
    if (empty($uid)){
        $this->setBodyClass('guest-page');
    }
    $bodyClass = ($this->isThemeDarkMode()) ? 'body-dark '.$this->getBodyClass():$this->getBodyClass();
?>
<body class="simple <?php echo $bodyClass; ?>" id="<?php echo $this->getPageId(); ?>">
<?php 
	echo $this->fetch('content'); 
?>
<!-- GET NOTIFICATION -->
<?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooNotification'),'object'=>array('$','mooNotification'))); ?>
	mooNotification.setActive(false);
<?php $this->Html->scriptEnd(); ?>
<?php
	echo $this->fetch('config');
	echo $this->fetch('mooPhrase');
	echo $this->fetch('mooScript');
	echo $this->fetch('script');
?>
</body>
</html>