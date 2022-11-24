<?php
$blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooBlog', 'hideshare'),'object'=>array('$', 'mooBlog'))); ?>
mooBlog.initOnView();
$(".sharethis").hideshare({media: '<?php echo $blogHelper->getImage($blog, array('prefix' => '300_square'));?>', linkedin: false});
<?php $this->Html->scriptEnd(); ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Blog Creator')?></h3>
        </div>
    </div>
    <div class="box_content box_menu">
        <?php echo $this->element('misc/user_creator', array('user' => $blog['User'])); ?>
    </div>
</div>

<?php if(!empty($other_entries)): ?>
<?php echo $this->element('blocks/blogs_block', array('blogs' => $other_entries, 'title' => __('Other Blogs'), 'region' => 'west')); ?>
<?php endif; ?>

<?php if(!empty($tags)): ?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Tags') ?></h3>
        </div>
    </div>
    <div class="box_content">
        <?php echo $this->element( 'blocks/tags_item_block' ); ?>
    </div>
</div>
<?php endif; ?>
<?php $this->end(); ?>

<div class="box2 box_view bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo $blog['Blog']['title']?></h1>
            <div class="box_action">
                <?php if(!empty($uid)): ?>
                    <div class="box-dropdown">
                        <div class="dropdown">
                            <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                                <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </a>
                            <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit">
                                <?php if ($blog['User']['id'] == $uid || ( !empty($cuser) && $cuser['Role']['is_admin'] )): ?>
                                    <li><a href="<?php echo $this->request->base?>/blogs/create/<?php echo $blog['Blog']['id']?>"> <?php echo __( 'Edit Blog')?></a></li>
                                <?php endif; ?>
                                <?php if ( ($blog['Blog']['user_id'] == $uid ) || ( !empty( $blog['Blog']['id'] ) && !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                    <li><a href="javascript:void(0)" data-id="<?php echo $blog['Blog']['id']?>" class="deleteBlog"> <?php echo __( 'Delete Blog')?></a></li>
                                    <li class="seperate"></li>
                                <?php endif; ?>
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(

                                        'href'=>$this->Html->url(array(
                                            "controller" => "reports",
                                            "action" => "ajax_create",
                                            "plugin" => false,
                                            'Blog_Blog',
                                            $blog['Blog']['id'],
                                        )),
                                        'title' => __( 'Report Blog'),
                                        'innerHtml'=>__( 'Report Blog'),
                                    ));
                                    ?>
                                </li>
                                <?php if ($blog['Blog']['privacy'] != PRIVACY_ME): ?>

                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="box_content">
        <div class="post_body">
            <div class="post_content">
                <?php echo $this->Moo->cleanHtml($this->Text->convert_clickable_links_for_hashtags( $blog['Blog']['body']  , Configure::read('Blog.blog_hashtag_enabled') ))?>
            </div>
            <div class="extra_info"><?php echo __( 'Posted in')?> <a href="<?php echo $this->request->base?>/blogs/index/<?php echo $blog['Blog']['category_id']?>/<?php echo seoUrl($blog['Category']['name'])?>"><strong><?php echo $blog['Category']['name']?></strong></a> <?php echo $this->Moo->getTime($blog['Blog']['created'], Configure::read('core.date_format'), $utz)?></div>
            <?php $this->Html->rating($blog['Blog']['id'],'blogs','Blog'); ?>
        </div>
    </div>
</div>

<div class="box2 bar-content-warp">
    <div class="box_content">
        <?php echo $this->element('likes', array('shareUrl' => $this->Html->url(array(
            'plugin' => false,
            'controller' => 'share',
            'action' => 'ajax_share',
            'Blog_Blog',
            'id' => $blog['Blog']['id'],
            'type' => 'blog_item_detail'
        ), true), 'item' => $blog['Blog'], 'type' => $blog['Blog']['moo_type'])); ?>
    </div>
</div>

<div class="box2 bar-content-warp">
    <div class="box_content core_comments blog-comment">
        <?php echo $this->renderComment();?>
    </div>
</div>