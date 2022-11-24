<?php
$link = unserialize($activity['Activity']['params']);
?>
<div class="comment_message">
    <a  href="<?php echo $activity['Activity']['content']?>" target="_blank" rel="nofollow"><?php echo h($this->Text->truncate($activity['Activity']['content'], 80, array('exact' => false)))?></a>
    <?php if ( !empty( $link['image'] ) ): 
        if ( strpos( $link['image'], 'http' ) === false ):
                                $link_image = $this->request->webroot . 'uploads/links/' .  $link['image'] ;
                            else:
                                $link_image = $link['image'];
                            endif;
        ?>
    <img src="<?php echo $link_image ?>" class="img_wrapper2" style="margin-right:10px;width:100px;padding:2px">
    <?php endif; ?>
    <div class="<?php if ( empty( $link['image'] ) ): ?>summary<?php endif; ?>">
        <a class="feed_title" href="<?php echo $activity['Activity']['content']?>" target="_blank" rel="nofollow"><strong><?php echo h($link['title'])?></strong></a>
        <?php
        if ( !empty( $link['description'] ) )
            echo '<div class=" comment_message feed_detail_text">' . h($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
        ?>
    </div>
</div>