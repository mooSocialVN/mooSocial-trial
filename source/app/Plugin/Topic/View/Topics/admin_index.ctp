<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

echo $this->element('admin/adminnav', array("cmenu" => "topics"));
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
$(document).ready(function(){
	$('.footable').footable();
});
<?php  $this->Html->scriptEnd(); ?>

<div id="center">
	<form method="post" action="<?php echo $this->request->base?>/admin/topics">
	<?php echo $this->Form->text('keyword', array('style' => 'float:right', 'placeholder' => 'Search by title'));?>
	<?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
	</form>
	
	<h1><?php echo __('Topics Manager');?></h1>
	<form method="post" action="<?php echo $this->request->base?>/admin/topics/delete" id="deleteForm">
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id', __('ID')); ?></th>
			<th><?php echo $this->Paginator->sort('title', __('Title')); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('User.name', __('Author')); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', __('Category')); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Group.name', __('Group')); ?></th>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<th width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($topics as $topic): ?>
		<tr>
			<td><?php echo $topic['Topic']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/topics/create/<?php echo $topic['Topic']['id']?>" target="_blank"><?php echo $this->Text->truncate($topic['Topic']['title'], 100, array('eclipse' => '...')) ?></a></td>
			<td><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $topic['User']['id']?>"><?php echo $topic['User']['name']?></a></td>
			<td><?php echo isset($categories[$topic['Category']['id']]) ? h($categories[$topic['Category']['id']]) : ''?></td>
			<td><?php echo $topic['Group']['name']?></td>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<td><input type="checkbox" name="topics[]" value="<?php echo $topic['Topic']['id']?>" class="check"></td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<div style="float:right">
    	<select onchange="doModeration(this.value, 'topics')">
    	    <option value="">With selected...</option>
    	    <option value="move">Move to</option>
    	    <option value="delete">Delete</option>
    	</select>
    	<?php echo $this->Form->select('category_id', $categories, array( 'onchange' => "confirmSubmitForm('Are you sure you want to move these topics', 'deleteForm')", 'style' => 'display:none' ) ); ?>
	</div>
	</form>
	
	<div class="pagination">
        <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?> 
    </div>
</div>