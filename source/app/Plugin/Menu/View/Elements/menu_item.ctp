<?php foreach ($menu_item as $key => $item): ?>
    <li id="menu-item-<?php echo  $item['CoreMenuItem']['id'] ?>"
        class="<?php if(!$item['CoreMenuItem']['is_active']){echo 'unactive';}else{echo 'active';} ?> menu-item menu-item-depth-<?php echo  $item['CoreMenuItem']['depth'] ?> menu-item-page menu-item-edit-inactive pending">
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
                        <div >
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
                           name="menu-item-attr-title[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                           value="<?php echo  $item['CoreMenuItem']['title_attribute'] ?>"/>
                    </div>
                </label>
            </div>

            <div class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'Google Material icon class') ?></span>
                    <div>
                        <input type="text" id="edit-menu-item-classes-<?php echo  $item['CoreMenuItem']['id'] ?>"
                               class="widefat code edit-menu-item-classes"
                               name="menu-item-classes[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                               value="<?php echo  $item['CoreMenuItem']['font_class'] ?>"/>
                        <div>
                            <span class="more-des"><?php echo __('Enter Google Material icon class to use. <a target="_blank" href="https://material.io/icons/">Click</a> to visit the site. You can use your own icons by overriding the css in your theme stylesheet');?></span>
                        </div>
                    </div>
                    
                </label>
                
            </div>

            <div class="field-active menu-active">
                <label for="edit-menu-item-active-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'Active') ?></span>
                    <div>
                    <input type="radio" <?php if ($item['CoreMenuItem']['is_active']) {
                        echo 'checked';
                    } ?> value="1" name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                    <?php echo  __( 'Yes') ?> <input <?php if (!$item['CoreMenuItem']['is_active']) {
                        echo 'checked';
                    } ?> type="radio" value="0"
                         name="menu-item-active[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                    <?php echo  __( 'No') ?>
                    </div>
                </label>
            </div>

            <?php if ($item['CoreMenuItem']['type'] != 'header'): ?>
            <div class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>">                    
                    <span><?php echo  __( 'Open in new tab or new window if using Safari') ?> </span>
                    <div class="line-height-input">
                    <input <?php if ($item['CoreMenuItem']['new_blank']) {
                        echo 'checked';
                    } ?> type="checkbox" id="edit-menu-item-target-<?php echo  $item['CoreMenuItem']['id'] ?>"
                         value="1"
                         name="menu-item-target[<?php echo  $item['CoreMenuItem']['id'] ?>]"/>
                    </div>
                </label>
            </div>
            <?php endif; ?>

            <div class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo  $item['CoreMenuItem']['id'] ?>">
                    <span><?php echo  __( 'User Group Access') ?></span>
                    <div class="wrapPermission">
                    <input type="checkbox" value="0" <?php if ($this->Moo->isCheckAllRole($item['CoreMenuItem']['role_access'])) echo 'checked'; ?> class="checkAll" /><?php echo  __( 'Everyone') ?><br/>
                    <div <?php if ($this->Moo->isCheckAllRole($item['CoreMenuItem']['role_access'])): ?> style="display:none;" <?php endif; ?> class="wrapCheck">
                    <?php foreach ($roles as $key_role => $item_role): ?>
                        <input class="check"
                        type="checkbox" <?php if (in_array($item_role['Role']['id'], json_decode($item['CoreMenuItem']['role_access'],true))) {
                            echo 'checked';
                        } ?> value="<?php echo $item_role['Role']['id']; ?>"
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
                						
                <a class="item-delete submitdelete deletion button button-primary" id="delete-<?php echo  $item['CoreMenuItem']['id'] ?>"
                   href="?action=delete-menu-item&amp;menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Remove') ?></a>
                <span class="meta-sep hide-if-no-js"> &nbsp;or&nbsp; </span> <a class="item-cancel hide-if-no-js"
                                                                   id="cancel-<?php echo  $item['CoreMenuItem']['id'] ?>"
                                                                   href="?edit-menu-item=<?php echo  $item['CoreMenuItem']['id'] ?>&#038;cancel=1414575799#menu-item-settings-<?php echo  $item['CoreMenuItem']['id'] ?>"><?php echo  __( 'Cancel') ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                   value="<?php echo  $item['CoreMenuItem']['id'] ?>">

            <input class="menu-item-data-parent-id" type="hidden"
                   name="menu-item-parent-id[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                   value="<?php echo  $item['CoreMenuItem']['parent_id'] ?>"/>
            <input class="menu-item-data-position" type="hidden"
                   name="menu-item-position[<?php echo  $item['CoreMenuItem']['id'] ?>]" value="<?php echo  $item['CoreMenuItem']['menu_order'] ?>"/>
            <input class="menu-item-data-type" type="hidden"
                   name="menu-item-type[<?php echo  $item['CoreMenuItem']['id'] ?>]"
                   value="<?php echo  $item['CoreMenuItem']['type'] ?>"/>
        </div>
        <ul class="menu-item-transport"></ul>
    </li>
<?php endforeach; ?>
