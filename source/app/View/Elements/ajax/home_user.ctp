<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery",'mooUser','mooSearchItem',"mooBehavior"], function($, mooUser ,mooSearchItem, mooBehavior) {
        mooBehavior.initMoreResults();
        $('#form_friend_search_wrap').SearchItemUI({asButtonOpenFor: '.open-friend-search-btn'});
        mooUser.initSearchFriend(0);
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser', 'mooSearchItem', 'mooBehavior'), 'object' => array('$', 'mooUser','mooSearchItem','mooBehavior'))); ?>
    mooBehavior.initMoreResults();
    $('#form_friend_search_wrap').SearchItemUI({asButtonOpenFor: '.open-friend-search-btn'});
    mooUser.initSearchFriend(0);
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Friends')?></h3>
            <div class="box_action">
                <a class="box-btn btn-header_icon open-friend-search-btn" href="javascript:void(0);">
                    <span class="btn-icon material-icons moo-icon moo-icon-search">search</span>
                </a>
                <?php if (Configure::read("core.allow_invite_friend")):?>
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/user_info/index/invite_friends">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                        <span class="btn-text hidden-xs"><?php echo __('Invite Friends')?></span>
                    </span>
                </a>
                <?php endif;?>
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

    <div class="box_content content_center_home">
        <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
        <div id="list-content" class="user-lists grid-view">
            <?php echo $this->element( 'lists/users_list' ); ?>
        </div>
    </div>
</div>