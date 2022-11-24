
<div id="photo-content" class="photo_on_theater">
    
	<?php echo $this->element('theater/photo_detail'); ?>
</div>

<div id="friends" style="display:none">
<?php 
if ( $uid )
{
    $friends = array_reverse($friends, true);
    $friends[$uid] = $cuser['name'] . ' (' . __( 'Me') . ')';
    $friends = array_reverse($friends, true);
}
                 
foreach ($friends as $id => $name): 
?>
    <a href="javascript:void(0)" class="tagFriends" data-id="<?php echo $id?>" data-tag-value="<?php echo h($name)?>"><?php echo $name?></a><br />
<?php 
endforeach; 
?>
</div>

<div id="preload" style="display:none"></div>