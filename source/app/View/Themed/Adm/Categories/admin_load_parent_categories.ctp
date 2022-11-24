<option value="0"></option>
<?php foreach ($parent_categories as $item): ?>
<option value="<?php echo $item['Category']['id']?>"><?php echo $item['Category']['name']?></option>
<?php endforeach; ?>
