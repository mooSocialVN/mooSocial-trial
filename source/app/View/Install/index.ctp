<?php echo $this->Html->script(array('scripts')); ?>
<script>
function doStep( step )
{
	$("#step_but i").attr("class", "icon-refresh icon-spin");
    $("#step_but").addClass('disabled');
    $("#step_but").spin('small');
	$.post("<?php echo $this->request->base?>/install/ajax_step" + step, $("#installForm").serialize(), function(data){
		$("#step_but i").attr("class", 'icon-ok');
		$("#step_but").spin(false);
        $("#step_but").removeClass('disabled');
		if (data.indexOf('mooError') > 0) {
			$(".error-message").show();
			$(".error-message").html(data);
		} else {
			$(".error-message").hide();
			$("#install").html(data);
		}
	});
}

</script>
<div id="header" role="navigation" class="navbar navbar-fixed-top sl-navbar">
    <div class="header-bg"></div>
    <div class="container full_header">
        <div class="hidden-xs hidden-sm">
            <div class="logo-default">
                <a href="<?php echo $this->request->webroot?>"><img alt="mooSocial" src="<?php echo $this->request->webroot?>theme/default/img/logo.png"></a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="wrapper">
                <div id="content" class="install-content">
                    <h1><?php echo __('Welcome to mooSocial Installation');?></h1>
                    <div class="error-message" style="display:none"></div>

                    <div id="install" >
                        <div class="bs-callout bs-callout-danger">
                            <h4 class="require_header" style="border-top:none;"><?php echo __('Please make sure that your server meets all the requirements before proceeding');?></h4>
                            <ul style="list-style:outside;padding-left:20px;">
                                <li><?php echo __('PHP 5.3 with short tags enabled or PHP 5.4+');?></li>
                                <li><?php echo __('MySql 5+');?></li>
                                <li><?php echo __('PHP extensions: MySql PDO, GD2, Curl, libxml, exif, zlib (if you need to export theme)');?></li>
                                <li><?php echo __('Magic quotes must be disabled');?></li>
                                <li><?php echo __('Memory Limit: 128M+');?></li>
                                <li><?php echo __('The following directories are writable by the web server user (e.g. change permission to 755 ): app/Config, app/tmp and all its subdirectories, app/webroot/uploads and all its subdirectories');?></li>
                            </ul>

                        </div>
                        <div class="bs-callout bs-callout-danger">
                            <h2><?php echo __('Step 1: Check Requirements');?></h2>
                            <div><?php echo __('Great! Next, let\'s make sure your server has everything it needs to support mooSocial. If any of the requirements below are marked with red, you will need to address them before continuing. If items are marked with yellow, we recommend that you address them before installing, but you can continue if you wish.');?></div>
                            <br/>
                            <ul class="list6 requirement_check">
                                <?php foreach ($check_list as $value):?>
                                    <li class="<?php if ($value['status'] == 0): ?>stt_err <?php elseif($value['status'] == 2): ?> stt_warning<?php endif; ?>">
                                        <label><?php echo $value['name'];?></label>
                                        <span><?php if ($value['status'] == 1) echo __('Ok'); else echo $value['message'];?></span>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                        <div><?php echo __('Please address all of the issues highlighted in red before continuing with the installation.'); ?></div>
                        <br/>
                        <form id="installForm" method="get">
                            <ul class="list6">
                                <li>
                                    <?php if (!$check) :?>
                                        <button type="submit" class="btn btn-danger"><?php echo __('Check Again');?></button>
                                    <?php else:; ?>
                                        <button type="button" onclick="window.location='<?php echo $this->base ?>/install/step'" class="btn btn-danger"><?php echo __('Next');?></button>
                                    <?php endif;?>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

