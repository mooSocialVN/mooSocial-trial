<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initOnUserProfile();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserProfile();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
    <?php echo $this->element('profilenav', array("cmenu" => "profile"));?>
<?php $this->end(); ?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Profile Information')?></h1>
                <div class="box_action">
                    <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/users/view/<?php echo $uid?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-library_books">library_books</span>
                            <span class="btn-text"><?php echo __('View Profile')?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="box_content profile-info-edit">
            <div class="create_form">
                <form id="form_edit_user" class="form-horizontal" action="<?php echo $this->request->base?>/users/profile" method="post">
                    <?php echo $this->element('ajax/profile_edit');?>

                    <?php if ( !$cuser['Role']['is_super'] && !$cuser['Role']['is_admin'] ): ?>
                    <div class="profile-edit-form-bottom">
                        <div class="pefb-item">
                            <a href="javascript:void(0)" class="deactiveMyAccount"><?php echo __('Deactivate my account')?></a>
                        </div>
						<?php if(!$cuser['lock_delete'] && !Configure::read('core.hide_delete_account')):?>
							<div class="pefb-item">
								<a href="javascript:void(0)" class="deleteMyAccount"><?php echo __('Delete my account')?></a>
							</div>
						<?php endif;?>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>