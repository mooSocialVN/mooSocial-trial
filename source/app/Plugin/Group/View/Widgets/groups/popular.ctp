<?php
if(Configure::read('Group.group_enabled') == 1):
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
if(empty($title)) $title = "Popular Groups";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

$popular_groups = $popularGroupWidget;
?>
<?php if (!empty($popular_groups)): ?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title">
                <?php echo h($title) ?>
            </h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="box_content box_popular_group box-region-<?php echo $region ?>">
        <?php
        if (!empty($popular_groups)):
            ?>
            <div class="core-lists group-popular-lists list-view">
            <?php foreach ($popular_groups as $group): ?>
                <div class="core-list-item">
                    <div class="core-item-warp">
                        <div class="core-item-figure">
                            <a class="core-item-thumb" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/<?php echo seoUrl($group['Group']['name'])?>">
                                <img class="core-item-img" alt="<?php echo $group['Group']['name']?>" src="<?php echo $groupHelper->getImage($group, array('prefix' => '300_square'))?>">
                            </a>
                        </div>
                        <div class="core-item-info">
                            <div class="core-item-head">
                                <a class="core-item-title" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/<?php echo seoUrl($group['Group']['name'])?>"><?php echo $group['Group']['name'] ?></a>
                            </div>
                            <div class="core-item-like_count">
                                <span class="item-count"><?php echo __n('%s member', '%s members', $group['Group']['group_user_count'], $group['Group']['group_user_count'] )?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php
        else:
            echo '<div class="no-more-results">'.__('Nothing found').'</div>';
        endif;
        ?>
    </div>
</div>
<?php endif;
endif; ?>