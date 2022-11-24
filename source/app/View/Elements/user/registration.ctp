<?php $this->Html->scriptStart(array('inline' => false)); ?>

jQuery(document).ready(function(){
	jQuery("#step1Submit").click(function(){
	    $('#step1Box').spin('small');

		jQuery('#step1Submit').attr('disabled', 'disabled');
		jQuery.post("<?php echo $this->request->base?>/users/ajax_signup_step1", jQuery("#regForm").serialize(), function(data){
			$('#step1Box').spin(false);
    
			if (data.indexOf('mooError') > 0) {
				jQuery("#regError").fadeIn();
				jQuery("#regError").html(data);
				jQuery('#step1Submit').removeAttr('disabled');
			} else {
				jQuery("#regError").fadeOut();
				jQuery("#regFields").append(data);
				jQuery("#captcha").fadeIn();
				jQuery('#step1Box').remove();
				jQuery(".tip").tipsy({ html: true, gravity: 's' });
				
				jQuery(".multi").multiSelect({
                    selectAll: false,
                    noneSelected: '',
                    oneOrMoreSelected: '<?php echo addslashes(__('% selected'))?>'
                });
			}
		});
	}); 
	
	jQuery("#step2Submit").click(function(){
	    $('#step2Box').spin('small');
		
		jQuery('#step2Submit').attr('disabled', 'disabled');
		jQuery.post("<?php echo $this->request->base?>/users/ajax_signup_step2", jQuery("#regForm").serialize(), function(data){
			$('#step2Box').spin(false);

			if (data != '') {
				jQuery("#regError").fadeIn();
				jQuery("#regError").html(data);
				jQuery('#step2Submit').removeAttr('disabled');
				
			} else {
				window.location = '<?php echo $this->request->base?>/';
			}
		});
	});
});
<?php $this->Html->scriptEnd(); ?>


<style>
input.button:disabled {color: transparent;}
</style>

<div class="box5">
	<?php $fb_app_id = Configure::read('core.fb_app_id');
        if ( Configure::read('core.fb_integration') && !empty($fb_app_id) ): ?>
	<div style="float:right">
		<a href="<?php echo $this->request->base?>/users/fb_register"><img src="<?php echo $this->request->webroot?>img/fb_register_button.png"></a>
	</div>
	<?php endif; ?>
	<form id="regForm">		
	<h1><?php echo __('Join')?> <?php echo Configure::read('core.site_name')?></h1>
	<ul class="list1" id="regFields">
		<?php if ( Configure::read('core.enable_registration_code') ): ?>
		<li><label><?php echo __('Registration Code')?> (<a href="javascript:void(0)" class="tip" title="<?php echo __('A registration code is required in order to register on this site')?>">?</a>)</label><?php echo $this->Form->text('registration_code') ?></li>
		<li>&nbsp;</li>
		<?php endif; ?>
		<li><label><?php echo __('Full Name')?></label><?php echo $this->Form->text('name') ?></li>
		<li><label><?php echo __('Email Address')?></label><?php echo $this->Form->text('email') ?></li>
		<li><label><?php echo __('Password')?></label><?php echo $this->Form->password('password') ?></li>
		<li><label><?php echo __('Verify Password')?></label><?php echo $this->Form->password('password2') ?></li>
	</ul>

    <div id="captcha" style="display:none">  
    	<?php if ( !empty( $challenge ) ): ?>
    	<div>
	        <p><?php echo __('To avoid spam, please answer the following question')?>:</p><?php echo $challenge['SpamChallenge']['question']?><br /><br />
	        <?php echo $this->Form->text('spam_challenge');?>
	    </div>
        <?php endif; ?>   
           
    	<?php 
            if ($this->Moo->isRecaptchaEnabled()): ?>
    	<div class="captcha_box">
    	    <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
            <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
    	</div>
    	<?php endif; ?>
    	
    	<div class="regSubmit" id="step2Box" class="regSubmit">
            <input type="button" value="<?php echo __('Sign Up')?>" id="step2Submit" class="button button-large button-action">
        </div>
    </div>
	
	<div class="regSubmit" id="step1Box">
		<input type="button" value="<?php echo __('Continue')?>" id="step1Submit" class="button button-large button-action">
	</div>
	</form>
	<div id="regError" class="alert alert-danger" style="display: none;"></div>
</div>