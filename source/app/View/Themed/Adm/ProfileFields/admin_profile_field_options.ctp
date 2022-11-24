<?php
//echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
//echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Profile Types Manager'), array('controller' => 'profile_fields', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Profile Fields Manager'), array('controller' => 'profile_fields', 'action' => 'admin_profile_fields',$profile_field['ProfileField']['profile_type_id']));
$this->Html->addCrumb(__('Profile Field Options Manager'), array('controller' => 'profile_fields', 'action' => 'admin_profile_field_options', $profile_field_id));

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
    
    jQuery.post("<?php echo $this->request->base ?>/admin/profile_fields/ajax_reorder_options",{order:list},function(data){
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
                                                                "action" => "admin_ajax_create_option",
                                                                "plugin" => false,
                                                                $profile_field_id
                                                            )),
                                'title' => __('Add New Field'),
                                'innerHtml'=> __('Add New Field'),
                            'class' => 'btn btn-gray',
                        	'target' => 'portlet-config'
                        ));
                    ?>
                    <a style="margin-left: 10px" onclick="save_order()" class="btn btn-gray" >
                        <?php echo __('Save order'); ?>
                    </a>                        
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php echo __('You\'re adding field values for %s', '<a href="'.$this->base.'/admin/profile_fields/profile_fields/'.$profile_field['ProfileField']['profile_type_id'].'">'.$profile_field['ProfileField']['name'].'</a>');?>
    </div>
    <br>
    <table class="table table-striped table-bordered table-hover" id="sample_1">
        <thead>
        <tr class="tbl_head">
            <th width="50px"><?php echo  __('ID');?></th>
            <th width="250px"><?php echo  __('Name');?></th>
            <th width="50px" ><?php echo  __('Order');?></th>
            <th width="50px" data-hide="phone"><?php echo  __('Actions');?></th>
        </tr>
        </thead>
        <tbody>
            <?php $count = 0;
            foreach ($field_options as $field_option): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>" id="<?php echo $field_option['ProfileFieldOption']['id']?>">
                    <td width="50px"><?php echo $field_option['ProfileFieldOption']['id']?></td>
                    <td width="300px" class="reorder">
                    	<a id="" href="<?php echo $this->base?>/admin/profile_fields/ajax_create_option/<?php echo $profile_field_id;?>/<?php echo $field_option['ProfileFieldOption']['id'];?>" data-target="#portlet-config" data-toggle="modal" class="" title="<?php echo $field_option['ProfileFieldOption']['name'];?>" data-dismiss="" data-backdrop="true" style=""><?php echo $field_option['ProfileFieldOption']['name'];?></a>
                    </td>
                    <td width="50px" class="reorder"><input data-id="<?php echo $field_option['ProfileFieldOption']['id'] ?>" style="width:50px" type="text" name="data[order]" value="<?php echo $field_option['ProfileFieldOption']['order'] ?>" /> </td>                 
                    <td width="50px">
                        <a href="<?php echo $this->base?>/admin/profile_fields/ajax_create_option/<?php echo $profile_field_id;?>/<?php echo $field_option['ProfileFieldOption']['id'];?>" data-target="#ajax" data-toggle="modal" class="" title="<?php echo $field_option['ProfileFieldOption']['name'];?>" data-dismiss="" data-backdrop="true" style=""><i class="icon-edit icon-small"></i></a>
                        <a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this field option? All the items within it will also be deleted. This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/profile_fields/delete_option/<?php echo $field_option['ProfileFieldOption']['id']?>')"><i class="icon-trash icon-small"></i></a>
                    </td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>




