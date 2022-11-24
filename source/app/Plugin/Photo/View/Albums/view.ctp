<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooPhoto', 'hideshare'),'object'=>array('$', 'mooPhoto'))); ?>
$(".sharethis").hideshare({media: '<?php echo $photoHelper->getAlbumCover($album['Album']['cover'], array('prefix' => '300_square'))?>', linkedin: false});
mooPhoto.initOnViewAlbum();
<?php $this->Html->scriptEnd(); ?>

<div class="box2 box_view bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo $album['Album']['moo_title']?></h1>
            <div class="box_action">
                <?php if ( empty( $album['Album']['type'] ) ): ?>
                    <?php if ( $uid == $album['User']['id'] ): ?>
                    <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "photos",
                            "action" => "ajax_upload",
                            "plugin" => 'photo',
                            'Photo_Album',
                            $album['Album']['id'],
                        )),
                        'title' => ($album['Album']['moo_title']),
                        'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-cloud_upload">cloud_upload</span> <span class="btn-text hidden-xs">'.__( 'Upload Photos').'</span></span>',
                        'class' => 'box-btn btn btn-header_title btn-cs',
                        'data-backdrop' => 'static'
                    )); ?>
                    <?php endif; ?>

                    <div class="box-dropdown">
                        <div class="dropdown">
                            <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                                <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </a>
                            <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit">
                                <?php if ( $uid == $album['User']['id'] || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "albums",
                                            "action" => "create",
                                            "plugin" => 'photo',
                                            $album['Album']['id']

                                        )),
                                        'title' => __( 'Edit Album'),
                                        'innerHtml'=> __( 'Edit Album'),
                                        "data-backdrop" => "static"
                                    ));
                                    ?>
                                </li>
                                <li><a href="javascript:void(0);" class="deleteAlbum" data-id="<?php echo $album['Album']['id']?>"><?php echo __( 'Delete Album')?></a></li>
                                <li><a href="<?php echo $this->request->base?>/albums/edit/<?php echo $album['Album']['id']?>"><?php echo __( 'Edit Photos')?></a></li>
                                <?php endif; ?>
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "reports",
                                            "action" => "ajax_create",
                                            "plugin" => false,
                                            'photo_album',
                                            $album['Album']['id'],
                                        )),
                                        'title' =>  __( 'Report Album'),
                                        'innerHtml'=>  __( 'Report Album'),
                                    ));
                                    ?>
                                </li>
                                <?php if ($album['Album']['privacy'] != PRIVACY_ME): ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="box_content">
        <div class="post_body album_view_detail">
            <div class="post_header">
                <div class="album-detail-info">
                    <?php echo __( 'Posted by %s', $this->Moo->getName($album['User']))?> <?php echo __( 'in')?> <a href="<?php echo $this->request->base?>/photos/index/<?php echo $album['Album']['category_id']?>/<?php echo seoUrl($album['Category']['name'])?>"><?php echo $album['Category']['name']?></a> <?php echo $this->Moo->getTime( $album['Album']['created'], Configure::read('core.date_format'), $utz )?>
                    &nbsp;&middot;&nbsp;<?php if ($album['Album']['privacy'] == PRIVACY_PUBLIC): ?>
                        <?php echo __('Public') ?>
                    <?php elseif ($album['Album']['privacy'] == PRIVACY_PRIVATE): ?>
                        <?php echo __('Private') ?>
                    <?php elseif ($album['Album']['privacy'] == PRIVACY_FRIENDS): ?>
                        <?php echo __('Friend') ?>
                    <?php endif; ?>
                </div>
                <?php $this->Html->rating($album['Album']['id'], 'albums','Photo');  ?>
            </div>

            <div class="post_warp">
                <?php echo $this->element( 'lists/photos_list', array( 'type' => 'Photo_Album' ) ); ?>
            </div>

            <div class="post_content">
                <?php echo $this->Moo->formatText( $album['Album']['description'], false, true, array('no_replace_ssl' => 1) )?>
            </div>

            <?php if (!empty($tags)): ?>
            <div class="post_tags">
                <div class="post_tags-title"><?php echo __( 'Tags')?>: </div>
                <?php echo $this->element('blocks/tags_item_block'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="box2 bar-content-warp">
    <div class="box_content">
        <?php echo $this->element( 'likes', array('shareUrl' => $this->Html->url(array(
            'plugin' => false,
            'controller' => 'share',
            'action' => 'ajax_share',
            'Photo_Album',
            'id' => $album['Album']['id'],
            'type' => 'album_item_detail'
        ), true), 'item' => $album['Album'], 'type' => 'Photo_Album' ) ); ?>
    </div>
</div>
<div class="box2 bar-content-warp">
    <div class="box_content core_comments album-comment">
        <?php echo $this->renderComment();?>
    </div>
</div>