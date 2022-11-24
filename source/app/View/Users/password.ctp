<?php echo  $this->Session->flash(); ?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<?php echo $this->element('profilenav', array("cmenu" => "password"));?>
<?php $this->end(); ?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Change Password')?></h1>
            </div>
        </div>
        <div class="box_content profile-info-edit">
            <div class="create_form">
                <form class="form-horizontal" action="<?php echo $this->request->base?>/users/password" method="post">
                    <div class="form-group">
                        <div class="col-xs-12"><?php echo __('To change your password, please enter your current password to for verification')?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Current Password')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->password('old_password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('New Password')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->password('password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Verify Password')?></label>
                        <div class="col-md-9">
                            <?php echo $this->Form->password('password2', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input class="btn btn-primary" type="submit" value="<?php echo __('Change Password')?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>