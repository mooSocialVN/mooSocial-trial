<script type='text/javascript'>
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
        Metronic.initUniform();
    });
</script>
    
<?php if ($menu_item_type == 'page'): ?>
    <?php foreach ($menu_item as $key => $item): ?>
        <li id="menu-item-<?php echo  $item['CoreMenuItem']['id'] ?>"
            class="menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
            <span class="item-title"><span class="menu-item-title"><?php echo  $item['CoreMenuItem']['name'] ?></span> <span
                    class="is-submenu"
                    style="display: none;"><?php echo  __( 'sub item') ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo  ucfirst($item['CoreMenuItem']['type']) ?></span>
						<span class="item-order hide-if-js">
							<a href="?action=move-up-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="item-move-up"><abbr title="<?php echo  __( 'Move up') ?>">&#8593;</abbr></a>
							|
							<a href="?action=move-down-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="item-move-down"><abbr title="<?php echo  __( 'Move down') ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           title="<?php echo  __( 'Edit Menu Item') ?>"
                           href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Edit Menu Item') ?></a>
					</span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>">
                <div class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Navigation Label') ?></span>
                        <div>
                        <input type="text" id="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-title"
                               name="menu-item-title[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                               value="<?php echo  $item['CoreMenuItem']['name'] ?>"/>
                            <div>
                                <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "manage",
                                            "action" => "admin_translate",
                                            "plugin" => 'menu',
                                            $item['CoreMenuItem']['id']
                                           
                                        )),
             'title' => __('Translation'),
             'innerHtml'=> __('Translation'),
     ));
 ?>
                              
                            </div>
                        </div>
                    </label>
                </div>
                
                <div style="<?php echo ($item['CoreMenuItem']['type'] == 'link') ? '' : "display:none"; ?>" class="description description-thin">
                    <label for="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'URL') ?></span>
                        <div>
                            <input type="text" id="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-link"
                               name="menu-item-link[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                               value="<?php echo  $item['CoreMenuItem']['url'] ?>"/>
                        </div>
                    </label>
                </div>

                <div class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Title Attribute') ?></span>
                        <div><input type="text" id="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-attr-title"
                               name="menu-item-attr-title[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                        </div>
                    </label>
                </div>

                <div class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Font Awesome Class') ?></span>
                        <div><input type="text" id="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat code edit-menu-item-classes"
                               name="menu-item-classes[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                            <div>
                            <span class="more-des"><?php echo __('Enter Google Material icon class to use. <a target="_blank" href="https://material.io/icons/">Click</a> to visit the site. You can use your own icons by overriding the css in your theme stylesheet');?></span>
                            </div>
                        </div>
                    </label>
                    
                </div>

                <div class="field-active menu-active">
                    <label>
                        <span><?php echo  __( 'Active') ?></span>
                        <div>
                        <input selected type="radio" id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>" checked value="1"
                                                        name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                        <?php echo  __( 'Yes') ?><input type="radio"
                                                id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                value="0" name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                        <?php echo  __( 'No') ?>
                        </div>
                    </label>
                </div>

                <?php if ($item['CoreMenuItem']['type'] != 'header'): ?>
                <div class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Open in new tab or new window if using Safari') ?> </span>
                        <div>
                        <input type="checkbox" id="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               value=""
                               name="menu-item-target[<?php echo  $item['CoreMenuItem']['id'] ?>]"/></div>
                    </label>   
                </div>
                <?php endif; ?>

                <div class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'User Group Access') ?></span>
                        <div class="wrapPermission">
                        <input class="checkAll" checked type="checkbox" value="0" /><?php echo  __( 'Everyone') ?><br/>
                        <div class="wrapCheck">
                        <?php foreach ($roles as $key_role => $item_role): ?>
                            <input checked class="check" type="checkbox" value="<?php echo $item_role['Role']['id']; ?>"
                                   name="menu-item-group-access[<?php echo  $item['CoreMenuItem']['id'] ?>][<?php echo  $key_role ?>]"/><?php echo $item_role['Role']['name'] ?>
                            <br/>
                        <?php endforeach; ?>
                        </div>
                        </div>
                    </label>
                </div>

                <div class="field-move hide-if-no-js description description-wide">
                    <label>
                        <?php echo  __( 'Move') ?>
                        <a href="#" class="menus-move-up"><?php echo  __( 'Up one') ?></a>
                        <a href="#" class="menus-move-down"><?php echo  __( 'Down one') ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php echo  __( 'To the top') ?></a>
                    </label>
                </div>
                <p class="link-to-original">Original: <a target="_blank" href="<?php echo $this->request->webroot . $item['CoreMenuItem']['url']?>"><?php echo $item['CoreMenuItem']['original_name']?></a></p>
                <div class="menu-item-actions description-wide submitbox">
                    
                    <a class="item-delete submitdelete deletion button button-primary" id="delete-<?php echo  $item['CoreMenuItem']['id'] ?>"
                       href="?action=delete-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>">Remove</a>
                    <span class="meta-sep hide-if-no-js"> &nbsp;or&nbsp; </span>
                    <a class="item-cancel hide-if-no-js"
                                                                       id="cancel-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                                       href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>&#038;cancel=1414575799#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Cancel') ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden"
                       name="menu-item-db-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="<?php echo  $item['CoreMenuItem']['id'] ?>">

                <input class="menu-item-data-parent-id" type="hidden"
                       name="menu-item-parent-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
                <input class="menu-item-data-position" type="hidden"
                       name="menu-item-position[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
                <input class="menu-item-data-type" type="hidden"
                       name="menu-item-type[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                       value="page"/>
            </div>
            <ul class="menu-item-transport"></ul>
        </li>
    <?php endforeach; ?>
