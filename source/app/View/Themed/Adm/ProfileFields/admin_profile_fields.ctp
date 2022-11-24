<?php
//echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
//echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Profile Types Manager'), array('controller' => 'profile_fields', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Profile Fields Manager'), array('controller' => 'profile_fields', 'action' => 'admin_profile_fields',$id));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "profile_fields"));
$this->end();
?>
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
$('input[name="data[order]"]').each(function(index,value){
list[$(value).data('id')] = $(value).val();
});
//console.log(list);
jQuery.post("<?php echo $this->request->base ?>/admin/profile_fields/ajax_reorder",{order:list},function(data){
window.location = data;
});
}
<?php $this->Html->scriptEnd(); ?>

<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <?php
                    $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "profile_fields",
                                "action" => "admin_ajax_create",
                                "plugin" => false,

                            )). '/'.$id,
                        'title' => __('Add New Field'),
                        'innerHtml'=> __('Add New Field'),
                        'class' => 'btn btn-gray',
                        'target' => 'ajax'
                    ));
                    ?>
                    <a style="margin-left: 10px" onclick="save_order()" class="btn btn-gray" >
                        <?php echo __('Save order'); ?>
                    </a>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding-top: 5px;">
                <div class="note note-info hide">

                    <p>
                        <?php echo __('You can enable Spam Challenge to force user to answer a challenge question in order to register.');?> <br/>
                        <?php echo __('To enable this feature, click System Settings -> Security -> Enable Spam Challenge');?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php echo __('Profile type');?>: <?php echo $profile_type['ProfileType']['name'];?>
    </div>
    <br>

    <table class="table table-striped table-bordered table-hover" id="sample_1">
        <thead>
        <tr class="tbl_head">
            <th width="50px"><?php echo  __('ID');?></th>
            <th width="250px"><?php echo  __('Name');?></th>
            <th width="50px"><?php echo  __('Type');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Required');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Registration');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Searchable');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Profile');?></th>
            <th width="100px" data-hide="phone"><?php echo  __('Hide from info tab');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Active');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Order');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Actions');?></th>
        </tr>
        </thead>
        <tbody>

        <?php $count = 0;
        foreach ($fields as $field): ?>
            <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>" id="<?php echo $field['ProfileField']['id']?>">
                <td width="50px"><?php echo $field['ProfileField']['id']?></td>
                <td width="250px" class="reorder">
                    <a id="" href="<?php echo $this->base?>/admin/profile_fields/ajax_create/<?php echo $id;?>/<?php echo $field['ProfileField']['id'];?>" data-target="#ajax" data-toggle="modal" class="" title="<?php echo $field['ProfileField']['name'];?>" data-dismiss="" data-backdrop="true" style=""><?php echo $field['ProfileField']['name'];?></a>
                </td>
                <td width="50px" class="reorder"><?php echo $field['ProfileField']['type']?></td>
                <td width="50px" class="reorder"><?php echo ($field['ProfileField']['required']) ? __('Yes') : __('No')?></td>
                <td width="50px" class="reorder"><?php echo ($field['ProfileField']['registration']) ? __('Yes') : __('No')?></td>
                <td width="50px" class="reorder"><?php echo ($field['ProfileField']['searchable']) ? __('Yes') : __('No')?></td>
                <td width="50px" class="reorder"><?php echo ($field['ProfileField']['profile']) ? __('Yes') : __('No')?></td>
                <td width="100px" class="reorder"><?php echo ($field['ProfileField']['hide_from_info_tab']) ? __('Yes') : __('No')?></td>
                <td width="50px" class="reorder"><?php echo ($field['ProfileField']['active']) ? __('Yes') : __('No')?></td>
                <td width="50px" class="reorder"><input data-id="<?php echo $field['ProfileField']['id'] ?>" style="width:50px" type="text" name="data[order]" value="<?php echo $field['ProfileField']['weight'] ?>" /> </td>
                <td width="100px">
                    <a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this field? All the items within it will also be deleted. This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/profile_fields/delete/<?php echo $field['ProfileField']['id']?>')"><i class="icon-trash icon-small"></i></a>
                    <?php
                    $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "profile_fields",
                                "action" => "admin_ajax_copy",
                                "plugin" => false,

                            )). '/'.$field['ProfileField']['id'],
                        'title' => __('Copy'),
                        'innerHtml'=> '<i class="material-icons icon-small">file_copy</i>',
                        'class' => '',
                        'style' => 'vertical-align: middle;'
                    ));
                    ?>
                    <?php if ($field['ProfileField']['type'] == 'list' || $field['ProfileField']['type'] == 'multilist') :?>
                        <a href="<?php echo $this->base;?>/admin/profile_fields/profile_field_options/<?php echo $field['ProfileField']['id'];?>"><?php echo __('Field values')?></a>
                    <?php endif; ?>
                </td>

            </tr>
        <?php endforeach ?>

        </tbody>
    </table>


</div>




