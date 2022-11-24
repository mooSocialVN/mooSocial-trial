<?php if(empty($settings) || $settings['disable_registration'] != 1): ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooUser'), 'object' => array('$', 'mooUser'))); ?>
    mooUser.initOnRegistration();
    <?php $this->Html->scriptEnd(); ?>

    <?php if ( ( empty($uid)) ): ?>
    <div class="section-page registration-page">
        <?php $this->getEventManager()->dispatch(new CakeEvent('View.SocialEnable', $this)); ?>
        <div id="signUpForm" class="user_register_form <?php if(!$this->Moo->socialIntegrationEnable('facebook') && !$this->Moo->socialIntegrationEnable('google') && !Configure::read('social.social_enable')): ?>no-social<?php endif; ?>">
            <div class="row">
                <div class="col-xs-12 <?php if($this->Moo->socialIntegrationEnable('facebook') || $this->Moo->socialIntegrationEnable('google') || Configure::read('social.social_enable')): ?>col-md-8<?php else: ?>col-md-12<?php endif; ?>">
                    <div class="register_main_form">
                        <h1 class="section-page-header register-page-header"><?php echo __('Join')?> <?php echo Configure::read('core.site_name')?></h1>
                        <div class="create_form">
                            <form id="regForm" class="form-register">
                                <div class="form-content">
                                    <div id="regFields" class="form-group">
                                        <?php if ( Configure::read('core.enable_registration_code') ): ?>
                                            <div class="form-group required">
                                                <label for="name">
                                                    <?php echo __('Registration Code')?> (<a href="javascript:void(0)" class="tip" title="<?php echo __('A registration code is required in order to register on this site')?>">?</a>)
                                                </label>
                                                <?php echo $this->Form->text('registration_code',array('class'=>'form-control')) ?>
                                            </div>

                                        <?php endif; ?>
                                        <div class="form-group required">
                                            <label for="full-name">
                                                <?php echo __('Full Name')?>
                                            </label>
                                            <?php echo $this->Form->text('name',array('class'=>'form-control')) ?>
                                        </div>

                                        <div class="form-group required">
                                            <label for="email">
                                                <?php echo __('Email Address')?>
                                            </label>
                                            <?php echo $this->Form->text('email',array('class'=>'form-control')) ?>
                                        </div>
                                        <div class="form-group required">
                                            <label for="password">
                                                <?php echo __('Password')?>
                                            </label>
                                            <?php echo $this->Form->password('password',array('class'=>'form-control')) ?>
                                        </div>
                                        <div class="form-group required">
                                            <label for="verify-password">
                                                <?php echo __('Verify Password')?>
                                            </label>
                                            <?php echo $this->Form->password('password2',array('class'=>'form-control')) ?>
                                        </div>
                                        <?php if (Configure::read('core.show_username_signup')): ?>
                                            <div class="form-group">
                                                <label for="verify-password">
                                                    <?php echo __('Profile address')?>
                                                </label>
                                                <?php echo $this->Form->text('username',array('class'=>'form-control')) ?>
                                                <span class="help-block">
                                            <?php
                                            $ssl_mode = Configure::read('core.ssl_mode');
                                            $http = (!empty($ssl_mode)) ? 'https' :  'http';
                                            ?>
                                                    <?php echo $http.'://'.$_SERVER['SERVER_NAME'].$this->base;?>/<span id="profile_user_name"></span>
                                        </span>
                                            </div>
                                        <?php endif;?>

                                    </div>
                                    <div id="captcha" class="form-group" style="display:none;">
                                        <?php if ( !empty( $challenge ) ): ?>
                                        <div class="form-group">
                                            <label for="spam_challenge"><?php echo __('To avoid spam, please answer the following question')?>:</label>
                                            <span class="help-block-label"><?php echo $challenge['SpamChallenge']['question']?></span>
                                            <?php echo $this->Form->text('spam_challenge', array('class'=>'form-control'));?>
                                        </div>
                                        <?php endif; ?>

                                        <?php $recaptcha_publickey = Configure::read('core.recaptcha_publickey');
                                        if ( $this->Moo->isRecaptchaEnabled()): ?>
                                        <div class="form-group">
                                            <div class="captcha_box">
                                                <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                                <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_publickey?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <div class="form-group regSubmit" id="step2Box">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-4 col-md-offset-4">
                                                    <input id="step2Submit" class="btn btn-primary btn-block" type="button" value="<?php echo __('Sign Up')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group regSubmit" id="step1Box">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 col-md-offset-4">
                                                <input id="submitFormsignup" class="btn btn-primary btn-block" type="button" value="<?php echo __('Continue')?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-alert">
                                    <div id="regError" class="alert alert-danger" style="display: none;"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php if($this->Moo->socialIntegrationEnable('facebook') || $this->Moo->socialIntegrationEnable('google') || Configure::read('social.social_enable')): ?>
                    <div class="col-xs-12 col-md-4">
                        <div class="register_social_form">
                            <div class="center-login-text">
                                <span><?php echo  __('Or Register using')?></span>
                            </div>
                            <div class="center-login-social">
                                <?php if ($this->Moo->socialIntegrationEnable('facebook')): ?>
                                    <div id="fSignInWrapper" class="social-group social-fSignIn">
                                        <a href="<?php echo  $this->Html->url(array('plugin' => 'social_integration', 'controller' => 'auths', 'action' => 'login', 'provider' => 'facebook')) ?>">
                                            <div class="social-overlay-button">
                                                <span class="social-icon social-facebook"></span>
                                                <span class="social-text"><?php echo  __('Facebook') ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->Moo->socialIntegrationEnable('google')): ?>
                                    <div id="gSignInWrapper" class="social-group social-gSignIn">
                                        <a href="<?php echo $this->Html->url(array('plugin' => 'social_integration', 'controller' => 'auths', 'action' => 'login', 'provider' => 'google')) ?>">
                                            <div class="social-overlay-button">
                                                <span class="social-icon social-google"></span>
                                                <span class="social-text"><?php echo __('Google') ?></span>
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php
                                if(Configure::read('social.social_enable')){
                                    $this->getEventManager()->dispatch(new CakeEvent('View.SocialLogin.Elements', $this));
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>