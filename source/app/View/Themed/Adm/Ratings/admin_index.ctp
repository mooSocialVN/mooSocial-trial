<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min','token-input'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable','jquery.tokeninput'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Rating Manager'), array('controller' => 'ratings', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "ratings"));
$this->end();
?>
<div class="portlet-body form systemSetting">
    <div class=" portlet-tabs">
        <div class="tabbable tabbable-custom boxless tabbable-reversed">


            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">

                            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $this->request->base?>/admin/ratings/quick_save">
                                <div class="form-body">
                                    <?php foreach($settings as &$setting): ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">
                                            <?php echo $setting['RatingSetting']['label']; ?>
                                        </label>
                                        <div class="col-md-7">
                                            <?php
                                            if($setting['RatingSetting']['name'] == 'enable_rating'):
                                                $listItem = json_decode($setting['RatingSetting']['value'],true);

                                                $event = new CakeEvent('View.Adm.Layout.adminGetContentInfo',$this);
                                                $result = $this->getEventManager()->dispatch($event);
                                                if(!empty($result->result['rating']['enable']) && is_array($result->result['rating']['enable']) ){
                                                    $listItem = array_merge($result->result['rating']['enable'],$listItem);
                                                }

                                                foreach($listItem as $name => &$value): ?>
                                                <?php
                                                    $checked = ($value == 1)? 'checked':null;
                                                    echo $this->Form->input('enable_rating['.$name.']',array(
                                                            'type' => $setting['RatingSetting']['type'],
                                                            $checked,
                                                            'id' => 'rating_setting_'.$name,
                                                            'label' => ($name == 'users')?'profiles':$name,
                                                            'name' => 'data['.$setting['RatingSetting']['id'].'][enable_rating]['.$name.']'
                                                        ));
                                                ?>
                                                <?php endforeach;?>
                                            <?php else: ?>
                                                <?php
                                                $checked = null;
                                                $name = null;
                                                if($setting['RatingSetting']['type'] == 'checkbox' && !empty($setting['RatingSetting']['value'])){
                                                    $checked = 'checked';
                                                    $value = null;
                                                }
                                                $options = array(
                                                    'type' => $setting['RatingSetting']['type'],
                                                    $checked,
                                                    'id' => 'rating_setting_'.$setting['RatingSetting']['id'],
                                                    'value' => $setting['RatingSetting']['value'],
                                                    'label' => false
                                                );
                                                if($setting['RatingSetting']['type'] == 'checkbox')
                                                    unset($options['value']);
                                                ?>
                                                <?php
                                                if($setting['RatingSetting']['name'] == 'skin'){
                                                    $new_options = array(
                                                        'type' => 'file',
                                                        'id' => 'rating_setting_new_skin',
                                                        'label' => false,
                                                        'name' => 'data['.$setting['RatingSetting']['id'].'][new_skin]'
                                                    );
                                                    $options['name']  = 'data['.$setting['RatingSetting']['id'].'][input_value]';
                                                    echo $this->Form->input($setting['RatingSetting']['id'],$options);
                                                    echo $this->Form->input($setting['RatingSetting']['id'],$new_options);
                                                }else{
                                                    echo $this->Form->input($setting['RatingSetting']['id'],$options);
                                                }
                                                ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <input type="submit" class="btn btn-circle btn-action" value="<?php echo __('Save Settings');?>">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>