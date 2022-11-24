<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooTopic'), 'object' => array('$', 'mooTopic'))); ?>
mooTopic.initOnCreate();
<?php $this->Html->scriptEnd(); ?>

<?php $this->setCurrentStyle(4) ?>
<?php
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
$tags_value = '';
if (!empty($tags)){
    $tags_value = implode(', ', $tags);
}
?>

<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title">
                    <?php if (empty($topic['Topic']['id'])) echo __( 'Create New Topic'); else echo __( 'Edit Topic');?>
                </h1>
            </div>
        </div>

        <div class="box_content">
            <div class="create_form">
                <form id="createForm" class="form-horizontal">
                <?php
                echo $this->Form->hidden( 'attachments', array( 'value' => $attachments_list ) );
                    echo $this->Form->hidden('thumbnail', array('value' => $topic['Topic']['thumbnail']));
                    echo $this->Form->hidden('plugin_topic_id', array('value' => PLUGIN_TOPIC_ID));
                    echo $this->Form->hidden('topic_photo_ids');
                if (!empty($topic['Topic']['id']))
                    echo $this->Form->hidden('id', array('value' => $topic['Topic']['id']));
                ?>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo __('Topic Title') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text( 'title', array( 'value' => html_entity_decode($topic['Topic']['title']), 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label"><?php echo __('Category') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select( 'category_id', $cats, array( 'value' => $topic['Topic']['category_id'], 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body" class="col-sm-2 control-label"><?php echo __('Topic') ?></label>
                        <div class="col-sm-10 tiny_desc">
                            <?php echo $this->Form->tinyMCE( 'body', array( 'value' => $topic['Topic']['body'], 'id' => 'editor', 'width' => '100%' ), $this ); ?>
                            <div class="toggle_image_wrap">
                                <div id="images-uploader" style="display: none;">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <div id="attachments_upload"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm" id="triggerUpload"><?php echo __( 'Upload Queued Files')?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php //if(empty($isMobile)): ?>
                                <a id="toggleUploader" class="btn-toggle-image" href="javascript:void(0)"><?php echo __( 'Upload Photos or Attachments into editor')?></a>
                                <?php //endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __( 'Thumbnail')?>(<a original-title="<?php echo __( 'Thumbnail only display on topic listing and share topic to facebook')?>" class="tip" href="javascript:void(0);">?</a>)</label>
                        <div class="col-sm-10">
                            <div id="topic_thumnail" class="control-upload"></div>
                            <div id="topic_thumnail_preview" class="control-upload-review">
                                <?php if (!empty($topic['Topic']['thumbnail'])): ?>
                                    <img width="150" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '150_square'))?>" />
                                <?php else: ?>
                                    <img width="150" src="" style="display: none;" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags" class="col-sm-2 control-label"><?php echo __('Tags') ?> (<a href="javascript:void(0)" class="tip" title="<?php echo __( 'Separated by commas or space')?>">?</a>)</label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text( 'tags', array( 'value' => $tags_value, 'class' => 'form-control' ) ); ?>
                        </div>
                    </div>
                    <?php if (!empty($attachments)): ?>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"><?php echo __('Attachments') ?></label>
                        <div class="col-sm-10">
                            <ul class="list6 list6sm" id="attachments_list" style="overflow: hidden;">
                                <?php foreach ($attachments as $attachment): ?>
                                    <li><span class="material-icons moo-icon moo-icon-attach_file">attach_file</span><a href="<?php echo $this->request->base?>/attachments/download/<?php echo $attachment['Attachment']['id']?>" target="_blank"><?php echo $attachment['Attachment']['original_filename']?></a>
                                        &nbsp;<a href="#" data-id="<?php echo $attachment['Attachment']['id']?>" class="attach_remove tip" title="<?php echo __( 'Delete')?>"><span class="material-icons moo-icon moo-icon-delete icon-small">delete</span></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="create-form-actions">
                                <button type='button' id='saveBtn' class='btn btn-primary'><?php echo __('Save'); ?></button>
                                <?php if ( !empty( $topic['Topic']['id'] ) ): ?>
                                    <a class="btn btn-default" href="<?php echo $this->request->base?>/topics/view/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Cancel')?></a>
                                <?php endif; ?>
                                <?php if ( ($topic['Topic']['user_id'] == $uid ) || ( !empty( $topic['Topic']['id'] ) && $cuser['Role']['is_admin'] ) ): ?>
                                    <a class="btn btn-danger deleteTopic" href="javascript:void(0)" data-id="<?php echo $topic['Topic']['id']?>"><?php echo __( 'Delete')?></a>
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