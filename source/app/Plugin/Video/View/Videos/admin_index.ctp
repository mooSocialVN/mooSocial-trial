<?php
echo $this->Html->css(array('footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('footable'), array('inline' => false));

echo $this->element('admin/adminnav', array("cmenu" => "videos"));
$this->Paginator->options(array('url' => $this->passedArgs));
?>

<script>
$(document).ready(function(){
	$('.footable').footable();
});
</script>

<div id="center">
	<form method="post" action="<?php echo $this->request->base?>/admin/videos">
	<?php echo $this->Form->text('keyword', array('style' => 'float:right', 'placeholder' => 'Search by title'));?>
	<?php echo $this->Form->submit('', array( 'style' => 'display:none' ));?>
	</form>
	
	<h1>Videos Manager</h1>
	<form method="post" action="<?php echo $this->request->base?>/admin/videos/delete" id="deleteForm">
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
			<th><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('User.name', 'Poster'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Category.name', 'Category'); ?></th>
			<th data-hide="phone"><?php echo $this->Paginator->sort('Group.name', 'Group'); ?></th>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<th width="30"><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
			<?php endif; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($videos as $video): ?>
		<tr>
			<td><?php echo $video['Video']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/videos/create/<?php echo $video['Video']['id']?>" class="overlay" title="<?php echo $video['Video']['title']?>"><?php echo h($video['Video']['title'])?></a></td>
			<td><a href="<?php echo $this->request->base?>/admin/users/edit/<?php echo $video['User']['id']?>"><?php echo $video['User']['name']?></a></td>
			<td><?php echo isset($categories[$video['Category']['id']]) ? h($categories[$video['Category']['id']]) : ''?></td>
			<td><?php echo $video['Group']['name']?></td>
			<?php if ( $cuser['Role']['is_super'] ): ?>
			<td><input type="checkbox" name="videos[]" value="<?php echo $video['Video']['id']?>" class="check"></td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	
	<div style="float:right">
        <select onchange="doModeration(this.value, 'videos')">
            <option value="">With selected...</option>
            <option value="move">Move to</option>
            <option value="delete">Delete</option>
        </select>
        <?php echo $this->Form->select('category_id', $categories, array( 'onchange' => "confirmSubmitForm('Are you sure you want to move these videos', 'deleteForm')", 'style' => 'display:none' ) ); ?>
    </div>
	</form>
	
	<div class="pagination">
        <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
		<?php echo $this->Paginator->numbers(); ?>
		<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?> 
    </div>
</div>