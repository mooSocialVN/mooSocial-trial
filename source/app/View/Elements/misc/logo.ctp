<div class="logo-default">
<?php
    $logo = Configure::read('core.logo');
    if ( !empty( $logo ) ):
?>
	<a class="logo-default-link" href="<?php echo $this->request->base ?>/home">
		<?php if (!$isThemeDarkMode):?>
        	<img class="logo-default-img" src="<?php echo $this->Moo->logo(); ?>" alt="<?php echo Configure::read('core.site_name'); ?>">
        <?php else:?>
        	<img class="logo-default-img" src="<?php echo $this->Moo->logoDark(); ?>" alt="<?php echo Configure::read('core.site_name'); ?>">
        <?php endif;?>
    </a>
<?php else: ?>
	<a class="logo-default-link" href="<?php echo $this->request->base?>/home">
        <span class="logo-default-text"><?php echo Configure::read('core.site_name'); ?></span>
    </a>
<?php endif; ?>
</div>