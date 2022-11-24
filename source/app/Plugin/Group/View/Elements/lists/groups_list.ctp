<?php
if(Configure::read('Group.group_enabled') == 1):
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
?>

<?php
if (!empty($groups) && count($groups) > 0):
    $i = 1;
    foreach ($groups as $group):

        ?>
        <div class="core-list-item <?php if (!empty($uid) && ( ( !empty($group['Group']['my_status']) && $group['Group']['my_status']['GroupUser']['status'] == GROUP_USER_ADMIN ) || !empty($cuser['Role']['is_admin'] )) ): ?>core-is-owner<?php endif; ?>">
            <div class="core-item-warp">
                <div class="core-item-figure">
                    <a class="core-item-thumb" href="<?php echo  $this->request->base ?>/groups/view/<?php echo  $group['Group']['id'] ?>/<?php echo  seoUrl($group['Group']['name']) ?>">
                        <img class="core-item-img" src="<?php echo $groupHelper->getImage($group, array('prefix' => '300_square'))?>">
                    </a>
                </div>
                <div class="core-item-info">
                    <div class="core-item-head">
                        <a class="core-item-title" href="<?php echo  $this->request->base ?>/groups/view/<?php echo  $group['Group']['id'] ?>/<?php echo  seoUrl($group['Group']['name']) ?>">
                            <?php echo  $group['Group']['name'] ?>
                        </a>
                        <?php if (!empty($uid) && ( ( !empty($group['Group']['my_status']) && $group['Group']['my_status']['GroupUser']['status'] == GROUP_USER_ADMIN ) || !empty($cuser['Role']['is_admin'] )) ): ?>
                        <div class="list_option">
                            <?php if ( ( !empty($group['Group']['my_status']) && $group['Group']['my_status']['GroupUser']['status'] == GROUP_USER_ADMIN ) || $group['Group']['type'] != PRIVACY_PRIVATE  || !empty($cuser['Role']['is_admin'] )): ?>
                                <div class="dropdown">
                                    <button id="dropdown-edit" data-target="#" data-toggle="dropdown">
                                        <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                    </button>

                                    <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit">
                                        <?php if ( ( !empty($group['Group']['my_status']) && $group['Group']['my_status']['GroupUser']['status'] == GROUP_USER_ADMIN && $group['Group']['user_id'] == $cuser['User']['id'] ) || !empty($cuser['Role']['is_admin'] ) ): ?>
                                            <li><a href="<?php echo $this->request->base?>/groups/create/<?php echo $group['Group']['id']?>"><?php echo __( 'Edit Group')?></a></li>
                                            <li><a href="javascript:void(0)" data-id="<?php echo  $group['Group']['id'] ?>" class="deleteGroup"><?php echo __( 'Delete Group')?></a></li>
                                        <?php endif; ?>
                                        <li class="seperate"></li>
                                        <?php if ( !empty($my_status) && ( $my_status['GroupUser']['status'] == GROUP_USER_MEMBER || $my_status['GroupUser']['status'] == GROUP_USER_ADMIN ) && ( $uid != $group['Group']['user_id'] ) ): ?>
                                            <li><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to leave this group?'))?>', '<?php echo $this->request->base?>/groups/do_leave/<?php echo $group['Group']['id']?>')"><?php echo __('Leave Group')?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="core-item-like_count">
                        <span class="item-count"><?php
                            switch ($group['Group']['type']) {
                                case PRIVACY_PUBLIC:
                                    echo __( 'Public');
                                    break;

                                case PRIVACY_RESTRICTED:
                                    echo __( 'Restricted');
                                    break;

                                case PRIVACY_PRIVATE:
                                    echo __( 'Private');
                                    break;
                            }
                        ?></span> . <span class="item-count"><?php echo  __n('%s member', '%s members', $group['Group']['group_user_count'], $group['Group']['group_user_count']) ?></span>
                    </div>
                    <div class="core-item-description">
                        <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>','&nbsp;'), array(' ',''), $group['Group']['description'])), 200, array('exact' => false)), Configure::read('Group.group_hashtag_enabled')) ?>
                    </div>
                    <div class="core-extra_info">
                        <?php $this->Html->rating($group['Group']['id'],'groups', 'Group'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    endforeach;
else:
    echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
endif;
?>

<?php
if (!empty($more_result)):
    ?>

    <?php $this->Html->viewMore($more_url) ?>
    <?php
endif;
endif;
?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($,mooGroup) {
        mooGroup.initOnListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initOnListing();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>