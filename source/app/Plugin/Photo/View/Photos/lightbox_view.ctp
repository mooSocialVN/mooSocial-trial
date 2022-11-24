<script>
photo_id = <?php echo $photo['Photo']['id']?>;

jQuery(document).ready(function(){
    jQuery('#photo_wrapper').click(function(event){
        event.stopPropagation();
    });
});
</script>

<style>
#showbox .showbox-image {
    width: 1260px;
    height: 620px;
}
</style>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>
<div id="photo_wrapper" style="width:1260px;">
    <div id="tag-wrapper" style="height: 620px;width:933px;" class="tag_wrapper">
        <div style="display: table-cell; vertical-align: middle;position:relative">
            <img src="<?php echo $photoHelper->getImage($photo, array('prefix' => ''));?>" class="showbox-img"> 
            <div id="tag-target"></div>
            <div id="tag-input">
                <?php echo __( "Enter person's name")?>
                <input type="text" id="tag-name">
                <?php echo __( 'Or select a friend')?>
                <div id="friends_list" class="tag_friends_list"></div>
                <input type="submit" value="<?php echo __( 'Submit')?>" id="tag-submit"> <input type="submit" value="<?php echo __( 'Cancel')?>" id="tag-cancel">
            </div>
            <?php 
            foreach ( $photo_tags as $tag ): 
            ?>
            <div style="<?php echo $tag['PhotoTag']['style']?>" class="hotspot" id="hotspot-0-<?php echo $tag['PhotoTag']['id']?>"><span>
                <?php
                if ( $tag['PhotoTag']['user_id'] ){
                    $tag['User']['no_tooltip'] = true;
                    echo $this->Moo->getName( $tag['User'], false );
                }else{
                    echo h($tag['PhotoTag']['value']);
                }
                ?>
            </span></div>
            <?php
            endforeach; 
            ?>
            <div id="lb_description" style="width:916px;display: none">
                <?php if ( $photo['Photo']['type'] == 'Group_Group' ): ?>
                <a href="<?php echo $this->request->base?>/groups/view/<?php echo $photo['Photo']['target_id']?>/<?php echo seoUrl($photo['Group']['name'])?>"><?php echo __( 'Photos of %s', $photo['Group']['name'])?></a>
                <?php else: ?>
                <a href="<?php echo $this->request->base?>/albums/view/<?php echo $photo['Photo']['target_id']?>/<?php echo seoUrl($photo['Album']['moo_title'])?>"><?php echo ($photo['Album']['moo_title'])?></a>
                <?php endif; ?> 
            	<ul>
            		<?php if ( $can_tag ): ?>
                    <li id="tagPhoto"><a href="javascript:void(0)" onclick="tagPhoto()"><?php echo __( 'Tag Photo')?></a></li>
                    <?php endif; ?>
            		<?php if ( !empty( $photo['Photo']['original'] ) ): ?>
            		<li><a href="<?php echo $this->request->webroot?><?php echo $photo['Photo']['original']?>" target="_blank"><?php echo __( 'Download Hi-res')?></a></li>
            		<?php endif; ?>
            	</ul>
           	</div>
        </div>        
    </div>
    
    <div id="lb_sidebar" style="height: 600px;width:307px;">
        <div style="overflow:hidden">
            <?php echo $this->Moo->getItemPhoto(array('User' => $photo['User']), array('prefix' => '100_square'))?> 
            <div class="comment" style="line-height: 1.5">
            	<?php echo $this->Moo->getName($photo['User'])?><br />
            	<span class="date"><?php echo $this->Moo->getTime( $photo['Photo']['created'], Configure::read('core.date_format') )?></span><br />
            	<a href="<?php echo $this->request->base?>/reports/ajax_create/photo_photo/<?php echo $photo['Photo']['id']?>" class="overlay" title="<?php echo __( 'Report')?>"><?php echo __( 'Report')?></a>
	            <?php if ( ( $uid && $cuser['role_id'] == ROLE_ADMIN ) || ( !empty( $admins ) && in_array( $uid, $admins ) ) ): ?>
	            . <a href="javascript:void(0)" onclick="deletePhoto()"><?php echo __( 'Delete')?></a>
	            <?php endif; ?>
	            &nbsp;<a href="javascript:void(0)" id="photo_like_count" data-thumb-up="1" data-id="<?php echo $photo['Photo']['id']?>" class="likePhoto thumbUp <?php if ( !empty( $uid ) && !empty( $like['Like']['thumb_up'] ) ): ?>active<?php endif; ?>">&nbsp;</a> <span id="photo_like_count2"><?php echo $photo['Photo']['like_count']?></span>
                <a href="javascript:void(0)" id="photo_dislike_count" data-thumb-up="0" data-id="<?php echo $photo['Photo']['id']?>" class="likePhoto thumbDown <?php if ( !empty( $uid ) && isset( $like['Like']['thumb_up'] ) && $like['Like']['thumb_up'] == 0 ): ?>active<?php endif; ?>">&nbsp;</a> <span id="photo_dislike_count2"><?php echo $photo['Photo']['dislike_count']?></span>
            </div> 
        </div>
        
        <div style="margin:10px 0">
        <?php echo $this->Moo->formatText( $photo['Photo']['caption'] )?>
        </div>
        
        <div id="tags" style="margin:5px 0;">
            <span class="date"><?php echo __( 'In this photo')?>: </span>
            <?php 
            $count = 0;
            foreach ( $photo_tags as $tag ): 
            ?>
            <span onmouseout="hideTag('0-<?php echo $tag['PhotoTag']['id']?>')" onmouseover="showTag('0-<?php echo $tag['PhotoTag']['id']?>')" id="hotspot-item-0-<?php echo $tag['PhotoTag']['id']?>">
                <?php
                if ( $tag['PhotoTag']['user_id'] )
                    echo $this->Moo->getName( $tag['User'], false );
                else
                    echo h($tag['PhotoTag']['value']);
                
                if ( $uid == $tag['PhotoTag']['tagger_id'] || $uid == $tag['PhotoTag']['user_id'] ):
                ?><a onclick="removeTag('0-<?php echo $tag['PhotoTag']['id']?>', <?php echo $tag['PhotoTag']['id']?>)" href="javascript:void(0)"><img src="<?php echo $this->request->webroot?>img/icons/cross_sm.png" align="absmiddle" class="cross-icon-sm"></a>
                <?php
                endif;
                ?>
            </span>
            <?php
                $count++; 
            endforeach; 
            ?>
        </div>     
           
        <ul class="activity_comments" id="compact_comments">
            <?php 
            if ( !empty($photo['Photo']['like_count']) ): 
            ?>
            <li><a href="<?php echo $this->request->base?>/likes/ajax_show/photo/<?php echo $photo['Photo']['id']?>" data-dismiss="modal" class="overlay" title="<?php echo __( 'People Who Like This')?>" style="text-decoration: none"><img src="<?php echo $this->request->webroot?>img/icons/heart.png" align="top" style="width:13px"> <?php echo __n('%s person likes this', '%s people like this', $photo['Photo']['like_count'], $photo['Photo']['like_count'] )?></a></li>
            <?php endif; ?> 
            <?php echo $this->element('comments', array( 'compact' => true ));?>
            <li id="compactCommentForm">
                <?php 
                if ( !isset( $is_member ) || $is_member  )
                    echo $this->element( 'comment_form', array( 'target_id' => $photo['Photo']['id'], 'type' => 'Photo_Photo', 'compact' => true ) ); 
                else
                    echo __( 'This a group photo. Only group members can leave comment');
                ?>
            </li>
        </ul>  	
    </div>
</div>