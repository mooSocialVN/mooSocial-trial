<?php

if(empty($settings) || Configure::read('core.disable_registration') != 1): ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($, mooUser) {
        mooUser.initOnCloseNetworkSignup(<?php echo $this->Moo->isRecaptchaEnabled() ? $this->Moo->isRecaptchaEnabled() : '0' ?>);
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnCloseNetworkSignup(<?php echo $this->Moo->isRecaptchaEnabled() ? $this->Moo->isRecaptchaEnabled() : '0' ?>);
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

    <style>
        input.button:disabled {color: transparent;}
    </style>
    <?php
    if ( ( empty($uid)) ):

        ?>
        <div class="bar-content">
            <div id="signUpForm" class="row">
                <div >
                    <div class="register_main_form">
                        <div class="box51">

                            <form id="regForm" class="form-horizontal" >
                                <h1 class="page-header"><?php echo __('Join')?> <?php echo Configure::read('core.site_name')?></h1>
                                <div class="list1" id="regFields">
                                    <?php if ( Configure::read('core.enable_registration_code') ): ?>
                                        <div class="form-group required">
                                            <label class="col-md-3 control-label" for="name">
                                                <?php echo __('Registration Code')?> (<a href="javascript:void(0)" class="tip" title="<?php echo __('A registration code is required in order to register on this site')?>">?</a>)
                                            </label>
                                            <div class="col-md-9">
                                                <?php echo $this->Form->text('registration_code',array('class'=>'form-control')) ?>

                                            </div>
                                        </div>

                                    <?php endif; ?>
                                    <div class="form-group required">
                                        <label class="col-md-3 control-label" for="full-name">
                                            <?php echo __('Full Name')?>
                                        </label>
                                        <div class="col-md-9">
                                            <?php echo $this->Form->text('name',array('class'=>'form-control')) ?>
                                        </div>
                                    </div>

                                    <div class="form-group required">
                                        <label class="col-md-3 control-label" for="email">
                                            <?php echo __('Email Address')?>
                                        </label>
                                        <div class="col-md-9">
                                            <?php echo $this->Form->text('email',array('class'=>'form-control')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-md-3 control-label" for="password">
                                            <?php echo __('Password')?>
                                        </label>
                                        <div class="col-md-9">
                                            <?php echo $this->Form->password('password',array('class'=>'form-control')) ?>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <label class="col-md-3 control-label" for="verify-password">
                                            <?php echo __('Verify Password')?>
                                        </label>
                                        <div class="col-md-9">
                                            <?php echo $this->Form->password('password2',array('class'=>'form-control')) ?>
                                        </div>
                                    </div>

                                </div>

                                <div id="captcha" style="display:none">
                                    <div class="col-md-3">&nbsp;</div>
                                    <div class="col-md-9">
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
                                    </div>
                                    <div class="clear"></div>
                                    <div class="regSubmit" id="step2Box" class="regSubmit">
                                        <input type="button" value="<?php echo __('Sign Up')?>" id="step2Submit" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="form-group regSubmit" id="step1Box">
                                    <label class="col-md-3 control-label">&nbsp;</label>
                                    <div class="col-md-9">
                                        <input type="button" value="<?php echo __('Continue')?>" id="submitFormsignup" class="btn btn-success">

                                    </div>

                                </div>

                            </form>
                            <div id="regError" class="alert alert-danger" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="register_fb">
                    <?php if(Configure::read('core.fb_integration') == 1 || Configure::read('core.google_integration') == 1): ?>
                        <div class="register_social_form">
                            <div class="center-login-text text-center">
                                <span><?php echo  __('Or Register using')?></span>
                            </div>
                            <?php $fb_app_id = Configure::read('core.fb_app_id');
                                if ( Configure::read('core.fb_integration') && !empty($fb_app_id) ): ?>
                                <div style="float:right" class="hide">
                                    <a href="<?php echo $this->request->base?>/users/fb_register" ><img src="<?php echo $this->request->webroot?>img/fb_register_button.png"></a>
                                </div>
                                <div class="fSignInWrapper">
                                   
                                    <div class="fb-login-button"> </div>
                                    <div class="overlay-button">
                                        <span class="icon"></span>
                                        <span class="buttonText"><a href="<?php echo  $this->Html->url(array('controller'=>'users','action'=>'fb_register')) ?>" style="color:white"><?php echo  __('Facebook') ?></a></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif;?>
                </div>
                </div>

                
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>