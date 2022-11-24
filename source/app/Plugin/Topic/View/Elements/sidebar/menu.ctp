<ul class="list2 menu-list" id="browse">
    <li <?php if (empty($this->request->named['category_id'])): ?>class="current"<?php endif; ?> id="browse_all"><a class="json-view" data-url="<?php echo $this->request->base ?>/topics/browse/all" href="<?php echo $this->request->base ?>/topics"><?php echo __('All Topics') ?></a></li>
    <?php if (!empty($uid)): ?>
        <li id="my_topics"><a data-url="<?php echo $this->request->base ?>/topics/browse/my" href="<?php echo $this->request->base ?>/topics"><?php echo __('My Topics') ?></a></li>
        <li id="friend_topics"><a data-url="<?php echo $this->request->base ?>/topics/browse/friends" href="<?php echo $this->request->base ?>/topics"><?php echo __("Friends' Topics") ?></a></li>
    <?php endif; ?>
    <li class="separate"></li>
</ul>