<div class="bar-content resetpass">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Reset Password')?></h1>
            </div>
        </div>
        <div class="box_content profile-info-edit">
            <div class="create_form ">
                <form class="form-horizontal" action="<?php echo $this->request->base?>/users/resetpass" method="post">
                    <?php echo $this->Form->hidden('code', array('value' => $code)); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('New Password')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->password('password', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Verify Password')?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->password('password2', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="create-form-actions">
                                <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
                            </div>
                            <div class="alert alert-danger error-message" id="errorMessage" style="display: none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>