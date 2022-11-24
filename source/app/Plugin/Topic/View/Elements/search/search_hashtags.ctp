<div class="core-lists topic-lists list-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Topic.lists/topics_list');?>
</div>