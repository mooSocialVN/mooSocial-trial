<?php
echo $this->Html->css(array('jquery.mp'), null, array('inline' => false));
echo $this->Html->script(array('jquery.mp.min'), array('inline' => false)); 
?>
<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Categories') ?></h3>
        </div>
    </div>
    <div class="box_content box_menu">
        <?php echo $this->element('lists/categories_list')?>
    </div>
</div>
<?php $this->end(); ?>
<?php $this->setNotEmpty('east');?>

<?php echo $this->element('browse_tabs')?>

<div class="box2 box_browse bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
        	<?php 
        		$title = __('All Blogs');
        		if (!empty($category_name))
        		{
        			$title = $category_name;
        		}
        	?>
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis" header-title="<?php echo $title?>"><?php echo $title?></h1>
            <div class="box_action">
                <?php if(!Configure::read('core.guest_search') && empty($uid)): ?><?php else: ?>
                <a class="box-btn btn-header_icon open-main-search-btn" href="javascript:void(0);">
                    <span class="btn-icon material-icons moo-icon moo-icon-search">search</span>
                </a>
                <?php endif; ?>
                <?php if (!empty($uid)): ?>
                <a class="box-btn btn-header_icon box-add box-scrolling-hide" href="<?php echo $this->request->base?>/blogs/create" title="<?php echo __('Write New Entry')?>">
                    <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if(!Configure::read('core.guest_search') && empty($uid)): ?><?php else: ?>
            <?php echo $this->element('advanced_search_form'); ?>
        <?php endif; ?>
    </div>
    <div class="box_content">
        <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'list-view') ); ?>
        <div id="list-content" class="core-lists blog-lists list-view">
            <?php 
			if ( !empty( $this->request->named['category_id'] )  || !empty($cat_id)){
				if (empty($cat_id)){
					$cat_id = $this->request->named['category_id'];
				}
				echo $this->element( 'lists/blogs_list', array( 'more_url' => '/blogs/browse/category/' . $cat_id . '/page:2' ) );
			}
			else {
				echo $this->element( 'lists/blogs_list', array( 'more_url' => '/blogs/browse/all/page:2' ) );
	        }
			?>	       
        </div>
    </div>
</div>
