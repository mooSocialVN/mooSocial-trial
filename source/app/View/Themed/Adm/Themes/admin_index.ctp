
<?php
$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Themes Manager'), array('controller' => 'themes', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "themes"));
$this->end();
?>
<?php $this->start('page-toolbar'); ?>

<?php $this->end('page-toolbar'); ?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
$(e.target).removeData('bs.modal');
});

$('.default_theme').change(function(){
    var theme_value = $(this).attr('theme-value');
    $(".default_theme").prop("disabled", true);
    $.post("<?php echo $this->request->base?>/admin/themes/ajax_change_default_theme", {key: theme_value}, function(data){
    var json = $.parseJSON(data);
            
            if ( json.result == 1 )
                location.reload();
            else
            {
                $(".error-message").show();
                $(".error-message").html('<strong>Error!</strong>'+json.message);
            }
		});
        
            return false;
});

<?php $this->Html->scriptEnd(); ?>
<style type="text/css">
    .tabbable-custom > .nav-tabs {
        border-bottom: 1px solid #DDDDDD;
    }
</style>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button href="<?php echo $this->request->base?>/admin/themes/ajax_create" class="btn btn-gray" data-target="#ajax" data-toggle="modal">
                            <?php echo __('Create New Theme');?>
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
                                <?php echo __('Installed Themes');?> </a>
                        </li>
                        <li>
                            <a href="#portlet_tab2" data-toggle="tab">
                                <?php echo __('Not Installed Themes');?> </a>
                        </li>
                        
                    </ul>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th><?php echo __('ID');?></th>
                                    <th><?php echo __('Name');?></th>
                                    <th><?php echo __('Key');?></th>
                                    <th><?php echo __('Default Theme');?></th>
                                    <th width="100"><?php echo __('Actions');?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $count = 0;
                                foreach ($themes as $theme): ?>
                                    <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                                        <td><?php echo $theme['Theme']['id']?></td>
                                        <td><a href="<?php echo $this->request->base?>/admin/themes/setting/<?php echo $theme['Theme']['id']?>"><?php echo h($theme['Theme']['name'])?></a></td>
                                        <td><?php echo $theme['Theme']['key']?></td>
                                        <td><input type='checkbox' <?php if($default_theme == $theme['Theme']['key']): ?>checked disabled readonly<?php endif; ?> class='default_theme' theme-value='<?php echo $theme['Theme']['key']?>'></td>
                                        <td>
                                            <a href="<?php echo $this->request->base?>/admin/themes/setting/<?php echo $theme['Theme']['id']?>"><i class="fa fa-wrench" aria-hidden="true" title="<?php __('Setting');?>"></i></a>&nbsp;
                                            <a href="<?php echo $this->request->base?>/admin/themes/do_uninstall/<?php echo $theme['Theme']['id']?>"><i class="icon-trash " title="<?php __('Uninstall');?>"></i></a>&nbsp;
                                            <a href="<?php echo $this->request->base?>/admin/themes/do_download/<?php echo $theme['Theme']['key']?>" target="_blank"><i class="fa  fa-download  " title="<?php echo __('Download')?>"></i></a>
                                        </td></tr>
                                <?php endforeach ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="portlet_tab2">
                            <ul class="list-group">
                                <?php foreach ($not_installed_themes as $theme): ?>
                                    <li class="list-group-item"><?php echo $theme?>
                                        <span class="badge badge-success">
                                            <a href="<?php echo $this->request->base?>/admin/themes/do_install/<?php echo $theme?>" style="color:#fff;"><?php echo __('Install');?></a>
                                        </span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
