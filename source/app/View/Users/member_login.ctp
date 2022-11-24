<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div class="loginPage">
    <div class="login-page-content">
        <h1 class="login-page-title"><?php echo __('Member Login')?></h1>
        <?php echo $this->element('signin' ); ?>
    </div>
</div>