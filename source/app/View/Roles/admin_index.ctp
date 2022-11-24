<?php
echo $this->element('admin/adminnav', array("cmenu" => "roles"));
?>

<div id="center">
    <a href="<?php echo $this->request->base?>/admin/roles/ajax_create" class="overlay button button-action topButton" title="Add New Role">Add New Role</a>
    <h1>Roles Manager</h1>
    <table class="mooTable" cellpadding="0" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Admin</th>
            <th>Super Admin</th>
        </tr>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?php echo $role['Role']['id']?></td>
            <td><a href="<?php echo $this->request->base?>/admin/roles/ajax_create/<?php echo $role['Role']['id']?>" class="overlay" title="<?php echo h($role['Role']['name'])?> Role"><?php echo h($role['Role']['name'])?></a></td>
            <td><?php echo ($role['Role']['is_admin']) ? 'Yes' : 'No'?></td>
            <td><?php echo ($role['Role']['is_super']) ? 'Yes' : 'No'?></td>
        </tr>
        <?php endforeach ?>
    </table>
</div>