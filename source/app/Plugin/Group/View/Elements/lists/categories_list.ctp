<?php $categories = $this->requestAction("groups/categories_list/"); ?>

<ul class="browse-menu menu-list <?php if (Configure::read('core.enable_category_toggle')) echo 'menu-list-toggle' ?>">
    <?php foreach ($categories as $cat): ?>
        <?php if ($cat['Category']['header']): ?>
            <li class="menu-list-item hasChild">
                <span class="menu-list-link menu-list-header header-arrow">
                    <?php echo $cat['Category']['name'] ?>
                </span>
                <?php if (!empty($cat['children'])): ?>
                <ul class="menu-list-dropdown">
                    <?php foreach ($cat['children'] as $subcat): ?>
                        <li id="cat_<?php echo $subcat['Category']['id'] ?>" class="menu-list-sub-item <?php if (!empty($cat_id) && $cat_id == $subcat['Category']['id']) echo 'current'; ?>">
                            <a class="menu-list-link has-badge core-menu-ajax" header-title="<?php echo $subcat['Category']['name'] ?>" data-url="<?php echo $this->request->base ?>/groups/browse/category/<?php echo $subcat['Category']['id'] ?>" <?php if (!empty($subcat['Category']['description'])): ?>title="<?php echo $subcat['Category']['description']; ?>"<?php endif ?> href="<?php echo $this->request->base ?>/<?php echo $this->request->controller ?>/index/<?php echo $subcat['Category']['id'] ?>/<?php echo seoUrl($subcat['Category']['name']) ?>">
                                <?php echo $subcat['Category']['name'] ?>
                                <span class="badge_counter"><?php echo $subcat['Category']['item_count'] ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
        <?php else: ?>
            <li id="cat_<?php echo $cat['Category']['id'] ?>" class="menu-list-item <?php if (!empty($cat_id) && $cat_id == $cat['Category']['id']) echo "current"; ?>">
                <a class="menu-list-link has-badge core-menu-ajax" header-title="<?php echo $cat['Category']['name'] ?>" data-url="<?php echo $this->request->base ?>/groups/browse/category/<?php echo $cat['Category']['id'] ?>" <?php if (!empty($cat['Category']['description'])): ?>title="<?php echo $cat['Category']['description'] ?>"<?php endif ?> href="<?php echo $this->request->base ?>/<?php echo $this->request->controller ?>/index/<?php echo $cat['Category']['id'] ?>/<?php echo seoUrl($cat['Category']['name']) ?>">
                    <?php echo $cat['Category']['name'] ?>
                    <span class="badge_counter"><?php echo $cat['Category']['item_count'] ?></span>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>