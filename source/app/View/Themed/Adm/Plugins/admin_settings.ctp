<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Plugins Settings'), array('controller' => 'plugins', 'action' => 'admin_settings'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "plugins_settings"));
$this->end();
?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
$(e.target).removeData('bs.modal');
});



jQuery(document).ready(function(){
jQuery( ".mooTable" ).sortable( {
items: "tr:not(.tbl_head)",
handle: ".reorder",
update: function(event, ui) {
var list = jQuery('.mooTable').sortable('toArray');
jQuery.post('<?php echo $this->request->base?>/admin/plugins/ajax_reorder', { plugins: list });
}
});


});
<?php $this->Html->scriptEnd(); ?>

<div class="portlet box blue tabbable">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i><?php echo __('Plugins Setting');?>
        </div>
    </div>
    <div class="portlet-body">
        <div class=" portlet-tabs">
            <div class="tab-content">
                <div class="tab-pane active" id="portlet_tab1">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th><?php echo __('ID');?></th>
                            <th><?php echo __('Name');?></th>
                            <th><?php echo __('Key');?></th>
                            <th data-hide="phone"><?php echo __('Version');?></th>
                            <th data-hide="phone"><?php echo __('Menu');?></th>
                            <th data-hide="phone"><?php echo __('Bootstrap');?></th>
                            <th data-hide="phone"><?php echo __('Routes');?></th>
                            <th data-hide="phone"><?php echo __('Enabled');?></th>
                            <th data-hide="phone"><?php echo __('Actions');?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $count = 0;
                        foreach ($plugins as $plugin):
                            $plugin = $plugin['Plugin'];
                            ?>
                            <tr id="<?php echo $plugin['id']?>" class="gradeX <?php if ( $plugin['core'] ): ?>highlight<?php endif; ?>">
                                <td><?php echo $plugin['id']?></td>
                                <td><i class="<?php echo $plugin['icon_class']?> icon-small"></i> <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "plugins",
                                            "action" => "admin_ajax_view",
                                            "plugin" => false,
                                            $plugin['id']
                                           
                                        )),
             'title' => h($plugin['name']),
             'innerHtml'=> h($plugin['name']),
     ));
 ?></td>
                                <td class="reorder"><?php echo $plugin['key']?></td>
                                <td class="reorder"><?php echo $plugin['version']?></td>
                                <td class="reorder"><?php echo ($plugin['menu'])?'Yes':'No'?></td>
                                <td class="reorder">
                                    <?php if ( !$plugin['core'] ): ?>
                                        <?php if ( $plugin['bootstrap'] ): ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/bootstrap_off/<?php echo $plugin['id']?>"><i class="fa fa-check-square-o " title="Disable"></i></a>&nbsp;
                                        <?php else: ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/bootstrap_on/<?php echo $plugin['id']?>"><i class="fa fa-times-circle" title="Enable"></i></a>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="reorder">
                                    <?php if ( !$plugin['core'] ): ?>
                                        <?php if ( $plugin['routes'] ): ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/routes_off/<?php echo $plugin['id']?>"><i class="fa fa-check-square-o " title="Disable"></i></a>&nbsp;
                                        <?php else: ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/routes_on/<?php echo $plugin['id']?>"><i class="fa fa-times-circle" title="Enable"></i></a>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="reorder">
                                    <?php if ( !$plugin['core'] ): ?>
                                        <?php if ( $plugin['enabled'] ): ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/do_disable/<?php echo $plugin['id']?>"><i class="fa fa-check-square-o " title="Disable"></i></a>&nbsp;
                                        <?php else: ?>
                                            <a href="<?php echo $this->request->base?>/admin/plugins/do_enable/<?php echo $plugin['id']?>"><i class="fa fa-times-circle" title="Enable"></i></a>&nbsp;
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ( !$plugin['core'] ): ?>
                                        <a href="<?php echo $this->request->base?>/admin/plugins/do_uninstall/<?php echo $plugin['id']?>" onclick="return confirm(addslashes(__('Are you sure?')))"><i class="fa fa-trash-o" title="Uninstall"></i></a>&nbsp;
                                        <a href="<?php echo $this->request->base?>/admin/plugins/do_download/<?php echo $plugin['key']?>" target="_blank"><i class="fa fa-download" title="Download"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="portlet_tab2">
                    <ul class="list-group">
                        <?php foreach ($not_installed_plugins as $plugin): ?>
                            <li class="list-group-item"><?php echo $plugin?>
                                <span class="badge badge-success">

                                    <a href="<?php echo $this->request->base?>/admin/plugins/do_install/<?php echo $plugin?>" style="color:#fff;">Install</a>
                                </span>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
