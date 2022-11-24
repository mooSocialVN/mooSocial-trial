<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Setting Groups Manager'), array('controller' => 'setting_groups', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "settinggroups"));
$this->end();
?>

<a href="<?php echo $this->request->base?>/admin/settinggroups/create" class="btn green btn_create_theme" data-toggle="modal">
    <i class="fa fa-plus"></i> <?php echo __('Create Setting Group');?>
</a>

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i><?php echo __('Managed Setting Groups');?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="">
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <th><?php echo __('Name');?></th>
                    <th width="90"><?php echo __('Actions');?></th>
                </tr>
                </thead>
                <tbody>

                <?php $count = 0;
                foreach ($setting_groups as $setting_group): 
                    $child_groups = $setting_group['children'];
                    $setting_group = $setting_group['SettingGroup'];
                ?>
                    <tr id="<?php echo $setting_group['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                        <td class="reorder"><?php echo $setting_group['name']?></td>
                        <td>
                            <a href="<?php echo $this->request->base?>/admin/settinggroups/create/<?php echo $setting_group['id']?>"><?php echo __('Edit');?></a>
                            <?php if($setting_group['group_type'] != 'core'):?>
                            |
                            <a href="<?php echo $this->request->base?>/admin/settinggroups/delete/<?php echo $setting_group['id']?>" onclick="return confirm('<?php echo addslashes(__('Are you sure?'));?>')"><?php echo __('Delete');?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php foreach($child_groups as $child_group):
                          $child_group = $child_group['SettingGroup'];
                    ?>
                    <tr id="<?php echo $child_group['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                        <td class="reorder">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|----<?php echo $child_group['name']?></td>
                        <td>
                            <a href="<?php echo $this->request->base?>/admin/settinggroups/create/<?php echo $child_group['id']?>"><?php echo __('Edit');?></a>
                            <?php if($child_group['group_type'] != 'core'):?>
                            |
                            <a href="<?php echo $this->request->base?>/admin/settinggroups/delete/<?php echo $child_group['id']?>" onclick="return confirm('<?php echo addslashes(__('Are you sure?'));?>')"><?php echo __('Delete');?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
