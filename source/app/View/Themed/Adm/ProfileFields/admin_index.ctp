<?php
//echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
//echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Profile Types Manager'), array('controller' => 'profile_fields', 'action' => 'admin_index'));

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
    jQuery.post("<?php echo $this->request->base ?>/admin/profile_fields/save_type_order",{order:list},function(data){
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
                                            "action" => "admin_ajax_type_create",
                                            "plugin" => false,
                                           
                                        )),
             'title' => __('Add New Profile Type'),
             'innerHtml'=> __('Add New Profile Type'),
          'class' => 'btn btn-gray'
     ));
 ?>
						<a style="margin-left: 10px" onclick="save_order()" class="btn btn-gray" >
	                        <?php echo __('Save order'); ?>
	                    </a>
                    </div>
                </div>                
            </div>            
        </div>

        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr class="tbl_head">
                <th width="50px"><?php echo  __('ID');?></th>
                <th width="250px"><?php echo  __('Name');?></th>
                <th width="50px" ><?php echo  __('Order');?></th>
                <th width="50px" data-hide="phone"><?php echo  __('Active');?></th>
                <th width="50px" data-hide="phone"><?php echo  __('Actions');?></th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($fields as $field): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>" id="<?php echo $field['ProfileType']['id']?>">
                    <td width="50px"><?php echo $field['ProfileType']['id']?></td>
                    <td width="300px">
                    	<a href="<?php echo $this->base?>/admin/profile_fields/profile_fields/<?php echo $field['ProfileType']['id'];?>"><?php echo $field['ProfileType']['name'];?></a>
                    </td>  
                    <td width="50px" class="reorder"><input data-id="<?php echo $field['ProfileType']['id'] ?>" style="width:50px" type="text" name="data[order]" value="<?php echo $field['ProfileType']['order'] ?>" /> </td>                  
                    <td width="50px" class="reorder"><?php echo ($field['ProfileType']['actived']) ? __('Yes') : __('No')?></td>
                    <td width="50px">
                    	<a href="<?php echo $this->base?>/admin/profile_fields/ajax_type_create/<?php echo $field['ProfileType']['id'];?>" data-target="#ajax" data-toggle="modal" class="" title="<?php echo $field['ProfileType']['name'];?>" data-dismiss="" data-backdrop="true" style=""><i class="icon-edit icon-small"></i></a>
                    	<?php if ($field['ProfileType']['id'] != PROFILE_TYPE_DEFAULT):?>
                    		<a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this profile type? All the items within it will also be deleted. This cannot be undone!'));?>', '<?php echo $this->request->base?>/admin/profile_fields/delete_type/<?php echo $field['ProfileType']['id']?>')"><i class="icon-trash icon-small"></i></a>
                    	<?php endif;?>
                    </td>

                </tr>
            <?php endforeach ?>

            </tbody>
        </table>


    </div>




