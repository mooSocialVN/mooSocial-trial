<div class="album-lists" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="album-list-content"<?php endif; ?>>
<?php if(isset($element_list_path)): ?>
    <?php echo $this->element($element_list_path);?>
<?php else: ?>
    <?php echo $this->element($search_view, array(), array('plugin' => $plugin));?>
<?php endif; ?>
</div>