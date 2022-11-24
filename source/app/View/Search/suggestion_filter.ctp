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

<?php if($this->request->is('ajax')) $this->setCurrentStyle(2); ?>
<?php if(!$this->request->is('ajax')):?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Search Filters')?></h3>
        </div>
    </div>
    <div class='box_content box_menu'>
        <ul id="global-search-filters" class="menu-list">
            <li class="menu-list-item">
                <a class="menu-list-link no-ajax" href="<?php echo $this->request->base?>/search/index/<?php echo $keyword?>">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-list">list</span>
                    <span class="menu-list-text"><?php echo __('All Results')?></span>
                </a>
            </li>
            <li class="menu-list-item <?php echo  ($type == 'user')? 'current':'' ?>">
                <a class="menu-list-link" data-url="<?php echo $this->request->base?>/search/suggestion/user/<?php echo $keyword?>" id="filter-users" href="#">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-person">person</span>
                    <span class="menu-list-text"><?php echo __('People')?></span>
                </a>
            </li>
            <?php if ( !empty( $other_header ) ): ?>
                <?php foreach($other_header as $k => $value):?>
                    <li class="menu-list-item <?php echo ($type == $k)? 'current':'' ?>">
                        <a class="menu-list-link" data-url="<?php echo $this->request->base?>/search/suggestion/<?php echo  lcfirst($k);?>/<?php echo $keyword;?>" id="filter-<?php echo strtolower($k);?>s" href="#">
                            <span class="menu-list-icon material-icons moo-icon moo-icon-<?php echo $value['icon_class']?>"><?php echo $value['icon_class']?></span>
                            <span class="menu-list-text"><?php echo $value['header']?></span>
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
    </div>
</div>
<?php $this->end(); ?>
<?php endif; ?>
<?php if (!empty($is_activity)):?>

    <?php if(isset($page) && $page != 1): ?>
        <?php echo $this->element('activities');?>
        <?php return;?>
    <?php endif;?>
    <div id="search_result_content">
        <div class="bar-content">
            <div class="box2">
                <div class="box_heading_title">
                    <h1 class="box_heading_text"><?php echo __('Search Results')?> "<?php echo h($keyword)?>"</h1>
                </div>
            </div>
        </div>
        <div class="bar-content">
            <div id="search-content">
                <div class="box2 bar-content-warp">
                    <div class="box_header">
                        <div class="box_header_main">
                            <h3 class="box_header_title"><?php echo __('Activities')?></h3>
                        </div>
                    </div>
                    <div class="box_content">
                        <?php if ( !empty( $activities ) ): ?>
                            <?php if(isset($page) && $page == 1): ?>
                                <div id="list-content" class="feed-entry-lists">
                            <?php endif ?>
                            <?php echo $this->element('activities');?>
                            <?php if(isset($page) && $page == 1): ?>
                                </div>
                            <?php endif ?>
                        <?php else:?>
                            <div class="no-more-results"><?php echo __('Nothing found')?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php return; endif;?>
<?php if(empty($more_link)):  ?>
<div id="search_result_content">
    <div class="bar-content">
        <div class="box2">
            <div class="box_heading_title">
                <h1 class="box_heading_text"><?php echo __('Search Results')?> "<?php echo h($keyword)?>"</h1>
            </div>
        </div>
    </div>

	<div class="bar-content">
	    <div id="search-content">
	        <?php if ( !empty( $result ) ): ?>
	        	<?php if(isset($type) && $type == 'user'):?>
	                <?php if(isset($page) && $page == 1): ?>
	                <div class="box2 bar-content-warp">
	                    <div class="box_header">
	                        <div class="box_header_main">
	                            <h3 class="box_header_title"><?php echo __('People')?></h3>
	                        </div>
	                    </div>
	                    <div class="box_content">
	                        <div id="list-content" class="user-lists grid-view">
	                <?php endif ?>
	                    <?php echo $this->element($element_list_path);?>
	                <?php if(isset($page) && $page == 1): ?>
	                        </div>
	                    </div>
	                </div>
	                <?php endif ?>
	            <?php else: ?>
	            <div class="box2 bar-content-warp">
	                <div class="box_header">
	                    <div class="box_header_main">
	                        <h3 class="box_header_title"><?php echo $element_search_header; ?></h3>
	                    </div>
	                </div>
	                <div class="box_content">
	                    <div class="search-list-filter">
	                        <?php echo $this->element($element_search_path, array('element_list_path' => $element_list_path, 'suggestion_filter' => true));?>
	                        <?php //echo $this->element($element_list_path);?>
	                    </div>
	                </div>
	            </div>
	            <?php endif; ?>
	        <?php else:?>
	            <div class="no-more-results"><?php echo __('Nothing found')?></div>
	        <?php endif; ?>
	    </div>
	</div>
</div>
<?php else: ?>
    <?php if ( !empty( $result ) ): ?>
        <?php if(isset($page) && $page == 1): ?>
            <div id="list-content" class="user-lists grid-view">
        <?php endif; ?>
            <?php echo $this->element($element_list_path);?>
        <?php if(isset($page) && $page == 1): ?>
            </div>
        <?php endif; ?>
    <?php else:?>
        <div class="no-more-results"><?php echo __('Nothing found')?></div>
    <?php endif; ?>
<?php endif; ?>