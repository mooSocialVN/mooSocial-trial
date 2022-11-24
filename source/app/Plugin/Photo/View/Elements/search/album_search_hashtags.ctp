<div class="album-lists" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="album-list-content"<?php endif; ?>>
    <?php echo $this->element('Photo.lists/albums_list');?>
</div>
