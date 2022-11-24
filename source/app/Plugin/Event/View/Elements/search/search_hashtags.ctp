<div class="core-lists event-lists list-view" <?php if(isset($suggestion_filter) && $suggestion_filter): ?>id="list-content"<?php endif; ?>>
    <?php echo $this->element('Event.lists/events_list');?>
</div>