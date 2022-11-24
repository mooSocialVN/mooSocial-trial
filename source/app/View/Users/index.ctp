<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initOnUserIndex();
        <?php if (!empty( $about ) || !empty( $values ) || !empty($online_filter) ): ?>
        $('#searchPeople').trigger('click');
        <?php endif; ?>
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserIndex();
<?php if (!empty( $about ) || !empty( $values ) || !empty($online_filter) ): ?>
$('#searchPeople').trigger('click');
<?php endif; ?>

<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
    <?php echo $this->element('user/search_form'); ?>
<?php $this->end(); ?>

<?php echo $this->element('user/browse_tabs')?>

<div class="box2 box_browse bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis"><?php echo __('Everyone')?></h1>
            <div class="box_action">
                <?php if (!Configure::read('core.guest_search') && empty($uid)): ?><?php else: ?>
                <a class="box-btn btn-header_icon open-main-search-btn" data-open="keyword" href="javascript:void(0);">
                    <span class="btn-icon material-icons moo-icon moo-icon-search">search</span>
                </a>
                <?php endif; ?>
                <?php if ($uid && Configure::read("core.allow_invite_friend")):?>
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/friends/ajax_invite?mode=model" data-target="#themeModal" data-toggle="modal" data-dismiss="" data-backdrop="static" title="<?php echo __('Invite Friends');?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span> <span class="btn-text hidden-xs"><?php echo __('Invite Friends');?></span>
                    </span>
                </a>
                <?php endif;?>
            </div>
        </div>
        <?php echo $this->element('user/advanced_search_form'); ?>
    </div>

    <div class="box_content">
        <!--<div class="core-flex core-section"><div class="core-flex-col core-flex-0"></div><div class="core-flex-col core-flex-1"></div></div>-->
        <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
        <div id="list-content" class="user-lists grid-view">
            <?php
            if (!empty( $about ) || !empty( $values ) || !empty($online_filter) )
                echo __('Loading...');
            else
                echo $this->element( 'lists/users_list', array( 'more_url' => '/users/ajax_browse/all/page:2' ) );
            ?>
        </div>
    </div>

</div>