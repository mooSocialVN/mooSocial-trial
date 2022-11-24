<?php if(empty($settings) || Configure::read('core.disable_registration') != 1): ?>
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
<div class="page-single">
    <div class="user_register_holder">
        <div class="row">
            <?php if($this->getPageId() == 'page_guest_home-index'): ?>
                <div class="col-xs-12 col-md-7">
                    <div class="user_register_intro">
                        <div class="signup_intro"><?php echo __('The social network<br/> for people with <br/><span>Shared Interests.</span>') ?></div>
                        <div class="signup_more">
                            <?php echo __('People are having fun and making new friends every day.<br/>You can too!') ?>
                        </div>
                        <?php echo $this->element('user/newsignup') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( ( empty($uid)) ): ?>
                <div class="col-xs-12 <?php if($this->getPageId() == 'page_guest_home-index'): ?>col-md-5<?php else: ?>col-md-6 col-md-offset-3<?php endif; ?>  ">
                    <?php if (Configure::read('core.disable_registration')): ?>
                        <div id="flashMessage" class="alert alert-danger error-message"><?php echo __('The admin has disabled registration on this site'); ?></div>
                    <?php else: ?>
                        <div id="signUpForm" class="user_register_form close-network-signup">
                            <?php $this->getEventManager()->dispatch(new CakeEvent('View.SocialEnable', $this)); ?>
                            <div class="register_main_form">
                                <div class="form-register-title"><?php echo __('Register Now!')?> </div>
                                <div class="create_form">
                                    <form id="regForm" class="form-register">
                                        <div class="form-content">
                                            <div id="regFields" class="form-group">
                                                <?php if ( Configure::read('core.enable_registration_code') ): ?>
                                                    <div class="form-group required">
                                                        <label class="control-label" for="name">
                                                            <?php echo __('Registration Code')?> (<a href="javascript:void(0)" class="tip" title="<?php echo __('A registration code is required in order to register on this site')?>">?</a>)
                                                        </label>
                                                        <?php echo $this->Form->text('registration_code',array('class'=>'form-control', 'placeholder' => __('Registration Code'))) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="form-group required">
                                                    <label class="control-label" for="name"><?php echo __('Full Name') ?></label>
                                                    <?php echo $this->Form->text('name',array('class'=>'form-control','placeholder' => __('Full Name'))) ?>
                                                </div>

                                                <div class="form-group required">
                                                    <label class="control-label" for="email"><?php echo __('Email Address') ?></label>
                                                    <?php echo $this->Form->text('email',array('class'=>'form-control','placeholder' => __('Email Address'))) ?>
                                                </div>
                                                <div class="form-group required">
                                                    <label class="control-label" for="password"><?php echo __('Password') ?></label>
                                                    <?php echo $this->Form->password('password',array('class'=>'form-control','placeholder' => __('Password'))) ?>
                                                </div>
                                                <div class="form-group required">
                                                    <label class="control-label" for="password2"><?php echo __('Verify Password') ?></label>
                                                    <?php echo $this->Form->password('password2',array('class'=>'form-control','placeholder'=>__('Verify Password'))) ?>
                                                </div>
                                                <?php if (Configure::read('core.show_username_signup')): ?>
                                                    <div class="form-group">
                                                        <?php echo $this->Form->text('username',array('class'=>'form-control','placeholder'=>__('Profile address'))) ?>
                                                        <div class="help-block">
                                                            <?php
                                                            $ssl_mode = Configure::read('core.ssl_mode');
                                                            $http = (!empty($ssl_mode)) ? 'https' :  'http';
                                                            ?>
                                                            <?php echo $http.'://'.$_SERVER['SERVER_NAME'].$this->base;?>/<span id="profile_user_name"></span>
                                                        </div>
                                                    </div>
                                                <?php endif;?>
                                            </div>

                                            <div id="captcha" class="form-group" style="display: none">
                                                <?php if ( !empty( $challenge ) ): ?>
                                                    <div class="form-group">
                                                        <label class="control-label is_show" for="spam_challenge"><?php echo __('To avoid spam, please answer the following question')?>:</label>
                                                        <span class="help-block-label"><?php echo $challenge['SpamChallenge']['question']?></span>
                                                        <?php echo $this->Form->text('spam_challenge', array('class'=>'form-control'));?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                if ( $this->Moo->isRecaptchaEnabled()): ?>
                                                    <div class="captcha_box form-group">
                                                        <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                                        <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey()?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                                                    </div>
                                                <?php endif; ?>

                                                <div id="step2Box" class="regSubmit">
                                                    <input id="step2Submit" class="btn btn-primary btn-block btn-step2Submit" type="button" value="<?php echo __('Sign Up')?>">
                                                </div>
                                            </div>

                                            <div class="form-group regSubmit" id="step1Box">
                                                <input id="submitFormsignup" class="btn btn-primary btn-block btn-stepContinue" type="button" value="<?php echo __('Continue')?>">
                                            </div>
                                        </div>
                                        <div class="form-alert">
                                            <div id="regError" class="alert alert-danger" style="display: none;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if($this->Moo->socialIntegrationEnable('facebook') || $this->Moo->socialIntegrationEnable('google') || Configure::read('social.social_enable')): ?>
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
                                                <a href="<?php echo  $this->Html->url(array('plugin' => 'social_integration', 'controller' => 'auths', 'action' => 'login', 'provider' => 'google')) ?>">
                                                    <div class="social-overlay-button">
                                                        <span class="social-icon social-google"></span>
                                                        <span class="social-text"><?php echo  __('Google') ?></span>
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
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php endif; ?>