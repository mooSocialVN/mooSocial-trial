
<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
echo $this->Html->script(array('admin/jquery.fileuploader.js'), array('inline' => false));
$this->Html->addCrumb(__('Plugin Manager'));
$this->Html->addCrumb(__('Country Manager'), array('controller' => 'countries', 'action' => 'admin_index'));
$this->Html->addCrumb(__('State/Province Manager'), array('controller' => 'countries', 'action' => 'admin_state',"plugin" => false, $state['Country']['id']));
$this->Html->addCrumb(__('City Manager'), array('controller' => 'countries', 'action' => 'admin_city',"plugin" => false, $state['State']['id']));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "countries"));
$this->end();
?>
<?php
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
function confirmSubmitForm1(msg, type, form_id)
{   
    $('#type').val(type);
    $('#'+form_id).submit();
}
$( document ).ready(function() {
    $('.js_drop_down_link').click(function()
    {
       eleOffset = $(this).offset();

       $('#js_drop_down_cache_menu').remove();

       $('body').prepend('<div id="js_drop_down_cache_menu" style="position:absolute; left:' + eleOffset.left + 'px; top:' + (eleOffset.top + 15) + 'px; z-index:9999;"><div class="link_menu" style="display:block;">' + $(this).parent().find('.link_menu:first').html() + '</div></div>');

               $('#js_drop_down_cache_menu .link_menu').hover(function()
               {

               },
               function()
               {
                       $('#js_drop_down_cache_menu').remove();
               });	    	

       return false;
   });
});
function save_order()
{
    var list={};
    $('input[name="data[order]"]').each(function(index,value){
        list[$(value).data('id')] = $(value).val();
    });
    //console.log(list);
    jQuery.post("<?php echo $this->request->base ?>/admin/countries/save_order/City",{order:list},function(data){
        window.location = data;
    });
}
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
$('.check_enable').each(function(){
    $(this).change(function(){
        var enable = 0;
        if ($(this).prop('checked'))
        {
            enable = 1;
        }
        jQuery.post("<?php echo $this->request->base ?>/admin/countries/save_enable/City/"+$(this).data('id') + '/' + enable,{},function(data){
            
        });
    });
});
<?php $this->Html->scriptEnd(); ?>
<div class="portlet-body">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base ?>/admin/countries/create_city/<?php echo $state['State']['id']?>">
                        <?php echo __('Add New City'); ?>
                    </button>
                    <button style="margin-left: 10px" class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base ?>/admin/countries/import_city/<?php echo $state['State']['id']?>">
                        <?php echo __('Import City'); ?>
                    </button>
                    <?php if (count($cities)):?>
                    <a style="margin-left: 10px" onclick="save_order()" class="btn btn-gray" >
                        <?php echo __('Save order'); ?>
                    </a>
                    <?php endif;?>
                    
                    <div class="btn-group">
                        <a class="btn btn-gray" id="enable" onclick="confirmSubmitForm1('','1','actionForm');" style="margin-left: 10px">
                            <?php echo __('Enable')?>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-gray" id="disable" onclick="confirmSubmitForm1('','0','actionForm');" style="margin-left: 10px">
                            <?php echo __('Disable')?>
                        </a>
                    </div>

                    <a style="margin-left: 10px" class="btn btn-gray" href="<?php echo  $this->request->base; ?>/admin/countries"><?php echo __('Back')?></a>
                </div>
            </div>
            <div class="col-md-6">    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding-top: 5px;">
                <div class="note note-info hide">
                    <p>
                        <?php echo __('You can enable Spam Challenge to force user to answer a challenge question in order to register.'); ?> <br/>
                        <?php echo __('To enable this feature, click System Settings -> Security -> Enable Spam Challenge'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php  if(!empty($cities)) : ?>
    <form method="post" action="<?php echo  $this->request->base ?>/admin/countries/manage/City" id="actionForm">
        <input type="hidden" id="type" name="type" value="" />
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr class="tbl_head">        
                    <th width="20px"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>            
                    <th width="20px"></th>
                    <th><?php echo __('Name'); ?></th>
                    <th width="50px"><?php echo __('Enable'); ?></th>
                    <th width="50px"><?php echo __('Order'); ?></th>
                    <th width="50px" data-hide="phone"><?php echo __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($cities as $city):
                    ?>
                    <tr class="gradeX <?php ( ++$count % 2 ? "odd" : "even") ?>" id="<?php echo $city['City']['id'] ?>">
                        <td><input type="checkbox" name="ids[]" value="<?php echo  $city['City']['id'] ?>" class="check">
                        </td> 
                        <td>
                            <a href="javascript::void(0);" class="js_drop_down_link">
                                <i class="fa fa-sort-desc"></i>
                            </a>
                            <div class="link_menu" style="display:none;" >
                                <ul class="sub-menu" >
                                    <li>
                                        <?php
                            $this->MooPopup->tag(array(
                                'href' => $this->Html->url(array("controller" => "countries",
                                    "action" => "admin_create_city",
                                    "plugin" => false,
                                    $state['State']['id'],
                                    $city['City']['id'],
                                    '',
                                )),
                                'title' => __('Edit'),
                                'innerHtml' => __('Edit'),
                                'target' => 'ajax'
                            ));
                            ?>
                                    </li>
                                    <li>
                                        <?php
                                            $this->MooPopup->tag(array(
                                                                        'href'=>$this->Html->url(array("controller" => "countries",
                                                                                                    "action" => "admin_translate",
                                                                                                    "plugin" => false,
                                                                                                    $city['City']['id'],
                                                                                                    'City'

                                                                                                )),
                                                                        'title' => __('Translation'),
                                                                        'innerHtml'=> __('Translation'),
                                                                    ));
                                        ?>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to delete this city/province? All the items within it will also be deleted. This cannot be undone!') ?>', '<?php echo $this->request->base ?>/admin/countries/delete_city/<?php echo $city['City']['id'] ?>')"><?php echo __("Delete") ?></a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="reorder">
                            <?php
                            $this->MooPopup->tag(array(
                                'href' => $this->Html->url(array("controller" => "countries",
                                    "action" => "admin_create_city",
                                    "plugin" => false,
                                    $state['State']['id'],
                                    $city['City']['id'],
                                    '',
                                )),
                                'title' => $city['City']['name'],
                                'innerHtml' => $city['City']['name'],
                                'target' => 'ajax'
                            ));
                            ?>
                        </td>
                        <td width="50px" class="reorder">
                            <input type="checkbox" class="check_enable" <?php if ($city['City']['enable']): ?>checked<?php endif; ?> data-id="<?php echo $city['City']['id'];?>"/>
                        </td>
                        <td width="50px" class="reorder"><input data-id="<?php echo $city['City']['id'] ?>" style="width:50px" type="text" name="data[order]" value="<?php echo $city['City']['order'] ?>" /> </td>
                        <td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo __('Are you sure you want to delete this city? All the items within it will also be deleted. This cannot be undone!') ?>', '<?php echo $this->request->base ?>/admin/countries/delete_city/<?php echo $city['City']['id'] ?>')"><i class="icon-trash icon-small"></i></a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </form>
    <?php else : ?>
        <div class="message_empty">
            <?php echo __('There are no city found!') ?>
        </div>
    <?php endif; ?>
</div>