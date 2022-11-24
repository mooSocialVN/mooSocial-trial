<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('User Menu')?></h3>
        </div>
    </div>
    <div class="box_content box_menu profile-info-edit">
        <ul class="menu-list">
            <li class="menu-list-item <?php if ($cmenu == 'profile') echo 'current'; ?>">
                <a class="menu-list-link" href="<?php echo $this->request->base?>/users/profile">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-description">description</span>
                    <span class="menu-list-text"><?php echo __('Profile Information')?></span>
                </a>
            </li>

            <li class="menu-list-item <?php if ($cmenu == 'notification_settings') echo 'current'; ?>">
                <a class="menu-list-link" href="<?php echo $this->request->base?>/users/notification_settings">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-settings">settings</span>
                    <span class="menu-list-text"><?php echo __('Notification Settings')?></span>
                </a>
            </li>

            <li class="menu-list-item <?php if ($cmenu == 'password') echo 'current'; ?>">
                <a class="menu-list-link" href="<?php echo $this->request->base?>/users/password">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-lock">lock</span>
                    <span class="menu-list-text"><?php echo __('Change Password')?></span>
                </a>
            </li>

            <li class="menu-list-item <?php if ($cmenu == 'email_settings') echo 'current'; ?>">
                <a class="menu-list-link" href="<?php echo $this->request->base?>/users/email_settings">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-email">email</span>
                    <span class="menu-list-text"><?php echo __('Email notification settings')?></span>
                </a>
            </li>

            <?php
                $helperSubscription = MooCore::getInstance()->getHelper('Subscription_Subscription');
                if ($helperSubscription->checkEnableSubscription() && $cuser['Role']['is_super'] != 1):
            ?>

            <li class="menu-list-item <?php if ($cmenu == 'upgrade_membership') echo 'current'; ?>">
                <?php echo $this->Html->link('<span class="menu-list-icon material-icons moo-icon moo-icon-unarchive">unarchive</span><span class="menu-list-text">' . __('Subscription Management').'</span>', array('plugin' => 'subscription', 'controller' => 'subscribes', 'action' => 'upgrade'), array( 'class' => 'menu-list-link', 'escape' => false)) ?>
            </li>
            <?php endif;?>

            <?php
            if ( $this->elementExists('menu/profile') )
                echo $this->element('menu/profile');
            ?>

                    <!-- Should be hook for third party -->
                    <?php $this->getEventManager()->dispatch(new CakeEvent('Elements.profilenav', $this, array('cmenu' => $cmenu))); ?>
                    <!-- Should be hook for third party -->
            <?php if($this->isEnableDarkMode()): ?>
            <li class="menu-list-item <?php if ($cmenu == 'appearance') echo 'current'; ?>">
                <a class="menu-list-link" href="<?php echo $this->request->base?>/users/appearance">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-brightness_6">brightness_6</span>
                    <span class="menu-list-text"><?php echo __('Appearance')?></span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
