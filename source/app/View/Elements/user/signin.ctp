<?php
if(empty($title)) $title = "Member Login";
?>

<?php if ( empty( $featured_users ) ): ?>
<div class="box2">
    <h3><?php echo $title;?></h3>
    <div class="box_content">

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
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1413388488948132&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            window.fbAsyncInit =function(){
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        // the user is logged in and has authenticated your
                        // app, and response.authResponse supplies
                        // the user's ID, a valid access token, a signed
                        // request, and the time the access token
                        // and signed request each expire
                        var uid = response.authResponse.userID;
                        var accessToken = response.authResponse.accessToken;
                        
                        
                    } else if (response.status === 'not_authorized') {
                        // the user is logged in to Facebook,
                        // but has not authenticated your app
                    } else {
                        // the user isn't logged in to Facebook.
                    }
                });
            }
        </script>
        <div class="loginPage">
            <div id="loginForm">
                <h1 class="text-center">Member Login</h1>
                <?php
                $form = $this->Form->create('User', array(
                        'class' => 'form-horizontal',
                        'url'=>array('controller'=>'users','action'=>'login')
                    )
                );
                $this->Form->inputDefaults(array(
                        'label' => false,
                        //'div' => array("class" => 'form-group'),
                        'class' => 'form-control',

                    )
                );
                $form .=$this->Form->input('id');
                $form .=$this->Form->input('email', array(
                        'id' => 'login_email',
                        'placeholder' => "Email",
                		'type' => 'text',
                        'name'=>"data[email]"
                    )
                );
                $form .=$this->Form->input('password', array(
                        'id' => 'login_password',
                        'placeholder' => "Password",
                        'name' => 'data[password]',
                        'class' => 'form-control'
                    )
                );
                $form .=$this->Form->submit('Sign in', array(
                        'class'=>'btn btn-success',
                        'value' => 'Sign in',
                        'div'=>false

                    )
                );
                //$form .=$this->Form->end(array('label'=>'Login','div'=>false,'class'=>'btn btn-success'));
                echo $form;
                ?>
                <div class="row">
                    <div class="checkbox col-md-6"><!--login-box-->
                        <input type="hidden" value="0" id="remember_" name="data[remember]">
                        <input type="checkbox" id="remember" value="1" checked="checked" name="data[remember]"> Remember me

                    </div>
                    <div class="col-md-6">
                        <p><a href="/moosocial/tags/2.0.3.themingrewrite/users/recover">Forgot password?</a></p>
                    </div>
                </div>
                </form>
                <div class="row">
                    <hr class="col-md-3"><span class="col-md-3">Or Sign in using</span><hr class="col-md-3">
                </div>

                <!-- In the callback, you would hide the gSignInWrapper element on a
              successful sign in -->

                <div class="fb-login-button" login_text="Sign in using facebook" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true" onlogin="hide_form"></div>
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

                <div id="status">
                    <span style="color:red"></span>
                </div>
                <div class="row">
                    <div class="col-md-6 text-left">Help: <a href="#">More</a></div>
                    <div class="col-md-6 text-right"><a href="#">English</a></div>
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

        <!-- Place this asynchronous JavaScript just before your </body> tag -->

        <style type="text/css">
            #customBtn {
                display: inline-block;
                background: #dd4b39;
                color: white;

                border-radius: 5px;
                white-space: nowrap;
            }
            #customBtn:hover {
                background: #e74b37;
                cursor: hand;
            }
            span.label {
                font-weight: bold;
            }
            span.icon {
                background: url('<?php echo FULL_BASE_URL . $this->request->webroot ?>/img/btn_red.png') transparent 5px 50% no-repeat;
                display: inline-block;
                vertical-align: middle;
                width: 35px;
                height: 35px;
                border-right: #bb3f30 1px solid;
            }
            span.buttonText {
                display: inline-block;
                vertical-align: middle;
                padding-left: 32px;
                padding-right: 32px;
                font-size: 14px;
                font-weight: bold;
                /* Use the Roboto font that is loaded in the <head> */
                font-family: 'Roboto',arial,sans-serif;
            }
        </style>
    <?php endif; ?>

    </div>
</div>
<?php endif; ?>