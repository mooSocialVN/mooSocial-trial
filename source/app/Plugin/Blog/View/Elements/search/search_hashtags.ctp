<div class="core-lists blog-lists list-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Blog.lists/blogs_list');?>
</div>
