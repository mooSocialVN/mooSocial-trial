<?php
$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('User Roles'), array('controller' => 'roles', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "roles"));
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

    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button class="btn btn-gray" data-toggle="modal" data-target="#ajax" href="<?php echo $this->request->base?>/admin/roles/ajax_create">
                            <?php echo __('Add New');?>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm('<?php echo addslashes(__('Are you sure? Any roles with users will not be deleted.'))?>', 'deleteForm')">
                            <?php echo  __('Delete');?>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">

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

        <form method="post" action="<?php echo $this->request->base?>/admin/roles/delete" id="deleteForm">
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <?php if ($cuser['Role']['is_super']): ?>
                <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
                <?php endif; ?>
                
                <th><?php echo __('ID');?></th>
                <th><?php echo __('Name');?></th>
                <th><?php echo __('Admin');?></th>
                <th><?php echo __('Super Admin');?></th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($roles as $role): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    
                    <?php if ( $cuser['Role']['is_super'] ): ?>
                        <td><input <?php if ($role['Role']['core']) echo 'disabled'; ?> type="checkbox" name="roles[]" value="<?php echo $role['Role']['id']?>" class="check"></td>
                    <?php endif; ?>
                        
                    <td><?php echo $role['Role']['id']?></td>
                    <td><?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "roles",
                                            "action" => "admin_ajax_create",
                                            "plugin" => false,
                                            $role['Role']['id']
                                            
                                        )),
             'title' => h($role['Role']['name']),
             'innerHtml'=> h($role['Role']['name']),
     ));
 ?>
                    </td>
                    <td><?php echo ($role['Role']['is_admin']) ? __('Yes') : __('No')?></td>
                    <td><?php echo ($role['Role']['is_super']) ? __('Yes') : __('No')?></td>
                </tr>
            <?php endforeach ?>

            </tbody>
        </table>
            </form>

    </div>
