<?php if (!Configure::read('core.guest_search') && empty($uid)): ?><?php else: ?>
<div id="form_main_search_wrap" class="box_header_search">
    <div class="box_header_search_overview"></div>
    <form id="form_main_search" class="header-advanced-search" search-type="ajax" method="post" action="<?php echo $this->request->base ?>/users/ajax_browse/search">
        <div class="header_search_holder">
            <?php echo $this->Form->text( 'name', array('id' => 'keyword', 'placeholder' => __('Search with name'), 'rel' => 'users', 'class' => 'form-control advanced-search-keyword json-view') );?>
            <a id="" class="header_search_btn" href="javascript:void(0);">
                <span class="header-search-icon material-icons moo-icon moo-icon-search">search</span>
            </a>
            <!--<a id="" class="header_search_more" href="javascript:void(0);">
                <span class="header-search-icon header-search-open-more material-icons moo-icon moo-icon-more_horiz">more_horiz</span>
                <span class="header-search-icon header-search-close-more material-icons moo-icon moo-icon-clear">clear</span>
            </a>-->
        </div>
        <!--
        <div class="header_search_popup">
            <div class="form-group-main">
                <div class="form-group">
                    <label><?php //echo __('Email') ?></label>
                    <?php //echo $this->Form->text('email', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <label><?php //echo __('Gender') ?></label>
                    <?php //echo $this->Form->select('gender', $this->Moo->getGenderList(), array('multiple' => 'multiple', 'class' => 'form-control multi')); ?>
                </div>
                <?php //if (Configure::read('core.show_about_search')):?>
                    <div class="form-group">
                        <label><?php //echo __('About') ?></label>
                        <?php //echo $this->Form->textarea('about',array('value'=>$about, 'class' => 'form-control')); ?>
                    </div>
                <?php //endif;?>
                <?php //echo $this->element('custom_fields',array('is_search'=>true, 'custom_field_for' => 'custom_field_advanced_search_form')); ?>
                <div class="form-group">
                    <label class="checkbox-control">
                        <?php //echo __('Profile Picture') ?>
                        <?php //echo $this->Form->checkbox('picture'); ?>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-control">
                        <?php //echo __('Online Users') ?>
                        <?php
                        //if (!empty($online_filter))
                            //echo $this->Form->checkbox('online', array('checked' => true));
                        //else
                            //echo $this->Form->checkbox('online');
                        ?>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <?php //$this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.searchForm.afterRender', $this)); ?>
            </div>

            <div class="form-group-bottom">
                <button class="btn btn-search_close btn-cs" type="button">
                    <span class="btn-cs-main">
                        <span class="btn-text"><?php //echo __('Cancel');?></span>
                    </span>
                </button>

                <button class="btn btn-search_submit btn-cs" type="submit">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-search">search</span> <span class="btn-text"><?php echo __('Search');?></span>
                    </span>
                </button>
            </div>
        </div>
        -->
    </form>
</div>
<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooSearchItem"], function($,mooUser) {
        $('#form_main_search_wrap').SearchItemUI({asButtonOpenFor: '.open-main-search-btn'});
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooSearchItem'), 'object' => array('$', 'mooSearchItem'))); ?>
    $('#form_main_search_wrap').SearchItemUI({asButtonOpenFor: '.open-main-search-btn'});
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>
<?php endif; ?>