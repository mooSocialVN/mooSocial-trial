<?php if (Configure::read('Group.group_enabled') == 1): ?>
    <?php if (!empty($groups)): ?>
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo  __('Groups') ?></h3>
                </div>
            </div>
            <div class="box_content box_block_group box-region-<?php echo $region ?>">
                <?php
                $groupHelper = MooCore::getInstance()->getHelper('Group_Group');
                ?>
                <?php if (!empty($groups)): ?>
                <div class="core-lists group-myjoined-lists list-view">
                <?php foreach ($groups as $group): ?>
                    <div class="core-list-item">
                        <div class="core-item-warp">
                            <div class="core-item-figure">
                                <a class="core-item-thumb" href="<?php echo  $this->request->base ?>/groups/view/<?php echo  $group['Group']['id'] ?>/<?php echo  seoUrl($group['Group']['name']) ?>">
                                    <img class="core-item-img" src="<?php echo  $groupHelper->getImage($group, array('prefix' => '75_square')); ?>">
                                </a>
                            </div>
                            <div class="core-item-info">
                                <div class="core-item-head">
                                    <a class="core-item-title" href="<?php echo  $this->request->base ?>/groups/view/<?php echo  $group['Group']['id'] ?>/<?php echo  seoUrl($group['Group']['name']) ?>"><?php echo  $this->Text->truncate($group['Group']['name'], 50, array('exact' => false)) ?></a>
                                </div>
                                <div class="core-item-like_count">
                                    <span class="item-count"><?php echo  __n('%s member', '%s members', $group['Group']['group_user_count'], $group['Group']['group_user_count']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>