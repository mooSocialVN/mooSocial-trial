<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
?>

<script>
jQuery(document).ready(function(){
	jQuery( ".mooTable" ).sortable( {
		items: "tr:not(.tbl_head)", 
		handle: ".reorder",
		update: function(event, ui) {
			var list = jQuery('.mooTable').sortable('toArray');
			jQuery.post('<?php echo $this->request->base?>/admin/categories/ajax_reorder', { cats: list });
		}
	});
	
	$('.footable').footable();
});
</script>

<?php echo $this->element('admin/adminnav', array("cmenu" => "categories"));?>

<div id="center">	
    <a href="<?php echo $this->request->base?>/admin/categories/ajax_create" class="overlay button button-action topButton" title="Add New Category">Add New Category</a>
	<h1>Categories Manager</h1>
	
	<ul class="list7" id="feed-type" style="float:right;margin:-5px 0 5px 0">
		<li><a href="<?php echo $this->request->base?>/admin/categories" <?php if (empty($type)) echo 'class="current"'?>>All</a></li>
		<li><a href="<?php echo $this->request->base?>/admin/categories/index/album" <?php if ($type == APP_ALBUM) echo 'class="current"'?>>Album</a></li>
		<li><a href="<?php echo $this->request->base?>/admin/categories/index/event" <?php if ($type == APP_EVENT) echo 'class="current"'?>>Event</a></li>
		<li><a href="<?php echo $this->request->base?>/admin/categories/index/topic" <?php if ($type == APP_TOPIC) echo 'class="current"'?>>Topic</a></li>
		<li><a href="<?php echo $this->request->base?>/admin/categories/index/video" <?php if ($type == APP_VIDEO) echo 'class="current"'?>>Video</a></li>
		<li><a href="<?php echo $this->request->base?>/admin/categories/index/group" <?php if ($type == APP_GROUP) echo 'class="current"'?>>Group</a></li>
	</ul>	
	
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr class="tbl_head">
			<th width="50px">ID</th>
			<th>Name</th>
			<th width="50px">Type</th>
			<th data-hide="phone">Parent</th>
			<th width="50px" data-hide="phone">Header</th>
			<th width="50px" data-hide="phone">Active</th>
			<th width="50px" data-hide="phone">Count</th>
			<th width="50px" data-hide="phone">Actions</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($categories as $category):
		?>
		<tr id="<?php echo $category['Category']['id']?>">
			<td width="50px"><?php echo $category['Category']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/admin/categories/ajax_create/<?php echo $category['Category']['id']?>" class="overlay" title="<?php echo $category['Category']['name']?>"><?php if ($category['Category']['header']):?><strong><?php echo $category['Category']['name']?></strong><?php else:?><?php echo $category['Category']['name']?><?php endif;?></a></td>
			<td width="50px" class="reorder"><?php echo $category['Category']['type']?></td>
			<td class="reorder"><?php if ( !empty($category['Parent']['name']) ) echo $category['Parent']['name']; else echo 'ROOT';?></td> 
			<td width="50px" class="reorder"><?php echo ($category['Category']['header']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo ($category['Category']['active']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo $category['Category']['item_count']?></td>
			<td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this category? All parent of sub-category it will also be changed to ROOT. This cannot be undone!!')) ?>', '<?php echo $this->request->base?>/admin/categories/delete/<?php echo $category['Category']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>