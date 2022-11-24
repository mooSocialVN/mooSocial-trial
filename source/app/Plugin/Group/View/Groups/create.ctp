<?php $this->setCurrentStyle(4) ?>
<?php
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initOnCreate();
<?php $this->Html->scriptEnd(); ?>

<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php if (empty($group['Group']['id'])) echo __( 'Add New Group'); else echo __( 'Edit Group'); ?></h1>
            </div>
        </div>

        <div class="box_content">
            <div class="create_form">
                <form id="createForm" class="form-horizontal">
                    <?php
                    if (!empty($group['Group']['id'])){
                        echo $this->Form->hidden('id', array('value' => $group['Group']['id']));
                        echo $this->Form->hidden('photo', array('value' => $group['Group']['photo']));
                    }else{
                        echo $this->Form->hidden('photo', array('value' => ''));
                    }
                    ?>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label"><?php echo __('Group Name') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->text('name', array('value' => html_entity_decode($group['Group']['name']), 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label"><?php echo __('Category') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->select('category_id', $categories, array('value' => $group['Group']['category_id'], 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label"><?php echo __('Description') ?></label>
                        <div class="col-sm-10">
                            <?php echo $this->Form->tinyMCE('description', array('id' => 'editor','escape'=>false,'value' => $group['Group']['description'], 'width' => '100%'), $this); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label"><?php echo  __( 'Group Type') ?> <a href="javascript:void(0)" class="tip" title="<?php echo  __( "<p style='display:inline-block; width:150px;'>Public: anyone can view and join<br />Private: only members can view group's details<br />Restricted: anyone can view but join request has to be accepted by group admins</p>") ?>">(?)</a></label>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->select('type', array(PRIVACY_PUBLIC => __( 'Public'),
                                PRIVACY_PRIVATE => __( 'Private'),
                                PRIVACY_RESTRICTED => __( 'Restricted')
                            ), array('value' => $group['Group']['type'], 'empty' => false, 'class' => 'form-control')
                            );
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-2 control-label"><?php echo __('Photo') ?></label>
                        <div class="col-sm-10">
                            <div id="select-0" class="control-upload"></div>
                            <div id="select_thumnail_preview" class="control-upload-review">
                                <?php if (!empty($group['Group']['photo'])): ?>
                                    <img width="150" src="<?php echo $groupHelper->getImage($group, array('prefix' => '150_square'))?>" id="item-avatar" class="img_wrapper">
                                <?php else: ?>
                                    <img width="150" src="" id="item-avatar" class="img_wrapper" style="display: none;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="create-form-actions">
                                <button type='button' id='saveBtn' class='btn btn-primary'><?php echo __('Save'); ?></button>
                                <?php if (!empty($group['Group']['id'])): ?>
                                <a class="btn btn-default" href="<?php echo  $this->request->base ?>/groups/view/<?php echo  $group['Group']['id'] ?>"><?php echo  __( 'Cancel') ?></a>
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