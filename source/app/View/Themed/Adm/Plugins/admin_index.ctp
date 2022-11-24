<?php

$this->Html->addCrumb(__('Plugins Manager'), array('controller' => 'plugins', 'action' => 'admin_index'));
echo $this->Html->css(array('plugin-site'), null, array('inline' => false));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "plugins"));
$this->end();

$array_plugin_no_show = array('PaymentGateway','Minify','MooUpload');
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).on('loaded.bs.modal', function (e) {
        Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
$("body").on("click","a.not-active",function(e){
    e.preventDefault();
    //return false;
})


<?php $this->Html->scriptEnd(); ?>

    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button href="<?php echo $this->request->base?>/admin/plugins/ajax_create" class="btn btn-gray" data-target="#ajax" data-toggle="modal">
                           <?php echo __('Create New Plugin');?>
                        </button>
                    </div>

                </div>

            </div>

        </div>
        <div class=" portlet-tabs">
            <div class="tabbable tabbable-custom boxless tabbable-reversed">

                <ul class="nav nav-tabs list7 chart-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab">
                            <?php echo __('Installed Plugins');?> </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab">
                            <?php echo __('Not Installed Plugins');?> </a>
                    </li>

                    <li>
                        <a href="#portlet_tab3" data-toggle="tab">
                            <?php echo __('Buy Plugins');?> </a>
                    </li>
                </ul>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                    <tr class="tbl_head">
                                        <th><?php echo __('Name');?></th>
                                        <th style="width: 15%"><?php echo __('Key');?></th>
                                        <th style="width: 12%"><?php echo __('Version');?></th>
                                        <?php if (Configure::read('core.production_mode') == 2): ?>
                                        <th style="width: 8%"><?php echo __('Bootstrap');?></th>
                                        <th style="width: 8%"><?php echo __('Routes');?></th>
                                        <th style="width: 8%"><?php echo __('Enabled');?></th>
                                        <?php endif; ?>
                                        <th style="width: 8%"><?php echo __('Actions');?></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $count = 0;
                                        foreach ($plugins as $key => $plugin):
                                            $plugin = $plugin['Plugin'];
                                            $disabled = '';
                                            $disable_router = '';
                                            if($plugin['core'])
                                                $disabled = 'not-active';
                                            $disable_router = (in_array($plugin['key'],array('SocialIntegration','Mail','Cron','Menu','Billing')))? 'not-active' : '';
                                    ?>
                                        <?php if(!in_array($plugin['key'],$array_plugin_no_show)): ?>
                                        <tr id="<?php echo $plugin['id']?>" class="gradeX <?php if ( $plugin['core'] ): ?>highlight<?php endif; ?>">
                                            <td class="reorder"><i class="<?php echo $plugin['icon_class']?> icon-small"></i> <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "plugins",
                                            "action" => "admin_ajax_view",
                                            "plugin" => false,
                                            $plugin['id']
                                            
                                        )),
             'title' => h($plugin['name']),
             'innerHtml'=> h($plugin['name']),
     ));
 ?> </td>
                                            <td class="reorder"><?php echo $plugin['key']?></td>
                                            <td class="reorder">
                                                <?php echo $plugin['version']?>
                                                <?php if($plugin['new_version']):?>
                                                <b style="color: red">(<?php echo __('New');?> <?php echo $plugin['new_version_number']?>)</b>
                                                <?php endif;?>
                                            </td>

                                            <?php if (Configure::read('core.production_mode') == 2): ?>
                                            <td class="reorder">
                                                    <?php if ( $plugin['bootstrap'] ): ?>
                                                        <a class="<?php echo  $disabled; ?>" href="<?php echo $this->request->base?>/admin/plugins/bootstrap_off/<?php echo $plugin['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                    <?php else: ?>
                                                        <a class="<?php echo  $disabled; ?>" href="<?php echo $this->request->base?>/admin/plugins/bootstrap_on/<?php echo $plugin['id']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                    <?php endif; ?>
                                            </td>
                                            <td class="reorder">
                                                    <?php if ( $plugin['routes'] ): ?>
                                                        <a class="<?php echo  $disabled; ?>" href="<?php echo $this->request->base?>/admin/plugins/routes_off/<?php echo $plugin['id']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                    <?php else: ?>
                                                        <a class="<?php echo  $disabled; ?>" href="<?php echo $this->request->base?>/admin/plugins/routes_on/<?php echo $plugin['id']?>"><i class="fa fa-times-circle" title=<?php echo __('Enable');?>></i></a>&nbsp;
                                                    <?php endif; ?>
                                            </td>
                                            <td class="reorder">
                                                    <?php if ( $plugin['enabled'] ): ?>
                                                        <a class="<?php echo  $disable_router; ?>" href="<?php echo $this->request->base?>/admin/plugins/do_disable/<?php echo $plugin['key']?>"><i class="fa fa-check-square-o " title="<?php echo __('Disable');?>"></i></a>&nbsp;
                                                    <?php else: ?>
                                                        <a class="<?php echo  $disable_router; ?>" href="<?php echo $this->request->base?>/admin/plugins/do_enable/<?php echo $plugin['key']?>"><i class="fa fa-times-circle" title="<?php echo __('Enable');?>"></i></a>&nbsp;
                                                    <?php endif; ?>
                                            </td>
                                            <?php endif; ?>
                                            <td>
                                                
                                                <a href="<?php echo $this->request->base?>/admin/<?php echo  $plugin_setting_url[$key] ?>/<?php echo  $plugin_setting_url[$key] ?>_settings">
                                                    <i class="fa fa-cog" title="<?php echo __('Settings');?>"></i>
                                                </a>&nbsp;
                                                    
                                                    <?php if(!$plugin['core']):  ?>
                                                    <a class="" href="<?php echo $this->request->base?>/admin/plugins/do_uninstall/<?php echo $plugin['id']?>" <?php if($disabled != 'not-active'): ?> onclick="return confirm('<?php echo addslashes(__('Are you sure?'));?>')" <?php endif; ?>>
                                                        <i class="fa fa-trash-o" title="<?php echo __('Uninstall');?>"></i>
                                                    </a>&nbsp;
                                                    <?php endif; ?>
                                                    
                                                    <a href="<?php echo $this->request->base?>/admin/plugins/do_download/<?php echo $plugin['key']?>" target="_blank">
                                                        <i class="fa fa-download" title="<?php echo __('Download');?>"></i>
                                                    </a>&nbsp;
                                                    <?php if($plugin['new_version']):?>
                                                        <a href="<?php echo $this->request->base?>/admin/plugins/do_upgrade/<?php echo $plugin['id']?>">
                                                            <i class="fa fa-level-up" title="<?php echo __('Upgrade version');?> <?php echo $plugin['new_version_number']?>"></i>
                                                        </a>
                                                    <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="portlet_tab2">
                                <ul class="list-group">
                                    <?php foreach ($not_installed_plugins as $plugin): ?>
                                        <li class="list-group-item">
                                            <div class="plugin-info" style="display: inline-block; width: 50%">
                                            <?php echo $plugin['name']?><br/>
                                            <?php if(!empty($plugin['version'])): ?>
                                                <?php echo  __('Version').': '.$plugin['version'];?><br/>
                                            <?php endif; ?>
                                            <?php if(!empty($plugin['author'])): ?>
                                                <?php echo  __('Author').': '.$plugin['author']?>
                                            <?php endif; ?>
                                            </div>
                                            <span class="badge badge-success">

                                                <a href="<?php echo $this->request->base?>/admin/plugins/do_install/<?php echo $plugin['name']?>" style="color:#fff;"><?php echo  __('Install');?></a>
                                            </span>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                            <div class="tab-pane" id="portlet_tab3">
                                <div class="row">
                                    <div id="plugin_list">

                                    </div>
                                </div>
                                <?php $this->Html->scriptStart(array('inline' => false)); ?>
                                    $.ajax({url: "<?php echo $this->request->base?>/admin/plugin_site/list", success: function(result){
                                        $("#plugin_list").html(result);
                                    }});
                                <?php $this->Html->scriptEnd(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

