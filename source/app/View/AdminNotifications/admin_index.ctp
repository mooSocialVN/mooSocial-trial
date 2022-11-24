<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Admin Notifications'), array('controller' => 'admin_notifications', 'action' => 'admin_index'));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array('cmenu' => 'notification'));
$this->end();
?>

    <ul class="nav nav-tabs list7 chart-tabs">
        <li class="active">
            <a href="<?php echo $this->request->base?>/admin/admin_notifications"><?php echo __('Admin Notifications');?></a>
        </li>
    </ul>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <?php echo __('Admin Notifications');?>
            </div>
        </div>
        <div class="portlet-body">
            <form method="post" action="<?php echo $this->request->base?>/admin/admin_notifications/delete" id="deleteForm">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <?php if ($cuser['Role']['is_super']): ?>

                            <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
                        <?php endif; ?>
                        <th class="text-center"><?php echo __('Notification detail'); ?></th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php $count = 0;
                    foreach ($requests as $request): ?>
                        <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                            <?php if ( $cuser['Role']['is_super'] ): ?>
                                <td><input type="checkbox" name="requests[]" value="<?php echo $request['AdminNotification']['id']?>" class="check"></td>
                            <?php endif; ?>
                            <td class="">
                                <a class="" href="<?php echo  $this->request->base ?>/admin/admin_notifications/ajax_view/<?php echo  $request['AdminNotification']['id'] ?>"
                                   <?php if (!empty($request['AdminNotification']['message'])): ?>data-toggle="modal" data-target="#ajax" data-backdrop="true" data-dismiss="modal"
                                   title="<?php echo  __('Notification Detail');?>"<?php endif; ?>>
                                    <b><?php echo $request['User']['name'] ?></b> <?php echo  $request['AdminNotification']['text'] ?>
                                    <span class="date"><?php echo  $this->Moo->getTime($request['AdminNotification']['created'], Configure::read('core.date_format'), $utz) ?></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    </tbody>
                </table>
            </form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm('<?php echo __('Are you sure you want to delete these notifications')?>', 'deleteForm')">
                            <?php echo  __('Delete selected notification');?>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pagination pull-right">
                        <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
                        <?php echo $this->Paginator->numbers(); ?>
                        <?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
    });
<?php $this->Html->scriptEnd(); ?>