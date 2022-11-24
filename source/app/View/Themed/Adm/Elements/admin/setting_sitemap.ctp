<?php 
	$lists = MooSeo::getInstance()->getSitemapEntities();
	$sitemap_ignore_key = MooSeo::getInstance()->getConfig("sitemap_ignore_key");
	$sitemap_ignore_key = explode(",", $sitemap_ignore_key);
	$values = array();
	$tmp = array();
	foreach ($lists as $key=>$list)
	{		
		$name = array();
		foreach ($list['items'] as $item)
		{
			$name[] = __(ucfirst($item['name'])) != __d(Inflector::underscore($key),ucfirst($item['name'])) ? __d(Inflector::underscore($key),ucfirst($item['name'])) : __(ucfirst($item['name']));
		}
		if (!in_array($key, $sitemap_ignore_key))
		{
			$values[] = $key;
		}
		$plugin = __($key) != __d(Inflector::underscore($key),$key) ? __d(Inflector::underscore($key),$key) : __($key);
		$tmp[$key] = $plugin.' ('.implode(',', $name).')';
	}
	$lists = $tmp;
?>
<div class="row" style="padding-top: 10px;">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tab-pane active" id="portlet_tab1">
				<div>
					<?php if (Configure::read('core.force_login')):?>
						<div class="alert alert-danger" role="alert"><?php echo __('Please turn off force login');?></div>
					<?php endif;?>
					<div><?php echo __('Insert the following line anywhere in your robots.txt file, specifying the path to your sitemap.');?></div>
					<?php if (MooSeo::getInstance()->getConfig('sitemap_last_build')):?>
						<div><?php echo __('Current Sitemap file location: ');?> <a href="<?php echo FULL_BASE_URL.$this->request->base.'/sitemap.xml'?>"><?php echo FULL_BASE_URL.$this->request->base.'/sitemap.xml'?></a></div>
					<?php else:?>
						<div><?php echo __('XML site map is updating....will be ready to get link very soon.');?></div>
					<?php endif;?>
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $this->request->base?>/admin/sitemap/setting_save/<?php echo $curGroup['SettingGroup']['id']; ?>">
	                	<div class="form-body">
	                		<div class="form-group">
	                        	<label class="col-md-3 control-label">
	                        		<?php echo __('Enable sitemap');?>
	                        	</label>
	                        	<div class="col-md-7">
	                        		<?php
		                        		echo $this->Form->input('sitemap_enable', array(
		                        				'type' => 'checkbox',
		                        				'checked' => MooSeo::getInstance()->getConfig("sitemap_enable"),
		                        				'label' => false
		                        		));
	                        		?>
	                        	</div>
	                        </div>
	                		<div class="form-group">
	                        	<label class="col-md-3 control-label">
	                        		<?php echo __('Schedule updates');?> (<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __('Sitemap update interval');?>" data-placement="top">?</a>)
	                        	</label>
	                        	<div class="col-md-7">
	                        		<div class="input select">
	                        			<?php 
	                        				$array = array(MooSeo::SITEMAP_UPDATE_DAILY => __('daily'),MooSeo::SITEMAP_UPDATE_WEEKLY => __('weekly'),MooSeo::SITEMAP_UPDATE_MONTHLY => __('monthly'));
	                        			?>
	                        			<select name="data[sitemap_schedule_update]" class="form-control">
	                        				<?php foreach ($array as $key=>$name):?>
												<option value="<?php echo $key;?>" <?php if (MooSeo::getInstance()->getConfig("sitemap_schedule_update") == $key):?>selected="selected" <?php endif;?> ><?php echo $name;?></option>
											<?php endforeach;?>
										</select>
									</div>
	                        	</div>
	                        </div>
	                        <div class="form-group">
	                        	<label class="col-md-3 control-label">
	                        		<?php echo __('Page types');?>
	                        	</label>
	                        	<div class="col-md-7">
	                        		<div class="input select">	                        			
	                        			<?php
		                        			echo $this->Form->input('sitemap_ignore_key',array(
		                        					'type' => 'select',
		                        					'multiple' => 'checkbox',
		                        					'value' => $values,
		                        					'label' => '',
		                        					'options'=>$lists
		                        			));
	                        			?>
									</div>
	                        	</div>
	                        </div>
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