<div class="box5">
    <h1><?php echo __('Admin Login');?></h1>
    <p><?php echo __('Please enter your email and password to continue');?></p>
    <form action="<?php echo $this->request->base?>/admin/home/login" method="post">
        <ul class="list1">
            <li><label><?php echo __('Email')?></label><?php echo $this->Form->text('admin_email'); ?></li>
            <li><label><?php echo __('Password')?></label><?php echo $this->Form->password('admin_password'); ?></li>
        </ul>
        <div class="regSubmit">
            <input type="submit" value="<?php echo __('Continue');?>" class="button button-rounded button-action">
        </div>
    </form>
</div>