<?php elseif ($menu_item_type == 'link'): ?>
    <?php foreach ($menu_item as $key => $item): ?>
        <li id="menu-item-<?php echo  $item['CoreMenuItem']['id'] ?>"
            class="menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
            <span class="item-title"><span class="menu-item-title"><?php echo  $item['CoreMenuItem']['name'] ?></span> <span
                    class="is-submenu"
                    style="display: none;"><?php echo  __( 'sub item') ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo  ucfirst($item['CoreMenuItem']['type']) ?></span>
						<span class="item-order hide-if-js">
							<a href="?action=move-up-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="item-move-up"><abbr title="<?php echo  __( 'Move up') ?>">&#8593;</abbr></a>
							|
							<a href="?action=move-down-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="item-move-down"><abbr title="<?php echo  __( 'Move down') ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           title="<?php echo  __( 'Edit Menu Item') ?>"
                           href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Edit Menu Item') ?></a>
					</span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>">
                <div class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Navigation Label') ?></span>
                        <div>
                        <input type="text" id="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-title"
                               name="menu-item-title[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                               value="<?php echo  $item['CoreMenuItem']['name'] ?>"/>
                               <div class="tips" style="margin-left: 165px;">
                                   <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "manage",
                                            "action" => "admin_translate",
                                            "plugin" => 'menu',
                                            $item['CoreMenuItem']['id']
                                            
                                        )),
             'title' => __('Translation'),
             'innerHtml'=> __('Translation'),
     ));
 ?>
                              
                            </div>
                        </div>
                    </label>
                </div>
                
                <div style="<?php echo ($item['CoreMenuItem']['type'] == 'link') ? '' : "display:none"; ?>" class="description description-thin">
                    <label for="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'URL') ?></span>
                        <div>
                            <input type="text" id="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-link"
                               name="menu-item-link[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                               value="<?php echo  $item['CoreMenuItem']['url'] ?>"/>
                        </div>
                    </label>
                </div>

                <div class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Title Attribute') ?></span>
                        <div>
                        <input type="text" id="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat edit-menu-item-attr-title"
                               name="menu-item-attr-title[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                        </div>
                    </label>
                </div>

                <div class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Font Awesome Class') ?></span>
                        <div>
                        <input type="text" id="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat code edit-menu-item-classes"
                               name="menu-item-classes[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                             <div>
                            <span><?php echo __('Enter Google Material icon class to use. <a target="_blank" href="https://material.io/icons/">Click</a> to visit the site. You can use your own icons by overriding the css in your theme stylesheet');?></span>
                                </div>
                        </div>
                    </label>
                   
                </div>

                <div class="field-active menu-active">
                    <label>
                        <span><?php echo  __( 'Active') ?></span>
                        <div>
                            <input selected type="radio" id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>" checked value="1"
                                                            name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                        <?php echo  __( 'Yes') ?><input type="radio"
                                                id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                value="0" name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                        <?php echo  __( 'No') ?>
                        </div>
                    </label>
                </div>

                <?php if ($item['CoreMenuItem']['type'] != 'header'): ?>
                <div class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'Open in new tab or new window if using Safari') ?> </span>
                        <div>
                        <input type="checkbox" id="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               value=""
                               name="menu-item-target[<?php echo  $item['CoreMenuItem']['id'] ?>]"/></div>
                    </label>    
                </div>
                <?php endif; ?>

                <div class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo  $item['CoreMenuItem']['id'] ?>">
                        <span><?php echo  __( 'User Group Access') ?></span>
                        <div class="wrapPermission">
                        <input type="checkbox" checked value="0" class="checkAll" /><?php echo  __( 'Everyone') ?><br/>
                        <div class="wrapCheck">
                        <?php foreach ($roles as $key_role => $item_role): ?>
                            <input checked class="check" type="checkbox" value="<?php echo $item_role['Role']['id']; ?>"
                                   name="menu-item-group-access[<?php echo  $item['CoreMenuItem']['id'] ?>][<?php echo  $key_role ?>]"/><?php echo $item_role['Role']['name'] ?>
                            <br/>
                        <?php endforeach; ?>
                        </div>
                        </div>
                    </label>
                </div>

                <div class="field-move hide-if-no-js description description-wide">
                    <label>
                        <?php echo  __( 'Move') ?>
                        <a href="#" class="menus-move-up"><?php echo  __( 'Up one') ?></a>
                        <a href="#" class="menus-move-down"><?php echo  __( 'Down one') ?></a>
                        <a href="#" class="menus-move-left"></a>
                        <a href="#" class="menus-move-right"></a>
                        <a href="#" class="menus-move-top"><?php echo  __( 'To the top') ?></a>
                    </label>
                </div>

                <div class="menu-item-actions description-wide submitbox">
                    <p class="link-to-original">Original: <a target="_blank" href="<?php echo $this->request->webroot . $item['CoreMenuItem']['url']?>"><?php echo $item['CoreMenuItem']['original_name']?></a></p>
                    <a class="item-delete submitdelete deletion button button-primary" id="delete-<?php echo  $item['CoreMenuItem']['id'] ?>"
                       href="?action=delete-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>">Remove</a>
                    <span class="meta-sep hide-if-no-js"> &nbsp;or&nbsp; </span> <a class="item-cancel hide-if-no-js"
                                                                       id="cancel-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                                       href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>&#038;cancel=1414575799#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Cancel') ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden"
                       name="menu-item-db-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="<?php echo  $item['CoreMenuItem']['id'] ?>">

                <input class="menu-item-data-parent-id" type="hidden"
                       name="menu-item-parent-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
                <input class="menu-item-data-position" type="hidden"
                       name="menu-item-position[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
                <input class="menu-item-data-type" type="hidden"
                       name="menu-item-type[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                       value="link"/>
            </div>
            <ul class="menu-item-transport"></ul>
        </li>
    <?php endforeach; ?>
