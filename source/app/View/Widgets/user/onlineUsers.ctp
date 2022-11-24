<?php
if ( !( empty($uid) && Configure::read('core.force_login') ) ):
    if(empty($num_item_show)) $num_item_show=10;
    if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
    
    $online = $onlineUsersCoreWidget['online'];
    ?>

<?php if ( !empty( $online['members'] ) ): ?>
    <div class="box2 bar-content-warp">
        <?php if($title_enable): ?>
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title">
                        <a class="box_header_link" href="<?php echo $this->request->base?>/users/index/online:1">
                            <?php if(empty($title)) $title = __("Who's Online");?>
                            <?php echo $title; ?>
                        </a>
                    </h3>
                </div>
            </div>
        <?php endif; ?>
        <div class="box_content box_online_user box-region-<?php echo $region ?>">
            <?php if ( !empty( $online['members'] ) ): 
                $tip = 'avatar_tip';
                if (Configure::read('core.profile_popup')){
                    $tip = '';
                }
                ?>
            <div class="box-user-list">
                <?php foreach ($online['members'] as $u): ?>
                <div class="box-user-item">
                    <div class="box-user-item-warp">
                        <?php echo $this->Moo->getItemPhoto(array('User' => $u['User']), array( 'prefix' => '50_square'), array('class' => "user_avatar $tip", 'original-title' => Configure::read('core.profile_popup')?'':$u['User']['name']))?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class='box_content_text'>
            <?php
                if(empty($member_only))
                    printf( __('There are currently %s and %s online'), __n( '%s member', '%s members', count($online['userids']), count($online['userids']) ), __n( '%s guest', '%s guests', $online['guests'], $online['guests'] ) );
                else
                    echo __n('There is currently %s member online', 'There are currently %s members online', count($online['userids']), count($online['userids']) );
            ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
endif;
?>
