<div class="core-lists topic-lists list-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
<?php if(isset($element_list_path)): ?>
    <?php echo $this->element($element_list_path);?>
<?php else: ?>
    <?php echo $this->element($search_view, array(), array('plugin' => $plugin));?>
<?php endif; ?>
</div>