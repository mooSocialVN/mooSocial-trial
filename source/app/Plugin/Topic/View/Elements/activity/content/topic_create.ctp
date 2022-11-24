<?php 
$topic = $object;
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
?>

<?php if (!empty($activity['Activity']['content'])): ?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1)); ?>
</div>
<?php endif; ?>
<div class="activity_item">
    <div class="activity_left">
        <a class="activity_img_thumb" href="<?php echo $topic['Topic']['moo_href']?>">
            <img class="activity-img" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '850'))?>"/>
        </a>
    </div>
    <div class="activity_right">
        <a class="activity_item_title" href="<?php if (!empty($topic['Topic']['group_id'])): ?><?php echo  $this->request->base ?>/groups/view/<?php echo  $topic['Topic']['group_id'] ?>/topic_id:<?php echo  $topic['Topic']['id'] ?><?php else: ?><?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo  seoUrl($topic['Topic']['title']) ?><?php endif; ?>"><b><?php echo  $topic['Topic']['title'] ?></b></a>
        <div class="activity_item_text">
            <?php echo  $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $topic['Topic']['body'])), 200, array('exact' => false)), Configure::read('Topic.topic_hashtag_enabled')) ?>
        </div>
    </div>
</div>
