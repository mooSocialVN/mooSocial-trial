<?php
$div_width = 24 * $rating_system;
if(!empty($ratings)){
    $rated_width = intval($ratings[key($ratings)]['score']) * 24;
    $unrated_width = $div_width - $rated_width ;
}
else
{
    $rated_width = 0;
    $unrated_width = $div_width;
}

?>
<div class="rating_star" style="width:<?php echo  $div_width; ?>px">
    <div data-step="<?php echo  $step; ?>" id="stars_<?php echo  $type; ?><?php echo  !empty($plugin) ? '_'.$plugin: '' ?>_<?php echo  $type_id ?>" data-id="<?php echo  $this->Auth->user('id'); ?>" style="display: block; position: relative; overflow: hidden; width: <?php echo  $div_width; ?>px; height: 24px; top: 0px; left: 0px; cursor: pointer;">
        <div class="un-rated" style="position: absolute; top: 0px; left: <?php echo  $rated_width; ?>px; padding: 0px; margin: 0px; background: url('<?php echo  $this->request->webroot ?>img/<?php echo  $skin; ?>') repeat-x scroll 0px 0px transparent; width: <?php echo  $unrated_width; ?>px; height: 24px; z-index: 1;" ></div>
        <div data-score="<?php echo  ($rated_width/24) ?>" class="rated" style="position: absolute; top: 0px; left: 0px; padding: 0px; margin: 0px; background: url('<?php echo  $this->request->webroot ?>img/<?php echo  $skin; ?>') repeat-x scroll 0px -24px transparent; width: <?php echo  $rated_width; ?>px; height: 24px; z-index: 2;"></div>
    </div>
    <div class="start-comment" style="width:<?php echo  $div_width; ?>px; min-height: 45px;"  data-votes="<?php echo  (!empty($ratings))? $ratings['Rating']['rating_user_count']: 0  ?>"><?php if(!empty($ratings)) echo $ratings['Rating']['score'].'/'.$rating_system.' (from '.$ratings['Rating']['rating_user_count'].' votes)'; ?></div>
</div>