<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooSearch"], function($,mooSearch) {
        mooSearch.init();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooSearch'), 'object' => array('$', 'mooSearch'))); ?>
mooSearch.init();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<?php $keyword = urlencode($keyword);?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Search Filters')?></h3>
        </div>
    </div>
    <div class="box_content box_menu">
        <ul id="global-search-filters" class="menu-list">
            <li class="menu-list-item current">
                <a class="menu-list-link no-ajax" href="<?php echo $this->request->base?>/search/index/<?php echo $keyword?>">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-list">list</span>
                    <span class="menu-list-text"><?php echo __('All Results')?></span>
                </a>
            </li>
            <li class="menu-list-item">
                <a class="menu-list-link" data-url="<?php echo $this->request->base?>/search/suggestion/user/<?php echo $keyword?>" id="filter-users" href="#">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-person">person</span>
                    <span class="menu-list-text"><?php echo __('People')?></span>
                </a>
            </li>
            <li class="menu-list-item">
                <a class="menu-list-link" data-url="<?php echo $this->request->base?>/search/suggestion/activity/<?php echo $keyword?>" id="filter-activities" href="#">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-library_books">library_books</span>
                    <span class="menu-list-text"><?php echo __('Activities')?></span>
                </a>
            </li>
            <?php if ( !empty( $searches ) ): ?>
                <?php foreach($searches as $k => $search):?>
                    <li class="menu-list-item">
                        <a class="menu-list-link" data-url="<?php echo $this->request->base?>/search/suggestion/<?php echo lcfirst($k);?>/<?php echo $keyword;?>" id="filter-<?php echo strtolower($k);?>s" href="#">
                            <span class="menu-list-icon material-icons moo-icon moo-icon-<?php echo $search['icon_class']?>"><?php echo $search['icon_class']?></span>
                            <span class="menu-list-text"><?php echo $search['header']?></span>
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
    </div>
</div>
<?php $this->end(); ?>

<div id="search_result_content">
    <div class="bar-content">
        <div class="box2">
            <div class="box_heading_title">
                <h1 class="box_heading_text"><?php echo __('Search Results')?> "<?php echo h($keyword)?>"</h1>
            </div>
        </div>
    </div>
    <div id="search-content">
    <div class="bar-content">
    <?php if ( !empty( $users ) ): ?>
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('People')?></h3>
                    <div class="box_action">
                        <a class="btn btn-primary btn-cs globalSearchMore" href="javascript:void(0)" data-query="users">
                            <span class="btn-cs-main">
                                <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                <span class="btn-text"><?php echo __('View More Results')?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box_content">
                <div class="user-lists grid-view">
                    <?php echo $this->element( 'lists/users_list' ); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( !empty( $activities) ): ?>
        <div class="box2 bar-content-activities">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Activities')?></h3>
                    <div class="box_action">
                        <a class="btn btn-primary btn-cs globalSearchMore" href="javascript:void(0)" data-query="activities">
                            <span class="btn-cs-main">
                                <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                <span class="btn-text"><?php echo __('View More Results')?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box_content">
                <div id="list-content" class="feed-entry-lists">
                    <?php echo $this->element( 'activities' ); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php $emptyResult = true; ?>
    <?php if ( !empty( $searches ) ): ?>
        <?php foreach($searches as $k => $search):?>
            <?php if(!empty($search['notEmpty'])): ?>
                <div class="box2 bar-content-warp">
                    <div class="box_header">
                        <div class="box_header_main">
                            <h3 class="box_header_title"><?php echo $search['header']?></h3>
                            <div class="box_action">
                                <a class="btn btn-primary btn-cs globalSearchMore" href="javascript:void(0)" data-query="<?php echo strtolower($k);?>s">
                                    <span class="btn-cs-main">
                                        <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                        <span class="btn-text"><?php echo __('View More Results')?></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class='box_content'>
                        <?php echo $this->element('search/search_results', array('search_view' => $search['view'], 'plugin' => $k), array('plugin' => $k));?>
                        <?php //echo $this->element($search['view'], array(), array('plugin' => $k));?>
                    </div>
                </div>
                 <?php $emptyResult = false; ?>
            <?php endif; ?>
        <?php endforeach;?>
    <?php endif; ?>

    <?php if($emptyResult): ?>
    <div class="box2 bar-content-warp">
        <div class="box_content">
            <div class="no-more-results"><?php echo __('No result found')?></div>
        </div>
    </div>
    <?php endif; ?>
    </div>
</div>
</div>

