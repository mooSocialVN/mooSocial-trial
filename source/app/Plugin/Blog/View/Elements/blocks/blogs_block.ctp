<?php if (Configure::read('Blog.blog_enabled') == 1): ?>
    <?php if (!empty($blogs)): ?>
       <div class="box2 bar-content-warp">
           <div class="box_header">
               <div class="box_header_main">
                   <h3 class="box_header_title"><?php echo !empty($title) ? $title: __('Blogs'); ?></h3>
               </div>
           </div>
            <div class="box_content box_other_blog box-region-<?php echo $region ?>">
                <?php
                $blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
                ?>
                <div class="core-lists blog-popular-lists <?php echo ($region == 'center') ? 'grid-view': 'list-view'; ?>">
                    <?php foreach ($blogs as $blog): ?>
                    <div class="core-list-item">
                        <div class="core-item-warp">
                            <div class="core-item-figure">
                                <a class="core-item-thumb" href="<?php echo  $this->request->base ?>/blogs/view/<?php echo  $blog['Blog']['id'] ?>/<?php echo  seoUrl($blog['Blog']['title']) ?>">
                                    <img class="core-item-img" src="<?php echo  $blogHelper->getImage($blog, array('prefix' => '300_square')) ?>">
                                </a>
                            </div>
                            <div class="core-item-info">
                                <div class="core-item-head">
                                    <a class="core-item-title" href="<?php echo  $this->request->base ?>/blogs/view/<?php echo  $blog['Blog']['id'] ?>/<?php echo  seoUrl($blog['Blog']['title']) ?>"><?php echo $blog['Blog']['title']; ?></a>
                                </div>
                                <div class="core-item-like_count">
                                    <span class="item-count"><?php echo  __n('%s comment', '%s comments', $blog['Blog']['comment_count'], $blog['Blog']['comment_count']) ?></span> . <span class="item-count"><?php echo  __n('%s like', '%s likes', $blog['Blog']['like_count'], $blog['Blog']['like_count']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
       </div>
    <?php endif; ?>
<?php endif; ?>