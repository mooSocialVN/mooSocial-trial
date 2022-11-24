<div id="form_main_search_wrap" class="box_header_search">
    <div class="box_header_search_overview"></div>
    <form id="form_main_search" class="header-advanced-search" search-type="ajax" method="get">
        <div class="header_search_holder">
            <?php echo $this->Form->text('keyword', array('placeholder' => __('Enter keyword to search'), 'rel' => 'groups', 'class' => 'form-control advanced-search-keyword json-view')); ?>
            <a id="" class="header_search_btn" href="javascript:void(0);">
                <span class="header-search-icon material-icons moo-icon moo-icon-search">search</span>
            </a>
        </div>
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