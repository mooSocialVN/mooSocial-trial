<?php echo $this->Html->script(array('mooPhrase','scripts')); ?>
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
                    <h1><?php echo __('Upgrading mooSocial');?></h1>

                    <div class="error-message" style="display:none"></div>


                    <div id="install">
                        <div class="bs-callout bs-callout-danger">
                            <h4 style="border-top:none;"><?php echo __('*Make sure that you backup all files and database before proceeding please');?></h4>
                            
                            <?php if (!$checkPermissionGarbageFiles): ?>
                            <h4 style="border-top:none;"><?php echo __('*Please change permission of directory "%s" and all sub-directories to 0755', $garbageFilesDirectory);?></h4>
                            <?php endif; ?>
                            
                            <?php if (!$checkPermissionPluginsXml): ?>
                            <h4 style="border-top:none;"><?php echo __('*Please change permission of file "%s" to 0755', $permissionPluginsXmlFile);?></h4>
                            <?php endif; ?>
                            
                            <?php if (!$checkPermissionSettings): ?>
                            <h4 style="border-top:none;"><?php echo __('*Please change permission of file "%s" to 0755', $permissionSettingsFile);?></h4>
                            <?php endif; ?>
                            
                            <?php if (!$checkPermissionLocale):?>
                            <h4 style="border-top:none;"><?php echo __('*Please change permission of directory "%s" and all sub-directories to 0755', APP.'Locale');?></h4>
                            <?php endif;?>

                            <h4 style="border-top:none;"><?php echo __('*Do not close your browser during upgrading process please');?></h4>

                            <p><?php echo __('Current version');?>: <span style="color:red"><?php echo  $current_version ?></span></p>

                            <p><?php echo __('Latest version');?>: <span style="color:green"><?php echo  $latest_version ?></span></p>
                            
                            
                        </div>


                    </div>
                    <button <?php if(!$checkPermissionGarbageFiles || !$checkPermissionPluginsXml || !$checkPermissionSettings) echo 'disabled'; ?> id="proceed" data-href="<?php echo  $this->request->base ?>/upgrade/run" class="btn btn-danger"><?php echo __('Proceed');?>
                    </button>


                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){
        $('#proceed').click(function(){
            $(this).spin('small');
            $(this).attr('disabled',true);
            window.location = $(this).data('href');
        })
    })
</script>
