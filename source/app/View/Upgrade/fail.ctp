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
                    <h1><?php echo __('Update Failed!');?></h1>

                    <div class="error-message" style="display:none"></div>


                    <div id="install">
                        <div class="bs-callout bs-callout-danger">
                            <h4 style="border-top:none;"><?php echo __('Upgrade failed, please try again!');?></h4>
                        </div>


                    </div>
                    <a href="<?php echo  $this->request->webroot ?>upgrade/" class="btn btn-danger"><?php echo __('Back');?></a>

                </div>
            </div>
        </div>

    </div>
</div>
