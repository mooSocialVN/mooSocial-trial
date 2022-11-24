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
			jQuery.post('<?php echo $this->request->base?>/admin/profile_fields/ajax_reorder', { fields: list });
		}
	});
	
	$('.footable').footable();
});
</script>

<?php echo $this->element('admin/adminnav', array("cmenu" => "profile_fields"));?>

<div id="center">
	<a href="<?php echo $this->request->base?>/admin/profile_fields/ajax_create" class="overlay topButton button button-action" title="Add New Field">Add New Field</a>

	<h1>Custom Profile Fields</h1>
	<table class="mooTable footable" cellpadding="0" cellspacing="0">
		<thead>
		<tr class="tbl_head">
			<th width="50px">ID</th>
			<th width="250px">Name</th>
			<th width="50px">Type</th>
			<th width="50px" data-hide="phone">Required</th>
			<th width="50px" data-hide="phone">Registration</th>
			<th width="50px" data-hide="phone">Searchable</th>
			<th width="50px" data-hide="phone">Profile</th>
			<th width="50px" data-hide="phone">Active</th>
			<th width="50px" data-hide="phone">Actions</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($fields as $field):
		?>
		<tr id="<?php echo $field['ProfileField']['id']?>">
			<td width="50px"><?php echo $field['ProfileField']['id']?></td>
			<td width="300px" class="reorder"><a href="/admin/profile_fields/ajax_create/<?php echo $field['ProfileField']['id']?>" class="overlay" title="<?php echo $field['ProfileField']['name']?>"><?php echo $field['ProfileField']['name']?></a></td>
			<td width="50px" class="reorder"><?php echo $field['ProfileField']['type']?></td>
			<td width="50px" class="reorder"><?php echo ($field['ProfileField']['required']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo ($field['ProfileField']['registration']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo ($field['ProfileField']['searchable']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo ($field['ProfileField']['profile']) ? 'Yes' : 'No'?></td>
			<td width="50px" class="reorder"><?php echo ($field['ProfileField']['active']) ? 'Yes' : 'No'?></td>
			<td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this field? All the items within it will also be deleted. This cannot be undone!')) ?>', '<?php echo $this->request->base?>/admin/profile_fields/delete/<?php echo $field['ProfileField']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>