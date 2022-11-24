<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup","mooTopic"], function($, mooGroup, mooTopic) {
        mooTopic.initOnCreate();
        mooGroup.initOnCreateGroupTopic();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooTopic', 'mooGroup'), 'object' => array('$', 'mooTopic', 'mooGroup'))); ?>
mooTopic.initOnCreate();
mooGroup.initOnCreateGroupTopic();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>

<?php
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
?>

<style>
.list6 .mce-tinymce { margin-left: 0; }
.attach_remove {display:none;}
#attachments_list li:hover .attach_remove {display:inline-block;}
</style>

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
            <div class="create_form create_form_ajax">
                <form id="createForm" class="form-horizontal">
                    <?php
                    $topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
                    echo $this->Form->hidden( 'attachments', array( 'value' => $attachments_list ) );
                    echo $this->Form->hidden('thumbnail', array('value' => $topic['Topic']['thumbnail']));
                    echo $this->Form->hidden( 'tags' );

                    if (!empty($topic['Topic']['id']))
                        echo $this->Form->hidden('id', array('value' => $topic['Topic']['id']));

                    echo $this->Form->hidden('topic_photo_ids');
                    echo $this->Form->hidden('group_id', array('value' => $group_id));
                    echo $this->Form->hidden('category_id', array('value' => 0));
                    ?>
                    <div class="groupId" data-id="<?php echo $group_id; ?>"></div>
                    <div class="form-content">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo __( 'Topic Title')?></label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->text( 'title', array( 'value' => html_entity_decode($topic['Topic']['title']), 'class' => 'form-control' ) ); ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo __( 'Topic')?></label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->tinyMCE( 'body', array( 'value' => $topic['Topic']['body'], 'id' => 'editor', 'width' => '100%' ), $this ); ?>
                                <div class="toggle_image_wrap">
                                    <div id="images-uploader" style="display: none">
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
                                        <div class="clear"></div>
                                    </div>
                                    <?php //if(empty($isMobile)): ?>
                                    <a id="toggleUploader" href="javascript:void(0)"><?php echo __( 'Upload Photos or Attachments into editor')?></a>
                                    <?php //endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo __( 'Thumbnail')?>(<a original-title="Thumbnail only display on topic listing and share topic to facebook" class="tip" href="javascript:void(0);">?</a>)</label>
                            <div class="col-sm-9">
                                <div id="topic_thumnail"></div>
                                <div id="topic_thumnail_preview">
                                    <?php if (!empty($topic['Topic']['thumbnail'])): ?>
                                        <img width="150" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '150_square'))?>" />
                                    <?php else: ?>
                                        <img width="150" src="" style="display: none;" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($attachments)): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo __( 'Attachments')?></label>
                            <div class="col-sm-9">
                                <ul class="list6 list6sm" id="attachments_list" style="overflow: hidden;">
                                    <?php foreach ($attachments as $attachment): ?>
                                        <li><span class="material-icons moo-icon moo-icon-attach_file">attach_file</span><a href="<?php echo $this->request->base?>/attachments/download/<?php echo $attachment['Attachment']['id']?>" target="_blank"><?php echo $attachment['Attachment']['original_filename']?></a>
                                            &nbsp;<a href="#" data-id="<?php echo $attachment['Attachment']['id']?>" class="attach_remove tip" title="<?php echo __( 'Delete')?>"><span class="material-icons moo-icon moo-icon-delete icon-small">delete</span></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php endif; ?>
                        <div class="form-alert">
                            <div class="alert alert-danger error-message" id="errorMessage" style="display:none;"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-offset-3 col-sm-9">
                                <a href="javascript:void(0)" class="btn btn-primary" id="ajaxCreateButton"><?php echo __( 'Save')?></a>

                                <?php if ( !empty( $topic['Topic']['id'] ) ): ?>
                                    <a href="javascript:void(0)" class="btn btn-default cancelTopic1" data-url="<?php echo $this->request->base?>/topics/ajax_view/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Cancel')?></a>

                                    <?php if ( ($topic['Topic']['user_id'] == $uid ) || ( !empty($my_status) && $my_status['GroupUser']['status'] == GROUP_USER_ADMIN ) || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                        <a href="javascript:void(0)" data-id="<?php echo $topic['Topic']['id']; ?>" data-group="<?php echo $topic['Topic']['group_id']; ?>" class="btn btn-danger deleteTopic"><?php echo __( 'Delete')?></a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <a href="javascript:void(0)" data-url="<?php echo $this->request->base?>/topics/browse/group/<?php echo $this->request->data['group_id']?>" class="btn btn-default cancelTopic"><?php echo __( 'Cancel')?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>