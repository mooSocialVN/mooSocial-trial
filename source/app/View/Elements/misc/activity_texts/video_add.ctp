<?php if ( !empty( $activity['TextContent']['Group'] ) ): ?>
&rsaquo; 
<a href="<?php echo $this->request->base?>/groups/view/<?php echo $activity['TextContent']['Group']['id']?>"><?php echo h($activity['TextContent']['Group']['name'])?></a>
<?php else:
echo __('shared a new video');
endif; ?>