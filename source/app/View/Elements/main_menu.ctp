<div id="mainMenuSection" class="main-menu-section main-menu-scrolling">
    <div id="mainMenuMobileToggle" class="main-menu-toggle">
        <span class="main-menu-mobile-icon material-icons moo-icon moo-icon-menu">menu</span>
        <span class="main-menu-toggle-icon menu-item-home material-icons moo-icon moo-icon-menu">menu</span>
        <span class="main-menu-toggle-text"><?php echo __('Menu') ?></span>
    </div>
    <div class="main-menu-warp">
        <div id="mainMenuOverview" class="main-menu-overview"></div>
        <div id="mainMenuClose" class="main-menu-close"><span class="main-menu-close-icon material-icons moo-icon moo-icon-cancel">cancel</span></div>
        <div class="main-menu-content">
            <div class="mobile-logo">
                <?php echo $this->element('misc/logo'); ?>
            </div>
            <?php echo $this->Menu->generate('main-menu', null, array('class' => 'main-menu', 'id' => 'main_menu'), true); ?>
        </div>
    </div>
</div>