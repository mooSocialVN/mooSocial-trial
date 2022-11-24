<?php echo $this->element('admin/adminnav', array("cmenu" => "tags"));?>

<div id="center">
	<form method="post" action="<?php echo $this->request->base?>/admin/tags">
	<?php echo $this->Form->text('keyword', array('style' => 'float:right', 'placeholder' => 'Search tag'));?>
	<?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
	</form>
	
	<h1>Tags Manager</h1>
	<form method="post" action="<?php echo $this->request->base?>/admin/tags/delete" id="deleteForm">
	<table class="mooTable" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('tag', 'Tag'); ?></th>
			<th><?php echo $this->Paginator->sort('type', 'Type'); ?></th>
			<th><?php echo $this->Paginator->sort('target_id', 'Item ID'); ?></th>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<th width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
			<?php endif; ?>
		</tr>
		<?php
		foreach ($tags as $tag):
		?>
		<tr>
			<td><?php echo h($tag['Tag']['tag'])?></td>
			<td><?php echo $tag['Tag']['type']?></td>
			<td><?php echo $tag['Tag']['target_id']?></td>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<td><input type="checkbox" name="tags[]" value="<?php echo $tag['Tag']['id']?>" class="check"></td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
	</table>
	
	<input type="button" value="Delete" class="topButton button button-caution" style="margin-top: 2px" onclick="confirmSubmitForm('Are you sure you want to delete these tags', 'deleteForm')">
	</form>
</div>

<div class="pagination">
	<?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
	<?php echo $this->Paginator->numbers(); ?>
	<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?> 
</div>