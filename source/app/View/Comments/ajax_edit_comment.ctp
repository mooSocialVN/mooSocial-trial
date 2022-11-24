<div>
    <?php
        $link = json_decode($comment['Comment']['params'],true);
        $url = (isset($link['url']) ? $link['url'] : '#');
    ?>
	<?php
		echo $this->viewMore(h($comment['Comment']['message']), null, null, null, true, array('no_replace_ssl' => 1));
	?>
	<?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('comment' => $comment))); ?>
	<?php if ($comment['Comment']['thumbnail']):?>
	<div class="comment_thumb">
		<a data-dismiss="modal" href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
		<?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
				                     <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                                <?php else: ?>
                                                        <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img', 'prefix'=>'200'));?>
                                                <?php endif; ?>
		</a>
	</div>
	<?php endif;?>

    <?php if ( !empty( $link['title'] ) ):?>
        <div class="activity_item comment_item">
            <?php if ( !empty( $link['image'] ) ): ?>
                <div class="activity_left">
                    <?php
                    if ( strpos( $link['image'], 'http' ) === false ):
                        $link_image = $this->storage->getUrl($comment['Comment']["id"],'',$link['image'],"links") ;
                    else:
                        $link_image = $link['image'];
                    endif;
                    ?>
                    <img class="activity-img" src="<?php echo $link_image ?>">
                </div>
            <?php endif; ?>
            <div class="<?php if ( !empty( $link['title'] ) ): ?>activity_right<?php endif; ?>">
                <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                    <?php echo h($link['title'])?>
                </a>
                <?php
                if ( !empty( $link['description'] ) )
                    echo '<div class="activity_item_text comment_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                ?>
            </div>
        </div>
    <?php elseif ( !empty( $link['type'] ) && $link['type'] == 'img' && !empty( $link['image'])):?>
        <div class="comment_thumb">
            <a data-dismiss="modal" href="<?php echo $link['image'] ?>"><img src="<?php echo $link['image'] ?>" class="comment-img"></a>
        </div>
    <?php endif; ?>
	<script>
		$('#history_item_comment_<?php echo $comment['Comment']['id']?>').find('.history_item_comment-text').html("<?php echo addslashes(__('Edited')).(isset($other_user) ? ' '.addslashes(__('by')).' '.$other_user['name'] : '');?>");
	</script>
</div>