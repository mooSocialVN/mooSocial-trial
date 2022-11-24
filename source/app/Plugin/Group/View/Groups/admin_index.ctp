<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

echo $this->element('admin/adminnav', array("cmenu" => "groups"));
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<script>
$(document).ready(function(){
	$('.footable').footable();
});
</script>

<div id="center">
	<form method="post" action="<?php echo $this->request->base?>/admin/groups">
	<?php echo $this->Form->text('keyword', array('style' => 'float:right', 'placeholder' => 'Search by name'));?>
	<?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
	</form>
	
	<h1>Groups Manager</h1>
	<form method="post" action="<?php echo $this->request->base?>/admin/groups/delete" id="deleteForm">
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('title', 'Name'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('User.name', 'Creator'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', 'Category'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<th width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($groups as $group): ?> 
		<tr>
			<td><?php echo $group['Group']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/groups/create/<?php echo $group['Group']['id']?>" target="_blank"><?php echo $group['Group']['name']?></a></td>
			<td><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $group['User']['id']?>"><?php echo ($group['User']['name'])?></a></td>
			<td><?php echo $group['Category']['name']?></td>
			<td><?php echo $this->Time->niceShort($group['Group']['created'])?></td>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<td><input type="checkbox" name="groups[]" value="<?php echo $group['Group']['id']?>" class="check"></td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<div style="float:right">
        <select onchange="doModeration(this.value, 'groups')">
            <option value="">With selected...</option>
            <option value="move">Move to</option>
            <option value="delete">Delete</option>
        </select>
        <?php echo $this->Form->select('category_id', $categories, array( 'onchange' => "confirmSubmitForm('Are you sure you want to move these groups', 'deleteForm')", 'style' => 'display:none' ) ); ?>
    </div>
	</form>
	
	<div class="pagination">
        <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?> 
    </div>
</div>