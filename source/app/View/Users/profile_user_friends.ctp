<?php if (isset($profile_id)):?>
	<?php if($this->request->is('ajax')): ?>
        <script type="text/javascript">
            require(["jquery", 'mooUser', 'mooSearchItem',"mooBehavior"], function ($, mooUser, mooSearchItem, mooBehavior) {
                mooBehavior.initMoreResults();
                $('#form_friend_search_wrap').SearchItemUI({asButtonOpenFor: '.open-friend-search-btn'});
                mooUser.initSearchFriend(<?php echo $profile_id?>);
            });
        </script>
	<?php else: ?>
        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser', 'mooBehavior', 'mooSearchItem'), 'object' => array('$', 'mooUser','mooBehavior', 'mooSearchItem'))); ?>
            mooBehavior.initMoreResults();
            $('#form_friend_search_wrap').SearchItemUI({asButtonOpenFor: '.open-friend-search-btn'});
            mooUser.initSearchFriend(<?php echo $profile_id?>);
        <?php $this->Html->scriptEnd(); ?>
    <?php endif;?>
<?php endif; ?>
<div id="profile_friends">
    <div class="box2 bar-content-warp">
        <?php if (isset($profile_id)):?>
            <div class="box_header mo_breadcrumb">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Friends')?></h3>
                    <div class="box_action">
                        <a class="box-btn btn-header_icon open-friend-search-btn" href="javascript:void(0);">
                            <span class="btn-icon material-icons moo-icon moo-icon-search">search</span>
                        </a>
                    </div>
                </div>

                <div id="form_friend_search_wrap" class="box_header_search">
                    <div class="box_header_search_overview"></div>
                    <form id="form_friend_search" class="header-advanced-search" search-type="ajax" method="get">
                        <div class="header_search_holder">
                            <input id="search_friend" class="form-control advanced-search-keyword" type="text" placeholder="<?php echo __('Search Friends')?>">
                            <a id="" class="header_search_btn friend_search_btn" href="javascript:void(0);">
                                <span class="header-search-icon material-icons moo-icon moo-icon-search">search</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif;?>

        <?php if (isset($user_block) && ($user_block === true)):?>
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __('Blocked Members')?></h3>
            </div>
        </div>
        <?php endif;?>

        <div class="box_content">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
            <div id="list-content" class="user-lists grid-view">
                <?php echo $this->element('lists/users_list'); ?>
            </div>
        </div>
    </div>
</div>