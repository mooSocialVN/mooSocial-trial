<div class="core-lists group-lists list-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Group.lists/groups_list');?>
</div>