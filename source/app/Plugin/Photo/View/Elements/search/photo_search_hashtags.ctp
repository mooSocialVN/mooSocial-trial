<div class="photo-lists" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Photo.lists/photos_list');?>
</div>