<?php elseif ($menu_item_type == 'header'): ?>
<?php foreach ($menu_item as $key => $item): ?>
    <li id="menu-item-<?php echo  $item['CoreMenuItem']['id'] ?>"
        class="menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
        <span class="item-title"><span class="menu-item-title"><?php echo  $item['CoreMenuItem']['name'] ?></span> <span
                class="is-submenu"
                style="display: none;"><?php echo  __( 'sub item') ?></span></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo  ucfirst($item['CoreMenuItem']['type']) ?></span>
                    <span class="item-order hide-if-js">
                        <a href="?action=move-up-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="item-move-up"><abbr title="<?php echo  __( 'Move up') ?>">&#8593;</abbr></a>
                        |
                        <a href="?action=move-down-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="item-move-down"><abbr title="<?php echo  __( 'Move down') ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo  $item['CoreMenuItem']['id'] ?>"
                       title="<?php echo  __( 'Edit Menu Item') ?>"
                       href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Edit Menu Item') ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>">
            <div class="description description-thin">
                <label for="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'Navigation Label') ?></span>
                    <div>
                    <input type="text" id="edit-menu-item-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="widefat edit-menu-item-title"
                           name="menu-item-title[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                           value="<?php echo  $item['CoreMenuItem']['name'] ?>"/>
                        <div class="tips" >
                            <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "manage",
                                            "action" => "admin_translate",
                                            "plugin" => 'menu',
                                           $item['CoreMenuItem']['id']
                                           
                                        )),
             'title' => __('Translation'),
             'innerHtml'=> __('Translation'),
     ));
 ?>
                              
                            </div>
                    </div>
                </label>
            </div>
            
            <div style="<?php echo ($item['CoreMenuItem']['type'] == 'link') ? '' : "display:none"; ?>" class="description description-thin">
                <label for="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'URL') ?></span>
                    <div>
                        <input type="text" id="edit-menu-item-link-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="widefat edit-menu-item-link"
                           name="menu-item-link[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                           value="<?php echo  $item['CoreMenuItem']['url'] ?>"/>
                    </div>
                </label>
            </div>

            <div class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'Title Attribute') ?></span>
                    <div>
                    <input type="text" id="edit-menu-item-attr-title-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="widefat edit-menu-item-attr-title"
                           name="menu-item-attr-title[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                    </div>
                </label>
            </div>

            <div class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'Font Awesome Class') ?></span>
                    <div>
                    <input type="text" id="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>"
                           class="widefat code edit-menu-item-classes"
                           name="menu-item-classes[<?php echo  $item['CoreMenuItem']['id'] ?>]" value=""/>
                    <div>
                        <span class="more-des"><?php echo __('Enter Google Material icon class to use. <a target="_blank" href="https://material.io/icons/">Click</a> to visit the site. You can use your own icons by overriding the css in your theme stylesheet');?></div>
                    </div>
                </label>
                
            </div>

            <div class="field-active menu-active">
                <label>
                    <span><?php echo  __( 'Active') ?></span>
                    <div>
                   <input selected type="radio" id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>" checked value="1"
                                                    name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                    <?php echo  __( 'Yes') ?><input type="radio"
                                            id="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                            value="0" name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                    <?php echo  __( 'No') ?>
                    </div>
                </label>
            </div>

            <div class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'User Group Access') ?></span>
                    <div class="wrapPermission">
                    <input type="checkbox" checked value="0" class="checkAll" /><?php echo  __( 'Everyone') ?><br/>
                    <div class="wrapCheck">
                    <?php foreach ($roles as $key_role => $item_role): ?>
                        <input checked class="check" type="checkbox" value="<?php echo $item_role['Role']['id']; ?>"
                               name="menu-item-group-access[<?php echo  $item['CoreMenuItem']['id'] ?>][<?php echo  $key_role ?>]"/><?php echo $item_role['Role']['name'] ?>
                        <br/>
                    <?php endforeach; ?>
                    </div>
                    </div>
                </label>
            </div>

            
            <div class="field-move hide-if-no-js description description-wide">
                <label>
                    <span><?php echo  __( 'Move') ?></span>
                   
                    <a href="#" class="menus-move-up"><?php echo  __( 'Up one') ?></a>
                    <a href="#" class="menus-move-down"><?php echo  __( 'Down one') ?></a>
                    <a href="#" class="menus-move-left"></a>
                    <a href="#" class="menus-move-right"></a>
                    <a href="#" class="menus-move-top"><?php echo  __( 'To the top') ?></a>
                    
                </label>
            </div>

            <div class="menu-item-actions description-wide submitbox">
                <p class="link-to-original">Original: <a target="_blank" href="<?php echo $this->request->webroot . $item['CoreMenuItem']['url']?>"><?php echo $item['CoreMenuItem']['original_name']?></a></p>
                <a class="item-delete submitdelete deletion button button-primary" id="delete-<?php echo  $item['CoreMenuItem']['id'] ?>"
                   href="?action=delete-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>">Remove</a>
                <span class="meta-sep hide-if-no-js"> &nbsp;or&nbsp; </span> <a class="item-cancel hide-if-no-js"
                                                                   id="cancel-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                                   href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>&#038;cancel=1414575799#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Cancel') ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden"
                   name="menu-item-db-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="<?php echo  $item['CoreMenuItem']['id'] ?>">

            <input class="menu-item-data-parent-id" type="hidden"
                   name="menu-item-parent-id[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
            <input class="menu-item-data-position" type="hidden"
                   name="menu-item-position[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="0"/>
            <input class="menu-item-data-type" type="hidden"
                   name="menu-item-type[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                   value="link"/>
        </div>
        <ul class="menu-item-transport"></ul>
    </li>
<?php endforeach; ?>

<?php endif; ?>