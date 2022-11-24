<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb('Site Manager');
$this->Html->addCrumb('Plugin Settings Manager', array('controller' => 'pluginsettings', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "pluginsettings"));
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

<a href="<?php echo $this->request->base?>/admin/pluginsettings/create" class="btn green btn_create_theme">
    <i class="fa fa-plus"></i> Create New Setting
</a>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Managed Plugin Settings
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Key</th>
                <th data-hide="phone">Version</th>
                <th data-hide="phone">Settings</th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($plugins as $plugin): ?>
                <tr id="<?php echo $plugin['Plugin']['id']?>" class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <td><?php echo $plugin['Plugin']['id']?></td>
                    <td><i class="<?php echo $plugin['Plugin']['icon_class']?> icon-small"></i> <a href="<?php echo $this->request->base?>/admin/plugins/ajax_view/<?php echo $plugin['Plugin']['id']?>" data-target="#ajax" data-toggle="modal" title="<?php echo h($plugin['Plugin']['name'])?> Plugin"><?php echo h($plugin['Plugin']['name'])?></a></td>
                    <td class="reorder"><?php echo $plugin['Plugin']['key']?></td>
                    <td class="reorder"><?php echo $plugin['Plugin']['version']?></td>
                    <td class="reorder">
                        <a href="<?php echo $this->request->base?>/admin/pluginsettings/view/<?php echo $plugin['Plugin']['id']?>">View</a>
                    </td>
                </tr>
            <?php endforeach ?>

            </tbody>
        </table>
    </div>
</div>
