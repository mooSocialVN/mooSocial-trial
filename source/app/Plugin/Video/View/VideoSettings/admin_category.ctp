<?php
//echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
//echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array('cmenu' => 'Video'));
$this->end();
?>
<?php echo $this->Moo->renderMenu('Video', __('Categories'));?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
jQuery(document).ready(function(){
    jQuery( "#sample_1" ).sortable( {
        items: "tr:not(.tbl_head)",
        handle: ".reorder",
        update: function(event, ui) {
        var list = jQuery('#sample_1').sortable('toArray');
        jQuery.post('<?php echo $this->request->base?>/admin/categories/ajax_reorder', { cats: list });
        }
    });
});
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
    Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

<?php $this->Html->scriptEnd(); ?>
<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base?>/admin/categories/ajax_create/0/<?php echo  'Video'; ?>">
                        Add New
                    </button>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>


    <table class="table table-striped table-bordered table-hover" id="sample_1">
        <thead>
        <tr class="tbl_head">
            <th width="50px">ID</th>
            <th>Name</th>
            <th width="50px">Type</th>
            <th data-hide="phone">Parent</th>
            <th width="50px" data-hide="phone">Header</th>
            <th width="50px" data-hide="phone">Active</th>
            <th width="50px" data-hide="phone">Count</th>
            <th width="50px" data-hide="phone">Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php $count = 0;
        foreach ($categories as $category): ?>
            <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>" id="<?php echo $category['Category']['id']?>">
                <td width="50px"><?php echo $category['Category']['id']?></td>
                <td class="reorder">
                    <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "categories",
                                            "action" => "admin_ajax_create",
                                            "plugin" => false,
                                            $category['Category']['id'],
                                            'Video',
                                        )),
             'title' => $category['Category']['name'],
             'innerHtml'=> ($category['Category']['header']) ? "<strong>" . $category['Category']['name'] . "</strong>"  : $category['Category']['name'],
     ));
 ?>
                   </td>
                <td width="50px" class="reorder"><?php echo $category['Category']['type']?></td>
                <td class="reorder"><?php if ( !empty($category['Parent']['name']) ) echo $category['Parent']['name']; else echo 'ROOT';?></td>
                <td width="50px" class="reorder"><?php echo ($category['Category']['header']) ? 'Yes' : 'No'?></td>
                <td width="50px" class="reorder"><?php echo ($category['Category']['active']) ? 'Yes' : 'No'?></td>
                <td width="50px" class="reorder"><?php echo $category['Category']['item_count']?></td>
                <td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this category? All parent of sub-category it will also be changed to ROOT. All items of this category will be deleted too. This cannot be undone!!')) ?>', '<?php echo $this->request->base?>/admin/categories/delete/<?php echo $category['Category']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>

</div>
