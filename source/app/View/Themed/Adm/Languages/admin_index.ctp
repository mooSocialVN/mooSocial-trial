

<?php
$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Languages Manager'), array('controller' => 'languages', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "languages"));
$this->end();

?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('loaded.bs.modal', function (e) {
    Metronic.init();
});
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
<?php $this->Html->scriptEnd(); ?>
<style type="text/css">
    .tabbable-custom > .nav-tabs {
        border-bottom: 1px solid #DDDDDD;
    }
</style>
	<?php if (!$checkPermissionLocale):?>
	    <div class="alert alert-danger">
			<?php echo __('*Please change permission of directory "%s" and all sub-directories to 0755','app/Locale');?>
		</div>
	<?php else:?>
		<div class="table-toolbar">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button href="<?php echo $this->request->base?>/admin/languages/ajax_create" class="btn btn-gray" data-target="#ajax" data-toggle="modal">
                            <?php echo __('Create New Language');?>
                        </button>
                    </div>

                </div>

            </div>

        </div>
	<?php endif;?>
    <div class="portlet-body">
        <div class=" portlet-tabs">
            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                <ul class="nav nav-tabs list7 chart-tabs">
                    <li class="active">
                        <a href="#portlet_tab1" data-toggle="tab">
                            <?php echo  __('Installed Languages');?> </a>
                    </li>
                    <li>
                        <a href="#portlet_tab2" data-toggle="tab">
                            <?php echo  __('Not Installed Languages');?> </a>
                    </li>
                    
                </ul>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">

                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab1">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th><?php echo  __('ID');?></th>
                                    <th><?php echo  __('Name');?></th>
                                    <th><?php echo  __('Key');?></th>
                                    <th width="70"><?php echo  __('Actions');?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $count = 0;
                                foreach ($languages as $language): ?>
                                    <tr  class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                                        <td><?php echo $language['Language']['id']?></td>
                                        <td><?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "languages",
                                            "action" => "admin_ajax_edit",
                                            "plugin" => false,
                                            $language['Language']['id']
                                            
                                        )),
             'title' => __('Edit Language Name'),
             'innerHtml'=> h($language['Language']['name']),
     ));
 ?></td>
                                        <td><?php echo $language['Language']['key']?></td>
                                        <td><?php if ( $language['Language']['key'] != 'eng' ): ?>
                                        		<a href="<?php echo $this->request->base?>/admin/languages/view/<?php echo $language['Language']['id']?>"><i class="fa fa-file" aria-hidden="true" title="<?php echo __('Files');?>"></i></a>
                                        		<a href="<?php echo $this->request->base?>/admin/languages/translate/<?php echo $language['Language']['id']?>"><i class="fa fa-wrench" aria-hidden="true" title="<?php echo __('Translate');?>"></i></a>
                                                <a href="javascript:void(0);" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to uninstall this language?'));?>','<?php echo $this->request->base?>/admin/languages/do_uninstall/<?php echo $language['Language']['id']?>');"><i class="tip icon-trash icon-small" title="<?php echo __('Uninstall');?>"></i></a>                                                
                                            <?php else: ?>
                                            	<a href="<?php echo $this->request->base?>/admin/languages/translate/<?php echo $language['Language']['id']?>"><i class="fa fa-wrench" aria-hidden="true" title="<?php echo __('Translate');?>"></i></a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="portlet_tab2">
                            <ul class="list-group">
                                <?php foreach ($not_installed_languages as $language): ?>
                                    <li class="list-group-item"><?php echo $language?>
                                        <span class="badge badge-success">
                                            <a href="<?php echo $this->request->base?>/admin/languages/do_install/<?php echo $language?>" style="color:#fff;"><?php echo __('Install');?></a>

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

