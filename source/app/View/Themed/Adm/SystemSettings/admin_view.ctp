<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min','token-input'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable','jquery.tokeninput'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('System Settings'), array('controller' => 'system_settings', 'action' => 'admin_view'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "settings"));
$this->end();
if(!empty($id_auto_add_friend)):
$this->Html->scriptStart(array('inline' => false));   ?>
$(document).ready(function(){
    $("#<?php echo  $id_auto_add_friend ?>").tokenInput("<?php echo $this->request->base?>/users/do_get_json",
        {
            preventDuplicates: true,
            hintText: "<?php echo addslashes(__('Enter one or more users'))?>",
            noResultsText: "<?php echo addslashes(__('No results'))?>",
            tokenLimit: 20,
            <?php if(!empty($friends)): ?>
            prePopulate: <?php echo  $friends; ?>,
            <?php endif; ?>
            resultsFormatter: function(item)
            {
                return '<li>' + item.avatar + item.name + '</li>';
            }
        }
    );
})
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if(!empty($link_after_login)):
$this->Html->scriptStart(array('inline' => false));   ?>
$(document).ready(function(){
    $('#<?php echo $link_after_login;?>').parent().append( "<p><span><?php echo FULL_BASE_URL.$this->request->base?>/</span><span id='url_login'></span></p>" );
    $('#<?php echo $link_after_login?>').keyup(function(){
    	$('#url_login').html( $('#<?php echo $link_after_login?>').val());
    });
    $('#url_login').html( $('#<?php echo $link_after_login?>').val());
})
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if($settingGuide != ''):?>
<div style="max-height: 300px;overflow: auto">
    <?php echo $settingGuide;?>
</div>
<?php endif;?>

