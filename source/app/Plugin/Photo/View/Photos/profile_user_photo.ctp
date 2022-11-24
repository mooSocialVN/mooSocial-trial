<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initShowAlbums();
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooUser'),'object'=>array('$','mooUser'))); ?>
    mooUser.initShowAlbums();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div id="profile_photos">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Photo Albums')?></h1>
                <div class="box_action">
                    <?php if ($tag_uid == $uid): ?>
                        <?php
                        $this->MooPopup->tag(array(
                            'href'=>$this->Html->url(array("controller" => "albums",
                                "action" => "create",
                                "plugin" => 'photo',

                            )),
                            'title' => __( 'Create New Album'),
                            'innerHtml'=> '<span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>',
                            'class' => 'box-btn btn-header_icon box-add'
                        ));
                        ?>
                    <?php endif; ?>
                    <a class="box-btn btn btn-header_title btn-cs showAlbums" href="javascript:void(0)" data-user-id="<?php echo $tag_uid;?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-photo">photo</span>
                            <span class="btn-text"><?php echo  __( 'View all') ?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="box_content">
            <div id="album-list-content" class="album-lists">
                <?php echo $this->element('lists/albums_list'); ?>
            </div>
        </div>
    </div>

    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo  __( 'Tagged Photos') ?></h3>
            </div>
        </div>
        <div class="box_content box-tagged-photo">
            <?php echo $this->element('lists/photos_list', array('type' => APP_USER, 'param' => $tag_uid)); ?>
        </div>
    </div>
</div>