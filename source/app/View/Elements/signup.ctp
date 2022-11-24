<?php $this->setCurrentStyle(4);?>

<?php $this->Html->scriptStart(array('inline'=>false)) ?>
jQuery(document).ready(function(){
    jQuery("#submitFormsignup").click(function(){
        $(this).attr('disabled','disable');
        $(this).text('Please wait');

        var sub_butt = $(this);
        
        jQuery.post("<?php echo $this->request->base?>/users/ajax_register", jQuery("#UserMemberSignupForm").serialize(), function(data){
            if (data != '') {
                jQuery("#regError").fadeIn();
                jQuery("#regError").html(data);
                sub_butt.removeAttr('disabled');
                sub_butt.text('Sign up');
            } else {
                jQuery("#regError").fadeOut();

                window.location = '<?php echo $this->request->base?>/';
            }
        });
    });
});
<?php $this->Html->scriptEnd(); ?>
<?php if($this->Auth->user('id') === null): ?>
    <div class="bar-content">
    </div>
    <?php

    $this->Html->scriptStart(array('inline' => false));
    ?>
$(document).ready(function(){
    $('#gSignOutWrapper').click(function(){
        gapi.auth.signOut();
        document.getElementById('gSignInWrapper').setAttribute('style', 'display: block');
        document.getElementById('gSignOutWrapper').setAttribute('style', 'display: none');
    });
    if($("#flashMessage").length!=0){
        $("#status span").text($("#flashMessage").text());
        $("#flashMessage").css({'display':'none'});
    }
});

    <?php
    $this->Html->scriptEnd();
    ?>
    <div class="row" id="signUpForm">

        <div class="col-md-sl7">
            <div class="register_main_form">
            <h1><?php echo __('Join mooSocial Demo'); ?></h1>
            <?php
            $form = $this->Form->create('User', array(
                    'class' => 'form-horizontal',
                    'url'=>false,
                    'id' => 'UserMemberSignupForm'
                )
            );
            $this->Form->inputDefaults(array(
                    'label' => false,
                    'class' => 'form-control col-md-9',
                    'legend' => false,
                )
            );
            $form.= '<div class=" form-group">';
            $form.='<div class="col-md-3 control-label">Name</div><div class="col-md-9">';
            $form .=$this->Form->input('text', array(
                    'id' => 'name',
                    'name'=>"data[name]",
                    "class" => "form-control"
            ));
            $form.= '</div></div>';

            $form.= '<div class="form-group">';
            $form.='<div class="col-md-3 control-label">Email Address</div><div class="col-md-9">';
            $form .=$this->Form->input('text', array(
                    'id' => 'email',
                    'name'=>"data[email]",
                    "class" => "form-control"
                )
            );
            $form.= '</div></div>';

            $form.= '<div class="form-group">';
            $form.='<div class="col-md-3 control-label">Password</div><div class="col-md-9">';
            $form .=$this->Form->input('password', array(

                    'id' => 'password',
                    'name' => 'data[password]'
                )
            );
            $form.= '</div></div>';

            $form.= '<div class="form-group">';
            $form.='<div class="col-md-3 control-label">Confirm Password</div><div class="col-md-9">';
            $form .=$this->Form->input('password', array(
                    'id' => 'password2',
                    'name' => 'data[password2]'
                )
            );
            $form.= '</div></div>';

            $form .= "<div class='form-group'><label class='col-md-3 control-label'>Birthday</label><div class='col-md-9'>";
            $form .='<div class="col-xs-4">';
            $form .= $this->Form->month('Month',array('class' => 'form-control','name'=>"data[birthday][month]",'id'=>"birthdayMonth"));
            $form .='</div>';

            $form .='<div class="col-xs-4"><div style="padding:0 4px;">';
            $form .= $this->Form->day('birthday',array('class' => 'form-control','name'=>"data[birthday][day]",'id'=>"birthdayDay"));
            $form .='</div></div>';

            $form .='<div class="col-xs-4">';
            $form .= $this->Form->year('birthday', 1930, date('Y'),array('class' => 'form-control',"name"=>"data[birthday][year]",'id'=>"birthdayYear"));
            $form .='</div>';
            $form .= '</div></div>';
        $enable_timezone_selection = Configure::read('core.enable_timezone_selection');
        if ( !empty($enable_timezone_selection ) ):
            $form .= "<div class='form-group'><label class='col-md-3 control-label'>Timezone</label><div class='col-md-9'>";
            $form .= $this->Form->select('timezone', $this->Moo->getTimeZones(),array('class' => 'form-control',"name"=>"data[timezone]",'id'=>"timezone"));
            $form .= '</div></div>';
        endif;
            $form .= "<div class='form-group'><label class='col-md-3 control-label'>Gender</label><div class='col-md-9 checkbox'>";
            
            $form .= $this->Form->input('gender',array(
                'label' => array("class" => "text-left"),
                'type' => 'radio',
                'options' => $this->Moo->getGenderList(),
                'name' => 'data[gender]',
                'id' => 'gender',
                'div' =>false,
                'legend' => false,
                'value' => 'Male',
                'class' => false,
            ));
            $form .= '</div></div>';

            echo $form;
            echo '<ul class="custom-register">';
            echo $this->element( 'custom_fields', array( 'show_heading' => true ) );
            echo '</ul>';

            ?>
            <div class="form-group">
                <label class="col-md-3 control-label">&nbsp;</label>
                <div class="col-md-9">
                     <a href="javascript:void(0)" id='submitFormsignup' class='btn btn-success'>Sign up</a>
                </div>

            </div>
            <div id="captcha" style="display:none">
                <?php if ( !empty( $challenge ) ): ?>
                    <div>
                        <p><?php echo __('To avoid spam, please answer the following question')?>:</p><?php echo $challenge['SpamChallenge']['question']?><br /><br />
                        <?php echo $this->Form->text('spam_challenge');?>
                    </div>
                <?php endif; ?>

                <?php 
                    if ( $this->Moo->isRecaptchaEnabled()): ?>
                    <div class="captcha_box">
                        <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                        <div class="g-recaptcha" data-sitekey="<?php echo $this->Moo->getRecaptchaPublickey(); ?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                    </div>
                <?php endif; ?>

            </div>
            </form>
            <div id="regError" class="alert alert-danger" style="display: none;"></div>
            </div>
        </div>
        <div class="col-md-sl3">
            <div class="register_social_form">
                <div class="center-login-text text-center">
                    <span>Or Sign in using</span>
                </div>
                <div class="fSignInWrapper">
                
                    <div class="fb-login-button"> </div>
                    <div class="overlay-button">
                        <span class="icon"></span>
                        <span class="buttonText"><a href="<?php echo  $this->Html->url(array('controller'=>'users','action'=>'fb_register')) ?>">Sign in using Facebook</a></span>
                    </div>
                </div>
                <div id="gSignInWrapper">
                    <div id="customBtn" class="customGPlusSignIn">
                        <span class="icon"></span>
                        <span class="buttonText">Sign in using Google</span>
                    </div>
                </div>

                <div id="gSignOutWrapper" style="display:none">
                    <div id="customBtn" class="customGPlusSignIn">
                        <span class="icon"></span>
                        <span class="buttonText">Sign out</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    echo $this->Html->script(

        array(
            'global/bootstrap/js/bootstrap.min.js?'. Configure::read('core.version'),
            'global/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js?'. Configure::read('core.version'),
        ),
        array('inline'=>false)
    );
    ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

<?php endif; ?>



