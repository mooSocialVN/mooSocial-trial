<?php if (Configure::read('Video.video_enabled') == 1): ?>
    <?php if (count($videos) > 0): ?>
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo  __('Videos') ?></h3>
                </div>
            </div>
            <div class="box_content box_block_video box-region-<?php echo $region ?>">
                <?php
                $videoHelper = MooCore::getInstance()->getHelper('Video_Video');
                ?>
                <div class="core-lists video-lists grid-view">
                    <?php foreach ($videos as $video): ?>
                        <div class="core-list-item">
                            <div class="core-item-warp">
                                <div class="core-item-figure">
                                    <a class="video_cover" href="<?php echo  $this->request->base ?>/videos/view/<?php echo  $video['Video']['id'] ?>/<?php echo  seoUrl($video['Video']['title']) ?>">
                                        <img class="vieo-item-img" src="<?php echo  $videoHelper->getImage($video, array('prefix' => '450')) ?>">
                                    </a>
                                </div>
                                <div class="core-item-info">
                                    <div class="core-item-head">
                                        <a class="core-item-title" href="<?php echo  $this->request->base ?>/videos/view/<?php echo  $video['Video']['id'] ?>/<?php echo  seoUrl($video['Video']['title']) ?>"><?php echo $this->Text->truncate($video['Video']['title'], 40, array('exact' => false)) ?></a>
                                    </div>
                                    <div class="core-item-like_count">
                                        <span class="item-count"><?php echo  __n('%s like', '%s likes', $video['Video']['like_count'], $video['Video']['like_count']) ?></span>
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