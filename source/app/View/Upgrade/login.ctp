<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<div class="loginPage">
    <div id="loginForm">
        <h1 class="text-center"><?php echo __('Only root admin can run the upgrade wizard');?></h1>
        <div><?php echo $this->Session->flash(); ?></div>
        <?php
        echo $this->Form->create('UserUpgrade', array(
                'class' => 'form-horizontal',
                'url'=>array('controller'=>'upgrade','action'=>'login')
            )
        );
        $this->Form->inputDefaults(array(
                'label' => false,
                //'div' => array("class" => 'form-group'),
                'class' => 'form-control',

            )
        );
        //echo $this->Form->input('id');
        echo $this->Form->input('email', array(
                'id' => 'login_email',
                'placeholder' => __("Email"),
                'type' => 'text'
            )
        );
        echo $this->Form->input('password', array(
                'id' => 'login_password',
                'placeholder' => __("Password"),
                'class' => 'form-control'
            )
        );
        echo $this->Form->submit(__('Sign in'), array(
                'class'=>'btn btn-success btn-login',
                'value' => __('Sign in'),
                'div'=>false

            )
        );
        //$form .=$this->Form->end(array('label'=>'Login','div'=>false,'class'=>'btn btn-success'));
        echo $this->Form->end();
        ?>


    </div>
</div>
