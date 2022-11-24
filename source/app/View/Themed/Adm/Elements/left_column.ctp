<div id="left" <?php //if ( isset( $this->request->params['admin'] ) || !empty($no_right_column) ) echo 'style="margin-right:0"' ?> >
	<?php echo $this->Session->flash(); ?>
	<?php
    if ( empty($uid) && !Configure::read('core.disable_registration') && !in_array( $this->request->params['action'], array( 'register', 'fb_register', 'recover', 'resetpass' ) ) ):
		if ( Configure::read('core.force_login') ):
			echo $this->element('registration');
		else: 
    ?>
    <div class="box1 guest_msg panel panel-default">
        <div class="panel-body">
            <?php $fb_app_id = Configure::read('core.fb_app_id');
                if ( Configure::read('core.fb_integration') && !empty($fb_app_id) ): ?>
            <div style="float:right">
                <a href="<?php echo $this->request->base?>/users/fb_register"><img src="<?php echo $this->request->webroot?>img/fb_register_button.png"></a>
            </div>
            <?php endif; ?>
            <h1><?php echo __('Welcome to')?> <?php echo Configure::read('core.site_name')?></h1>

            <a href="<?php echo $this->request->base?>/users/register" class="btn btn-success" id="join_now"><?php echo __('Join Now!')?></a>

            <?php $registration_message = Configure::read('core.registration_message');
                if ( !empty($registration_message) ): ?>
            <p><?php echo nl2br(Configure::read('core.registration_message'))?></p>
            <?php else: ?>
            <p><?php echo __('Be part of the community and join us today!')?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php 
		endif;
    endif; 
    ?>
    <div class="row">
	    <?php echo $this->fetch('content'); ?>
    </div>
</div>