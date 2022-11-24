<div class="box5">
    <h1 class="form-title"><?php echo __('Admin Login');?></h1>
    <p><?php echo __('Please enter your email and password to continue');?></p>
        <?php echo $form = $this->Form->create('User', array(
                'class' => 'login-form',
                'novalidate'=>'novalidate',
                'url'=>array('controller'=>'home','action'=>'admin_login')
            )
        ); ?>
        <input  type="hidden" name="admin_redirect_url" value="<?php echo $redirect_url ?>"/>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9"><?php echo __('Email')?></label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <?php echo $this->Form->text('email', array('class' => 'form-control placeholder-no-fix','value'=>isset($this->request->data['admin_email']) ? $this->request->data['admin_email'] : '', 'autocomplete'=>'off', 'placeholder'=>__('Email' ))); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9"><?php echo __('Password')?></label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <?php echo $this->Form->password('password', array('value'=>isset($this->request->data['admin_password']) ? $this->request->data['admin_password'] : '','class' => 'form-control placeholder-no-fix', 'autocomplete'=>'off', 'placeholder'=>__('Password' ))); ?>
            </div>
        </div>
        <div class="regSubmit">
            <input type="submit" value="<?php echo __('Continue');?>" class="button button-rounded button-action btn green pull-right">
        </div>
    </form>
</div>