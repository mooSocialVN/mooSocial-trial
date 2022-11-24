<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

echo $this->element('admin/adminnav', array("cmenu" => "users"));
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<script>
$(document).ready(function(){
	$('.footable').footable();
});
</script>

<div id="center">
	<form method="post" action="<?php echo $this->request->base?>/admin/users">
	<?php echo $this->Form->text('keyword', array('style' => 'float:right', 'placeholder' => 'Search by name or email'));?>
	<?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
	</form>
	
	<h1>Users Manager</h1>
	<form method="post" action="<?php echo $this->request->base?>/admin/users/delete" id="deleteForm">
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
			<th><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Role.name', 'Role'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('active', 'Active'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('confirmed', 'Confirmed'); ?></th>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<th data-hide="phone" width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['User']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $user['User']['id']?>"><?php echo $user['User']['name']?></a></td>
			<td><?php echo $user['User']['email']?></td>
			<td><?php echo $user['Role']['name']?></td>
			<td><?php if ($user['User']['active']) echo 'Yes'; else echo 'No'; ?></td>
			<td><?php if ($user['User']['confirmed']) echo 'Yes'; else echo 'No'; ?></td>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<td><input type="checkbox" name="users[]" value="<?php echo $user['User']['id']?>" class="check"></td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<input type="button" value="Delete" class="topButton button button-caution" style="margin-top: 2px" onclick="confirmSubmitForm('Are you sure you want to delete these users? All their content that they created (including groups, events, topics, albums...) will be deleted. It is not recommended to delete users unless they are spammers. This cannot be undone!<br /><br />', 'deleteForm')">
	</form>
	
	<div class="pagination">
        <?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>
        <?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?> 
    </div>
</div>