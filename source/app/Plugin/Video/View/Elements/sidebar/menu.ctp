<ul class="list2 menu-list" id="browse">
    <li <?php if (empty($this->request->named['category_id'])): ?>class="current"<?php endif; ?> id="browse_all"><?php echo $this->Html->link(__('All Videos'), '/videos', array('class' => "json-view", 'data-url' => $this->request->base . "/videos/browse/all")); ?></li>
    <?php if (!empty($uid)): ?>
        <li><?php echo $this->Html->link(__('My Videos'),"/videos", array('class' => "json-view", 'data-url' => $this->request->webroot . "videos/browse/my")); ?></li>
        <li><?php echo $this->Html->link(__("Friends' Videos"), "/videos", array('class' => "json-view", 'data-url' => $this->request->webroot . "videos/browse/friends")); ?></li>
    <?php endif; ?>
    <li class="separate"></li>
</ul>