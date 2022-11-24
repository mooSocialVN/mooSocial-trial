<div class="hidden" id="remove-hidden-after-loading">
	<?php
	echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
	echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
	$this->Html->addCrumb(__d("setting",'Storage System'), null);
	$url = Router::url(array(
		'plugin'=>'storage',
		'controller' => 'storages',
		'action' => 'admin_index'),true);
	$this->Html->addCrumb(__('Manage Storage Services'), $url);
	$this->Html->addCrumb(__('Amazon S3'), null);
	$this->startIfEmpty('sidebar-menu');
	echo $this->element('admin/adminnav', array('cmenu' => 'storage'));
	$this->end();
	?>
	<?php echo $this->Moo->renderMenu('Storage', __('Settings'));?>




	<div class="portlet-body form">
		<div class=" portlet-tabs">
			<div class="tabbable tabbable-custom boxless tabbable-reversed">
				<div class="row">
					<div class="col-md-12">
						<div class="form-wizard">
							<div class="form-body">
								<ul class="nav nav-pills nav-justified steps">
									<li >
										<a href="#tab1"  class="step" aria-expanded="true">
											<span class="number"> 1 </span>
											<span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('PHP Compatibility Test'); ?> </span>
										</a>
									</li>
									<li>
										<a href="#tab2"  class="step">
											<span class="number"> 2 </span>
											<span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Amazon S3 Account Setup'); ?> </span>
										</a>
									</li>
									<li class="active">
										<a href="#tab3"  class="step active">
											<span class="number"> 3 </span>
											<span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Amazon S3 API Test'); ?> </span>
										</a>
									</li>
									<li>
										<a href="#tab4"  class="step">
											<span class="number"> 4 </span>
											<span class="desc">
                                                                    <i class="fa fa-check"></i> <?php echo __('Confirm'); ?> </span>
										</a>
									</li>
								</ul>
								<div id="bar" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-success" style="width: 75%;"> </div>
								</div>

							</div>

						</div>
						<div class="note note-success">
							<h4 class="block"><?php echo __('All Tests Passed!'); ?></h4>
							<p><?php echo __('You can continue to the next step.'); ?></p>
						</div>

					</div>
				</div>

				<div class="row" style="padding-top: 10px;">
					<div class="col-md-12">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_tab1">
								<form class="form-horizontal intergration-setting" method="post"  action="<?php echo Router::url(array(
									'plugin'=>'storage',
									'controller' => 'StorageAmazon',
									'action' => 'admin_confirm_enable_step4'))?>">

									<div class="form-actions">
										<div class="row">




												<div class="col-md-offset-11 col-md-12">
													<input type="submit" class="btn btn-circle btn-action " value="<?php echo __('Next'); ?>">
												</div>



										</div>
									</div>
								</form>                        </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$( document ).ready(function() {
	$(".tab-2 >a").text("<?php echo __('Amazon S3'); ?>");
	$("#remove-hidden-after-loading").removeClass("hidden");
	});
<?php $this->Html->scriptEnd(); ?>
