<?php
if(Configure::read('Blog.blog_enabled') == 1):
    if(empty($title)) $title = "Popular Entries";
    if(empty($num_item_show)) $num_item_show = 10;
    if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
   
    $blogHelper = MooCore::getInstance()->getHelper('Blog_Blog')
    ?>
    <?php if (!empty($popular_blogs)): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo h($title) ?></h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content box_popular_blog box-region-<?php echo $region ?>">
            <?php
            if (!empty($popular_blogs)):
                ?>
                <div class="core-lists blog-popular-lists <?php echo ($region == 'center') ? 'grid-view': 'list-view'; ?>">
                    <?php foreach ($popular_blogs as $blog): ?>
                        <div class="core-list-item">
                            <div class="core-item-warp">
                                <div class="core-item-figure">
                                    <a class="core-item-thumb" href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                                        <img class="core-item-img" src="<?php echo $blogHelper->getImage($blog, array('prefix' => '300_square'))?>">
                                    </a>
                                </div>
                                <div class="core-item-info">
                                    <div class="core-item-head">
                                        <a class="core-item-title" href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>"><?php echo $blog['Blog']['title'];?></a>
                                    </div>
                                    <div class="core-item-like_count">
                                        <span class="item-count"><?php echo __n('%s comment', '%s comments', $blog['Blog']['comment_count'], $blog['Blog']['comment_count'] )?></span> . <span class="item-count"><?php echo __n('%s like', '%s likes', $blog['Blog']['like_count'], $blog['Blog']['like_count'] )?></span>
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
    <?php endif; ?>
<?php endif; ?>