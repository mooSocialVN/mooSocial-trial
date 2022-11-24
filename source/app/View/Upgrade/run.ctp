<?php echo $this->Html->script(array('jquery-easyui/jquery.easyui.min')); ?>
<?php echo $this->Html->css(array('jquery-easyui-themes/bootstrap/progressbar')); ?>
<script>
    <?php if ( $version == $latest_version ): ?>
    setTimeout('window.location = "<?php echo $this->request->base?>/upgrade/index/done"', 5000);
    <?php else: ?>
    setTimeout('window.location = "<?php echo $this->request->base?>/upgrade/run"', 5000);
    <?php endif; ?>
</script>


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
                <div id="content">
                    <h1><?php echo __('Upgrading mooSocial to version');?> <?php echo  $version ?></h1>

                    <div class="error-message" style="display:none"></div>


                    <div id="install">
                        <div class="bs-callout bs-callout-danger">
                            <h4 style="border-top:none;"><img src="<?php echo  $this->request->webroot ?>img/indicator.gif"
                                                              align="absmiddle"><?php echo __('Please wait...');?></h4>

                            <h4 style="border-top:none;"><?php echo __('Do not close your browser during upgrading process please');?></h4>
                        </div>


                    </div>

                    <div id="progressbar"></div>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(function() {
        $( "#progressbar" ).progressbar({
            value: <?php echo !empty($percent_complete)?$percent_complete:0 ?>
        });
    });
</script>