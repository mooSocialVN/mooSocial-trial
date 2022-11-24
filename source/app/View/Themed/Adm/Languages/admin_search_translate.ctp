<?php if ($result): ?>
	<?php foreach ($result as $key=>$tmp):?>
	<?php $plural = isset($tmp['plural']);?>
	<?php if (empty($single)):?>
	<tr class="translate_click" id="<?php echo md5($key); ?>" data-key="<?php echo md5($key); ?>">
	<?php endif;?>
		<th><?php echo $key;?></th>
		<?php if ($plural):?>
			<th>
				<?php echo $tmp[''][0] ? $tmp[''][0] : '';?>
			</th>
			<th>
				<?php echo $tmp[''][0] ? $tmp[''][1] : '';?>
			</th>
		<?php else:?>
			<th>
				<?php echo $tmp[''] ? $tmp[''] : '';?>
			</th>
			<th>
			</th>
		<?php endif;?>
	<?php if (empty($single)):?>	
	</tr>
	<?php endif;?>
	<?php endforeach;?>
	<?php if (empty($single)):?>
	<script>
		var translates = <?php echo json_encode($result)?>;
	</script>
	<?php else:?>
		<script>
			translates['<?php echo addslashes(key($result)); ?>'] = <?php echo json_encode($result[key($result)])?>;
		</script>
	<?php endif; ?>
<?php endif;?>