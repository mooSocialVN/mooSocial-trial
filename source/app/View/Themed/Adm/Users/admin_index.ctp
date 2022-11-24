<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Users Manager'), array('controller' => 'users', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "users"));
$this->end();
$this->Paginator->options(array('url' => $data_search));
?>

<script>
function confirmSubmitForm1(msg, type, form_id)
{   
    $('#type').val(type);
    if (type == 'delete'){
        $('#category').val($("#category_id").val());
        // Set title
        $($('#portlet-config  .modal-header .modal-title')[0]).html('Please Confirm');
        // Set content
        $($('#portlet-config  .modal-body')[0]).html(msg);
        // OK callback
        $('#portlet-config  .modal-footer .ok').click(function(){
            $('#portlet-config').modal('hide');
            $('#'+form_id).submit();
        });
        $('#portlet-config').modal('show');
    }else if (type == 'approve'){
        $('#'+form_id).submit();
    }

}
function changeLock(id, e) {

    var value = 0;
    if ($(e).html() == 'cancel') {
        value = 1;
    }
    $.post("<?php echo $this->request->base ?>/admin/users/lock_delete", {
        'id': id,
        'value': value,
        type: 'active'
    }, function (data) {
        var json = $.parseJSON(data);
        if (json.result == 1) {
            if (value) {
                $(e).html('check');
                $(e).attr('title', '<?php echo __('Yes'); ?>');
            }
            else {
                $(e).html('cancel');
                $(e).attr('title', '<?php echo __('No'); ?>');
            }
        }
    });
}
</script>

<div class="portlet-body">
    <div class="table-toolbar">
	    <form method="post" action="<?php echo $this->base?>/admin/users/index">
			<div style="padding-bottom: 15px;" class="dataTables_filter">
				<div class="search_inline_item">
					<input class="form-control input-normal input-inline" value="<?php echo $keyword?>" type="text" placeholder="<?php echo __('Search by name or email')?>" name="keyword">
				</div>
				<select class="form-control input-normal input-inline" name="role_id">	
					<?php foreach ($roles as $key=>$role):?>
						<option <?php if ($role_id == $key) echo 'selected="selected"'?> value="<?php echo $key;?>"><?php echo $role;?></option>
					<?php endforeach;?>			
				</select>
				<div class="search_inline_item">
					<input class="form-control input-normal input-inline" value="<?php echo $ip?>" type="text" placeholder="<?php echo __('Search by ip')?>" name="ip">
				</div>
				<button class="btn btn-gray" id="sample_editable_1_new" type="submit">
					<?php echo __('Search');?>
				</button>
			</div>
		</form>
        <div class="row">
            <div class="col-md-12">
            <?php if ($cuser['Role']['is_super']): ?>
                <div class="btn-group">
                    <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm1('<?php echo addslashes(__('Are you sure you want to delete these users? All their content that they created (including groups, events, topics, albums...) will be deleted. It is not recommended to delete users unless they are spammers. This cannot be undone!'));?><br /><br />', 'delete', 'deleteForm')">
                        <?php echo __('Delete')?>
                    </button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-gray" id="sample_editable_1_new" onclick="confirmSubmitForm1('', 'approve', 'deleteForm')">
                        <?php echo __('Approve and Active')?>
                    </button>
                </div>
                <div class="btn-group">
                    <a class="btn btn-gray" id="sample_editable_1_new" href="<?php echo $this->base?>/admin/users/create_user" data-target="#ajax" data-toggle="modal" class=""data-dismiss="" data-backdrop="true" style="" >
                        <?php echo __('Create new user')?>
                    </a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-gray" id="sample_editable_1_new" href="<?php echo $this->base?>/admin/users/export_user"style="" >
                        <?php echo __('Export to csv')?>
                    </a>
                </div>
                 <?php endif; ?>
            </div>
        </div>
    </div>
    <form method="post" action="<?php echo  $this->request->base ?>/admin/users/manage" id="deleteForm">
        <?php echo $this->Form->input('type', array('type' => 'hidden', 'value' => '')) ?>
    <table class="table table-striped table-bordered table-hover" id="sample_1">
        <thead>
        <tr>
            <?php if ($cuser['Role']['is_super']): ?>
            <th width="30"><input type="checkbox" onclick="toggleCheckboxes2(this)"></th>
            <?php endif; ?>
            <th>
                <?php echo $this->Paginator->sort('id', __('ID')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('name', __('Name')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('email', __('Email')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Role.name', __('Role')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('Role.name', __('User IP')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('active', __('Active')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('confirmed', __('Confirmed')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('approved', __('Approved')); ?>
            </th>
            <th>
                <?php echo $this->Paginator->sort('lock_delete', __('Lock delete')); ?>
            </th>
            <th>
                <?php echo __('Action'); ?>
            </th>
        </tr>
        </thead>
        <tbody>
            <?php $count = 0;
            foreach ($users as $user): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>">
                    <?php if ($cuser['Role']['is_super']): ?>
                        <td><input type="checkbox" name="users[]" value="<?php echo  $user['User']['id'] ?>" class="check">
                        </td>
                    <?php endif; ?>
                    <td><?php echo  $user['User']['id'] ?></td>
                    <td>
                        <a href="<?php echo  $this->request->base ?>/admin/users/edit/<?php echo  $user['User']['id'] ?>"><?php echo  $user['User']['name'] ?></a>
                    </td>
                    <td><?php echo  $user['User']['email'] ?></td>
                    <td><?php echo  $user['Role']['name'] ?></td>
                    <td><?php echo  $user['User']['ip_address'] ?></td>
                    <td><?php if ($user['User']['active']) echo __('Yes'); else echo __('No'); ?></td>
                    <td><?php if ($user['User']['confirmed']) echo __('Yes'); else echo __('No'); ?></td>
                    <td><?php if ($user['User']['approved']) echo __('Yes'); else echo __('No'); ?></td>
                    <td>
                        <?php
                        if($cuser['id'] == ROOT_ADMIN_ID) {
                            if ($user['User']['lock_delete']) {
                                ?>
                                <a href="javascript:void(0)"><span
                                            onclick="changeLock(<?php echo $user['User']['id']; ?>, this);"
                                            class="material-icons" title="<?php echo __('Yes'); ?>"
                                            style="font-size: 20px;">check</span></a>
                                <?php
                            } else {
                                ?>
                                <a href="javascript:void(0)"><span
                                            onclick="changeLock(<?php echo $user['User']['id']; ?>, this);"
                                            class="material-icons" title="<?php echo __('No'); ?>"
                                            style="font-size: 20px;">cancel</span></a>
                                <?php
                            }
                        }else{
                            echo $user['User']['lock_delete'] ? __('Yes') : __('No');
                        }
                        ?>
                    </td>
                    <td>
                    	<?php if ($cuser['Role']['is_super'] && !$user['Role']['is_super']): ?>
                    		<a href="javascript:void(0);" data-id="<?php echo $user['User']['id']; ?>" class="btn btn-default login_as_user"><?php echo __('Login as user'); ?></a>
                    	<?php endif;?>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>
    </form>
    <div class="pagination">
        <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
    </div>
</div>


<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).on('hidden.bs.modal', function (e) {
    $(e.target).removeData('bs.modal');
});
<?php $this->Html->scriptEnd(); ?>
