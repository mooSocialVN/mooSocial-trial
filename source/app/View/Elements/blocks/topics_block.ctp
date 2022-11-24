<?php 
if (!empty($topics)): 
?>
<ul class="list6 list6sm">
<?php foreach ($topics as $topic): ?>
	<li><a href="<?php echo $this->request->base?>/topics/view/<?php echo $topic['Topic']['id']?>/<?php echo seoUrl($topic['Topic']['title'])?>"><?php echo h($topic['Topic']['title'])?></a><br />
		<span class="date">
			<?php echo __n( '%s reply', '%s replies', $topic['Topic']['comment_count'], $topic['Topic']['comment_count'] )?>,
			<?php echo __n( '%s like', '%s likes', $topic['Topic']['like_count'], $topic['Topic']['like_count'] )?>
		</span>
	</li>
<?php endforeach; ?>
</ul>
<?php 
else:
	echo __('Nothing found');
endif; 
?>