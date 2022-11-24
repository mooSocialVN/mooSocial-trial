<?php
echo $this->Html->css(array('/menu/css/main'), null, array('inline' => false));
echo $this->Html->script(array('/menu/js/menu'), array('inline' => false));

$this->Html->addCrumb(__( 'System Admin'));
$this->Html->addCrumb(__( 'Menu Manager'), array('controller' => 'manage', 'action' => 'admin_index'));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "menu"));
$this->end();
?>

<?php echo $this->Html->scriptStart(array('inline' => false)); ?>
    function initTogglePermission(){
        $('.wrapPermission .checkAll').each(function(item, index){ 
            $(this).click(function(){
                if ($(this).is(':checked')){
                    $(this).parents('.wrapPermission').find('.check').attr('checked', 'checked');
                    $(this).parents('.wrapPermission').find('.check').parent('span').addClass('checked');
                    $(this).parents('.wrapPermission').find('.wrapCheck:first').hide();
                }else{
                    $(this).parents('.wrapPermission').find('.check').attr('checked', false);
                    $(this).parents('.wrapPermission').find('.check').parent('span').removeClass('checked');
                    $(this).parents('.wrapPermission').find('.wrapCheck:first').show();
                }
            });
        });
        
    }
    $(document).ready(function(){
        initTogglePermission();
    });
<?php echo $this->Html->scriptEnd(); ?>

<script type="text/javascript">

    var ajaxurl = '<?php echo $this->request->base ?>/admin/menu/manage/ajax_add_menu/';
    var menus = {
        "oneThemeLocationNoMenus": "",
        "moveUp": "Move up one",
        "moveDown": "Move down one",
        "moveToTop": "Move to the top",
        "moveUnder": "Move under %s",
        "moveOutFrom": "Move out from under %s",
        "under": "Under %s",
        "outFrom": "Out from under %s",
        "menuFocus": "%1$s. Menu item %2$d of %3$d.",
        "subMenuFocus": "%1$s. Sub item number %2$d under %3$s."
    };

    function changeMenu() {
        var menu_id = $('#menu').val();
        window.location.href = "<?php echo $this->request->base ?>/admin/menu/manage/edit_menu/" + menu_id;
    }

    function updateMenu() {

        disableButton('save_menu_header');
        $.post("<?php echo $this->request->base?>/admin/menu/manage/update_menu", $("#update-nav-menu").serialize(), function (data) {
            enableButton('save_menu_header');
            var json = $.parseJSON(data);
            if (json.result == 1) {
                window.location.reload();
            }
            else {
                $(".error-message").show();
                $(".error-message").html(json.message);
            }
        });
    }
    
    function selectAll(obj){
        if ($('.menu-item-checkbox:checked').length != $('.menu-item-checkbox').length){
            $('.menu-item-checkbox').each(function(item, index){
                    if ($(this).is(':checked')){

                    }else{
                        $(this).click();
                    }
            });
        }
        else{
            $('.menu-item-checkbox').each(function(item, index){
                $(this).click();
            });
        }
    }
        

</script>

<div class="wp-core-ui js nav-menus-php">

<div id="wpwrap">

<div id="wpcontent">


<div id="wpbody">
<div id="wpbody-content" aria-label="Main content" tabindex="0" style="overflow: hidden;">
<div class="wrap">

<div class="manage-menus">
    <form method="get" action="<?php echo  $this->request->base ?>/admin/menu/manage">
        <a style="float: left;margin-right:10px;" href="<?php echo  $this->request->base ?>/admin/menu/manage/ajax_create"
           class="btn green"
           data-target="#ajax" data-toggle="modal">
            <?php echo  __( 'Add New Menu') ?></a>
        &nbsp;&nbsp;<span class="choose_menu"><?php echo  __( 'Or Select a menu to edit:') ?></span>&nbsp;&nbsp;
        <?php if ($aMenus): ?>
            <select name="menu" id="menu" onchange="changeMenu();">
                <?php foreach ($aMenus as $item): ?>
                    <option
                        value="<?php echo $item['CoreMenu']['id']; ?>" <?php if ($item['CoreMenu']['id'] == $firstMenu['CoreMenu']['id']) {
                        echo 'selected';
                    } ?>><?php echo $item['CoreMenu']['name']; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </form>
    
</div>
<div><?php echo  __('Note: after a menu is created it will auto add a widget into Available Block at')?> <a href="<?php echo  $this->request->base ?>/admin/layout"><?php echo  __('Layout Editor'); ?></a> <?php echo  __('so that you can drap and drop this widget to anywhere on Page Block Placement')?></div>