<div class="portlet-body form systemSetting">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">
            <ul class="nav nav-tabs list7 chart-tabs">
                <?php foreach($setting_groups as $setting_group):
                    $setting_group = $setting_group['SettingGroup'];
                ?>
                <li <?php if($active_setting == $setting_group['id']):?> class="active" <?php endif;?>>
                    <a href="<?php echo $this->request->base?>/admin/system_settings/view/<?php echo $setting_group['id'];?>"><?php echo __d('setting',$setting_group['name']);?></a>
                </li>
                <?php endforeach;?>
            </ul>
            <?php if ($curGroup['SettingGroup']['name'] == "Site Map"):?>
            	<?php echo $this->element("admin/setting_sitemap");?>
            <?php elseif ($curGroup['SettingGroup']['name'] == "SEO Settings & Rules"):?>
				<?php echo $this->element("admin/setting_seo");?>
			<?php elseif ($curGroup['SettingGroup']['name'] == "Activity Feed Settings"):?>
				<?php echo $this->element("admin/setting_feed");?>
			<?php else: ?>
	            <div class="row" style="padding-top: 10px;">
	                <div class="col-md-12">
	                    <div class="tab-content">
	                        <div class="tab-pane active" id="portlet_tab1">
	                            <?php if($child_groups != null): $count=0;?>
	                                <?php foreach($child_groups as $child_group):
	                                    $count++;
	                                    $child_group = $child_group['SettingGroup'];
	                                ?>
	                                <a href="<?php echo $this->request->base?>/admin/settings/view/<?php echo $child_group['id'];?>">
	                                    <?php echo __d('setting', $child_group['name'])?>
	                                </a>
	                                <?php echo ($count < count($setting_groups)) ? '|' : '';?>
	                                <?php endforeach;?>
	                                <br/><br/>
	                            <?php endif;?>
	                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $this->request->base?>/admin/system_settings/quick_save">
	                                <div class="form-body">
	                                <?php if($settings != null):
	                                    foreach ($settings as $setting): 
	                                    $setting = $setting['Setting'];
	                                    if (in_array($setting['name'],array('version','link_version')))
	                                    	continue;
	                                ?>
	                                    <?php if($setting['name'] != 'logo' && $setting['name'] != 'logo_dark' && $setting['name'] != 'og_image' && $setting['name'] != 'favicon_image' &&  $setting['name'] != 'cover_desktop' && $setting['name'] != 'male_avatar' && $setting['name'] != 'female_avatar' && $setting['name'] != 'unknown_avatar' ):?>
	                                        <?php echo $this->Form->hidden('setting_id.', array('value' => $setting['id'], 'id' => false)); ?>
	                                        <?php echo $this->Form->hidden('type_id.'.$setting['id'], array('value' => $setting['type_id'], 'id' => false)); ?>
	                                    <?php endif; ?>	
	                                    <div class="form-group">
	                                        <label class="col-md-3 control-label">
	                                            <?php echo __d('setting',$setting['label']);?>
	                                            <?php
	                                                if($setting['description'] != ''):
	                                                    $href = "";
	                                                    $target = "";
	                                                    preg_match('/href="(.*)"/i',__d('setting',trim($setting['description'])),$match);
	                                                    preg_match('/target="(.*)"/i',__d('setting',trim($setting['description'])),$target);
	                                                    if(!empty($match))
	                                                        {
	                                                            $href = (strpos($match[1],'http')!== false) ? $match[1]:$this->request->base.$match[1];
	                                                        }
	                                                    if(!empty($target))
	                                                        $target = $target[1];
	                                            ?>
	                                                (<a data-html="true"  href="<?php echo (empty($href))?"javascript:void(0)":$href; ?>" <?php echo (empty($target))?"":'target="'.$target.'"' ?> class="tooltips" data-original-title="<?php echo (str_replace('"','\'',__d('setting',trim($setting['description']))));?>" data-placement="top">?</a>)
	                                            <?php endif;?>
	                                            <?php if($allow_modify):?>
	                                                <br/><?php echo $setting['name'];?>
	                                            <?php endif;?>
	                                        </label>
	                                        <div class="col-md-7">
	                                            <?php if($setting['name'] == 'logo' || $setting['name'] == 'logo_dark' || $setting['name'] == 'og_image' || $setting['name'] == 'favicon_image' || $setting['name'] == 'cover_desktop' || $setting['name'] == 'male_avatar' || $setting['name'] == 'female_avatar' || $setting['name'] == 'unknown_avatar'):?>
	                                                
	                                                <input type="file" name="<?php echo $setting['name'];?>">
	                                            <?php else:?>
	                                                <?php 
	                                                    switch($setting['type_id'])
	                                                    {
	                                                        case 'text':
	                                                            echo $this->Form->text('text.'.$setting['id'], array(
	                                                                    'value' => $setting['value_actual'],
	                                                                    'class' => 'form-control',
	                                                                    'label' => false
	                                                                ));
	                                                            break;
	                                                        case 'textarea':
	                                                            echo $this->Form->textarea('textarea.'.$setting['id'], array(
	                                                                    'value' => $setting['value_actual'],
	                                                                    'class' => 'form-control',
	                                                                    'label' => false
	                                                                ));
	                                                            break;
	                                                        case 'radio':
	                                                            $options = array();
	                                                            $checked = '';
	                                                            $multis = json_decode($setting['value_actual'], true);
	                                                            foreach($multis as $multi)
	                                                            {
	                                                                $options[$multi['value']] = __d('setting',$multi['name']);
	                                                                if($multi['select'] == 1)
	                                                                {
	                                                                    $checked = $multi['value'];
	                                                                }
	                                                            }
	                                                            echo $this->Form->radio('multi.'.$setting['id'], $options, array('separator' => '<br/>', 'value' => $checked, 'legend' => false, 'label' => array('class' => 'radio-setting')));
	
	                                                            break;
	                                                        case 'checkbox':
	                                                            $options = array();
	                                                            $checked = '';
	                                                            $multis = json_decode($setting['value_actual'], true);
	                                                            foreach($multis as $multi)
	                                                            {
	                                                                echo $this->Form->input('multi.'.$setting['id'].'.'.$multi['value'], array(
	                                                                    'type' => 'checkbox', 
	                                                                    'checked' => $multi['select'],
	                                                                    'label' => $multi['name'],
	                                                                    'id' => 'ch'.$setting['id'].$multi['value']
	                                                                ));
	                                                            }
	                                                            break;
	                                                        case 'select':
	                                                            $options = array();
	                                                            $selected = '';
	                                                            $multis = json_decode($setting['value_actual'], true);
	                                                            foreach($multis as $multi)
	                                                            {
	                                                                $options[$multi['value']] = __d('setting',$multi['name']);
	                                                                if($multi['select'] == 1)
	                                                                {
	                                                                    $selected = $multi['value'];
	                                                                }
	                                                            }
	                                                            echo $this->Form->input('multi.'.$setting['id'], array(
	                                                                'options' => $options,
	                                                                'value' => $selected,
	                                                                'class' => 'form-control',
	                                                                'label' => false
	                                                            ));
	                                                            break;
	                                                        case 'timezone':
	                                                            echo $this->Form->select('timezone.'.$setting['id'], $this->Moo->getTimeZones(), array(
	                                                                'value' => $setting['value_actual'], 
	                                                                'empty' => false, 
	                                                                'class' => 'form-control'
	                                                            )); 
	                                                            break;
	                                                        case 'language':
	                                                            echo $this->Form->select('language.'.$setting['id'], $site_langs, array(
	                                                                'value' => $setting['value_actual'], 
	                                                                'empty' => false, 
	                                                                'class' => 'form-control'
	                                                            )); 
	                                                            break;
	                                                    }
	                                                ?>
	                                            <?php endif;?>
	                                        </div>	                                        
	                                    </div>
	                                    <?php if($setting['name'] == 'logo'):?>
	                                            <?php if ( !empty($setting['value_actual']) ): ?>
	                                        <div class="clear"></div>
	                                        <div class="form-group">
	                                            <label class="col-md-3 control-label"><?php echo __('Current Logo');?></label>
	                                            <div class="col-md-7">
	                                                <img style="max-height: 100px;" src="<?php echo $this->Moo->logo();?>">
	                                            </div>
	                                        </div>
	                                            <?php endif; ?>
	                                                
	                                        <?php endif; ?>
	                                        
	                                     <?php if($setting['name'] == 'logo_dark'):?>
	                                            <?php if ( !empty($setting['value_actual']) ): ?>
	                                        <div class="clear"></div>
	                                        <div class="form-group">
	                                            <label class="col-md-3 control-label"><?php echo __('Current Logo Dark Mode');?></label>
	                                            <div class="col-md-7">
	                                                <img style="max-height: 100px;" src="<?php echo $this->Moo->logoDark();?>">
	                                            </div>
	                                        </div>
	                                            <?php endif; ?>
	                                                
	                                        <?php endif; ?>

										<?php if($setting['name'] == 'og_image'):?>
											<?php if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo __('Current Og Image');?></label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->ogImage();?>">
													</div>
												</div>
											<?php endif; ?>
										<?php endif; ?>
										<?php if($setting['name'] == 'favicon_image'):?>
											<?php if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo __('Current Favicon Image');?></label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->faviconImage();?>">
													</div>
												</div>
											<?php endif; ?>
										<?php endif; ?>

										<?php if($setting['name'] == 'cover_desktop'):?>
											<?php //if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo __('Current Desktop Cover photo');?>
                                                                                                            <div class="tips">
                                                                                                                <?php echo  __('We recommend using image with resolution 1165x305 for desktop cover photo') ?>
                                                                                                            </div>
                                                                                                        </label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->defaultCoverUrl();?>">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label"></label>
													<div class="col-md-7">
                                                                                                            <a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to reset image to default ?')?>', '<?php echo  $this->request->base ?>/admin/system_settings/reset_image_default/<?php echo  $setting['id'] ?>')"><?php echo __('Reset to default');?></a>
													</div>
												</div>
											<?php //endif; ?>
										<?php endif; ?>
										<?php if($setting['name'] == 'male_avatar'):?>
											<?php //if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label">
                                                                                                            <?php echo __('Current Male Avatar');?>
                                                                                                            <div class="tips">
                                                                                                                <?php echo  __('We recommend using image with resolution 300x300 for avatar ') ?>
                                                                                                            </div>
                                                                                                        </label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->defaultAvatar("male");?>">
													</div>
												</div>
                                                                                                <div class="form-group">
                                                                                                            <label class="col-md-3 control-label"></label>
                                                                                                            <div class="col-md-7">
                                                                                                                <a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to reset image to default ?')?>', '<?php echo  $this->request->base ?>/admin/system_settings/reset_image_default/<?php echo  $setting['id'] ?>')"><?php echo __('Reset to default');?></a>
                                                                                                            </div>
                                                                                                        </div>
											<?php //endif; ?>
										<?php endif; ?>
										<?php if($setting['name'] == 'female_avatar'):?>
											<?php //if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo __('Current Female Avatar');?>
                                                                                                            <div class="tips">
                                                                                                                <?php echo  __('We recommend using image with resolution 300x300 for avatar ') ?>
                                                                                                            </div>
                                                                                                        </label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->defaultAvatar("female");?>">
													</div>
												</div>
                                                                                                <div class="form-group">
                                                                                                            <label class="col-md-3 control-label"></label>
                                                                                                            <div class="col-md-7">
                                                                                                                <a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to reset image to default ?')?>', '<?php echo  $this->request->base ?>/admin/system_settings/reset_image_default/<?php echo  $setting['id'] ?>')"><?php echo __('Reset to default');?></a>
                                                                                                            </div>
                                                                                                        </div>
											<?php //endif; ?>
										<?php endif; ?>
										<?php if($setting['name'] == 'unknown_avatar'):?>
											<?php //if ( !empty($setting['value_actual']) ): ?>
												<div class="clear"></div>
												<div class="form-group">
													<label class="col-md-3 control-label"><?php echo __('Current Unspecified Gender Avatar');?>
                                                                                                            <div class="tips">
                                                                                                                <?php echo  __('We recommend using image with resolution 300x300 for avatar ') ?>
                                                                                                            </div>
                                                                                                        </label>
													<div class="col-md-7">
														<img style="max-height: 100px;" src="<?php echo $this->Moo->defaultAvatar("unknown");?>">
													</div>
												</div>
                                                                                                <div class="form-group">
                                                                                                            <label class="col-md-3 control-label"></label>
                                                                                                            <div class="col-md-7">
                                                                                                                <a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to reset image to default ?')?>', '<?php echo  $this->request->base ?>/admin/system_settings/reset_image_default/<?php echo  $setting['id'] ?>')"><?php echo __('Reset to default');?></a>
                                                                                                            </div>
                                                                                                        </div>
											<?php //endif; ?>
										<?php endif; ?>
	                                <?php endforeach;?>
	                                </div>
	                                <div class="form-actions">
	                                    <div class="row">
	                                        <div class="col-md-offset-3 col-md-9">
	                                            <input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Settings');?>">
	                                        </div>
	                                    </div>
	                                </div>
	                                <?php else: ?>
	                                    <?php echo __('No settings found');?>
	                                <?php endif;?>
	                            </form>
	                        </div>
	                    </div>
	                </div>
	            </div>
            <?php endif;?>
        </div>
    </div>
</div>