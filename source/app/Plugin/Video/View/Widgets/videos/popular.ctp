<?php
if(Configure::read('Video.video_enabled') == 1):
    if(empty($title)) $title = "Popular Videos";
    if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

    $videoHelper = MooCore::getInstance()->getHelper('Video_Video');
    ?>
    <?php if (!empty($popular_videos)): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo $title?></h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content box_popular_video box-region-<?php echo $region ?>">
            <?php
            if (!empty($popular_videos)):
                ?>
                <div class="core-lists video-lists grid-view">
                    <?php foreach ($popular_videos as $video): ?>
                        <div class="core-list-item">
                            <div class="core-item-warp">
                                <div class="core-item-figure">
                                    <a class="video_cover" href="<?php echo $this->request->base?>/videos/view/<?php echo $video['Video']['id']?>/<?php echo seoUrl($video['Video']['title'])?>">
                                        <img class="vieo-item-img" src='<?php echo $videoHelper->getImage($video, array('prefix' => '450'))?>' />
                                    </a>
                                </div>
                                <div class="core-item-info">
                                    <div class="core-item-head">
                                        <a class="core-item-title" href=<?php if ( !empty( $ajax_view ) ): ?>"javascript:void(0)" onclick="loadPage('videos', '<?php echo $this->request->base?>/videos/ajax_view/<?php echo $video['Video']['id']?>', true)"<?php else: ?>"<?php echo $this->request->base?>/videos/view/<?php echo $video['Video']['id']?>/<?php echo seoUrl($video['Video']['title'])?>"<?php endif; ?>><?php echo $this->Text->truncate( $video['Video']['title'], 100 )?></a>
                                    </div>
                                    <div class="core-item-like_count">
                                        <span class="item-count"><?php echo __n('%s like','%s likes',$video['Video']['like_count'],$video['Video']['like_count']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php
            else:
                echo '<div class="no-more-results">'.__( 'Nothing found').'</div>';
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>