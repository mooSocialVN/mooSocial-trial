<?php if ( !empty( $activity['TextContent']['Group'] ) ): ?>
&rsaquo; <a href="<?php echo $this->request->base?>/groups/view/<?php echo $activity['TextContent']['Group']['id']?>"><?php echo h($activity['TextContent']['Group']['name'])?></a>
<?php elseif ( !empty( $activity['TextContent']['Event'] ) ): ?>
&rsaquo; <a href="<?php echo $this->request->base?>/events/view/<?php echo $activity['TextContent']['Event']['id']?>"><?php echo h($activity['TextContent']['Event']['title'])?></a>
<?php elseif ( !empty( $activity['TextContent']['User'] ) ): ?>
&rsaquo; <?php echo $this->Moo->getName($activity['TextContent']['User'], false)?>
<?php endif; ?>
