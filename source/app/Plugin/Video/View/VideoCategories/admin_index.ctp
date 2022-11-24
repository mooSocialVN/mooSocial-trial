<?php
//echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
//echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->Html->addCrumb(__('Plugins Manager'), '/admin/plugins');
$this->Html->addCrumb(__('Video Categories'), array('controller' => 'video_categories', 'action' => 'admin_index'));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array('cmenu' => 'Video'));
$this->end();
?>
<?php echo $this->Moo->renderMenu('Video', __('Categories'));?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
    Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});

function save_order()
{
    var list={};
    $('input[name="data[weight]"]').each(function(index,value){
        list[$(value).data('id')] = $(value).val();
    })
    
    jQuery.post("<?php echo $this->request->base?>/admin/categories/save_order/",{cats:list},function(data){
        window.location = data;
    });
}
<?php $this->Html->scriptEnd(); ?>

<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base?>/admin/video/video_categories/create/">
                        <?php echo __('Add New');?>
                    </button>
                    <button style="margin-left: 10px" class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo  $this->request->base ?>/admin/categories/import/Video">
                        <?php echo __('Import categories');?>
                    </button>
                    <a style="margin-left: 10px" onclick="save_order()" class="btn btn-gray" >
                        <?php echo __('Save order');?>
                    </a>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>


    <table class="table table-striped table-bordered table-hover" id="sample_1">
        <thead>
        <tr class="tbl_head">
            <th width="50px"><?php echo __('ID');?></th>
            <th><?php echo __('Name');?></th>
            <th width="50px"><?php echo __('Order');?></th>
            <th width="50px"><?php echo __('Type');?></th>
            <th data-hide="phone"><?php echo __('Parent');?></th>
            <th width="50px" data-hide="phone"><?php echo __('Header');?></th>
            <th width="50px" data-hide="phone"><?php echo __('Active');?></th>
            <th width="50px" data-hide="phone"><?php echo __('Count');?></th>
            <th width="50px" data-hide="phone"><?php echo __('Actions');?></th>
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
                                            'Video'
                                        )),
             'title' => $category['Category']['name'],
             'innerHtml'=> ($category['Category']['header']) ? "<strong>" . $category['Category']['name'] . "</strong>" : $category['Category']['name'],
             'target' => 'ajax'
     ));
 ?>
                   </td>
                <td width="50px" class="reorder"><input data-id="<?php echo $category['Category']['id']?>" style="width:50px" type="text" name="data[weight]" value="<?php echo $category['Category']['weight']?>" /> </td>
                <td width="50px" class="reorder"><?php echo $category['Category']['type']?></td>
                <td class="reorder"><?php if ( !empty($category['Parent']['name']) ) echo $category['Parent']['name']; else echo 'ROOT';?></td>
                <td width="50px" class="reorder"><?php echo ($category['Category']['header']) ? 'Yes' : 'No'?></td>
                <td width="50px" class="reorder"><?php echo ($category['Category']['active']) ? 'Yes' : 'No'?></td>
                <td width="50px" class="reorder"><?php echo $category['Category']['item_count']?></td>
                <?php if($category['Category']['header']): ?>
                <td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this category? All parent of sub-category it will also be changed to ROOT. This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/categories/delete/<?php echo $category['Category']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
                <?php else: ?>
                <td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this category? All the items within it will also be deleted. This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/categories/delete/<?php echo $category['Category']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>

</div>
