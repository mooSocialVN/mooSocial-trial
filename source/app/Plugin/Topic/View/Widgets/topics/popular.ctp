<?php
if(Configure::read('Topic.topic_enabled') == 1):
if(empty($title)) $title = "Popular Topics";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');

?>
<?php if (!empty($popular_topics)): ?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo h($title) ?></h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="box_content box_popular_topic box-region-<?php echo $region ?>">
        <?php
        if (!empty($popular_topics)):
            ?>
            <div class="core-lists topic-popular-lists <?php echo ($region == 'center') ? 'grid-view': 'list-view'; ?>">
                <?php foreach ($popular_topics as $topic): ?>
                    <div class="core-list-item">
                        <div class="core-item-warp">
                            <div class="core-item-figure">
                                <a class="core-item-thumb" href=<?php if ( !empty( $ajax_view ) ): ?>"javascript:void(0)" onclick="loadPage('topics', '<?php echo $this->request->base?>/topics/ajax_view/<?php echo $topic['Topic']['id']?>')"<?php else: ?>"<?php echo $this->request->base?>/topics/view/<?php echo $topic['Topic']['id']?>/<?php echo seoUrl($topic['Topic']['title'])?>"<?php endif; ?>>
                                    <img class="core-item-img" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '300_square'))?>">
                                </a>
                            </div>
                            <div class="core-item-info">
                                <div class="core-item-head">
                                    <a class="core-item-title" href="<?php echo $this->request->base?>/topics/view/<?php echo $topic['Topic']['id']?>/<?php echo seoUrl($topic['Topic']['title'])?>">
                                        <?php echo $topic['Topic']['title']?>
                                    </a>
                                </div>
                                <div class="core-item-like_count">
                                    <span class="item-count"><?php echo __n('%s reply', '%s replies', $topic['Topic']['comment_count'], $topic['Topic']['comment_count'] )?></span> . <span class="item-count"><?php echo __n('%s like', '%s likes', $topic['Topic']['like_count'], $topic['Topic']['like_count'] )?></span>
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
<?php endif;endif; ?>