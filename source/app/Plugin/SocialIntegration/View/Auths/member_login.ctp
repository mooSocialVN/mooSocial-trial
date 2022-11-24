<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<?php if($this->Auth->user('id') === null): ?>
    <?php //echo $this->Session->flash(); ?>
<div class="bar-content">
</div>

<div id="fb-root"></div>

<div class="loginPage">
<div id="loginForm">
    <h1 class="text-center"><?php echo __('Sync Account')?></h1>
    <?php
    $form = $this->Form->create(null, array(
            'class' => 'form-horizontal',
            'url'=>array('plugin'=>'social_integration','controller'=>'auths','action'=>'member_verify', 'provider'=>$provider)
        )
    );
    $this->Form->inputDefaults(array(
            'label' => false,
            //'div' => array("class" => 'form-group'),
            'class' => 'form-control',

        )
    );

    $form .=$this->Form->input('text', array(
            'id' => 'login_email',
            'placeholder' => __('Email'),
            'name'=>"data[email]",

        )
    );
    $form .=$this->Form->input('password', array(
            'id' => 'login_password',
            'placeholder' => __('Password'),
            'name' => 'data[password]',
            'class' => 'form-control',
            'required' => false
        )
    );
    $form .=$this->Form->submit(__('Confirm'), array(
            'class'=>'btn btn-success btn-login',
            'value' => __('Confirm'),
            'div'=>false

        )
    );
    //$form .=$this->Form->end(array('label'=>'Login','div'=>false,'class'=>'btn btn-success'));
    echo $form;
    ?>
    
    
    </form>
</div>
</div>
<?php endif; ?>

