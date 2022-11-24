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
				<?php if (!empty($url)):?>
					if (step == 3)
					{
						$("#install").html('<h2>Installation Progess</h2><div>Please wait while the script is being installed.</div>');
						$('h1').remove();
						window.location.href = '<?php echo $this->request->base.$url;?>';
					}
				<?php endif;?>
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
						<h2><?php echo __('Step 2: Database Configuration');?></h2>
						<form id="installForm">
							<ul class="list6">
								<li><label><?php echo __('Database Host');?></label>
									<?php echo $this->Form->text('db_host', array('value' => 'localhost')); ?> <?php echo __('(this is usually "localhost")');?>
								</li>
								<li><label><?php echo __('Database Username');?></label>
									<?php echo $this->Form->text('db_username'); ?>
								</li>
								<li><label><?php echo __('Database Password');?></label>
									<?php echo $this->Form->password('db_password'); ?>
								</li>
								<li><label><?php echo __('Database Name');?></label>
									<?php echo $this->Form->text('db_name'); ?>
								</li>
								<li><label><?php echo __('Unix Socket');?></label>
									<?php echo $this->Form->text('db_socket'); ?> <?php echo __('(leave empty if you are not sure)');?>
								</li>
								<li><label><?php echo __('Table Prefix');?></label>
									<?php echo $this->Form->text('db_prefix'); ?> <?php echo __('(choose an optional table prefix which must end in an underscore)');?>
								</li>
								<li><label>&nbsp;</label>
									<a href="javascript:void(0)" onclick="doStep(1)" id="step_but" class="btn btn-danger"><i class="icon-ok"></i> <?php echo __('Next');?></a>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

