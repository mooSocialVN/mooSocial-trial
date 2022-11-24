<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="bar-content ">
    <div class="profile-info-menu">
        <?php echo $this->element('profilenav', array("cmenu" => "upgrade_membership"));?>
    </div>
</div>
<?php $this->end(); ?>
<div class="bar-content full_content p_m_10">
    <div class="content_center profile-info-edit subscription_upgrade">
		<h1><?php echo __('Subscription Management') ?></h1>
        <?php echo $this->element('Subscription.upgrade');?>
    </div>
</div>
