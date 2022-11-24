<?php
if(Configure::read('Group.group_enabled') == 1 && $uid):
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
if ( !( empty($uid) && Configure::read('core.force_login') ) ):
    $aMyJoinedGroup = $myJoinedGroupWidget;
if (count($aMyJoinedGroup) > 0):
?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title">
                <?php if(empty($title)) $title = "My Joined Groups";?>
                <?php echo h($title) ?>
            </h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="box_content box_myjoined_group box-region-<?php echo $region ?>">
        <div class="core-lists group-myjoined-lists list-view">
        <?php
            $i = 1;
            foreach ($aMyJoinedGroup as $group):
        ?>
            <div class="core-list-item">
                <div class="core-item-warp">
                    <div class="core-item-figure">
                        <a class="core-item-thumb" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/<?php echo seoUrl($group['Group']['name'])?>">
                            <img class="core-item-img" alt="<?php echo $group['Group']['name']?>" src="<?php echo $groupHelper->getImage($group, array('prefix' => '300_square'))?>">
                        </a>
                    </div>
                    <div class="core-item-info">
                        <div class="core-item-head">
                            <a class="core-item-title" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/<?php echo seoUrl($group['Group']['name'])?>"><?php echo $this->Text->truncate($group['Group']['name'], 35 )?></a>
                        </div>
                        <div class="core-item-like_count">
                            <span class="item-count"><?php echo __n('%s member', '%s members', $group['Group']['group_user_count'], $group['Group']['group_user_count'] )?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $i++;
            endforeach;
        ?>
        </div>
    </div>
</div>
<?php
endif;
endif;
endif;
?>
