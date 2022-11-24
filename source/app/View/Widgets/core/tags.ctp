<?php
if(empty($title)) $title = "Tags";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

$formatted_hashtag = array();
foreach($hashtags as &$hashtag)
{
    $aHashtag = explode(',',$hashtag['Hashtag']['hashtags']);
    foreach($aHashtag as &$tag)
    {
        if(!empty($formatted_hashtag[$tag]))
            $formatted_hashtag[$tag]['count'] += 1;
        else
        {
            $formatted_hashtag[$tag]['count'] = 1;
            $formatted_hashtag[$tag]['created'] = $hashtag['Hashtag']['created'];
            $formatted_hashtag[$tag]['title'] = $tag;
        }
    }
}

foreach($tagsWidget as &$tag)
{
    if(!empty($formatted_hashtag[$tag['Tag']['tag']]))
        $formatted_hashtag[$tag['Tag']['tag']]['count'] += $tag[0]['count'];
    else
    {
        $formatted_hashtag[$tag['Tag']['tag']]['count'] = $tag[0]['count'];
        $formatted_hashtag[$tag['Tag']['tag']]['created'] = $tag['Tag']['created'];
        $formatted_hashtag[$tag['Tag']['tag']]['title'] = $tag['Tag']['tag'];
    }
}

if(!empty($order))
{
    if($order == 'popular')
        $formatted_hashtag = Hash::sort($formatted_hashtag,'{s}.count','desc');
    elseif($order == 'newest')
        $formatted_hashtag = Hash::sort($formatted_hashtag,'{s}.created','desc');
}
if(count($formatted_hashtag) > $num_item_show)
    $formatted_hashtag = array_slice($formatted_hashtag,0,$num_item_show);
    
foreach($formatted_hashtag as $key=>&$value)
{
    $formatted_hashtag[$key] = $value['title'];
}

?>
<?php if(empty($style) || $style == 'classic'): ?>
    <?php if (!empty($formatted_hashtag)): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title">
                    <?php echo $title;?>
                </h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="box_content">
            <?php
            if (!empty($formatted_hashtag)):
                echo '<ul class="tags">';
                    foreach ($formatted_hashtag as $tag=>$title): ?>
                        <li><a href="<?php echo $this->request->base?>/search/hashtags/<?php echo h($title)?>/tabs:<?php echo $type; ?>"># <?php echo h($title)?></a></li>
                <?php
                    endforeach;
                echo '</ul>';
            else:
                echo '<div class="nothing_found">' . __('Nothing found') . '</div>';
            endif;
            ?>
        </div>
    </div>
    <?php endif; ?>
<?php else: ?>
    <?php echo $this->widget('hashtag',array('formatted_hashtag' => $formatted_hashtag, 'type' => $type,'title_enable' => $title_enable, 'title' => $title)); ?>
<?php endif; ?>