<?php
foreach ($categories as $cat):
    if ( $cat['Category']['header'] ):
?>
    <li class="category_header"><?php echo $cat['Category']['name']?></li>
<?php
        foreach ( $cat['children'] as $subcat ): 
?>
    <li id="cat_<?php echo $subcat['Category']['id']?>" class="sub-cat <?php if ( !empty( $cat_id ) && $cat_id == $subcat['Category']['id'] ) echo 'current';?>">
        <a data-url="<?php echo $this->request->base?>/<?php echo $controller?>/ajax_browse/category/<?php echo $subcat['Category']['id']?>" <?php if ( !empty($subcat['Category']['description']) ):?>class="tip" title="<?php echo nl2br($subcat['Category']['description'])?>"<?php endif ?> href="<?php echo $this->request->base?>/<?php echo $this->request->controller?>/index/<?php echo $subcat['Category']['id']?>/<?php echo seoUrl($subcat['Category']['name'])?>"><?php echo $subcat['Category']['name']?>
        <span class="badge_counter"><?php echo $subcat['Category']['item_count']?></span></a>
    </li>
<?php 
        endforeach;
    else: 
?>
    <li id="cat_<?php echo $cat['Category']['id']?>" <?php if ( !empty( $cat_id ) && $cat_id == $cat['Category']['id'] ) echo 'class="current"';?>>
        <a data-url="<?php echo $this->request->base?>/<?php echo $controller?>/ajax_browse/category/<?php echo $cat['Category']['id']?>" <?php if ( !empty($cat['Category']['description']) ):?>class="tip" title="<?php echo nl2br($cat['Category']['description'])?>"<?php endif ?> href="<?php echo $this->request->base?>/<?php echo $this->request->controller?>/index/<?php echo $cat['Category']['id']?>/<?php echo seoUrl($cat['Category']['name'])?>"><?php echo $cat['Category']['name']?>
        <span class="badge_counter"><?php echo $cat['Category']['item_count']?></span></a>
    </li>
<?php 
    endif;
endforeach;
?> 