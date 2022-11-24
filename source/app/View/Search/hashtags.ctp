<?php if($this->request->is('ajax')) $this->setCurrentStyle(2); ?>
<?php if(!$this->request->is('ajax')):?>
    <?php $this->setNotEmpty('west');?>
    <?php $this->start('west'); ?>
    <?php $searchParams = array('tabs'=>((!empty($tabs))? $tabs : ''),'link'=>$this->request->base.'/search/hashtags/'.$keyword); ?>
    
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooSearch'), 'object' => array('$', 'mooSearch'))); ?>
    var searchParams = '<?php echo json_encode($searchParams); ?>';
    mooSearch.hashInit(searchParams);
    <?php $this->Html->scriptEnd(); ?>

    <div class="box2 bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __('Search Filters')?></h3>
            </div>
        </div>
        <div class="box_content box_menu">
            <ul class="menu-list" id="global-search-filters">
                <li class="menu-list-item <?php echo ($type == 'all')? 'current':'' ?>">
                    <a class="menu-list-link no-ajax" href="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>">
                        <span class="menu-list-icon material-icons moo-icon moo-icon-list">list</span>
                        <span class="menu-list-text"><?php echo __('All Results')?></span>
                    </a>
                </li>
                <?php if(!empty($activities)): ?>
                <li class="menu-list-item <?php echo ($type == 'activities') ? 'current':'' ?>">
                    <a class="menu-list-link" href="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>/tabs:activities" data-url="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>/activities" id="filter-activities" href="#">
                        <span class="menu-list-icon material-icons moo-icon moo-icon-person">person</span>
                        <span class="menu-list-text"><?php echo __('Activities')?></span>
                    </a>
                </li>
                    <?php
                        echo $this->Html->script(array('jquery.fileuploader'),array('inline' => false));
                        echo $this->Html->css(array( 'fineuploader' ));
                    ?>
                <?php endif; ?>
                <?php if(!empty($comments) || !empty($activity_comments)): ?>
                <li class="menu-list-item <?php echo ($type == 'comments')? 'current':'' ?>">
                    <a class="menu-list-link" href="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>/tabs:comments" data-url="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>/comments" id="filter-comments" href="#">
                        <span class="menu-list-icon material-icons moo-icon moo-icon-comment">comment</span>
                        <span class="menu-list-text"><?php echo __('Comments')?></span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ( !empty( $other_suggestion ) ): ?>
                    <?php foreach($other_suggestion as $k => $value):?>
                        <li class="menu-list-item <?php echo  ($type == $k)? 'current':'' ?>">
                            <a class="menu-list-link" href="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword?>/tabs:<?php echo  lcfirst($k);?>" data-url="<?php echo $this->request->base?>/search/hashtags/<?php echo $keyword;?>/<?php echo  lcfirst($k);?>" id="filter-<?php echo strtolower($k);?>" href="#">
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

<div id="search_result_content">
<div class="bar-content">
    <div class="box2">
        <div class="box_heading_title">
            <h1 class="box_heading_text"><?php echo __('Search Results')?> "#<?php echo h($keyword)?>"</h1>
        </div>
    </div>
</div>

<?php if(empty($tabs)): ?>
    <?php if($type != 'all'): ?>
        <?php if(empty($more_link)):  ?>
            <!--<div class="box_header_main">
                <h3 class="box_header_title"><?php /*echo __('Search Results')*/?> "#<?php /*echo h($keyword)*/?>"</h3>
            </div>-->

            <div id="search-content">
                <div class="bar-content">
                    <?php if ( !empty( $result ) ): ?>
                        <?php echo $this->element($element_list_path);?>
                    <?php else: ?>
                        <div class="box2 bar-content-warp">
                            <div class="box_content">
                                <div class="no-more-results"><?php echo __('Nothing found')?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php if ( !empty( $result ) ): ?>
                <?php if(isset($page) && $page == 1): ?>
                    <div id="list-content" class="user-lists list-view">
                <?php endif; ?>
                <?php echo $element_list_path; echo $this->element($element_list_path);?>
                <?php if(isset($page) && $page == 1): ?>
                    </div>
                <?php endif; ?>
            <?php else:?>
                <div class="box2 bar-content-warp">
                    <div class="box_content">
                        <div class="no-more-results"><?php echo __('Nothing found')?></div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <!--<div class='mo_breadcrumb'>
            <h1><?php /*echo __('Search Results')*/?> "#<?php /*echo h($keyword)*/?>"</h1>
        </div>-->
        <div id="search-content">
            <div class="bar-content">
            <?php if ( !empty( $activities ) ): ?>
                <div class="box2 bar-content-activities">
                    <div class="box_header">
                        <div class="box_header_main">
                            <h3 class="box_header_title"><?php echo __('Activities')?></h3>
                            <div class="box_action">
                                <?php if(empty($filter)): ?>
                                    <a href="javascript:void(0)" data-query="activities" class="btn btn-primary btn-cs globalSearchMore">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                            <span class="btn-text"><?php echo __('View More Results')?></span>
                                        </span>
                                    </a>
                                <?php else: ?>
                                    <?php echo $this->Html->link(__('View More Results'),array('controller' => 'search','action' => 'hashtags',$keyword,'activities'),array('class' => 'button')) ?>
                                <?php endif; ?>
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

            <?php if ( !empty( $comments ) || !empty($activity_comments) ): ?>
                <div class="box2 bar-content-warp">
                    <div class="box_header">
                        <div class="box_header_main">
                            <h3 class="box_header_title"><?php echo __('Comments')?></h3>
                            <div class="box_action">
                                <?php if(empty($filter)): ?>
                                    <a href="javascript:void(0)" data-query="comments" class="btn btn-primary btn-cs globalSearchMore">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                            <span class="btn-text"><?php echo __('View More Results')?></span>
                                        </span>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-primary btn-cs globalSearchMore" href="<?php echo $this->Html->url(array('controller' => 'search','action' => 'hashtags',$keyword,'comments')) ?>">
                                        <span class="btn-cs-main">
                                            <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                            <span class="btn-text"><?php echo __('View More Results')?></span>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="box_content">
                        <div id="comments" class="comment_lists comment_parent_lists">
                            <?php echo $this->element( 'lists/comments_list' ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( !empty( $other_suggestion ) ): ?>
                <?php foreach($other_suggestion as $k => $search):?>
                    <div class="box2 bar-content-warp">
                        <div class="box_header">
                            <div class="box_header_main">
                                <h3 class="box_header_title"><?php echo $search['header']?></h3>
                                <div class="box_action">
                                    <?php if(empty($filter)): ?>
                                        <a href="javascript:void(0)" data-query="<?php echo strtolower($k);?>" class="btn btn-primary btn-cs globalSearchMore">
                                            <span class="btn-cs-main">
                                                <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                                <span class="btn-text"><?php echo __('View More Results')?></span>
                                            </span>
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-primary btn-cs globalSearchMore" href="<?php echo $this->Html->url(array('controller' => 'search','action' => 'hashtags',$keyword,strtolower($k))) ?>">
                                            <span class="btn-cs-main">
                                                <span class="btn-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
                                                <span class="btn-text"><?php echo __('View More Results')?></span>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="box_content">
                            <?php echo $this->element($search['view']);?>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif; ?>

            <?php if(empty($activities) && empty($activity_comments) && empty($comments) && empty($other_suggestion)): ?>
                <div class="box2 bar-content-warp">
                    <div class="box_content">
                        <div class="no-more-results"><?php echo __('Nothing found')?></div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>
