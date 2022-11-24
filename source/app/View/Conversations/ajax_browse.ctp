<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Conversations')?></h3>
            <div class="box_action">
                <a class="box-btn btn-header_icon open-conv-search-btn" href="javascript:void(0);">
                    <span class="btn-icon material-icons moo-icon moo-icon-search">search</span>
                </a>
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->Html->url(array("controller" => "conversations", "action" => "mark_all_read", "plugin" => false)); ?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-check_circle">check_circle</span>
                        <span class="btn-text hidden-xs"><?php echo __('Mark All As Read'); ?></span>
                    </span>
                </a>

                <?php $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "conversations",
                        "action" => "ajax_send",
                        "plugin" => false,

                    )),
                    'title' => __('Send New Message'),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-email">email</span><span class="btn-text hidden-xs">'.__('Send New Message').'</span></span>',
                    'class' => 'box-btn btn btn-header_title btn-cs'
                )); ?>
            </div>
        </div>

        <div id="form_conv_search_wrap" class="box_header_search">
            <div class="box_header_search_overview"></div>
            <form id="form_conv_search" class="header-advanced-search" search-type="ajax" method="get">
                <div class="header_search_holder">
                    <?php echo $this->Form->text('conv_keyword', array('class' => 'form-control advanced-search-keyword', 'placeholder' => __('Search')));?>
                    <a id="" class="header_search_btn" href="javascript:void(0);">
                        <span class="header-search-icon material-icons moo-icon moo-icon-search">search</span>
                    </a>
                </div>
            </form>
        </div>

    </div>
    <div class="box_content content_center_messages">
        <ul id="list-content" class="notification-group-list conversation_list">
            <?php echo $this->element( 'lists/messages_list', array( 'more_url' => '/conversations/ajax_browse/page:2' ) ); ?>
        </ul>
    </div>
</div>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">require(["jquery","mooGlobal","mooSearchItem"], function($,mooUser) {
        <?php else: ?>
        <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooGlobal','mooSearchItem'), 'object' => array('$', 'mooGlobal', 'mooSearchItem'))); ?>
        <?php endif; ?>
        mooGlobal.initSearchMessage();
        $('#form_conv_search_wrap').SearchItemUI({asButtonOpenFor: '.open-conv-search-btn'});
        <?php if($this->request->is('ajax')): ?>});
</script>
<?php else: ?>
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>