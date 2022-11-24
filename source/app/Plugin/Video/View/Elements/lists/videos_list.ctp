<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooVideo"], function($, mooVideo) {
        mooVideo.initOnListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooVideo'), 'object' => array('$', 'mooVideo'))); ?>
mooVideo.initOnListing();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
$videoHelper = MooCore::getInstance()->getHelper('Video_Video');
?>
    <?php
    if (!empty($videos) && count($videos) > 0)
    {
        foreach ($videos as $video):
    ?>

    <div class="core-list-item <?php if (($video['User']['id'] == $uid) || (!empty($cuser) && $cuser['Role']['is_admin'] ) || (isset($video['Video']['admins']) && in_array($uid, $video['Video']['admins'])) || (!empty($admins) && in_array($uid, $admins) )): ?>core-is-owner<?php endif; ?>">
        <div class="core-item-warp">
            <div class="core-item-figure">
                <?php if(!empty( $ajax_view )): ?>
                <a class="ajaxLoadPage video_cover" href="javascript:void(0)" data-url="<?php echo $this->request->base?>/videos/ajax_view/<?php echo $video['Video']['id']?>">
                    <img class="vieo-item-img" src='<?php echo $videoHelper->getImage($video, array('prefix' => '450'))?>' />
                </a>
                <?php else: ?>
                <a class="video_cover" href="<?php echo $this->request->base?>/videos/view/<?php echo $video['Video']['id']?>/<?php echo seoUrl($video['Video']['title'])?>">
                    <img class="vieo-item-img" src='<?php echo $videoHelper->getImage($video, array('prefix' => '450'))?>' />
                </a>
                <?php endif; ?>
            </div>
            <div class="core-item-info">
                <div class="core-item-head">
                    <?php if ( !empty( $ajax_view ) ): ?>
                        <a class="core-item-title ajaxLoadPage" href="javascript:void(0)" data-url="<?php echo $this->request->base?>/videos/ajax_view/<?php echo $video['Video']['id']?>"><?php echo $this->Text->truncate( $video['Video']['title'], 60 )?></a>
                    <?php else: ?>
                        <a class="core-item-title" href="<?php echo $this->request->base?>/videos/view/<?php echo $video['Video']['id']?>/<?php echo seoUrl($video['Video']['title'])?>"><?php echo $this->Text->truncate( $video['Video']['title'], 60 )?></a>
                    <?php endif; ?>
                    <?php if (($video['User']['id'] == $uid) || (!empty($cuser) && $cuser['Role']['is_admin'] ) || (isset($video['Video']['admins']) && in_array($uid, $video['Video']['admins'])) || (!empty($admins) && in_array($uid, $admins) )): ?>
                    <div class="list_option">
                        <div class="dropdown">
                            <button id="dropdown-edit" data-target="#" data-toggle="dropdown" >
                                <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </button>
                            <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit" style="float: right;">
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "videos",
                                            "action" => "create",
                                            "plugin" => 'video',
                                            $video['Video']['id']

                                        )),
                                        'title' => __('Edit Video'),
                                        'innerHtml'=> __( 'Edit Video'),
                                    ));
                                    ?>
                                </li>
                                <li><a href="javascript:void(0)" class="deleteVideo" data-id="<?php echo $video['Video']['id'] ?>"> <?php echo __( 'Delete Video')?></a></li>
                                <li class="seperate"></li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="core-item-date">
                    <?php echo __( 'Posted by')?> <?php echo $this->Moo->getName($video['User'], false)?>  <?php echo $this->Moo->getTime($video['Video']['created'], Configure::read('core.date_format'), $utz)?>
                    <?php if (empty($type)): ?>
                        &middot;
                        <?php if(empty($video['Video']['group_id'])): ?>
                            <?php if ($video['Video']['privacy'] == PRIVACY_PUBLIC): ?>
                                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo __('Shared with: Everyone');?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-public">public</span></a>
                            <?php elseif ($video['Video']['privacy'] == PRIVACY_ME): ?>
                                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo __('Shared with: Only Me');?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-lock">lock</span></a>
                            <?php elseif ($video['Video']['privacy'] == PRIVACY_FRIENDS): ?>
                                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo __('Shared with: Friends Only');?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-people">people</span></a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($video['Video']['privacy'] == PRIVACY_PUBLIC): ?>
                                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo __('Shared with: Everyone');?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-public">public</span></a>
                            <?php else: ?>
                                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo __('Shared with: member of their group');?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-people">people</span></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="core-extra-info">
                    <?php $this->Html->rating($video['Video']['id'],'videos', 'Video'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php 
        endforeach;
    } 

    else
        echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
    ?>
    <?php if (isset($more_url)&& !empty($more_result)): ?>
        <?php $this->Html->viewMore($more_url) ?>
    <?php endif; ?>
