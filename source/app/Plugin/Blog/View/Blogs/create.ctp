<?php $this->setCurrentStyle(4) ?>
<?php
$tags_value = '';
$blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
if (!empty($tags))
    $tags_value = implode(', ', $tags);
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooBlog'), 'object' => array('$', 'mooBlog'))); ?>
mooBlog.initOnCreate();
<?php $this->Html->scriptEnd(); ?>

<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php if (empty($blog['Blog']['id'])) echo __('Write New Blog'); else echo __('Edit Blog'); ?></h1>
            </div>
        </div>

        <div class="box_content">
            <div class="create_form">
                <form id="createForm" class="form-horizontal" action="<?php echo $this->request->base; ?>/blogs/save" method="post">
                    <?php
                    if (!empty($blog['Blog']['id']))
                        echo $this->Form->hidden('id', array('value' => $blog['Blog']['id']));
                    echo $this->Form->hidden('thumbnail', array('value' => $blog['Blog']['thumbnail']));
                    echo $this->Form->hidden('blog_photo_ids');
                    ?>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo __('Title') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('title', array('value' => html_entity_decode($blog['Blog']['title']), 'class' => 'form-control', 'placeholder' => '')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label"><?php echo __('Category') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select( 'category_id', $cats, array( 'value' => $blog['Blog']['category_id'], 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="body" class="col-sm-2 control-label"><?php echo __('Body') ?></label>
                        <div class="col-sm-10 tiny_desc">
                            <?php echo $this->Form->tinyMCE('body', array('value' => $blog['Blog']['body'], 'id' => 'editor', 'width' => '100%'), $this); ?>
                            <div class="toggle_image_wrap">
                                <div id="images-uploader" style="display: none;">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div id="photos_upload"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm" id="triggerUpload"><?php echo __('Upload Queued Files') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php //if (empty($isMobile)): ?>
                                <a id="toggleUploader" class="btn-toggle-image" href="javascript:void(0)"><?php echo __('Upload photos into editor') ?></a>
                                <?php //endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label">
                            <?php echo __('Thumbnail') ?> (<a original-title="<?php echo __('Thumbnail only display on blog listing and share blog to facebook') ?>" class="tip" href="javascript:void(0);">?</a>)
                        </label>
                        <div class="col-sm-10">
                            <div id="blog_thumnail" class="control-upload"></div>
                            <div id="blog_thumnail_preview" class="control-upload-review">
                                <?php if (!empty($blog['Blog']['thumbnail'])): ?>
                                    <img width="150" src="<?php echo $blogHelper->getImage($blog, array('prefix' => '150_square')) ?>" />
                                <?php else: ?>
                                    <img width="150" style="display: none;" src="" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tags" class="col-sm-2 control-label"><?php echo __('Tags') ?>  <a href="javascript:void(0)" class="tip" title="<?php echo __('Separated by commas or space') ?>">(?)</a></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('tags', array('value' => $tags_value, 'class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="privacy" class="col-sm-2 control-label"><?php echo __('Privacy') ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->select('privacy', array(PRIVACY_EVERYONE => __('Everyone'),
                                PRIVACY_FRIENDS => __('Friends Only'),
                                PRIVACY_ME => __('Only Me')), array('value' => $blog['Blog']['privacy'],
                                'empty' => false,
                                'class' => 'form-control'
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="create-form-actions">
                                <button type='button' id='saveBtn' class='btn btn-primary'><?php echo __('Save'); ?></button>
                                <?php if (!empty($blog['Blog']['id'])): ?>
                                    <a class="btn btn-default" href="<?php echo $this->request->base ?>/blogs/view/<?php echo $blog['Blog']['id'] ?>"><?php echo __('Cancel') ?></a>
                                <?php endif; ?>
                                <?php if (($blog['Blog']['user_id'] == $uid ) || (!empty($blog['Blog']['id']) && $cuser['Role']['is_admin'] )): ?>
                                    <a class="btn btn-danger deleteBlog" href="javascript:void(0)" data-id="<?php echo $blog['Blog']['id'] ?>"><?php echo __('Delete') ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-danger error-message" id="errorMessage" style="display: none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>