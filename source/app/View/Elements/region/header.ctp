<div class="header-wrapper-top">
    <?php $this->doLoadingHeader();?>
</div>
<?php if (!empty($uid)): ?>
    <?php if ($this->Moo->socialIntegrationEnable('facebook')): ?>
    <div id="fb-root"></div>
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '<?php echo Configure::read('FacebookIntegration.facebook_app_id')?>',
                cookie     : true,  // enable cookies to allow the server to access
                // the session
                xfbml      : true,  // parse social plugins on this page
                version    : 'v2.1' // use version 2.1
            });
        };

        // Load the SDK asynchronously
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        function FBLogout(){

            FB.getLoginStatus(function(response) {
                if (response && response.status === 'connected') {
                    FB.logout(function(response) {

                        window.location ="<?php echo $this->request->base?>/users/do_logout";
                    });
                }else{
                    // To do:
                    gapi.auth.signOut();
                    window.location ="<?php echo $this->request->base?>/users/do_logout";
                }
            });
        }
    </script>
    <?php endif; ?>
<?php endif; ?>