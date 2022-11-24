<div id="header" role="navigation" class="navbar navbar-fixed-top sl-navbar">
    <div class="header-bg"></div>
    <div class="container full_header">
        <div class="hidden-xs hidden-sm">
            <div class="logo-default">
                <a href="<?php echo  $this->request->webroot ?>"><img alt="mooSocial"
                                                              src="<?php echo  $this->request->webroot ?>theme/default/img/logo.png"></a>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="wrapper">
                <div id="content" class="upgrade-content">
                    <h1><?php echo __('Congratulation!');?></h1>

                    <div class="error-message" style="display:none"></div>

                    <?php if (!empty($url)):?>
                        <div id="install">
                            <div class="bs-callout bs-callout-danger">
                                <h4 style="border-top:none;"><?php echo __('Please wait while the script is being upgraded');?><?php echo  $latest_version ?></h4>
                            </div>
                        </div>
                        <script>
                            window.location.href = '<?php echo $this->request->base.$url;?>';
                        </script>
                        
                    <?php else:?>
                        <div id="install">
                            <div class="bs-callout bs-callout-danger">
                                <h4 style="border-top:none;"><?php echo __('You have successfully upgraded mooSocial to version');?><?php echo  $latest_version ?></h4>
                            </div>


                        </div>
                        <a href="<?php echo  $this->request->webroot ?>" class="btn btn-danger"><?php echo __('Go to Homepage');?></a>
                    <?php endif;?>
                </div>
            </div>
        </div>

    </div>
</div>
