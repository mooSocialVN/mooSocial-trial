<?php
if(empty($title)) $title = "Friends";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

$friends = $friendCoreWidget;
?>

<?php if ( !empty( $friends ) ): ?>
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
    <div class="box_content box_friend_user box-region-<?php echo $region ?>">
        <div class="box-user-list">
            <?php
            $tip = 'avatar_tip';
                if (Configure::read('core.profile_popup')){
                    $tip = '';
                }
            foreach ($friends as $user): ?>
                <div class="box-user-item">
                    <div class="box-user-item-warp">
                        <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']),array('prefix' => '50_square'),array('class' => "user_avatar $tip", 'original-title' => Configure::read('core.profile_popup')?'':$user['User']['name']))?>
                    </div>
                </div>
            <?php
            endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>