<div id="nav-menus-frame">
    
    <div id="menu-settings-column" class="metabox-holder <?php if (!$firstMenu){echo 'metabox-holder-disabled';} ?>">
        <div class="clear"></div>
        <form id="nav-menu-meta" action="" class="nav-menu-meta" method="post" enctype="multipart/form-data">
            <input type="hidden" name="menu" id="nav-menu-meta-object-id" value="8">
            <input type="hidden" name="action" value="add-menu-item">

            <div id="side-sortables" class="accordion-container">
                <ul class="outer-border">
                    <li class="control-section accordion-section  open add-page" id="add-page">
                        <h3 class="accordion-section-title hndle" tabindex="0"><?php echo  __( 'Pages') ?></h3>

                        <div class="accordion-section-content ">
                            <div class="inside">
                                <div id="posttype-page" class="posttypediv">

                                    <div id="page-all" class="tabs-panel tabs-panel-view-all tabs-panel-active">
                                        <ul id="pagechecklist" data-wp-lists="list:page"
                                            class="categorychecklist form-no-clear">
                                            <?php foreach($aPages as $key => $item): ?>
                                            <li>
                                                <label class="menu-item-title">
                                                    <input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-object-id]" value="<?php echo $item['Page']['id']; ?>">
                                                    <?php echo $item['Page']['title']; ?>
                                                </label>
                                                <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-db-id]" value="0">
                                                <input type="hidden" class="menu-item-object" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-object]" value="">
                                                <input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-parent-id]" value="">
                                                <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-type]" value="page">
                                                <input type="hidden" class="menu-item-title" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-title]" value="<?php echo $item['Page']['title']; ?>">
                                                <input type="hidden" class="menu-item-url" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-url]" value="<?php echo $item['Page']['url']; ?>">
                                                <input type="hidden" class="menu-item-target" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-target]" value="">
                                                <input type="hidden" class="menu-item-attr_title" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-attr_title]" value="">
                                                <input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $item['Page']['id']; ?>][menu-item-classes]" value="">
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <p class="button-controls">
                                        <span class="list-controls">
                                            <a href="javascript:void(0)"
                                               onclick="selectAll(this)" class="select-all"><?php echo  __( 'Select All') ?></a>
                                        </span>

                                        <span class="add-to-menu">
                                            <input <?php if (!$firstMenu){echo 'disabled';} ?> type="submit" class="button-secondary submit-add-to-menu right" value="<?php echo  __( 'Add to Menu') ?>"
                                                   name="add-post-type-menu-item" id="submit-posttype-page">
                                            <span class="spinner"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="control-section accordion-section   add-custom-links" id="add-custom-links">
                        <h3 class="accordion-section-title hndle" tabindex="0"><?php echo  __( 'Links') ?></h3>

                        <div class="accordion-section-content ">
                            <div class="inside">
                                <div class="customlinkdiv" id="customlinkdiv">
                                    <input type="hidden" value="link" name="menu-item[-1][menu-item-type]">

                                    <p id="menu-item-url-wrap">
                                        <label class="howto" for="custom-menu-item-url">
                                            <span><?php echo  __( 'URL') ?></span>
                                            <input id="custom-menu-item-url" name="menu-item[-1][menu-item-url]"
                                                   type="text" class="code menu-item-textbox" value="http://">
                                        </label>
                                    </p>

                                    <p id="menu-item-name-wrap">
                                        <label class="howto" for="custom-menu-item-name">
                                            <span><?php echo  __( 'Link Text') ?></span>
                                            <input id="custom-menu-item-name"
                                                   name="menu-item[-1][menu-item-title]" type="text"
                                                   class="regular-text menu-item-textbox input-with-default-title"
                                                   title="<?php echo  __( 'Menu Item') ?>">
                                        </label>
                                    </p>

                                    <p class="button-controls">
                                        <span class="add-to-menu">
                                            <input <?php if (!$firstMenu){echo 'disabled';} ?> type="submit" class="button-secondary submit-add-to-menu right"
                                                   value="<?php echo __( 'Add to Menu')?>" name="add-custom-menu-item"
                                                   id="submit-customlinkdiv">
                                            <span class="spinner"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="control-section accordion-section   add-custom-header" id="add-custom-header">
                        <h3 class="accordion-section-title hndle" tabindex="0"><?php echo  __( 'Header Title') ?></h3>

                        <div class="accordion-section-content ">
                            <div class="inside">
                                <div class="customlinkdiv" id="customlinkdiv">
                                    <input type="hidden" value="header" name="menu-item[-1][menu-item-type]">

                                    <p id="menu-item-name-wrap">
                                        <label class="howto" for="custom-menu-item-name">
                                            <span><?php echo  __( 'Title') ?></span>
                                            <input id="header-menu-item-name"
                                                   name="menu-item[-1][menu-item-title]" type="text"
                                                   class="regular-text menu-item-textbox input-with-default-title"
                                                   title="<?php echo  __( 'Header Title') ?>">
                                        </label>
                                    </p>

                                    <p class="button-controls">
                                        <span class="add-to-menu">
                                            <input <?php if (!$firstMenu){echo 'disabled';} ?> type="submit" class="button-secondary submit-add-header-to-menu right"
                                                   value="<?php echo __( 'Add Header to Menu')?>" name="add-custom-menu-item"
                                                   id="submit-headerdiv">
                                            <span class="spinner"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
    <div id="menu-management-liquid">
        <div id="menu-management">
            <form id="update-nav-menu" action="<?php echo $this->request->base?>/admin/menu/manage/update_menu" method="post" enctype="multipart/form-data">
                <?php if ($firstMenu): ?>
                    <div class="menu-edit ">
                        <input type="hidden" name="id" id="menu" value="<?php if ($firstMenu) { echo $firstMenu['CoreMenu']['id'];} ?>">
                        <div id="nav-menu-header">
                            <div class="major-publishing-actions">
                                <label class="menu-name-label howto open-label" for="menu-name">
                                    <!--span><?php echo  __( 'Menu Name') ?></span-->
                                    <input name="name" id="menu-name" type="text"
                                           class="menu-name regular-text menu-item-textbox"
                                           title="<?php echo  __( 'Enter menu name here') ?>"
                                           value="<?php if ($firstMenu) {
                                               echo $firstMenu['CoreMenu']['name'];
                                           } ?>">
                                </label>
                            </div>
                        </div>
                        <div id="post-body">
                            <div id="post-body-content">
                                <div class="menu-settings">
                                    <dl class="auto-add-pages">
                                        <dt class="menu-style"><?php echo  __( 'Name') ?></dt>
                                        <dd class="checkbox-input">
                                            <select>
                                                <option><?php echo  __('Main Menu');?></option>
                                            </select>
                                        </dd>
                                    </dl>
                                    <dl class="auto-add-pages">
                                        <dt class="menu-style"><?php echo  __( 'Menu Setting') ?></dt>
                                        <dd class="checkbox-input">
                                            <?php echo $this->Form->select('style',
                                                array('horizontal' => __( 'Horizontal'),
                                                    'vertical' => __( 'Vertical')
                                                ), array('value' => $firstMenu['CoreMenu']['style'])); ?>
                                        </dd>
                                    </dl>
                                </div>
                                
                                <h3><?php echo __( 'Menu Structure')?></h3>
                                <div class="drag-instructions post-body-plain" style="display: none;">
                                    <p><?php echo  __('Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.') ?></p>
                                </div>
                                <div id="menu-instructions" class="post-body-plain">
                                    <p><?php echo  __( 'Add menu items from the column on the left.') ?></p></div>
                                <ul class="menu ui-sortable" id="menu-to-edit">
                                    <?php if (isset($menu_item)): ?>
                                    <?php echo $this->element('menu_item' ); ?>
                                    <?php endif; ?>
                                </ul>
                                
                            </div>
                        </div>
                        <div id="nav-menu-footer">
                            <div class="major-publishing-actions">
                            <?php if (!in_array($firstMenu['CoreMenu']['alias'], array('main-menu', 'footer-menu'))): ?>
                            <span class="delete-action">
                                <a style="float: left;"
                                   onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to remove this menu?'));?>', '<?php echo  $this->request->base ?>/admin/menu/manage/do_delete/<?php echo  $firstMenu['CoreMenu']['id'] ?>')"
                                   href="javascript:void(0);" class=""><?php echo  __( 'Delete Menu') ?></a>
                            </span>
                            <?php endif; ?>

                                <div class="publishing-action">
                                    <input type="submit" name="save_menu"
                                           id="save_menu_header"
                                           class="button button-primary menu-save"
                                           value="<?php echo  __( 'Save Menu') ?>"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="alert alert-danger error-message" style="display:none;margin-top:10px;"></div>
            </form>
        
    </div>
</div>
</div>

</div>

</div>

</div>

</div>