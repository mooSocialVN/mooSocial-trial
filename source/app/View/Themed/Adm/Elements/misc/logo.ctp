<!-- BEGIN LOGO -->
<div class="page-logo">

<?php $logo = Configure::read('core.logo');
    if (!empty($logo)): ?>

    <a style="display: inline; float: none" href="<?php echo  $this->request->base ?>/" alt="logo" class=""><img src="<?php echo $this->Moo->logo(); ?>"
                                                                    alt="<?php echo Configure::read('core.site_name'); ?>"></a>
<?php else: ?>
    <a href="<?php echo  $this->request->base ?>/" alt="logo" class="logo-default"><?php echo Configure::read('core.site_name'); ?>.<span class="slogan">admin</span></a>
<?php endif; ?>
    <div class="menu-toggler sidebar-toggler hide">
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
    </div>
</div>
<!-- END LOGO -->