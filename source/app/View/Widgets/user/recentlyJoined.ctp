<?php
if(empty($title)) $title = "Recently Joined";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

    $new_users = $recentlyJoinedCoreWidget['users'];
?>
<?php if ( !empty( $new_users ) ): ?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo $title; ?></h3>
            </div>
        </div>
    <?php endif; ?>
    <div class="box_content box_recently_join box-region-<?php echo $region ?>">
        <div class="box-user-list">
            <?php
            $tip = 'avatar_tip';
            if (Configure::read('core.profile_popup')){
                $tip = '';
            }
            foreach ($new_users as $user): ?>
                <div class="box-user-item">
                    <div class="box-user-item-warp">
                        <?php echo $this->Moo->getItemPhoto($user, array( 'prefix' => '50_square') ,array('class' => "$tip user_avatar", 'original-title' => Configure::read('core.profile_popup')?'':$user['User']['name']));?>
                    </div>
                </div>
            <?php
            endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>