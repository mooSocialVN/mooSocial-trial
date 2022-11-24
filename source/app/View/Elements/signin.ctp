<?php if($this->Auth->user('id') === null): ?>
    <div class="login-form">
            <?php
            $form = $this->Form->create('User', array(
                'class' => 'form-login',
                'url'=>array('plugin' => false, 'controller'=>'users','action'=>'login')
            ));
            $this->Form->inputDefaults(array(
                'label' => false,
                'class' => 'form-control',
            ));
            $pararms = array('name'=>'data[redirect_url]');
            if (isset($redirect_url)){
                $pararms['value'] = $redirect_url;
            }

            $form .=$this->Form->hidden('redirect_url', $pararms);

            $form .=$this->Form->input('id');

        $form .= '<div class="main_login_form">';
            $form .= '<div class="login_form_input">';

            $form .=$this->Form->input('email', array(
                'label' => array(
                    'text' => __('Email'),
                    "class" => "label-control"
                ),
                'id' => 'login_email',
                'placeholder' => __('Email'),
                //'name'=>"data[email]",
                'class'=>'form-control',
                'div' => array("class" => 'form-group login_form_email'),
                //'before' => '',
                //'between' => '<div class="">',
                //'after' => '</div>'
            ));

            $form .=$this->Form->input('password', array(
                'label' => array(
                    'text' => __('Password'),
                    "class" => "label-control"
                ),
                'id' => 'login_password',
                'placeholder' => __('Password'),
                //'name' => 'data[password]',
                'class' => 'form-control',
                'div' => array("class" => 'form-group login_form_pass'),
                'required' => false
            ));

            ?>
                <?php echo $form; ?>
                <div class="login_form_clink">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6 login-form-remember">
                                <label class="checkbox-control">
                                    <input type="hidden" value="0" id="remember_" name="data[remember]">
                                    <input type="checkbox" id="remember" value="1" checked="checked" name="data[remember]"> <?php echo __('Remember me')?>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-xs-6 login-form-forgot">
                                <a href="<?php echo $this->request->base ;?>/users/recover"><?php echo __('Forgot password?')?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo '</div>' ?>

            <div class="login_form_submit">
            <?php
                echo $this->Form->submit(__('Login'), array(
                    'class'=>'btn btn-primary btn-block btn-login',
                    'value' => __('Sign in'),
                    'div'=>false
                ));
            ?>
            </div>
            <?php echo '</div>' ?>
            <?php echo '</form>' ?>
        <?php echo $this->Form->end(); ?>

        <?php $this->getEventManager()->dispatch(new CakeEvent('View.SocialEnable', $this)); ?>
        <?php if($this->Moo->socialIntegrationEnable('facebook') || $this->Moo->socialIntegrationEnable('google') || Configure::read('social.social_enable')): ?>
        <div class="register_social_form">
            <div class="center-login-text">
                <span><?php echo  __('Or Using')?></span>
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
        <?php endif; ?>
        <?php if(Configure::read('core.disable_registration') != 1): ?>
        <div class="register_account_form">
            <?php echo __('Don’t have an account.') ?>
            <br>
            <a href="<?php echo $this->request->base . '/users/register' ?>"><?php echo __('Sign Up') ?></a> <?php echo __('Now!') ?>
        </div>
        <?php endif; ?>
    </div>
    <?php echo $this->Html->script(array(
            'global/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js?'. Configure::read('core.version'),
        ), array('inline'=>false));
    ?>
<?php endif; ?>