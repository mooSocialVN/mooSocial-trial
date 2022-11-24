<ul class="list2">
<?php foreach ($files as $file): ?>
	<?php if ( strpos($file, '.') === false ): ?>
	<li><a href="javascript:void(0)" onclick="openFolder('<?php if ( !empty($path) ) echo $path . '/'; ?><?php echo $file?>', '<?php echo $type?>', this)"><i class="fa fa-folder-open-o" aria-hidden="true"></i> <?php echo $file?></a></li>
	<?php else: ?>
	<li><a href="javascript:void(0)" onclick="openFile('<?php if ( !empty($path) ) echo $path . '/'; ?><?php echo $file?>', '<?php echo $type?>', this)"><i class="fa fa-file" aria-hidden="true"></i> <?php echo $file?></a></li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>