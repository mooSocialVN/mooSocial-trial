<ul class="list2 menu-list" id="browse">
    <li class="current json-view" id="browse_all"><a data-url="<?php echo $this->request->base ?>/groups/browse/all" href="<?php echo $this->request->base ?>/groups"><?php echo __('All Groups') ?></a></li>
    <?php if (!empty($uid)): ?>
        <li><a class="json-view" data-url="<?php echo $this->request->base ?>/groups/browse/my" href="<?php echo $this->request->base ?>/groups"><?php echo __('My Groups') ?></a></li>
        <li><a class="json-view" data-url="<?php echo $this->request->base ?>/groups/browse/friends" href="<?php echo $this->request->base ?>/groups"><?php echo __("Friends' Groups") ?></a></li>
    <?php endif; ?>
    <li class="separate"></li>
</ul>