<?php 
$videoHelper = MooCore::getInstance()->getHelper('Video_Video');
$videoModel = MooCore::getInstance()->getModel('Video_Video');
$video = $videoModel->findById($activity['Activity']['parent_id']);
?>

<div class="activity_feed_message">
<?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <div class="activity_feed_content_text">
            <div class="activity_item">
                <div class="video-feed-body">
                    <div class="video-feed-content">
                        <?php
                        $flag_enable = false;
                        if(in_array('video_view',$uacos))
                        {
                            $flag_enable = true;
                            echo $this->element('Video./video_snippet', array('video' => $video));
                        }
                        else
                        {
                            echo $this->element('Video./video_thumb',array('video' => $video));
                        }
                        ?>
                    </div>
                    <div class="video-feed-info video_feed_content">
                        <div class="video-title">
                            <a
                                <?php if(!$flag_enable):?>
                                    class="activity_item_title"
                                    data-target="#portlet-config" data-toggle="modal" href="<?php echo $video['Video']['moo_href']?>"
                                <?php else:?>
                                    class="activity_item_title"
                                    href="<?php if ( !empty( $video['Video']['group_id'] ) ): ?><?php echo $this->request->base?>/groups/view/<?php echo $video['Video']['group_id']?>/video_id:<?php echo $video['Video']['id']?><?php else: ?><?php echo $this->request->base?>/videos/view/<?php echo $video['Video']['id']?>/<?php echo seoUrl($video['Video']['title'])?><?php endif; ?>"
                                <?php endif;?>
                            >
                                <?php echo $video['Video']['title']?>
                            </a>
                        </div>
                        <div class="video-description comment_message feed_detail_text">
                            <?php echo  $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $video['Video']['description'])), 200, array('exact' => false)), Configure::read('Video.video_hashtag_enabled')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>