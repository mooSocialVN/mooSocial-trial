<?php
	__('When a new user sign up');
	__('When a user join a Group (apply for both home feed and on group feed)');
	__('When a user becomes friends with another user');
	__('When a user updates profile photo');
	__('When a user attents an event');
	$settingFeedModel = MooCore::getInstance()->getModel("UserSettingFeed");
	$settings = $settingFeedModel->find('all');
?>
<div class="row" style="padding-top: 10px;">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tab-pane active" id="portlet_tab1">
				<div>
					<div style="padding-left: 20px;"><?php echo __('Please Un-check to remove activity item from "what\'s new" page');?></div>
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $this->request->base?>/admin/system_settings/feed">
	                	<div class="form-body">
							<?php foreach ($settings  as $setting): ?>
								<div class="form-group">
									<label class="col-md-3 control-label">
										<?php if ($setting['UserSettingFeed']['plugin']): ?>
											<?php echo __d(Inflector::underscore($setting['UserSettingFeed']['plugin']),$setting['UserSettingFeed']['text']);?>
										<?php else: ?>
											<?php echo __($setting['UserSettingFeed']['text']);?>
										<?php endif;?>
									</label>
									<div class="col-md-7">
										<?php
											echo $this->Form->input($setting['UserSettingFeed']['type'], array(
													'type' => 'checkbox',
													'checked' => $setting['UserSettingFeed']['active'],
													'label' => false
											));
										?>
									</div>
								</div>
							<?php endforeach; ?>
	                        <div class="form-actions">
                            	<div class="row">
                                	<div class="col-md-offset-3 col-md-9">
                                    	<input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Settings');?>">
                                    </div>
                                </div>
                            </div>
	                	</div>
	                </form>
				</div>
			</div>
		</div>
	</div>
</div>