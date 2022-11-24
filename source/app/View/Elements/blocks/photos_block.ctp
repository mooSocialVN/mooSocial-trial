<?php 
if (!empty($albums)): 
?>
<ul class="list6 list6sm">
<?php foreach ($albums as $album): ?>
	<li><a href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>/<?php echo seoUrl($album['Album']['title'])?>"><img src="<?php echo $this->Moo->getAlbumCover($album['Album']['cover'])?>" class="img_wrapper2" style="width:50px"></a>
		<div style="margin-left: 60px;"><a href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>/<?php echo seoUrl($album['Album']['title'])?>"><?php echo h($this->Text->truncate($album['Album']['title'], 40, array('exact' => false)))?></a><br />
			<span class="date"><?php echo __n( '%s photo', '%s photos', $album['Album']['photo_count'], $album['Album']['photo_count'] )?></span>
		</div>
	</li>
<?php endforeach; ?>
</ul>
<?php 
else:
    echo __('Nothing found');
endif; 
?>