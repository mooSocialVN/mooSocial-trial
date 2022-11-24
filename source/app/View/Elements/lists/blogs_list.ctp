
<?php
if (count($blogs) > 0)
{
	$i = 1;
	foreach ($blogs as $blog):
?>
        <li class="full_content p_m_10" <?php if( $i == count($blogs) ) echo 'style="border-bottom:0"'; ?>>
            <a href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>">
            <?php if($blog['Blog']['thumbnail']): ?>
                <img width="45" src="<?php echo $this->request->base . '/' . $blog['Blog']['thumbnail']?>" class="img_wrapper2 user_list">
            <?php else: ?>
                <img width="45" src="<?php echo $this->request->base?>/img/noimage/noimage-blog.png" class="img_wrapper2 user_list"/>
            <?php endif; ?>
            </a>
            <div class="topics_count"><span class="arr-left"></span><?php echo $blog['Blog']['comment_count']?></div>
		<div class="comment list-blog-item">
			<a href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>"><b><?php echo h($blog['Blog']['title'])?></b></a>
			<div class="comment_message">
				<?php 
				
                                echo $this->Text->truncate(strip_tags(str_replace(array('<br>','&nbsp;'), array(' ',''), $blog['Blog']['body'])), 150, array('exact' => false));
				?>
				<div class="date date-small">
    				<?php echo __( 'Posted by')?> <?php echo $this->Moo->getName($blog['User'], false)?>
    				<?php echo $this->Moo->getTime( $blog['Blog']['created'], Configure::read('core.date_format'), $utz )?> . <a href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>"><?php echo __( 'Read more')?></a>
				</div>
			</div>
		</div>	
	</li>
<?php 
    $i++;
	endforeach;
}
else
	echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
?>

<?php if (count($blogs) >= RESULTS_LIMIT): ?>
    <?php $this->Html->viewMore($more_url) ?>
<?php endif; ?>