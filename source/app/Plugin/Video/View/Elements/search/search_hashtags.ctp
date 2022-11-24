<div class="core-lists video-lists grid-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Video.lists/videos_list');?>
</div>
