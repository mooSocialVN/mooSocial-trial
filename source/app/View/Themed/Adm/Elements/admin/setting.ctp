<?php if($setting_groups != null && count($setting_groups) > 1): $count=0;?>
    <?php foreach($setting_groups as $setting_group):
        $count++;
        $setting_group = $setting_group['SettingGroup'];
    ?>
        <a href="<?php echo $this->request->base?>/admin/subscription/settings/index/<?php echo $setting_group['id'];?>">
            <span <?php echo ($acive_group == $setting_group['id']) ? 'class="bold"' : ''?>><?php echo $setting_group['name'];?></span>
        </a>
        <?php echo ($count < count($setting_groups)) ? '|' : '';?>
    <?php endforeach;?>
    <br/><br/>
<?php endif;?>
<?php if($settingGuides != null):?>
    <?php foreach($settingGuides as $settingGuide):?>
        <?php if($settingGuide != ''):?>
        <div class="Metronic-alerts alert alert-warning fade in" style="max-height: 300px;overflow: auto">
            <?php echo $settingGuide;?>
        </div>
        <?php endif;?>
    <?php endforeach;?>
<?php endif;?>
<form class="form-horizontal intergration-setting" method="post" enctype="multipart/form-data" action="<?php echo $this->request->base?>/admin/system_settings/quick_save">
    <div class="form-body">
    <?php if(isset($url_redirect)){ ?><input type="hidden" name="url_redirect" value="<?php echo $url_redirect; ?>"><?php }?>
    <?php if($settings != null):
        foreach ($settings as $setting):
		$plugin = Inflector::underscore($setting['SettingGroup']['module_id']);
        $setting = $setting['Setting'];
		
        $setting['label'] = $this->MooTranslate->translateText($setting['label'],$plugin,'setting');		

		if ($setting['description'])
		{
			$setting['description'] = $this->MooTranslate->translateText($setting['description'],$plugin,'setting');
		}
    ?>

        <?php echo $this->Form->hidden('setting_id.', array('value' => $setting['id'], 'id' => false)); ?>
        <?php echo $this->Form->hidden('type_id.'.$setting['id'], array('value' => $setting['type_id'], 'id' => false)); ?>
        <div class="form-group">
            <label class="col-md-3 control-label">
                <?php
					echo $setting['label'];
				?>
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
						(<a data-html="true"  href="<?php echo (empty($href))?"javascript:void(0)":$href; ?>" <?php echo (empty($target))?"":'target="'.$target.'"' ?> class="tooltips" data-original-title="<?php echo (str_replace('"','\'',trim($setting['description'])));?>" data-placement="top">?</a>)
					<?php endif;?>
                <?php if(Configure::read('core.production_mode')):?>
                    <br/><?php echo $setting['name'];?>
                <?php endif;?>
            </label>
            <div class="col-md-7">
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
								$options[$multi['value']] = $this->MooTranslate->translateText($multi['name'],$plugin,'setting');
								
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
                                                                'label' => $this->MooTranslate->translateText($multi['name'],$plugin,'setting'),
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
								$options[$multi['value']] = $this->MooTranslate->translateText($multi['name'],$plugin,'setting');
								
								if($multi['select'] == 1)
								{
									$selected = $multi['value'];
								}
							}
                            $readonly = '';
                            if($setting['name'] == 'facebook_sdk_version')
                            {
                                $readonly = 'readonly';
                            }
							echo $this->Form->input('multi.'.$setting['id'], array(
								'options' => $options,
								'value' => $selected,
								'class' => 'form-control',
								'label' => false,
                                $readonly
							));
                            if($readonly != '')
                                $this->Form->hidden('multi.'.$setting['id'], array(
                                    'options' => $options,
                                    'value' => $selected,
                                    'class' => 'form-control',
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
            </div>
            <?php if(Configure::read('core.production_mode')):?>           
            <?php endif;?>
        </div>
    <?php endforeach;?>
    </div>
    <div class="form-actions">
        <div class="row">
            <?php if(!isset($isShowNextButton)): ?>
                <div class="col-md-offset-3 col-md-9">
                    <input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Settings');?>">
                </div>
            <?php else:?>
                <div class="col-md-offset-11 col-md-12">
                    <input type="submit" class="btn btn-circle btn-action " value="<?php echo __('Next'); ?>">
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php else: ?>
        <?php echo __('No settings found');?>
    <?php endif;?>
</form>