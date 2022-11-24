<?php
if (count($users) > 0)
{
    ?>
    <?php if ($page == 1): ?>
    <div id="profile_followers">
        <div class="box2 bar-content-warp">
            <div class="box_header mo_breadcrumb">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Followers')?></h3>
                </div>
            </div>
            <div class="box_content">
                <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
                <div id="list-content" class="user-lists grid-view">
    <?php endif; ?>
    <?php
    foreach ($users as $user):
        ?>
        <div class="user-list-item">
            <div class="user-item-warp">
                <div class="user-item-main">
                    <div class="user-item-figure">
                        <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array('prefix' => '200_square', 'class' => 'user-item-picture'))?>
                    </div>
                    <div class="user-item-info">
                        <div class="user-item-holder">
                            <div class="user-item-name">
                                <?php echo $this->Moo->getName($user['User'])?>
                            </div>
                            <div class="user-item-date">
                                <?php echo __n( '%s friend', '%s friends', $user['User']['friend_count'], $user['User']['friend_count'] )?> . <?php echo __n( '%s photo', '%s photos', $user['User']['photo_count'], $user['User']['photo_count'] )?><br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
    ?>
    <?php if (!empty($url_more)):?>
        <?php $this->Html->viewMore($url_more); ?>
    <?php endif; ?>
    <?php if ($page == 1): ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php
}
else
    echo '<div class="no-more-results">' . __('No more results found') . '</div>';
?>

<?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooBehavior"], function($, mooBehavior) {
        	mooBehavior.initMoreResults();
        });
    </script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooBehavior'), 'object' => array('$', 'mooBehavior'))); ?>
    mooBehavior.initMoreResults();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>