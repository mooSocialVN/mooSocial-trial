<?php

if (isset($title_enable) && ($title_enable) === "") $title_enable = false; else $title_enable = true;
?>

<?php if (!$this->Moo->loggedIn()): ?>
    <div class="box2">
        <?php if ($title_enable): ?>
            <h3><?php echo  __('Login') ?></h3>
        <?php endif; ?>
        <div class="box_content box_login">
            <?php
            echo $this->Form->create("User", array(
                    'class' => 'form-horizontal',
                    'url' => array('controller' => 'users', 'action' => 'login')
                )
            );
            $this->Form->inputDefaults(array(
                    'label' => false,
                    //'div' => array("class" => 'form-group'),
                    'class' => 'form-control',

                )
            );
            echo $this->Form->input('id');
            echo $this->Form->input('text', array(
                    'id' => 'login_email',
                    'placeholder' => __('Email'),
                    'name' => "data[email]",

                )
            );
            echo $this->Form->input('password', array(
                    'id' => 'login_password',
                    'placeholder' => __('Password'),
                    'name' => 'data[password]',
                    'class' => 'form-control',
                    'required' => false
                )
            );
            echo $this->Form->submit(__('Sign in'), array(
                    'class' => 'btn btn-success btn-login',
                    'value' => __('Sign in'),
                    'div' => false

                )
            );

            echo $this->Form->end();
            ?>
            <div class="row p_top_15">
                <div class="col-md-6 text-left"><!--login-box-->
                    <input type="hidden" value="0" id="remember_" name="data[remember]">
                    <input type="checkbox" id="remember" value="1" checked="checked" name="data[remember]"> <?php echo __('Remember me')?>

                </div>
                <div class="col-md-6 text-right">
                    <a href="<?php echo $this->request->base ;?>/users/recover"><?php echo __('Forgot password?')?></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php endif; ?>