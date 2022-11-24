<div class="form-content-setting">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tab-setting" role="tablist">
        <li role="presentation" class="active"><a href="#default-setting" role="tab" data-toggle="tab"><?php echo __('Layout') ?></a></li>
        <li role="presentation"><a href="#menu-setting" role="tab" data-toggle="tab"><?php echo __('Menu') ?></a></li>
        <li role="presentation"><a href="#whatnew-setting" role="tab" data-toggle="tab"><?php echo __("What's New") ?></a></li>
        <li role="presentation"><a href="#comment-setting" role="tab" data-toggle="tab"><?php echo __('Comment') ?></a></li>
        <li role="presentation"><a href="#profile-setting" role="tab" data-toggle="tab"><?php echo __('Profile') ?></a></li>
        <li role="presentation"><a href="#globalSearch-setting" role="tab" data-toggle="tab"><?php echo __('Global Search') ?></a></li>
        <li role="presentation"><a href="#block-setting" role="tab" data-toggle="tab"><?php echo __('Block') ?></a></li>
        <li role="presentation"><a href="#modal-setting" role="tab" data-toggle="tab"><?php echo __('Modal') ?></a></li>
        <li role="presentation"><a href="#form-setting" role="tab" data-toggle="tab"><?php echo __('Form') ?></a></li>
        <li role="presentation"><a href="#content-setting" role="tab" data-toggle="tab"><?php echo __('Content') ?></a></li>
        <li role="presentation"><a href="#mobile-setting" role="tab" data-toggle="tab"><?php echo __('Mobile') ?></a></li>
        <li role="presentation"><a href="#widget-notification" role="tab" data-toggle="tab"><?php echo __('Notification') ?></a></li>
        <li role="presentation"><a href="#more-setting" role="tab" data-toggle="tab"><?php echo __('More') ?></a></li>
        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.adminThemeSetting.settingTabMenu', $this, array())); ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tab-content-setting">
        <div role="tabpanel" class="tab-pane active" id="default-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Body'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseBody" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseBody">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/body.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseBody" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Image'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_image_value = isset($custom_css_arr['page_background_image']['value']) ? $custom_css_arr['page_background_image']['value'] : '' ?>
                            <div class="upload_image_review">
                                <?php if(!empty($page_background_image_value)): ?>
                                <div class="image_review-thumb">
                                    <img class="review-img" src="<?php echo $this->request->webroot.'uploads/theme/'.$page_background_image_value ?>">
                                    <a class="reset-upload_image_review" href="javascript:void(0)"><?php echo __('Reset'); ?></a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="upload_image_field" name="page_background_image">
                                <input type="hidden" class="upload_image_value" name="data[css][page_background_image][value]" value="<?php echo $page_background_image_value ?>">
                                <input type="hidden" class="upload_image_type" name="data[css][page_background_image][type]" value="upload_image">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Position'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_position_value = isset($custom_css_arr['page_background_position']['value']) ? $custom_css_arr['page_background_position']['value'] : '' ?>
                            <select id="frm-page_background_position" class="form-control" name="data[css][page_background_position][value]">
                                <option value="">none</option>
                                <option value="center center" <?php if($page_background_position_value == 'center center'): ?>selected="selected"<?php endif; ?>>center center</option>
                                <option value="top center" <?php if($page_background_position_value == 'top center'): ?>selected="selected"<?php endif; ?>>top center</option>
                                <option value="top left" <?php if($page_background_position_value == 'top left'): ?>selected="selected"<?php endif; ?>>top left</option>
                                <option value="top right" <?php if($page_background_position_value == 'top right'): ?>selected="selected"<?php endif; ?>>top right</option>
                                <option value="bottom center" <?php if($page_background_position_value == 'bottom center'): ?>selected="selected"<?php endif; ?>>bottom center</option>
                                <option value="bottom left" <?php if($page_background_position_value == 'bottom left'): ?>selected="selected"<?php endif; ?>>bottom left</option>
                                <option value="bottom right" <?php if($page_background_position_value == 'bottom right'): ?>selected="selected"<?php endif; ?>>bottom right</option>
                            </select>
                            <input type="hidden" name="data[css][page_background_position][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Repeat'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_repeat_value = isset($custom_css_arr['page_background_repeat']['value']) ? $custom_css_arr['page_background_repeat']['value'] : '' ?>
                            <select id="frm-page_background_repeat" class="form-control" name="data[css][page_background_repeat][value]">
                                <option value="">none</option>
                                <option value="no-repeat" <?php if($page_background_repeat_value == 'no-repeat'): ?>selected="selected"<?php endif; ?>>no-repeat</option>
                                <option value="repeat" <?php if($page_background_repeat_value == 'repeat'): ?>selected="selected"<?php endif; ?>>repeat</option>
                                <option value="repeat-x" <?php if($page_background_repeat_value == 'repeat-x'): ?>selected="selected"<?php endif; ?>>repeat-x</option>
                                <option value="repeat-y" <?php if($page_background_repeat_value == 'repeat-y'): ?>selected="selected"<?php endif; ?>>repeat-y</option>
                            </select>
                            <input type="hidden" name="data[css][page_background_repeat][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Size'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_size_value = isset($custom_css_arr['page_background_size']['value']) ? $custom_css_arr['page_background_size']['value'] : '' ?>
                            <select id="frm-page_background_size" class="form-control" name="data[css][page_background_size][value]">
                                <option value="">none</option>
                                <option value="cover" <?php if($page_background_size_value == 'cover'): ?>selected="selected"<?php endif; ?>>cover</option>
                                <option value="contain" <?php if($page_background_size_value == 'contain'): ?>selected="selected"<?php endif; ?>>contain</option>
                                <option value="auto" <?php if($page_background_size_value == 'auto'): ?>selected="selected"<?php endif; ?>>auto</option>
                            </select>
                            <input type="hidden" name="data[css][page_background_size][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Attachment'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_size_value = isset($custom_css_arr['page_background_attachment']['value']) ? $custom_css_arr['page_background_attachment']['value'] : '' ?>
                            <select id="frm-page_background_attachment" class="form-control" name="data[css][page_background_attachment][value]">
                                <option value="">none</option>
                                <option value="fixed" <?php if($page_background_size_value == 'fixed'): ?>selected="selected"<?php endif; ?>>fixed</option>
                                <option value="scroll" <?php if($page_background_size_value == 'scroll'): ?>selected="selected"<?php endif; ?>>scroll</option>
                            </select>
                            <input type="hidden" name="data[css][page_background_attachment][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_background_color_value = isset($custom_css_arr['page_background_color']['value']) ? $custom_css_arr['page_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_background_color" class="color-picker form-control" name="data[css][page_background_color][value]" value="<?php echo $page_background_color_value ?>">
                            <input type="hidden" name="data[css][page_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_text_color_value = isset($custom_css_arr['page_text_color']['value']) ? $custom_css_arr['page_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_text_color" class="color-picker form-control" name="data[css][page_text_color][value]" value="<?php echo $page_text_color_value ?>">
                            <input type="hidden" name="data[css][page_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_link_color_value = isset($custom_css_arr['page_link_color']['value']) ? $custom_css_arr['page_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_link_color" class="color-picker form-control" name="data[css][page_link_color][value]" value="<?php echo $page_link_color_value ?>">
                            <input type="hidden" name="data[css][page_link_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_active_link_color_value = isset($custom_css_arr['page_active_link_color']['value']) ? $custom_css_arr['page_active_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_active_link_color" class="color-picker form-control" name="data[css][page_active_link_color][value]" value="<?php echo $page_active_link_color_value ?>">
                            <input type="hidden" name="data[css][page_active_link_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_border_color_value = isset($custom_css_arr['page_border_color']['value']) ? $custom_css_arr['page_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_border_color" class="color-picker form-control" name="data[css][page_border_color][value]" value="<?php echo $page_border_color_value ?>">
                            <input type="hidden" name="data[css][page_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Header'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseHeader" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseHeader">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/header.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseHeader" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Image'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_background_image_value = isset($custom_css_arr['page_header_background_image']['value']) ? $custom_css_arr['page_header_background_image']['value'] : '' ?>
                            <div class="upload_image_review">
                                <?php if(!empty($page_header_background_image_value)): ?>
                                <div class="image_review-thumb">
                                    <img class="review-img" src="<?php echo $this->request->webroot.'uploads/theme/'.$page_header_background_image_value ?>">
                                    <a class="reset-upload_image_review" href="javascript:void(0)"><?php echo __('Reset'); ?></a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="upload_image_field" name="page_header_background_image">
                                <input type="hidden" class="upload_image_value" name="data[css][page_header_background_image][value]" value="<?php echo $page_header_background_image_value ?>">
                                <input type="hidden" class="upload_image_type" name="data[css][page_header_background_image][type]" value="upload_image">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Position'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_background_position_value = isset($custom_css_arr['page_header_background_position']['value']) ? $custom_css_arr['page_header_background_position']['value'] : '' ?>
                            <select id="frm-page_header_background_position" class="form-control" name="data[css][page_header_background_position][value]">
                                <option value="">none</option>
                                <option value="center center" <?php if($page_header_background_position_value == 'center center'): ?>selected="selected"<?php endif; ?>>center center</option>
                                <option value="top center" <?php if($page_header_background_position_value == 'top center'): ?>selected="selected"<?php endif; ?>>top center</option>
                                <option value="top left" <?php if($page_header_background_position_value == 'top left'): ?>selected="selected"<?php endif; ?>>top left</option>
                                <option value="top right" <?php if($page_header_background_position_value == 'top right'): ?>selected="selected"<?php endif; ?>>top right</option>
                                <option value="bottom center" <?php if($page_header_background_position_value == 'bottom center'): ?>selected="selected"<?php endif; ?>>bottom center</option>
                                <option value="bottom left" <?php if($page_header_background_position_value == 'bottom left'): ?>selected="selected"<?php endif; ?>>bottom left</option>
                                <option value="bottom right" <?php if($page_header_background_position_value == 'bottom right'): ?>selected="selected"<?php endif; ?>>bottom right</option>
                            </select>
                            <input type="hidden" name="data[css][page_header_background_position][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Repeat'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_background_repeat_value = isset($custom_css_arr['page_header_background_repeat']['value']) ? $custom_css_arr['page_header_background_repeat']['value'] : '' ?>
                            <select id="frm-page_header_background_repeat" class="form-control" name="data[css][page_header_background_repeat][value]">
                                <option value="">none</option>
                                <option value="no-repeat" <?php if($page_header_background_repeat_value == 'no-repeat'): ?>selected="selected"<?php endif; ?>>no-repeat</option>
                                <option value="repeat" <?php if($page_header_background_repeat_value == 'repeat'): ?>selected="selected"<?php endif; ?>>repeat</option>
                                <option value="repeat-x" <?php if($page_header_background_repeat_value == 'repeat-x'): ?>selected="selected"<?php endif; ?>>repeat-x</option>
                                <option value="repeat-y" <?php if($page_header_background_repeat_value == 'repeat-y'): ?>selected="selected"<?php endif; ?>>repeat-y</option>
                            </select>
                            <input type="hidden" name="data[css][page_header_background_repeat][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Size'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_background_size_value = isset($custom_css_arr['page_header_background_size']['value']) ? $custom_css_arr['page_header_background_size']['value'] : '' ?>
                            <select id="frm-page_header_background_size" class="form-control" name="data[css][page_header_background_size][value]">
                                <option value="">none</option>
                                <option value="cover" <?php if($page_header_background_size_value == 'cover'): ?>selected="selected"<?php endif; ?>>cover</option>
                                <option value="contain" <?php if($page_header_background_size_value == 'contain'): ?>selected="selected"<?php endif; ?>>contain</option>
                                <option value="auto" <?php if($page_header_background_size_value == 'auto'): ?>selected="selected"<?php endif; ?>>auto</option>
                            </select>
                            <input type="hidden" name="data[css][page_header_background_size][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_background_color_value = isset($custom_css_arr['page_header_background_color']['value']) ? $custom_css_arr['page_header_background_color']['value'] : '' ?>
                            <input id="frm-page_header_background_color" type="text" class="color-picker form-control" name="data[css][page_header_background_color][value]" value="<?php echo $page_header_background_color_value ?>">
                            <input type="hidden" name="data[css][page_header_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Top Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_top_background_color_value = isset($custom_css_arr['page_header_top_background_color']['value']) ? $custom_css_arr['page_header_top_background_color']['value'] : '' ?>
                            <input id="frm-page_header_top_background_color" type="text" class="color-picker form-control" name="data[css][page_header_top_background_color][value]" value="<?php echo $page_header_top_background_color_value ?>">
                            <input type="hidden" name="data[css][page_header_top_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icons Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_icons_color_value = isset($custom_css_arr['page_header_icons_color']['value']) ? $custom_css_arr['page_header_icons_color']['value'] : '' ?>
                            <input type="text" id="frm-page_header_icons_color" class="color-picker form-control" name="data[css][page_header_icons_color][value]" value="<?php echo $page_header_icons_color_value ?>">
                            <input type="hidden" name="data[css][page_header_icons_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icons Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_icons_active_color_value = isset($custom_css_arr['page_header_icons_active_color']['value']) ? $custom_css_arr['page_header_icons_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_header_icons_active_color" class="color-picker form-control" name="data[css][page_header_icons_active_color][value]" value="<?php echo $page_header_icons_active_color_value ?>">
                            <input type="hidden" name="data[css][page_header_icons_active_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_header_border_color_value = isset($custom_css_arr['page_header_border_color']['value']) ? $custom_css_arr['page_header_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_header_border_color" class="color-picker form-control" name="data[css][page_header_border_color][value]" value="<?php echo $page_header_border_color_value ?>">
                            <input type="hidden" name="data[css][page_header_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('User'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseUser" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseUser">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/user.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseUser" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('User Name Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_name_color_value = isset($custom_css_arr['page_user_name_color']['value']) ? $custom_css_arr['page_user_name_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_name_color" class="color-picker form-control" name="data[css][page_user_name_color][value]" value="<?php echo $page_user_name_color_value ?>">
                            <input type="hidden" name="data[css][page_user_name_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_dropdown_background_color_value = isset($custom_css_arr['page_user_dropdown_background_color']['value']) ? $custom_css_arr['page_user_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_dropdown_background_color" class="color-picker form-control" name="data[css][page_user_dropdown_background_color][value]" value="<?php echo $page_user_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_user_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_dropdown_text_color_value = isset($custom_css_arr['page_user_dropdown_text_color']['value']) ? $custom_css_arr['page_user_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_dropdown_text_color" class="color-picker form-control" name="data[css][page_user_dropdown_text_color][value]" value="<?php echo $page_user_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_user_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Hover Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_dropdown_hover_background_color_value = isset($custom_css_arr['page_user_dropdown_hover_background_color']['value']) ? $custom_css_arr['page_user_dropdown_hover_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_dropdown_hover_background_color" class="color-picker form-control" name="data[css][page_user_dropdown_hover_background_color][value]" value="<?php echo $page_user_dropdown_hover_background_color_value ?>">
                            <input type="hidden" name="data[css][page_user_dropdown_hover_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Hover Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_dropdown_hover_text_color_value = isset($custom_css_arr['page_user_dropdown_hover_text_color']['value']) ? $custom_css_arr['page_user_dropdown_hover_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_dropdown_hover_text_color" class="color-picker form-control" name="data[css][page_user_dropdown_hover_text_color][value]" value="<?php echo $page_user_dropdown_hover_text_color_value ?>">
                            <input type="hidden" name="data[css][page_user_dropdown_hover_text_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('List Items'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseListitem" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseListitem">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/listitem.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseListitem" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Title Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_title_color_value = isset($custom_css_arr['page_list_item_title_color']['value']) ? $custom_css_arr['page_list_item_title_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_title_color" class="color-picker form-control" name="data[css][page_list_item_title_color][value]" value="<?php echo $page_list_item_title_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_title_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Count Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_count_color_value = isset($custom_css_arr['page_list_item_count_color']['value']) ? $custom_css_arr['page_list_item_count_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_count_color" class="color-picker form-control" name="data[css][page_list_item_count_color][value]" value="<?php echo $page_list_item_count_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_count_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_date_color_value = isset($custom_css_arr['page_list_item_date_color']['value']) ? $custom_css_arr['page_list_item_date_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_date_color" class="color-picker form-control" name="data[css][page_list_item_date_color][value]" value="<?php echo $page_list_item_date_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_date_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_text_color_value = isset($custom_css_arr['page_list_item_text_color']['value']) ? $custom_css_arr['page_list_item_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_text_color" class="color-picker form-control" name="data[css][page_list_item_text_color][value]" value="<?php echo $page_list_item_text_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_link_color_value = isset($custom_css_arr['page_list_item_link_color']['value']) ? $custom_css_arr['page_list_item_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_link_color" class="color-picker form-control" name="data[css][page_list_item_link_color][value]" value="<?php echo $page_list_item_link_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_link_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Pin Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_pin_icon_color_value = isset($custom_css_arr['page_list_item_pin_icon_color']['value']) ? $custom_css_arr['page_list_item_pin_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_pin_icon_color" class="color-picker form-control" name="data[css][page_list_item_pin_icon_color][value]" value="<?php echo $page_list_item_pin_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_pin_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_dropdown_icon_color_value = isset($custom_css_arr['page_list_item_dropdown_icon_color']['value']) ? $custom_css_arr['page_list_item_dropdown_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_dropdown_icon_color" class="color-picker form-control" name="data[css][page_list_item_dropdown_icon_color][value]" value="<?php echo $page_list_item_dropdown_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_dropdown_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_background_color_value = isset($custom_css_arr['page_list_item_gridlist_background_color']['value']) ? $custom_css_arr['page_list_item_gridlist_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_background_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_background_color][value]" value="<?php echo $page_list_item_gridlist_background_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_icon_color_value = isset($custom_css_arr['page_list_item_gridlist_icon_color']['value']) ? $custom_css_arr['page_list_item_gridlist_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_icon_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_icon_color][value]" value="<?php echo $page_list_item_gridlist_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_border_color_value = isset($custom_css_arr['page_list_item_gridlist_border_color']['value']) ? $custom_css_arr['page_list_item_gridlist_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_border_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_border_color][value]" value="<?php echo $page_list_item_gridlist_border_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_active_background_color_value = isset($custom_css_arr['page_list_item_gridlist_active_background_color']['value']) ? $custom_css_arr['page_list_item_gridlist_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_active_background_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_active_background_color][value]" value="<?php echo $page_list_item_gridlist_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Icon Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_icon_active_color_value = isset($custom_css_arr['page_list_item_gridlist_icon_active_color']['value']) ? $custom_css_arr['page_list_item_gridlist_icon_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_icon_active_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_icon_active_color][value]" value="<?php echo $page_list_item_gridlist_icon_active_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_icon_active_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Grid/List Active Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_gridlist_active_border_color_value = isset($custom_css_arr['page_list_item_gridlist_active_border_color']['value']) ? $custom_css_arr['page_list_item_gridlist_active_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_gridlist_active_border_color" class="color-picker form-control" name="data[css][page_list_item_gridlist_active_border_color][value]" value="<?php echo $page_list_item_gridlist_active_border_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_gridlist_active_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_list_item_border_color_value = isset($custom_css_arr['page_list_item_border_color']['value']) ? $custom_css_arr['page_list_item_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_list_item_border_color" class="color-picker form-control" name="data[css][page_list_item_border_color][value]" value="<?php echo $page_list_item_border_color_value ?>">
                            <input type="hidden" name="data[css][page_list_item_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button View More Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $button_viewmore_background_color_value = isset($custom_css_arr['button_viewmore_background_color']['value']) ? $custom_css_arr['button_viewmore_background_color']['value'] : '' ?>
                            <input type="text" id="frm-button_viewmore_background_color" class="color-picker form-control" name="data[css][button_viewmore_background_color][value]" value="<?php echo $button_viewmore_background_color_value ?>">
                            <input type="hidden" name="data[css][button_viewmore_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button View More Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $button_viewmore_text_color_value = isset($custom_css_arr['button_viewmore_text_color']['value']) ? $custom_css_arr['button_viewmore_text_color']['value'] : '' ?>
                            <input type="text" id="frm-button_viewmore_text_color" class="color-picker form-control" name="data[css][button_viewmore_text_color][value]" value="<?php echo $button_viewmore_text_color_value ?>">
                            <input type="hidden" name="data[css][button_viewmore_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button View More Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $button_viewmore_border_color_value = isset($custom_css_arr['button_viewmore_border_color']['value']) ? $custom_css_arr['button_viewmore_border_color']['value'] : '' ?>
                            <input type="text" id="frm-button_viewmore_border_color" class="color-picker form-control" name="data[css][button_viewmore_border_color][value]" value="<?php echo $button_viewmore_border_color_value ?>">
                            <input type="hidden" name="data[css][button_viewmore_border_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Like Section'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseLikeSection" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseLikeSection">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/likesection.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseLikeSection" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_like_icon_color_value = isset($custom_css_arr['page_like_icon_color']['value']) ? $custom_css_arr['page_like_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_like_icon_color" class="color-picker form-control" name="data[css][page_like_icon_color][value]" value="<?php echo $page_like_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_like_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_like_text_color_value = isset($custom_css_arr['page_like_text_color']['value']) ? $custom_css_arr['page_like_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_like_text_color" class="color-picker form-control" name="data[css][page_like_text_color][value]" value="<?php echo $page_like_text_color_value ?>">
                            <input type="hidden" name="data[css][page_like_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_like_icon_active_color = isset($custom_css_arr['page_like_icon_active_color']['value']) ? $custom_css_arr['page_like_icon_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_like_icon_active_color" class="color-picker form-control" name="data[css][page_like_icon_active_color][value]" value="<?php echo $page_like_icon_active_color ?>">
                            <input type="hidden" name="data[css][page_like_icon_active_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Footer'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseFooter" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseFooter">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/footer.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseFooter" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Image'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_background_image_value = isset($custom_css_arr['page_footer_background_image']['value']) ? $custom_css_arr['page_footer_background_image']['value'] : '' ?>
                            <div class="upload_image_review">
                                <?php if(!empty($page_footer_background_image_value)): ?>
                                    <div class="image_review-thumb">
                                        <img class="review-img" src="<?php echo $this->request->webroot.'uploads/theme/'.$page_footer_background_image_value ?>">
                                        <a class="reset-upload_image_review" href="javascript:void(0)"><?php echo __('Reset'); ?></a>
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="upload_image_field" name="page_footer_background_image">
                                <input type="hidden" class="upload_image_value" name="data[css][page_footer_background_image][value]" value="<?php echo $page_footer_background_image_value ?>">
                                <input type="hidden" class="upload_image_type" name="data[css][page_footer_background_image][type]" value="upload_image">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Position'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_background_position_value = isset($custom_css_arr['page_footer_background_position']['value']) ? $custom_css_arr['page_footer_background_position']['value'] : '' ?>
                            <select id="frm-page_footer_background_position" class="form-control" name="data[css][page_footer_background_position][value]">
                                <option value="">none</option>
                                <option value="center center" <?php if($page_footer_background_position_value == 'center center'): ?>selected="selected"<?php endif; ?>>center center</option>
                                <option value="top center" <?php if($page_footer_background_position_value == 'top center'): ?>selected="selected"<?php endif; ?>>top center</option>
                                <option value="top left" <?php if($page_footer_background_position_value == 'top left'): ?>selected="selected"<?php endif; ?>>top left</option>
                                <option value="top right" <?php if($page_footer_background_position_value == 'top right'): ?>selected="selected"<?php endif; ?>>top right</option>
                                <option value="bottom center" <?php if($page_footer_background_position_value == 'bottom center'): ?>selected="selected"<?php endif; ?>>bottom center</option>
                                <option value="bottom left" <?php if($page_footer_background_position_value == 'bottom left'): ?>selected="selected"<?php endif; ?>>bottom left</option>
                                <option value="bottom right" <?php if($page_footer_background_position_value == 'bottom right'): ?>selected="selected"<?php endif; ?>>bottom right</option>
                            </select>
                            <input type="hidden" name="data[css][page_footer_background_position][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Repeat'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_background_repeat_value = isset($custom_css_arr['page_footer_background_repeat']['value']) ? $custom_css_arr['page_footer_background_repeat']['value'] : '' ?>
                            <select id="frm-page_footer_background_repeat" class="form-control" name="data[css][page_footer_background_repeat][value]">
                                <option value="">none</option>
                                <option value="no-repeat" <?php if($page_footer_background_repeat_value == 'no-repeat'): ?>selected="selected"<?php endif; ?>>no-repeat</option>
                                <option value="repeat" <?php if($page_footer_background_repeat_value == 'repeat'): ?>selected="selected"<?php endif; ?>>repeat</option>
                                <option value="repeat-x" <?php if($page_footer_background_repeat_value == 'repeat-x'): ?>selected="selected"<?php endif; ?>>repeat-x</option>
                                <option value="repeat-y" <?php if($page_footer_background_repeat_value == 'repeat-y'): ?>selected="selected"<?php endif; ?>>repeat-y</option>
                            </select>
                            <input type="hidden" name="data[css][page_footer_background_repeat][type]" value="select">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Size'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_background_size_value = isset($custom_css_arr['page_footer_background_size']['value']) ? $custom_css_arr['page_footer_background_size']['value'] : '' ?>
                            <select id="frm-page_footer_background_size" class="form-control" name="data[css][page_footer_background_size][value]">
                                <option value="">none</option>
                                <option value="cover" <?php if($page_footer_background_size_value == 'cover'): ?>selected="selected"<?php endif; ?>>cover</option>
                                <option value="contain" <?php if($page_footer_background_size_value == 'contain'): ?>selected="selected"<?php endif; ?>>contain</option>
                                <option value="auto" <?php if($page_footer_background_size_value == 'auto'): ?>selected="selected"<?php endif; ?>>auto</option>
                            </select>
                            <input type="hidden" name="data[css][page_footer_background_size][type]" value="select">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_background_color_value = isset($custom_css_arr['page_footer_background_color']['value']) ? $custom_css_arr['page_footer_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_footer_background_color" class="color-picker form-control" name="data[css][page_footer_background_color][value]" value="<?php echo $page_footer_background_color_value ?>">
                            <input type="hidden" name="data[css][page_footer_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_text_color_value = isset($custom_css_arr['page_footer_text_color']['value']) ? $custom_css_arr['page_footer_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_footer_text_color" class="color-picker form-control" name="data[css][page_footer_text_color][value]" value="<?php echo $page_footer_text_color_value ?>">
                            <input type="hidden" name="data[css][page_footer_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_text_link_color_value = isset($custom_css_arr['page_footer_text_link_color']['value']) ? $custom_css_arr['page_footer_text_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_footer_text_link_color" class="color-picker form-control" name="data[css][page_footer_text_link_color][value]" value="<?php echo $page_footer_text_link_color_value ?>">
                            <input type="hidden" name="data[css][page_footer_text_link_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_dropdown_background_color_value = isset($custom_css_arr['page_footer_dropdown_background_color']['value']) ? $custom_css_arr['page_footer_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_footer_dropdown_background_color" class="color-picker form-control" name="data[css][page_footer_dropdown_background_color][value]" value="<?php echo $page_footer_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_footer_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_footer_dropdown_text_link_color_value = isset($custom_css_arr['page_footer_dropdown_text_link_color']['value']) ? $custom_css_arr['page_footer_dropdown_text_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_footer_dropdown_text_link_color" class="color-picker form-control" name="data[css][page_footer_dropdown_text_link_color][value]" value="<?php echo $page_footer_dropdown_text_link_color_value ?>">
                            <input type="hidden" name="data[css][page_footer_dropdown_text_link_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="menu-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Navigation'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseNavigation" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseNavigation">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/navigation.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseNavigation" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_background_color_value = isset($custom_css_arr['page_navigation_background_color']['value']) ? $custom_css_arr['page_navigation_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_background_color" class="color-picker form-control" name="data[css][page_navigation_background_color][value]" value="<?php echo $page_navigation_background_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_text_color_value = isset($custom_css_arr['page_navigation_text_color']['value']) ? $custom_css_arr['page_navigation_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_text_color" class="color-picker form-control" name="data[css][page_navigation_text_color][value]" value="<?php echo $page_navigation_text_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_active_background_color_value = isset($custom_css_arr['page_navigation_active_background_color']['value']) ? $custom_css_arr['page_navigation_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_active_background_color" class="color-picker form-control" name="data[css][page_navigation_active_background_color][value]" value="<?php echo $page_navigation_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_active_text_color_value = isset($custom_css_arr['page_navigation_active_text_color']['value']) ? $custom_css_arr['page_navigation_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_active_text_color" class="color-picker form-control" name="data[css][page_navigation_active_text_color][value]" value="<?php echo $page_navigation_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_background_color_value = isset($custom_css_arr['page_navigation_dropdown_background_color']['value']) ? $custom_css_arr['page_navigation_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_background_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_background_color][value]" value="<?php echo $page_navigation_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_text_color_value = isset($custom_css_arr['page_navigation_dropdown_text_color']['value']) ? $custom_css_arr['page_navigation_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_text_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_text_color][value]" value="<?php echo $page_navigation_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_border_color = isset($custom_css_arr['page_navigation_dropdown_border_color']['value']) ? $custom_css_arr['page_navigation_dropdown_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_border_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_border_color][value]" value="<?php echo $page_navigation_dropdown_border_color ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_active_background_color_value = isset($custom_css_arr['page_navigation_dropdown_active_background_color']['value']) ? $custom_css_arr['page_navigation_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_active_background_color][value]" value="<?php echo $page_navigation_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_active_text_color_value = isset($custom_css_arr['page_navigation_dropdown_active_text_color']['value']) ? $custom_css_arr['page_navigation_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_active_text_color][value]" value="<?php echo $page_navigation_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_dropdown_active_border_color_value = isset($custom_css_arr['page_navigation_dropdown_active_border_color']['value']) ? $custom_css_arr['page_navigation_dropdown_active_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_dropdown_active_border_color" class="color-picker form-control" name="data[css][page_navigation_dropdown_active_border_color][value]" value="<?php echo $page_navigation_dropdown_active_border_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_dropdown_active_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Back Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_back_text_color_value = isset($custom_css_arr['page_navigation_back_text_color']['value']) ? $custom_css_arr['page_navigation_back_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_back_text_color" class="color-picker form-control" name="data[css][page_navigation_back_text_color][value]" value="<?php echo $page_navigation_back_text_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_back_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Back Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_navigation_back_border_color_value = isset($custom_css_arr['page_navigation_back_border_color']['value']) ? $custom_css_arr['page_navigation_back_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_navigation_back_border_color" class="color-picker form-control" name="data[css][page_navigation_back_border_color][value]" value="<?php echo $page_navigation_back_border_color_value ?>">
                            <input type="hidden" name="data[css][page_navigation_back_border_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Sticky Menu'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseStickymenu" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseStickymenu">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/stickymenu.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseStickymenu" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_background_color_value = isset($custom_css_arr['page_stickymenu_background_color']['value']) ? $custom_css_arr['page_stickymenu_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_background_color" class="color-picker form-control" name="data[css][page_stickymenu_background_color][value]" value="<?php echo $page_stickymenu_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_text_color_value = isset($custom_css_arr['page_stickymenu_text_color']['value']) ? $custom_css_arr['page_stickymenu_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_text_color" class="color-picker form-control" name="data[css][page_stickymenu_text_color][value]" value="<?php echo $page_stickymenu_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_active_background_color_value = isset($custom_css_arr['page_stickymenu_active_background_color']['value']) ? $custom_css_arr['page_stickymenu_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_active_background_color" class="color-picker form-control" name="data[css][page_stickymenu_active_background_color][value]" value="<?php echo $page_stickymenu_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_active_text_color_value = isset($custom_css_arr['page_stickymenu_active_text_color']['value']) ? $custom_css_arr['page_stickymenu_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_active_text_color" class="color-picker form-control" name="data[css][page_stickymenu_active_text_color][value]" value="<?php echo $page_stickymenu_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Badge Counter Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_count_text_color_value = isset($custom_css_arr['page_stickymenu_count_text_color']['value']) ? $custom_css_arr['page_stickymenu_count_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_count_text_color" class="color-picker form-control" name="data[css][page_stickymenu_count_text_color][value]" value="<?php echo $page_stickymenu_count_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_count_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Badge Counter Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_count_background_color_value = isset($custom_css_arr['page_stickymenu_count_background_color']['value']) ? $custom_css_arr['page_stickymenu_count_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_count_background_color" class="color-picker form-control" name="data[css][page_stickymenu_count_background_color][value]" value="<?php echo $page_stickymenu_count_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_count_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Badge Counter Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_count_active_text_color_value = isset($custom_css_arr['page_stickymenu_count_active_text_color']['value']) ? $custom_css_arr['page_stickymenu_count_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_count_active_text_color" class="color-picker form-control" name="data[css][page_stickymenu_count_active_text_color][value]" value="<?php echo $page_stickymenu_count_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_count_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Badge Counter Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_count_active_background_color_value = isset($custom_css_arr['page_stickymenu_count_active_background_color']['value']) ? $custom_css_arr['page_stickymenu_count_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_count_active_background_color" class="color-picker form-control" name="data[css][page_stickymenu_count_active_background_color][value]" value="<?php echo $page_stickymenu_count_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_count_active_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_background_color_value = isset($custom_css_arr['page_stickymenu_dropdown_background_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_background_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_background_color][value]" value="<?php echo $page_stickymenu_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_text_color_value = isset($custom_css_arr['page_stickymenu_dropdown_text_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_text_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_text_color][value]" value="<?php echo $page_stickymenu_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_active_background_color_value = isset($custom_css_arr['page_stickymenu_dropdown_active_background_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_active_background_color][value]" value="<?php echo $page_stickymenu_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_active_text_color_value = isset($custom_css_arr['page_stickymenu_dropdown_active_text_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_active_text_color][value]" value="<?php echo $page_stickymenu_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_border_color_value = isset($custom_css_arr['page_stickymenu_dropdown_border_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_border_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_border_color][value]" value="<?php echo $page_stickymenu_dropdown_border_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Arrow Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_arrow_color_value = isset($custom_css_arr['page_stickymenu_dropdown_arrow_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_arrow_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_arrow_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_arrow_color][value]" value="<?php echo $page_stickymenu_dropdown_arrow_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_arrow_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Badge Counter Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_count_text_color_value = isset($custom_css_arr['page_stickymenu_dropdown_count_text_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_count_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_count_text_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_count_text_color][value]" value="<?php echo $page_stickymenu_dropdown_count_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_count_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Badge Counter Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_count_background_color_value = isset($custom_css_arr['page_stickymenu_dropdown_count_background_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_count_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_count_background_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_count_background_color][value]" value="<?php echo $page_stickymenu_dropdown_count_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_count_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Badge Counter Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_count_active_text_color_value = isset($custom_css_arr['page_stickymenu_dropdown_count_active_text_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_count_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_count_active_text_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_count_active_text_color][value]" value="<?php echo $page_stickymenu_dropdown_count_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_count_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Badge Counter Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_count_active_background_color_value = isset($custom_css_arr['page_stickymenu_dropdown_count_active_background_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_count_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_count_active_background_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_count_active_background_color][value]" value="<?php echo $page_stickymenu_dropdown_count_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_count_active_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Overlay Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_overlay_background_color_value = isset($custom_css_arr['page_stickymenu_dropdown_overlay_background_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_overlay_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_overlay_background_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_overlay_background_color][value]" value="<?php echo $page_stickymenu_dropdown_overlay_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_overlay_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Close Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_dropdown_close_icon_color_value = isset($custom_css_arr['page_stickymenu_dropdown_close_icon_color']['value']) ? $custom_css_arr['page_stickymenu_dropdown_close_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_dropdown_close_icon_color" class="color-picker form-control" name="data[css][page_stickymenu_dropdown_close_icon_color][value]" value="<?php echo $page_stickymenu_dropdown_close_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_dropdown_close_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_icon_color_value = isset($custom_css_arr['page_stickymenu_icon_color']['value']) ? $custom_css_arr['page_stickymenu_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_icon_color" class="color-picker form-control" name="data[css][page_stickymenu_icon_color][value]" value="<?php echo $page_stickymenu_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_button_background_color_value = isset($custom_css_arr['page_stickymenu_button_background_color']['value']) ? $custom_css_arr['page_stickymenu_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_button_background_color" class="color-picker form-control" name="data[css][page_stickymenu_button_background_color][value]" value="<?php echo $page_stickymenu_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_stickymenu_button_text_color_value = isset($custom_css_arr['page_stickymenu_button_text_color']['value']) ? $custom_css_arr['page_stickymenu_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_stickymenu_button_text_color" class="color-picker form-control" name="data[css][page_stickymenu_button_text_color][value]" value="<?php echo $page_stickymenu_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_stickymenu_button_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Category Menu'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseCategoryMenu" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseCategoryMenu">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/category.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseCategoryMenu" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_background_color_value = isset($custom_css_arr['page_category_menu_background_color']['value']) ? $custom_css_arr['page_category_menu_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_background_color" class="color-picker form-control" name="data[css][page_category_menu_background_color][value]" value="<?php echo $page_category_menu_background_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_text_color_value = isset($custom_css_arr['page_category_menu_text_color']['value']) ? $custom_css_arr['page_category_menu_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_text_color" class="color-picker form-control" name="data[css][page_category_menu_text_color][value]" value="<?php echo $page_category_menu_text_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_active_background_color_value = isset($custom_css_arr['page_category_menu_active_background_color']['value']) ? $custom_css_arr['page_category_menu_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_active_background_color" class="color-picker form-control" name="data[css][page_category_menu_active_background_color][value]" value="<?php echo $page_category_menu_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_active_text_color_value = isset($custom_css_arr['page_category_menu_active_text_color']['value']) ? $custom_css_arr['page_category_menu_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_active_text_color" class="color-picker form-control" name="data[css][page_category_menu_active_text_color][value]" value="<?php echo $page_category_menu_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_active_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Counter Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_counter_background_color_value = isset($custom_css_arr['page_category_menu_counter_background_color']['value']) ? $custom_css_arr['page_category_menu_counter_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_counter_background_color" class="color-picker form-control" name="data[css][page_category_menu_counter_background_color][value]" value="<?php echo $page_category_menu_counter_background_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_counter_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Counter Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_counter_text_color_value = isset($custom_css_arr['page_category_menu_counter_text_color']['value']) ? $custom_css_arr['page_category_menu_counter_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_counter_text_color" class="color-picker form-control" name="data[css][page_category_menu_counter_text_color][value]" value="<?php echo $page_category_menu_counter_text_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_counter_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Counter Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_counter_active_background_color_value = isset($custom_css_arr['page_category_menu_counter_active_background_color']['value']) ? $custom_css_arr['page_category_menu_counter_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_counter_active_background_color" class="color-picker form-control" name="data[css][page_category_menu_counter_active_background_color][value]" value="<?php echo $page_category_menu_counter_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_counter_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Counter Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_counter_active_text_color_value = isset($custom_css_arr['page_category_menu_counter_active_text_color']['value']) ? $custom_css_arr['page_category_menu_counter_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_counter_active_text_color" class="color-picker form-control" name="data[css][page_category_menu_counter_active_text_color][value]" value="<?php echo $page_category_menu_counter_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_counter_active_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Arrow Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_arrow_color_value = isset($custom_css_arr['page_category_menu_arrow_color']['value']) ? $custom_css_arr['page_category_menu_arrow_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_arrow_color" class="color-picker form-control" name="data[css][page_category_menu_arrow_color][value]" value="<?php echo $page_category_menu_arrow_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_arrow_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Arrow Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_category_menu_arrow_active_color_value = isset($custom_css_arr['page_category_menu_arrow_active_color']['value']) ? $custom_css_arr['page_category_menu_arrow_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_category_menu_arrow_active_color" class="color-picker form-control" name="data[css][page_category_menu_arrow_active_color][value]" value="<?php echo $page_category_menu_arrow_active_color_value ?>">
                            <input type="hidden" name="data[css][page_category_menu_arrow_active_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Menu Horizontal'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseHorizontal" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseHorizontal">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/navigation.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseNavigation" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_background_color_value = isset($custom_css_arr['page_horizontal_background_color']['value']) ? $custom_css_arr['page_horizontal_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_background_color" class="color-picker form-control" name="data[css][page_horizontal_background_color][value]" value="<?php echo $page_horizontal_background_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_text_color_value = isset($custom_css_arr['page_horizontal_text_color']['value']) ? $custom_css_arr['page_horizontal_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_text_color" class="color-picker form-control" name="data[css][page_horizontal_text_color][value]" value="<?php echo $page_horizontal_text_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_active_background_color_value = isset($custom_css_arr['page_horizontal_active_background_color']['value']) ? $custom_css_arr['page_horizontal_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_active_background_color" class="color-picker form-control" name="data[css][page_horizontal_active_background_color][value]" value="<?php echo $page_horizontal_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_active_text_color_value = isset($custom_css_arr['page_horizontal_active_text_color']['value']) ? $custom_css_arr['page_horizontal_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_active_text_color" class="color-picker form-control" name="data[css][page_horizontal_active_text_color][value]" value="<?php echo $page_horizontal_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_dropdown_background_color_value = isset($custom_css_arr['page_horizontal_dropdown_background_color']['value']) ? $custom_css_arr['page_horizontal_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_dropdown_background_color" class="color-picker form-control" name="data[css][page_horizontal_dropdown_background_color][value]" value="<?php echo $page_horizontal_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_dropdown_text_color_value = isset($custom_css_arr['page_horizontal_dropdown_text_color']['value']) ? $custom_css_arr['page_horizontal_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_dropdown_text_color" class="color-picker form-control" name="data[css][page_horizontal_dropdown_text_color][value]" value="<?php echo $page_horizontal_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_dropdown_active_background_color_value = isset($custom_css_arr['page_horizontal_dropdown_active_background_color']['value']) ? $custom_css_arr['page_horizontal_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_horizontal_dropdown_active_background_color][value]" value="<?php echo $page_horizontal_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_horizontal_dropdown_active_text_color_value = isset($custom_css_arr['page_horizontal_dropdown_active_text_color']['value']) ? $custom_css_arr['page_horizontal_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_horizontal_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_horizontal_dropdown_active_text_color][value]" value="<?php echo $page_horizontal_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_horizontal_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Menu Vertical'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseVertical" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseVertical">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/navigation.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseNavigation" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_background_color_value = isset($custom_css_arr['page_vertical_background_color']['value']) ? $custom_css_arr['page_vertical_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_background_color" class="color-picker form-control" name="data[css][page_vertical_background_color][value]" value="<?php echo $page_vertical_background_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_text_color_value = isset($custom_css_arr['page_vertical_text_color']['value']) ? $custom_css_arr['page_vertical_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_text_color" class="color-picker form-control" name="data[css][page_vertical_text_color][value]" value="<?php echo $page_vertical_text_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_active_background_color_value = isset($custom_css_arr['page_vertical_active_background_color']['value']) ? $custom_css_arr['page_vertical_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_active_background_color" class="color-picker form-control" name="data[css][page_vertical_active_background_color][value]" value="<?php echo $page_vertical_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_active_text_color_value = isset($custom_css_arr['page_vertical_active_text_color']['value']) ? $custom_css_arr['page_vertical_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_active_text_color" class="color-picker form-control" name="data[css][page_vertical_active_text_color][value]" value="<?php echo $page_vertical_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_dropdown_background_color_value = isset($custom_css_arr['page_vertical_dropdown_background_color']['value']) ? $custom_css_arr['page_vertical_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_dropdown_background_color" class="color-picker form-control" name="data[css][page_vertical_dropdown_background_color][value]" value="<?php echo $page_vertical_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_dropdown_text_color_value = isset($custom_css_arr['page_vertical_dropdown_text_color']['value']) ? $custom_css_arr['page_vertical_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_dropdown_text_color" class="color-picker form-control" name="data[css][page_vertical_dropdown_text_color][value]" value="<?php echo $page_vertical_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_dropdown_active_background_color_value = isset($custom_css_arr['page_vertical_dropdown_active_background_color']['value']) ? $custom_css_arr['page_vertical_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_vertical_dropdown_active_background_color][value]" value="<?php echo $page_vertical_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_vertical_dropdown_active_text_color_value = isset($custom_css_arr['page_vertical_dropdown_active_text_color']['value']) ? $custom_css_arr['page_vertical_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_vertical_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_vertical_dropdown_active_text_color][value]" value="<?php echo $page_vertical_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_vertical_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="whatnew-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Feed Header'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseFeedHeader" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseFeedHeader">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/feedheader.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseFeedHeader" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_header_color_value = isset($custom_css_arr['page_feed_header_color']['value']) ? $custom_css_arr['page_feed_header_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_header_color" class="color-picker form-control" name="data[css][page_feed_header_color][value]" value="<?php echo $page_feed_header_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_header_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Feed Type Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_type_color_value = isset($custom_css_arr['page_feed_type_color']['value']) ? $custom_css_arr['page_feed_type_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_type_color" class="color-picker form-control" name="data[css][page_feed_type_color][value]" value="<?php echo $page_feed_type_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_type_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Feed Type Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_type_active_color_value = isset($custom_css_arr['page_feed_type_active_color']['value']) ? $custom_css_arr['page_feed_type_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_type_active_color" class="color-picker form-control" name="data[css][page_feed_type_active_color][value]" value="<?php echo $page_feed_type_active_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_type_active_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Status Box'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseStatusBox" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseStatusBox">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/statusbox.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseStatusBox" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_background_color_value = isset($custom_css_arr['page_statusbox_background_color']['value']) ? $custom_css_arr['page_statusbox_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_background_color" class="color-picker form-control" name="data[css][page_statusbox_background_color][value]" value="<?php echo $page_statusbox_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_border_color_value = isset($custom_css_arr['page_statusbox_border_color']['value']) ? $custom_css_arr['page_statusbox_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_border_color" class="color-picker form-control" name="data[css][page_statusbox_border_color][value]" value="<?php echo $page_statusbox_border_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Message Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_message_color_value = isset($custom_css_arr['page_statusbox_message_color']['value']) ? $custom_css_arr['page_statusbox_message_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_message_color" class="color-picker form-control" name="data[css][page_statusbox_message_color][value]" value="<?php echo $page_statusbox_message_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_message_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_icon_color_value = isset($custom_css_arr['page_statusbox_icon_color']['value']) ? $custom_css_arr['page_statusbox_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_icon_color" class="color-picker form-control" name="data[css][page_statusbox_icon_color][value]" value="<?php echo $page_statusbox_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_icon_background_color_value = isset($custom_css_arr['page_statusbox_icon_background_color']['value']) ? $custom_css_arr['page_statusbox_icon_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_icon_background_color" class="color-picker form-control" name="data[css][page_statusbox_icon_background_color][value]" value="<?php echo $page_statusbox_icon_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_icon_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_icon_border_color_value = isset($custom_css_arr['page_statusbox_icon_border_color']['value']) ? $custom_css_arr['page_statusbox_icon_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_icon_border_color" class="color-picker form-control" name="data[css][page_statusbox_icon_border_color][value]" value="<?php echo $page_statusbox_icon_border_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_icon_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_background_color_value = isset($custom_css_arr['page_statusbox_privacy_background_color']['value']) ? $custom_css_arr['page_statusbox_privacy_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_background_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_background_color][value]" value="<?php echo $page_statusbox_privacy_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_text_color_value = isset($custom_css_arr['page_statusbox_privacy_text_color']['value']) ? $custom_css_arr['page_statusbox_privacy_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_text_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_text_color][value]" value="<?php echo $page_statusbox_privacy_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_dropdown_background_color_value = isset($custom_css_arr['page_statusbox_privacy_dropdown_background_color']['value']) ? $custom_css_arr['page_statusbox_privacy_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_dropdown_background_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_dropdown_background_color][value]" value="<?php echo $page_statusbox_privacy_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_dropdown_text_color_value = isset($custom_css_arr['page_statusbox_privacy_dropdown_text_color']['value']) ? $custom_css_arr['page_statusbox_privacy_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_dropdown_text_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_dropdown_text_color][value]" value="<?php echo $page_statusbox_privacy_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_dropdown_active_background_color_value = isset($custom_css_arr['page_statusbox_privacy_dropdown_active_background_color']['value']) ? $custom_css_arr['page_statusbox_privacy_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_dropdown_active_background_color][value]" value="<?php echo $page_statusbox_privacy_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Privacy Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_privacy_dropdown_active_text_color_value = isset($custom_css_arr['page_statusbox_privacy_dropdown_active_text_color']['value']) ? $custom_css_arr['page_statusbox_privacy_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_privacy_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_statusbox_privacy_dropdown_active_text_color][value]" value="<?php echo $page_statusbox_privacy_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_privacy_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Share Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_share_color_value = isset($custom_css_arr['page_statusbox_share_color']['value']) ? $custom_css_arr['page_statusbox_share_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_share_color" class="color-picker form-control" name="data[css][page_statusbox_share_color][value]" value="<?php echo $page_statusbox_share_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_share_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Share Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_share_background_color_value = isset($custom_css_arr['page_statusbox_share_background_color']['value']) ? $custom_css_arr['page_statusbox_share_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_share_background_color" class="color-picker form-control" name="data[css][page_statusbox_share_background_color][value]" value="<?php echo $page_statusbox_share_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_share_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Share Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_share_border_color_value = isset($custom_css_arr['page_statusbox_share_border_color']['value']) ? $custom_css_arr['page_statusbox_share_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_share_border_color" class="color-picker form-control" name="data[css][page_statusbox_share_border_color][value]" value="<?php echo $page_statusbox_share_border_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_share_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_background_color_value = isset($custom_css_arr['page_statusbox_tagpeople_background_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_background_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_background_color][value]" value="<?php echo $page_statusbox_tagpeople_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_text_color_value = isset($custom_css_arr['page_statusbox_tagpeople_text_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_text_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_text_color][value]" value="<?php echo $page_statusbox_tagpeople_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Dropdown Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_dropdown_background_color_value = isset($custom_css_arr['page_statusbox_tagpeople_dropdown_background_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_dropdown_background_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_dropdown_background_color][value]" value="<?php echo $page_statusbox_tagpeople_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Dropdown Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_dropdown_text_color_value = isset($custom_css_arr['page_statusbox_tagpeople_dropdown_text_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_dropdown_text_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_dropdown_text_color][value]" value="<?php echo $page_statusbox_tagpeople_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Dropdown Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_dropdown_active_background_color_value = isset($custom_css_arr['page_statusbox_tagpeople_dropdown_active_background_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_dropdown_active_background_color][value]" value="<?php echo $page_statusbox_tagpeople_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Tag People Dropdown Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_tagpeople_dropdown_active_text_color_value = isset($custom_css_arr['page_statusbox_tagpeople_dropdown_active_text_color']['value']) ? $custom_css_arr['page_statusbox_tagpeople_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_tagpeople_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_statusbox_tagpeople_dropdown_active_text_color][value]" value="<?php echo $page_statusbox_tagpeople_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_tagpeople_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_statusbox_text_color_value = isset($custom_css_arr['page_statusbox_text_color']['value']) ? $custom_css_arr['page_statusbox_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_statusbox_text_color" class="color-picker form-control" name="data[css][page_statusbox_text_color][value]" value="<?php echo $page_statusbox_text_color_value ?>">
                            <input type="hidden" name="data[css][page_statusbox_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Feed Items'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseFeedItems" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseFeedItems">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/feeditem.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseFeedItems" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_background_color_value = isset($custom_css_arr['page_feed_item_background_color']['value']) ? $custom_css_arr['page_feed_item_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_background_color" class="color-picker form-control" name="data[css][page_feed_item_background_color][value]" value="<?php echo $page_feed_item_background_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_text_color_value = isset($custom_css_arr['page_feed_item_text_color']['value']) ? $custom_css_arr['page_feed_item_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_text_color" class="color-picker form-control" name="data[css][page_feed_item_text_color][value]" value="<?php echo $page_feed_item_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_date_text_color_value = isset($custom_css_arr['page_feed_item_date_text_color']['value']) ? $custom_css_arr['page_feed_item_date_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_date_text_color" class="color-picker form-control" name="data[css][page_feed_item_date_text_color][value]" value="<?php echo $page_feed_item_date_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_date_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_dropdown_icon_color_value = isset($custom_css_arr['page_feed_item_dropdown_icon_color']['value']) ? $custom_css_arr['page_feed_item_dropdown_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_dropdown_icon_color" class="color-picker form-control" name="data[css][page_feed_item_dropdown_icon_color][value]" value="<?php echo $page_feed_item_dropdown_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_dropdown_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_like_icon_color_value = isset($custom_css_arr['page_feed_item_like_icon_color']['value']) ? $custom_css_arr['page_feed_item_like_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_like_icon_color" class="color-picker form-control" name="data[css][page_feed_item_like_icon_color][value]" value="<?php echo $page_feed_item_like_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_like_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_like_text_color_value = isset($custom_css_arr['page_feed_item_like_text_color']['value']) ? $custom_css_arr['page_feed_item_like_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_like_text_color" class="color-picker form-control" name="data[css][page_feed_item_like_text_color][value]" value="<?php echo $page_feed_item_like_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_like_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Active Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_like_active_icon_color_value = isset($custom_css_arr['page_feed_item_like_active_icon_color']['value']) ? $custom_css_arr['page_feed_item_like_active_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_like_active_icon_color" class="color-picker form-control" name="data[css][page_feed_item_like_active_icon_color][value]" value="<?php echo $page_feed_item_like_active_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_like_active_icon_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Feed Comment'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseFeedComment" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseFeedComment">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/feedcomment.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseFeedComment" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Comment Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_background_color_value = isset($custom_css_arr['page_feed_item_comment_background_color']['value']) ? $custom_css_arr['page_feed_item_comment_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_background_color" class="color-picker form-control" name="data[css][page_feed_item_comment_background_color][value]" value="<?php echo $page_feed_item_comment_background_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Comment Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_text_color_value = isset($custom_css_arr['page_feed_item_comment_text_color']['value']) ? $custom_css_arr['page_feed_item_comment_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_text_color" class="color-picker form-control" name="data[css][page_feed_item_comment_text_color][value]" value="<?php echo $page_feed_item_comment_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_date_color_value = isset($custom_css_arr['page_feed_item_comment_date_color']['value']) ? $custom_css_arr['page_feed_item_comment_date_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_date_color" class="color-picker form-control" name="data[css][page_feed_item_comment_date_color][value]" value="<?php echo $page_feed_item_comment_date_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_date_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_link_color_value = isset($custom_css_arr['page_feed_item_comment_link_color']['value']) ? $custom_css_arr['page_feed_item_comment_link_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_link_color" class="color-picker form-control" name="data[css][page_feed_item_comment_link_color][value]" value="<?php echo $page_feed_item_comment_link_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_link_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_like_icon_color_value = isset($custom_css_arr['page_feed_item_comment_like_icon_color']['value']) ? $custom_css_arr['page_feed_item_comment_like_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_like_icon_color" class="color-picker form-control" name="data[css][page_feed_item_comment_like_icon_color][value]" value="<?php echo $page_feed_item_comment_like_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_like_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_like_text_color_value = isset($custom_css_arr['page_feed_item_comment_like_text_color']['value']) ? $custom_css_arr['page_feed_item_comment_like_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_like_text_color" class="color-picker form-control" name="data[css][page_feed_item_comment_like_text_color][value]" value="<?php echo $page_feed_item_comment_like_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_like_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Active Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_like_active_icon_color_value = isset($custom_css_arr['page_feed_item_comment_like_active_icon_color']['value']) ? $custom_css_arr['page_feed_item_comment_like_active_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_like_active_icon_color" class="color-picker form-control" name="data[css][page_feed_item_comment_like_active_icon_color][value]" value="<?php echo $page_feed_item_comment_like_active_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_like_active_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_text_color_value = isset($custom_css_arr['page_feed_item_comment_button_text_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_text_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_text_color][value]" value="<?php echo $page_feed_item_comment_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_background_color_value = isset($custom_css_arr['page_feed_item_comment_button_background_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_background_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_background_color][value]" value="<?php echo $page_feed_item_comment_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_border_color_value = isset($custom_css_arr['page_feed_item_comment_button_border_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_border_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_border_color][value]" value="<?php echo $page_feed_item_comment_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_form_background_color_value = isset($custom_css_arr['page_feed_item_comment_form_background_color']['value']) ? $custom_css_arr['page_feed_item_comment_form_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_form_background_color" class="color-picker form-control" name="data[css][page_feed_item_comment_form_background_color][value]" value="<?php echo $page_feed_item_comment_form_background_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_form_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_form_border_color_value = isset($custom_css_arr['page_feed_item_comment_form_border_color']['value']) ? $custom_css_arr['page_feed_item_comment_form_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_form_border_color" class="color-picker form-control" name="data[css][page_feed_item_comment_form_border_color][value]" value="<?php echo $page_feed_item_comment_form_border_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_form_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_form_text_color_value = isset($custom_css_arr['page_feed_item_comment_form_text_color']['value']) ? $custom_css_arr['page_feed_item_comment_form_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_form_text_color" class="color-picker form-control" name="data[css][page_feed_item_comment_form_text_color][value]" value="<?php echo $page_feed_item_comment_form_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_form_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_dropdown_icon_color_value = isset($custom_css_arr['page_feed_item_comment_dropdown_icon_color']['value']) ? $custom_css_arr['page_feed_item_comment_dropdown_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_dropdown_icon_color" class="color-picker form-control" name="data[css][page_feed_item_comment_dropdown_icon_color][value]" value="<?php echo $page_feed_item_comment_dropdown_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_dropdown_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_cancel_text_color_value = isset($custom_css_arr['page_feed_item_comment_button_cancel_text_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_cancel_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_cancel_text_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_cancel_text_color][value]" value="<?php echo $page_feed_item_comment_button_cancel_text_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_cancel_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_cancel_background_color_value = isset($custom_css_arr['page_feed_item_comment_button_cancel_background_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_cancel_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_cancel_background_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_cancel_background_color][value]" value="<?php echo $page_feed_item_comment_button_cancel_background_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_cancel_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_feed_item_comment_button_cancel_border_color_value = isset($custom_css_arr['page_feed_item_comment_button_cancel_border_color']['value']) ? $custom_css_arr['page_feed_item_comment_button_cancel_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_feed_item_comment_button_cancel_border_color" class="color-picker form-control" name="data[css][page_feed_item_comment_button_cancel_border_color][value]" value="<?php echo $page_feed_item_comment_button_cancel_border_color_value ?>">
                            <input type="hidden" name="data[css][page_feed_item_comment_button_cancel_border_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane" id="comment-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Comment'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseComment" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseComment">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/comment.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseComment" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_header_color_value = isset($custom_css_arr['page_comment_header_color']['value']) ? $custom_css_arr['page_comment_header_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_header_color" class="color-picker form-control" name="data[css][page_comment_header_color][value]" value="<?php echo $page_comment_header_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_header_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_text_color_value = isset($custom_css_arr['page_comment_text_color']['value']) ? $custom_css_arr['page_comment_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_text_color" class="color-picker form-control" name="data[css][page_comment_text_color][value]" value="<?php echo $page_comment_text_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_date_color_value = isset($custom_css_arr['page_comment_date_color']['value']) ? $custom_css_arr['page_comment_date_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_date_color" class="color-picker form-control" name="data[css][page_comment_date_color][value]" value="<?php echo $page_comment_date_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_date_color][type]" value="color">
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label class="col-md-3 control-label"><?php /*echo __('Link Color'); */?></label>
                        <div class="col-md-7">
                            <?php /*$page_comment_link_color_value = isset($custom_css_arr['page_comment_link_color']['value']) ? $custom_css_arr['page_comment_link_color']['value'] : '' */?>
                            <input type="text" id="frm-page_comment_link_color" class="color-picker form-control" name="data[css][page_comment_link_color][value]" value="<?php /*echo $page_comment_link_color_value */?>">
                            <input type="hidden" name="data[css][page_comment_link_color][type]" value="color">
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_like_icon_color_value = isset($custom_css_arr['page_comment_like_icon_color']['value']) ? $custom_css_arr['page_comment_like_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_like_icon_color" class="color-picker form-control" name="data[css][page_comment_like_icon_color][value]" value="<?php echo $page_comment_like_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_like_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_like_text_color_value = isset($custom_css_arr['page_comment_like_text_color']['value']) ? $custom_css_arr['page_comment_like_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_like_text_color" class="color-picker form-control" name="data[css][page_comment_like_text_color][value]" value="<?php echo $page_comment_like_text_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_like_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Like Active Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_like_active_icon_color_value = isset($custom_css_arr['page_comment_like_active_icon_color']['value']) ? $custom_css_arr['page_comment_like_active_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_like_active_icon_color" class="color-picker form-control" name="data[css][page_comment_like_active_icon_color][value]" value="<?php echo $page_comment_like_active_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_like_active_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_text_color_value = isset($custom_css_arr['page_comment_button_text_color']['value']) ? $custom_css_arr['page_comment_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_text_color" class="color-picker form-control" name="data[css][page_comment_button_text_color][value]" value="<?php echo $page_comment_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_background_color_value = isset($custom_css_arr['page_comment_button_background_color']['value']) ? $custom_css_arr['page_comment_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_background_color" class="color-picker form-control" name="data[css][page_comment_button_background_color][value]" value="<?php echo $page_comment_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_border_color_value = isset($custom_css_arr['page_comment_button_border_color']['value']) ? $custom_css_arr['page_comment_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_border_color" class="color-picker form-control" name="data[css][page_comment_button_border_color][value]" value="<?php echo $page_comment_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_form_background_color_value = isset($custom_css_arr['page_comment_form_background_color']['value']) ? $custom_css_arr['page_comment_form_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_form_background_color" class="color-picker form-control" name="data[css][page_comment_form_background_color][value]" value="<?php echo $page_comment_form_background_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_form_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_form_border_color_value = isset($custom_css_arr['page_comment_form_border_color']['value']) ? $custom_css_arr['page_comment_form_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_form_border_color" class="color-picker form-control" name="data[css][page_comment_form_border_color][value]" value="<?php echo $page_comment_form_border_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_form_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_form_text_color_value = isset($custom_css_arr['page_comment_form_text_color']['value']) ? $custom_css_arr['page_comment_form_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_form_text_color" class="color-picker form-control" name="data[css][page_comment_form_text_color][value]" value="<?php echo $page_comment_form_text_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_form_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Form Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_form_icon_color_value = isset($custom_css_arr['page_comment_form_icon_color']['value']) ? $custom_css_arr['page_comment_form_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_form_icon_color" class="color-picker form-control" name="data[css][page_comment_form_icon_color][value]" value="<?php echo $page_comment_form_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_form_icon_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_cancel_text_color_value = isset($custom_css_arr['page_comment_button_cancel_text_color']['value']) ? $custom_css_arr['page_comment_button_cancel_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_cancel_text_color" class="color-picker form-control" name="data[css][page_comment_button_cancel_text_color][value]" value="<?php echo $page_comment_button_cancel_text_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_cancel_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_cancel_background_color_value = isset($custom_css_arr['page_comment_button_cancel_background_color']['value']) ? $custom_css_arr['page_comment_button_cancel_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_cancel_background_color" class="color-picker form-control" name="data[css][page_comment_button_cancel_background_color][value]" value="<?php echo $page_comment_button_cancel_background_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_cancel_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Cancel Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_comment_button_cancel_border_color_value = isset($custom_css_arr['page_comment_button_cancel_border_color']['value']) ? $custom_css_arr['page_comment_button_cancel_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_comment_button_cancel_border_color" class="color-picker form-control" name="data[css][page_comment_button_cancel_border_color][value]" value="<?php echo $page_comment_button_cancel_border_color_value ?>">
                            <input type="hidden" name="data[css][page_comment_button_cancel_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Header Profile'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseHeaderProfile" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseHeaderProfile">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/profile.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseHeaderProfile" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_background_color_value = isset($custom_css_arr['page_profile_header_background_color']['value']) ? $custom_css_arr['page_profile_header_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_background_color" class="color-picker form-control" name="data[css][page_profile_header_background_color][value]" value="<?php echo $page_profile_header_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_text_color_value = isset($custom_css_arr['page_profile_header_text_color']['value']) ? $custom_css_arr['page_profile_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_text_color" class="color-picker form-control" name="data[css][page_profile_header_text_color][value]" value="<?php echo $page_profile_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_link_text_color_value = isset($custom_css_arr['page_profile_header_link_text_color']['value']) ? $custom_css_arr['page_profile_header_link_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_link_text_color" class="color-picker form-control" name="data[css][page_profile_header_link_text_color][value]" value="<?php echo $page_profile_header_link_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_link_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Info Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_info_text_color_value = isset($custom_css_arr['page_profile_header_info_text_color']['value']) ? $custom_css_arr['page_profile_header_info_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_info_text_color" class="color-picker form-control" name="data[css][page_profile_header_info_text_color][value]" value="<?php echo $page_profile_header_info_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_info_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_button_background_color_value = isset($custom_css_arr['page_profile_header_button_background_color']['value']) ? $custom_css_arr['page_profile_header_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_button_background_color" class="color-picker form-control" name="data[css][page_profile_header_button_background_color][value]" value="<?php echo $page_profile_header_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_button_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_button_border_color_value = isset($custom_css_arr['page_profile_header_button_border_color']['value']) ? $custom_css_arr['page_profile_header_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_button_border_color" class="color-picker form-control" name="data[css][page_profile_header_button_border_color][value]" value="<?php echo $page_profile_header_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_button_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_button_text_color_value = isset($custom_css_arr['page_profile_header_button_text_color']['value']) ? $custom_css_arr['page_profile_header_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_button_text_color" class="color-picker form-control" name="data[css][page_profile_header_button_text_color][value]" value="<?php echo $page_profile_header_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_button_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_text_color_value = isset($custom_css_arr['page_profile_header_menu_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_text_color][value]" value="<?php echo $page_profile_header_menu_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_active_text_color_value = isset($custom_css_arr['page_profile_header_menu_active_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_active_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_active_text_color][value]" value="<?php echo $page_profile_header_menu_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_active_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_active_background_color_value = isset($custom_css_arr['page_profile_header_menu_active_background_color']['value']) ? $custom_css_arr['page_profile_header_menu_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_active_background_color" class="color-picker form-control" name="data[css][page_profile_header_menu_active_background_color][value]" value="<?php echo $page_profile_header_menu_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_active_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Badge Counter Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_badge_background_color_value = isset($custom_css_arr['page_profile_header_menu_badge_background_color']['value']) ? $custom_css_arr['page_profile_header_menu_badge_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_badge_background_color" class="color-picker form-control" name="data[css][page_profile_header_menu_badge_background_color][value]" value="<?php echo $page_profile_header_menu_badge_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_badge_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Badge Counter Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_badge_text_color_value = isset($custom_css_arr['page_profile_header_menu_badge_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_badge_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_badge_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_badge_text_color][value]" value="<?php echo $page_profile_header_menu_badge_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_badge_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Badge Counter Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_badge_active_background_color_value = isset($custom_css_arr['page_profile_header_menu_badge_active_background_color']['value']) ? $custom_css_arr['page_profile_header_menu_badge_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_badge_active_background_color" class="color-picker form-control" name="data[css][page_profile_header_menu_badge_active_background_color][value]" value="<?php echo $page_profile_header_menu_badge_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_badge_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Menu Badge Counter Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_badge_active_text_color_value = isset($custom_css_arr['page_profile_header_menu_badge_active_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_badge_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_badge_active_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_badge_active_text_color][value]" value="<?php echo $page_profile_header_menu_badge_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_badge_active_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_dropdown_background_color_value = isset($custom_css_arr['page_profile_header_menu_dropdown_background_color']['value']) ? $custom_css_arr['page_profile_header_menu_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_dropdown_background_color" class="color-picker form-control" name="data[css][page_profile_header_menu_dropdown_background_color][value]" value="<?php echo $page_profile_header_menu_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_dropdown_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_dropdown_border_color_value = isset($custom_css_arr['page_profile_header_menu_dropdown_border_color']['value']) ? $custom_css_arr['page_profile_header_menu_dropdown_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_dropdown_border_color" class="color-picker form-control" name="data[css][page_profile_header_menu_dropdown_border_color][value]" value="<?php echo $page_profile_header_menu_dropdown_border_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_dropdown_border_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_dropdown_text_color_value = isset($custom_css_arr['page_profile_header_menu_dropdown_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_dropdown_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_dropdown_text_color][value]" value="<?php echo $page_profile_header_menu_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_dropdown_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_dropdown_active_background_color_value = isset($custom_css_arr['page_profile_header_menu_dropdown_active_background_color']['value']) ? $custom_css_arr['page_profile_header_menu_dropdown_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_dropdown_active_background_color" class="color-picker form-control" name="data[css][page_profile_header_menu_dropdown_active_background_color][value]" value="<?php echo $page_profile_header_menu_dropdown_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_dropdown_active_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_menu_dropdown_active_text_color_value = isset($custom_css_arr['page_profile_header_menu_dropdown_active_text_color']['value']) ? $custom_css_arr['page_profile_header_menu_dropdown_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_menu_dropdown_active_text_color" class="color-picker form-control" name="data[css][page_profile_header_menu_dropdown_active_text_color][value]" value="<?php echo $page_profile_header_menu_dropdown_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_menu_dropdown_active_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Badge Counter Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_dropdown_menu_badge_background_color_value = isset($custom_css_arr['page_profile_header_dropdown_menu_badge_background_color']['value']) ? $custom_css_arr['page_profile_header_dropdown_menu_badge_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_dropdown_menu_badge_background_color" class="color-picker form-control" name="data[css][page_profile_header_dropdown_menu_badge_background_color][value]" value="<?php echo $page_profile_header_dropdown_menu_badge_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_dropdown_menu_badge_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Badge Counter Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_dropdown_menu_badge_text_color_value = isset($custom_css_arr['page_profile_header_dropdown_menu_badge_text_color']['value']) ? $custom_css_arr['page_profile_header_dropdown_menu_badge_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_dropdown_menu_badge_text_color" class="color-picker form-control" name="data[css][page_profile_header_dropdown_menu_badge_text_color][value]" value="<?php echo $page_profile_header_dropdown_menu_badge_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_dropdown_menu_badge_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Badge Counter Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_dropdown_menu_badge_active_background_color_value = isset($custom_css_arr['page_profile_header_dropdown_menu_badge_active_background_color']['value']) ? $custom_css_arr['page_profile_header_dropdown_menu_badge_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_dropdown_menu_badge_active_background_color" class="color-picker form-control" name="data[css][page_profile_header_dropdown_menu_badge_active_background_color][value]" value="<?php echo $page_profile_header_dropdown_menu_badge_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_dropdown_menu_badge_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Dropdown Menu Badge Counter Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_header_dropdown_menu_badge_active_text_color_value = isset($custom_css_arr['page_profile_header_dropdown_menu_badge_active_text_color']['value']) ? $custom_css_arr['page_profile_header_dropdown_menu_badge_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_header_dropdown_menu_badge_active_text_color" class="color-picker form-control" name="data[css][page_profile_header_dropdown_menu_badge_active_text_color][value]" value="<?php echo $page_profile_header_dropdown_menu_badge_active_text_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_header_dropdown_menu_badge_active_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Avatar Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_avatar_border_color_value = isset($custom_css_arr['page_profile_avatar_border_color']['value']) ? $custom_css_arr['page_profile_avatar_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_avatar_border_color" class="color-picker form-control" name="data[css][page_profile_avatar_border_color][value]" value="<?php echo $page_profile_avatar_border_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_avatar_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Upload Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_upload_icon_color_value = isset($custom_css_arr['page_profile_upload_icon_color']['value']) ? $custom_css_arr['page_profile_upload_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_upload_icon_color" class="color-picker form-control" name="data[css][page_profile_upload_icon_color][value]" value="<?php echo $page_profile_upload_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_upload_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Upload Icon Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_upload_icon_background_color_value = isset($custom_css_arr['page_profile_upload_icon_background_color']['value']) ? $custom_css_arr['page_profile_upload_icon_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_upload_icon_background_color" class="color-picker form-control" name="data[css][page_profile_upload_icon_background_color][value]" value="<?php echo $page_profile_upload_icon_background_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_upload_icon_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Upload Icon Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_profile_upload_icon_border_color_value = isset($custom_css_arr['page_profile_upload_icon_border_color']['value']) ? $custom_css_arr['page_profile_upload_icon_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_profile_upload_icon_border_color" class="color-picker form-control" name="data[css][page_profile_upload_icon_border_color][value]" value="<?php echo $page_profile_upload_icon_border_color_value ?>">
                            <input type="hidden" name="data[css][page_profile_upload_icon_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="globalSearch-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Global Search'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseGlobalSearch" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseGlobalSearch">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/globalsearch.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseGlobalSearch" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_background_color_value = isset($custom_css_arr['page_search_bar_background_color']['value']) ? $custom_css_arr['page_search_bar_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_background_color" class="color-picker form-control" name="data[css][page_search_bar_background_color][value]" value="<?php echo $page_search_bar_background_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_border_color_value = isset($custom_css_arr['page_search_bar_border_color']['value']) ? $custom_css_arr['page_search_bar_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_border_color" class="color-picker form-control" name="data[css][page_search_bar_border_color][value]" value="<?php echo $page_search_bar_border_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon & Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_icon_text_color_value = isset($custom_css_arr['page_search_bar_icon_text_color']['value']) ? $custom_css_arr['page_search_bar_icon_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_icon_text_color" class="color-picker form-control" name="data[css][page_search_bar_icon_text_color][value]" value="<?php echo $page_search_bar_icon_text_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_icon_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Global Search Suggestion'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseGlobalSearchSuggestion" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseGlobalSearchSuggestion">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/globalsearchsuggestion.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseGlobalSearchSuggestion" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_background_color_value = isset($custom_css_arr['page_search_bar_suggestion_background_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_background_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_background_color][value]" value="<?php echo $page_search_bar_suggestion_background_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_border_color_value = isset($custom_css_arr['page_search_bar_suggestion_border_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_border_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_border_color][value]" value="<?php echo $page_search_bar_suggestion_border_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_header_background_color_value = isset($custom_css_arr['page_search_bar_suggestion_header_background_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_header_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_header_background_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_header_background_color][value]" value="<?php echo $page_search_bar_suggestion_header_background_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_header_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_header_text_color_value = isset($custom_css_arr['page_search_bar_suggestion_header_text_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_header_text_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_header_text_color][value]" value="<?php echo $page_search_bar_suggestion_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Item Title Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_title_text_color_value = isset($custom_css_arr['page_search_bar_suggestion_title_text_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_title_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_title_text_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_title_text_color][value]" value="<?php echo $page_search_bar_suggestion_title_text_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_title_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Item Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_text_color_value = isset($custom_css_arr['page_search_bar_suggestion_text_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_text_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_text_color][value]" value="<?php echo $page_search_bar_suggestion_text_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Item Hover Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_hover_background_color_value = isset($custom_css_arr['page_search_bar_suggestion_hover_background_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_hover_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_hover_background_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_hover_background_color][value]" value="<?php echo $page_search_bar_suggestion_hover_background_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_hover_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Item Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_search_bar_suggestion_item_border_color_value = isset($custom_css_arr['page_search_bar_suggestion_item_border_color']['value']) ? $custom_css_arr['page_search_bar_suggestion_item_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_search_bar_suggestion_item_border_color" class="color-picker form-control" name="data[css][page_search_bar_suggestion_item_border_color][value]" value="<?php echo $page_search_bar_suggestion_item_border_color_value ?>">
                            <input type="hidden" name="data[css][page_search_bar_suggestion_item_border_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane" id="block-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Block'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseBlock" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseBlock">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/block.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseBlock" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_background_color_value = isset($custom_css_arr['page_block_header_background_color']['value']) ? $custom_css_arr['page_block_header_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_background_color" class="color-picker form-control" name="data[css][page_block_header_background_color][value]" value="<?php echo $page_block_header_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_text_color_value = isset($custom_css_arr['page_block_header_text_color']['value']) ? $custom_css_arr['page_block_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_text_color" class="color-picker form-control" name="data[css][page_block_header_text_color][value]" value="<?php echo $page_block_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_border_color_value = isset($custom_css_arr['page_block_header_border_color']['value']) ? $custom_css_arr['page_block_header_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_border_color" class="color-picker form-control" name="data[css][page_block_header_border_color][value]" value="<?php echo $page_block_header_border_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_icon_color_value = isset($custom_css_arr['page_block_header_icon_color']['value']) ? $custom_css_arr['page_block_header_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_icon_color" class="color-picker form-control" name="data[css][page_block_header_icon_color][value]" value="<?php echo $page_block_header_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_button_background_color_value = isset($custom_css_arr['page_block_header_button_background_color']['value']) ? $custom_css_arr['page_block_header_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_button_background_color" class="color-picker form-control" name="data[css][page_block_header_button_background_color][value]" value="<?php echo $page_block_header_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_button_border_color_value = isset($custom_css_arr['page_block_header_button_border_color']['value']) ? $custom_css_arr['page_block_header_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_button_border_color" class="color-picker form-control" name="data[css][page_block_header_button_border_color][value]" value="<?php echo $page_block_header_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_header_button_text_color_value = isset($custom_css_arr['page_block_header_button_text_color']['value']) ? $custom_css_arr['page_block_header_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_header_button_text_color" class="color-picker form-control" name="data[css][page_block_header_button_text_color][value]" value="<?php echo $page_block_header_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_block_header_button_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Content Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_content_background_color_value = isset($custom_css_arr['page_block_content_background_color']['value']) ? $custom_css_arr['page_block_content_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_content_background_color" class="color-picker form-control" name="data[css][page_block_content_background_color][value]" value="<?php echo $page_block_content_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_content_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Content Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_content_text_color_value = isset($custom_css_arr['page_block_content_text_color']['value']) ? $custom_css_arr['page_block_content_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_content_text_color" class="color-picker form-control" name="data[css][page_block_content_text_color][value]" value="<?php echo $page_block_content_text_color_value ?>">
                            <input type="hidden" name="data[css][page_block_content_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Author Name Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_author_name_color_value = isset($custom_css_arr['page_block_author_name_color']['value']) ? $custom_css_arr['page_block_author_name_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_author_name_color" class="color-picker form-control" name="data[css][page_block_author_name_color][value]" value="<?php echo $page_block_author_name_color_value ?>">
                            <input type="hidden" name="data[css][page_block_author_name_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Author Count Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_author_count_color_value = isset($custom_css_arr['page_block_author_count_color']['value']) ? $custom_css_arr['page_block_author_count_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_author_count_color" class="color-picker form-control" name="data[css][page_block_author_count_color][value]" value="<?php echo $page_block_author_count_color_value ?>">
                            <input type="hidden" name="data[css][page_block_author_count_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Content Search'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseContentSearch" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseContentSearch">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/contentsearch.png">

                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseContentSearch" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_search_header_background_color_value = isset($custom_css_arr['page_block_search_header_background_color']['value']) ? $custom_css_arr['page_block_search_header_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_search_header_background_color" class="color-picker form-control" name="data[css][page_block_search_header_background_color][value]" value="<?php echo $page_block_search_header_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_search_header_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_search_header_text_color_value = isset($custom_css_arr['page_block_search_header_text_color']['value']) ? $custom_css_arr['page_block_search_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_search_header_text_color" class="color-picker form-control" name="data[css][page_block_search_header_text_color][value]" value="<?php echo $page_block_search_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_block_search_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_search_header_icon_color_value = isset($custom_css_arr['page_block_search_header_icon_color']['value']) ? $custom_css_arr['page_block_search_header_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_search_header_icon_color" class="color-picker form-control" name="data[css][page_block_search_header_icon_color][value]" value="<?php echo $page_block_search_header_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_block_search_header_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Body Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_search_body_background_color_value = isset($custom_css_arr['page_block_search_body_background_color']['value']) ? $custom_css_arr['page_block_search_body_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_search_body_background_color" class="color-picker form-control" name="data[css][page_block_search_body_background_color][value]" value="<?php echo $page_block_search_body_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_search_body_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Footer Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_block_search_footer_background_color_value = isset($custom_css_arr['page_block_search_footer_background_color']['value']) ? $custom_css_arr['page_block_search_footer_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_block_search_footer_background_color" class="color-picker form-control" name="data[css][page_block_search_footer_background_color][value]" value="<?php echo $page_block_search_footer_background_color_value ?>">
                            <input type="hidden" name="data[css][page_block_search_footer_background_color][type]" value="color">
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Button Close'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_close_background_color_value = isset($custom_css_arr['page_block_search_footer_button_close_background_color']['value']) ? $custom_css_arr['page_block_search_footer_button_close_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_close_background_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_close_background_color][value]" value="<?php echo $page_block_search_footer_button_close_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_close_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_close_border_color_value = isset($custom_css_arr['page_block_search_footer_button_close_border_color']['value']) ? $custom_css_arr['page_block_search_footer_button_close_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_close_border_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_close_border_color][value]" value="<?php echo $page_block_search_footer_button_close_border_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_close_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_close_text_color_value = isset($custom_css_arr['page_block_search_footer_button_close_text_color']['value']) ? $custom_css_arr['page_block_search_footer_button_close_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_close_text_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_close_text_color][value]" value="<?php echo $page_block_search_footer_button_close_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_close_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Button Search'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_submit_background_color_value = isset($custom_css_arr['page_block_search_footer_button_submit_background_color']['value']) ? $custom_css_arr['page_block_search_footer_button_submit_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_submit_background_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_submit_background_color][value]" value="<?php echo $page_block_search_footer_button_submit_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_submit_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_submit_border_color_value = isset($custom_css_arr['page_block_search_footer_button_submit_border_color']['value']) ? $custom_css_arr['page_block_search_footer_button_submit_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_submit_border_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_submit_border_color][value]" value="<?php echo $page_block_search_footer_button_submit_border_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_submit_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_block_search_footer_button_submit_text_color_value = isset($custom_css_arr['page_block_search_footer_button_submit_text_color']['value']) ? $custom_css_arr['page_block_search_footer_button_submit_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_block_search_footer_button_submit_text_color" class="color-picker form-control" name="data[css][page_block_search_footer_button_submit_text_color][value]" value="<?php echo $page_block_search_footer_button_submit_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_block_search_footer_button_submit_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="modal-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Modal'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseModal" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseModal">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/modal.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseModal" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_background_color_value = isset($custom_css_arr['page_modal_background_color']['value']) ? $custom_css_arr['page_modal_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_background_color" class="color-picker form-control" name="data[css][page_modal_background_color][value]" value="<?php echo $page_modal_background_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_text_color_value = isset($custom_css_arr['page_modal_text_color']['value']) ? $custom_css_arr['page_modal_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_text_color" class="color-picker form-control" name="data[css][page_modal_text_color][value]" value="<?php echo $page_modal_text_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_border_color_value = isset($custom_css_arr['page_modal_border_color']['value']) ? $custom_css_arr['page_modal_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_border_color" class="color-picker form-control" name="data[css][page_modal_border_color][value]" value="<?php echo $page_modal_border_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Button Close'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseModalBtnClose" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseModalBtnClose">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/modalclose.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseModalBtnClose" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_close_background_color_value = isset($custom_css_arr['page_modal_button_close_background_color']['value']) ? $custom_css_arr['page_modal_button_close_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_close_background_color" class="color-picker form-control" name="data[css][page_modal_button_close_background_color][value]" value="<?php echo $page_modal_button_close_background_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_close_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_close_border_color_value = isset($custom_css_arr['page_modal_button_close_border_color']['value']) ? $custom_css_arr['page_modal_button_close_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_close_border_color" class="color-picker form-control" name="data[css][page_modal_button_close_border_color][value]" value="<?php echo $page_modal_button_close_border_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_close_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_close_text_color_value = isset($custom_css_arr['page_modal_button_close_text_color']['value']) ? $custom_css_arr['page_modal_button_close_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_close_text_color" class="color-picker form-control" name="data[css][page_modal_button_close_text_color][value]" value="<?php echo $page_modal_button_close_text_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_close_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Button Ok'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseModalBtnOk" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseModalBtnOk">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/modalok.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseModalBtnOk" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_ok_background_color_value = isset($custom_css_arr['page_modal_button_ok_background_color']['value']) ? $custom_css_arr['page_modal_button_ok_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_ok_background_color" class="color-picker form-control" name="data[css][page_modal_button_ok_background_color][value]" value="<?php echo $page_modal_button_ok_background_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_ok_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_ok_border_color_value = isset($custom_css_arr['page_modal_button_ok_border_color']['value']) ? $custom_css_arr['page_modal_button_ok_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_ok_border_color" class="color-picker form-control" name="data[css][page_modal_button_ok_border_color][value]" value="<?php echo $page_modal_button_ok_border_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_ok_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_ok_text_color_value = isset($custom_css_arr['page_modal_button_ok_text_color']['value']) ? $custom_css_arr['page_modal_button_ok_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_ok_text_color" class="color-picker form-control" name="data[css][page_modal_button_ok_text_color][value]" value="<?php echo $page_modal_button_ok_text_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_ok_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Button Delete'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseModalBtnDelete" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseModalBtnDelete">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/modaldelete.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseModalBtnDelete" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_delete_background_color_value = isset($custom_css_arr['page_modal_button_delete_background_color']['value']) ? $custom_css_arr['page_modal_button_delete_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_delete_background_color" class="color-picker form-control" name="data[css][page_modal_button_delete_background_color][value]" value="<?php echo $page_modal_button_delete_background_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_delete_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_delete_border_color_value = isset($custom_css_arr['page_modal_button_delete_border_color']['value']) ? $custom_css_arr['page_modal_button_delete_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_delete_border_color" class="color-picker form-control" name="data[css][page_modal_button_delete_border_color][value]" value="<?php echo $page_modal_button_delete_border_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_delete_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_modal_button_delete_text_color_value = isset($custom_css_arr['page_modal_button_delete_text_color']['value']) ? $custom_css_arr['page_modal_button_delete_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_modal_button_delete_text_color" class="color-picker form-control" name="data[css][page_modal_button_delete_text_color][value]" value="<?php echo $page_modal_button_delete_text_color_value ?>">
                            <input type="hidden" name="data[css][page_modal_button_delete_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Photo Theater'); ?>
                    <a class="panel-heading-review collapsed" href="#collapsePhotoTheater" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapsePhotoTheater">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/phototheater.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapsePhotoTheater" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('List Photo Tags'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_button_background_color_value = isset($custom_css_arr['photo_theater_tag_button_background_color']['value']) ? $custom_css_arr['photo_theater_tag_button_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_button_background_color" class="color-picker form-control" name="data[css][photo_theater_tag_button_background_color][value]" value="<?php echo $photo_theater_tag_button_background_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_button_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_button_border_color_value = isset($custom_css_arr['photo_theater_tag_button_border_color']['value']) ? $custom_css_arr['photo_theater_tag_button_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_button_border_color" class="color-picker form-control" name="data[css][photo_theater_tag_button_border_color][value]" value="<?php echo $photo_theater_tag_button_border_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_button_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_button_text_color_value = isset($custom_css_arr['photo_theater_tag_button_text_color']['value']) ? $custom_css_arr['photo_theater_tag_button_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_button_text_color" class="color-picker form-control" name="data[css][photo_theater_tag_button_text_color][value]" value="<?php echo $photo_theater_tag_button_text_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_button_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Hover Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_button_hover_text_color_value = isset($custom_css_arr['photo_theater_tag_button_hover_text_color']['value']) ? $custom_css_arr['photo_theater_tag_button_hover_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_button_hover_text_color" class="color-picker form-control" name="data[css][photo_theater_tag_button_hover_text_color][value]" value="<?php echo $photo_theater_tag_button_hover_text_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_button_hover_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Tag Photo'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_background_color_value = isset($custom_css_arr['photo_theater_tag_box_background_color']['value']) ? $custom_css_arr['photo_theater_tag_box_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_background_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_background_color][value]" value="<?php echo $photo_theater_tag_box_background_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_text_color_value = isset($custom_css_arr['photo_theater_tag_box_text_color']['value']) ? $custom_css_arr['photo_theater_tag_box_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_text_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_text_color][value]" value="<?php echo $photo_theater_tag_box_text_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_border_color_value = isset($custom_css_arr['photo_theater_tag_box_border_color']['value']) ? $custom_css_arr['photo_theater_tag_box_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_border_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_border_color][value]" value="<?php echo $photo_theater_tag_box_border_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_button_background_color_value = isset($custom_css_arr['photo_theater_tag_box_button_background_color']['value']) ? $custom_css_arr['photo_theater_tag_box_button_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_button_background_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_button_background_color][value]" value="<?php echo $photo_theater_tag_box_button_background_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_button_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_button_border_color_value = isset($custom_css_arr['photo_theater_tag_box_button_border_color']['value']) ? $custom_css_arr['photo_theater_tag_box_button_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_button_border_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_button_border_color][value]" value="<?php echo $photo_theater_tag_box_button_border_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_button_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $photo_theater_tag_box_button_text_color_value = isset($custom_css_arr['photo_theater_tag_box_button_text_color']['value']) ? $custom_css_arr['photo_theater_tag_box_button_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-photo_theater_tag_box_button_text_color" class="color-picker form-control" name="data[css][photo_theater_tag_box_button_text_color][value]" value="<?php echo $photo_theater_tag_box_button_text_color_value ?>">
                                    <input type="hidden" name="data[css][photo_theater_tag_box_button_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="form-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Form Layout'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseFormLayout" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseFormLayout">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/formlayout.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseFormLayout" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Group Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_group_border_color_value = isset($custom_css_arr['page_form_group_border_color']['value']) ? $custom_css_arr['page_form_group_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_group_border_color" class="color-picker form-control" name="data[css][page_form_group_border_color][value]" value="<?php echo $page_form_group_border_color_value ?>">
                            <input type="hidden" name="data[css][page_form_group_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Group Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_group_header_text_color_value = isset($custom_css_arr['page_form_group_header_text_color']['value']) ? $custom_css_arr['page_form_group_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_group_header_text_color" class="color-picker form-control" name="data[css][page_form_group_header_text_color][value]" value="<?php echo $page_form_group_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_form_group_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_text_color_value = isset($custom_css_arr['page_form_text_color']['value']) ? $custom_css_arr['page_form_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_text_color" class="color-picker form-control" name="data[css][page_form_text_color][value]" value="<?php echo $page_form_text_color_value ?>">
                            <input type="hidden" name="data[css][page_form_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Label Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_label_color_value = isset($custom_css_arr['page_form_label_color']['value']) ? $custom_css_arr['page_form_label_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_label_color" class="color-picker form-control" name="data[css][page_form_label_color][value]" value="<?php echo $page_form_label_color_value ?>">
                            <input type="hidden" name="data[css][page_form_label_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Label Tooltip Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_label_tip_color_value = isset($custom_css_arr['page_form_label_tip_color']['value']) ? $custom_css_arr['page_form_label_tip_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_label_tip_color" class="color-picker form-control" name="data[css][page_form_label_tip_color][value]" value="<?php echo $page_form_label_tip_color_value ?>">
                            <input type="hidden" name="data[css][page_form_label_tip_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_input_border_color_value = isset($custom_css_arr['page_form_input_border_color']['value']) ? $custom_css_arr['page_form_input_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_input_border_color" class="color-picker form-control" name="data[css][page_form_input_border_color][value]" value="<?php echo $page_form_input_border_color_value ?>">
                            <input type="hidden" name="data[css][page_form_input_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_input_background_color_value = isset($custom_css_arr['page_form_input_background_color']['value']) ? $custom_css_arr['page_form_input_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_input_background_color" class="color-picker form-control" name="data[css][page_form_input_background_color][value]" value="<?php echo $page_form_input_background_color_value ?>">
                            <input type="hidden" name="data[css][page_form_input_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_form_input_text_color_value = isset($custom_css_arr['page_form_input_text_color']['value']) ? $custom_css_arr['page_form_input_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_form_input_text_color" class="color-picker form-control" name="data[css][page_form_input_text_color][value]" value="<?php echo $page_form_input_text_color_value ?>">
                            <input type="hidden" name="data[css][page_form_input_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Select Box'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $form_select_dropdown_background_color_value = isset($custom_css_arr['form_select_dropdown_background_color']['value']) ? $custom_css_arr['form_select_dropdown_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-form_select_dropdown_background_color" class="color-picker form-control" name="data[css][form_select_dropdown_background_color][value]" value="<?php echo $form_select_dropdown_background_color_value ?>">
                                    <input type="hidden" name="data[css][form_select_dropdown_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $form_select_dropdown_text_color_value = isset($custom_css_arr['form_select_dropdown_text_color']['value']) ? $custom_css_arr['form_select_dropdown_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-form_select_dropdown_text_color" class="color-picker form-control" name="data[css][form_select_dropdown_text_color][value]" value="<?php echo $form_select_dropdown_text_color_value ?>">
                                    <input type="hidden" name="data[css][form_select_dropdown_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $form_select_dropdown_border_color_value = isset($custom_css_arr['form_select_dropdown_border_color']['value']) ? $custom_css_arr['form_select_dropdown_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-form_select_dropdown_border_color" class="color-picker form-control" name="data[css][form_select_dropdown_border_color][value]" value="<?php echo $form_select_dropdown_border_color_value ?>">
                                    <input type="hidden" name="data[css][form_select_dropdown_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $form_select_dropdown_active_background_color_value = isset($custom_css_arr['form_select_dropdown_active_background_color']['value']) ? $custom_css_arr['form_select_dropdown_active_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-form_select_dropdown_active_background_color" class="color-picker form-control" name="data[css][form_select_dropdown_active_background_color][value]" value="<?php echo $form_select_dropdown_active_background_color_value ?>">
                                    <input type="hidden" name="data[css][form_select_dropdown_active_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $form_select_dropdown_active_text_color_value = isset($custom_css_arr['form_select_dropdown_active_text_color']['value']) ? $custom_css_arr['form_select_dropdown_active_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-form_select_dropdown_active_text_color" class="color-picker form-control" name="data[css][form_select_dropdown_active_text_color][value]" value="<?php echo $form_select_dropdown_active_text_color_value ?>">
                                    <input type="hidden" name="data[css][form_select_dropdown_active_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Tags Input'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_button_background_color_value = isset($custom_css_arr['tagsinput_button_background_color']['value']) ? $custom_css_arr['tagsinput_button_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_button_background_color" class="color-picker form-control" name="data[css][tagsinput_button_background_color][value]" value="<?php echo $tagsinput_button_background_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_button_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_button_text_color_value = isset($custom_css_arr['tagsinput_button_text_color']['value']) ? $custom_css_arr['tagsinput_button_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_button_text_color" class="color-picker form-control" name="data[css][tagsinput_button_text_color][value]" value="<?php echo $tagsinput_button_text_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_button_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_dropdown_background_color_value = isset($custom_css_arr['tagsinput_dropdown_background_color']['value']) ? $custom_css_arr['tagsinput_dropdown_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_dropdown_background_color" class="color-picker form-control" name="data[css][tagsinput_dropdown_background_color][value]" value="<?php echo $tagsinput_dropdown_background_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_dropdown_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_dropdown_text_color_value = isset($custom_css_arr['tagsinput_dropdown_text_color']['value']) ? $custom_css_arr['tagsinput_dropdown_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_dropdown_text_color" class="color-picker form-control" name="data[css][tagsinput_dropdown_text_color][value]" value="<?php echo $tagsinput_dropdown_text_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_dropdown_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Active Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_dropdown_active_background_color_value = isset($custom_css_arr['tagsinput_dropdown_active_background_color']['value']) ? $custom_css_arr['tagsinput_dropdown_active_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_dropdown_active_background_color" class="color-picker form-control" name="data[css][tagsinput_dropdown_active_background_color][value]" value="<?php echo $tagsinput_dropdown_active_background_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_dropdown_active_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Dropdown Active Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $tagsinput_dropdown_active_text_color_value = isset($custom_css_arr['tagsinput_dropdown_active_text_color']['value']) ? $custom_css_arr['tagsinput_dropdown_active_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-tagsinput_dropdown_active_text_color" class="color-picker form-control" name="data[css][tagsinput_dropdown_active_text_color][value]" value="<?php echo $tagsinput_dropdown_active_text_color_value ?>">
                                    <input type="hidden" name="data[css][tagsinput_dropdown_active_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('WYSIWYG Html Editor'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseWYSIWYGHtmlEditor" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseWYSIWYGHtmlEditor">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/editor.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseWYSIWYGHtmlEditor" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $wysiwyg_panel_background_color_value = isset($custom_css_arr['wysiwyg_panel_background_color']['value']) ? $custom_css_arr['wysiwyg_panel_background_color']['value'] : '' ?>
                            <input type="text" id="frm-wysiwyg_panel_background_color" class="color-picker form-control" name="data[css][wysiwyg_panel_background_color][value]" value="<?php echo $wysiwyg_panel_background_color_value ?>">
                            <input type="hidden" name="data[css][wysiwyg_panel_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $wysiwyg_panel_text_color_value = isset($custom_css_arr['wysiwyg_panel_text_color']['value']) ? $custom_css_arr['wysiwyg_panel_text_color']['value'] : '' ?>
                            <input type="text" id="frm-wysiwyg_panel_text_color" class="color-picker form-control" name="data[css][wysiwyg_panel_text_color][value]" value="<?php echo $wysiwyg_panel_text_color_value ?>">
                            <input type="hidden" name="data[css][wysiwyg_panel_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $wysiwyg_panel_active_background_color_value = isset($custom_css_arr['wysiwyg_panel_active_background_color']['value']) ? $custom_css_arr['wysiwyg_panel_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-wysiwyg_panel_active_background_color" class="color-picker form-control" name="data[css][wysiwyg_panel_active_background_color][value]" value="<?php echo $wysiwyg_panel_active_background_color_value ?>">
                            <input type="hidden" name="data[css][wysiwyg_panel_active_background_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Default'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_default_background_color_value = isset($custom_css_arr['page_button_default_background_color']['value']) ? $custom_css_arr['page_button_default_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_default_background_color" class="color-picker form-control" name="data[css][page_button_default_background_color][value]" value="<?php echo $page_button_default_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_default_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_default_border_color_value = isset($custom_css_arr['page_button_default_border_color']['value']) ? $custom_css_arr['page_button_default_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_default_border_color" class="color-picker form-control" name="data[css][page_button_default_border_color][value]" value="<?php echo $page_button_default_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_default_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_default_text_color_value = isset($custom_css_arr['page_button_default_text_color']['value']) ? $custom_css_arr['page_button_default_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_default_text_color" class="color-picker form-control" name="data[css][page_button_default_text_color][value]" value="<?php echo $page_button_default_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_default_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Primary'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_primary_background_color_value = isset($custom_css_arr['page_button_primary_background_color']['value']) ? $custom_css_arr['page_button_primary_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_primary_background_color" class="color-picker form-control" name="data[css][page_button_primary_background_color][value]" value="<?php echo $page_button_primary_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_primary_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_primary_border_color_value = isset($custom_css_arr['page_button_primary_border_color']['value']) ? $custom_css_arr['page_button_primary_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_primary_border_color" class="color-picker form-control" name="data[css][page_button_primary_border_color][value]" value="<?php echo $page_button_primary_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_primary_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_primary_text_color_value = isset($custom_css_arr['page_button_primary_text_color']['value']) ? $custom_css_arr['page_button_primary_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_primary_text_color" class="color-picker form-control" name="data[css][page_button_primary_text_color][value]" value="<?php echo $page_button_primary_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_primary_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Success'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_success_background_color_value = isset($custom_css_arr['page_button_success_background_color']['value']) ? $custom_css_arr['page_button_success_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_success_background_color" class="color-picker form-control" name="data[css][page_button_success_background_color][value]" value="<?php echo $page_button_success_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_success_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_success_border_color_value = isset($custom_css_arr['page_button_success_border_color']['value']) ? $custom_css_arr['page_button_success_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_success_border_color" class="color-picker form-control" name="data[css][page_button_success_border_color][value]" value="<?php echo $page_button_success_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_success_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_success_text_color_value = isset($custom_css_arr['page_button_success_text_color']['value']) ? $custom_css_arr['page_button_success_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_success_text_color" class="color-picker form-control" name="data[css][page_button_success_text_color][value]" value="<?php echo $page_button_success_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_success_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Info'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_info_background_color_value = isset($custom_css_arr['page_button_info_background_color']['value']) ? $custom_css_arr['page_button_info_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_info_background_color" class="color-picker form-control" name="data[css][page_button_info_background_color][value]" value="<?php echo $page_button_info_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_info_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_info_border_color_value = isset($custom_css_arr['page_button_info_border_color']['value']) ? $custom_css_arr['page_button_info_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_info_border_color" class="color-picker form-control" name="data[css][page_button_info_border_color][value]" value="<?php echo $page_button_info_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_info_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_info_text_color_value = isset($custom_css_arr['page_button_info_text_color']['value']) ? $custom_css_arr['page_button_info_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_info_text_color" class="color-picker form-control" name="data[css][page_button_info_text_color][value]" value="<?php echo $page_button_info_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_info_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Warning'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_warning_background_color_value = isset($custom_css_arr['page_button_warning_background_color']['value']) ? $custom_css_arr['page_button_warning_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_warning_background_color" class="color-picker form-control" name="data[css][page_button_warning_background_color][value]" value="<?php echo $page_button_warning_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_warning_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_warning_border_color_value = isset($custom_css_arr['page_button_warning_border_color']['value']) ? $custom_css_arr['page_button_warning_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_warning_border_color" class="color-picker form-control" name="data[css][page_button_warning_border_color][value]" value="<?php echo $page_button_warning_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_warning_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_warning_text_color_value = isset($custom_css_arr['page_button_warning_text_color']['value']) ? $custom_css_arr['page_button_warning_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_warning_text_color" class="color-picker form-control" name="data[css][page_button_warning_text_color][value]" value="<?php echo $page_button_warning_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_warning_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?php echo __('Button Danger'); ?></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_danger_background_color_value = isset($custom_css_arr['page_button_danger_background_color']['value']) ? $custom_css_arr['page_button_danger_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_danger_background_color" class="color-picker form-control" name="data[css][page_button_danger_background_color][value]" value="<?php echo $page_button_danger_background_color_value ?>">
                            <input type="hidden" name="data[css][page_button_danger_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_danger_border_color_value = isset($custom_css_arr['page_button_danger_border_color']['value']) ? $custom_css_arr['page_button_danger_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_danger_border_color" class="color-picker form-control" name="data[css][page_button_danger_border_color][value]" value="<?php echo $page_button_danger_border_color_value ?>">
                            <input type="hidden" name="data[css][page_button_danger_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_button_danger_text_color_value = isset($custom_css_arr['page_button_danger_text_color']['value']) ? $custom_css_arr['page_button_danger_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_button_danger_text_color" class="color-picker form-control" name="data[css][page_button_danger_text_color][value]" value="<?php echo $page_button_danger_text_color_value ?>">
                            <input type="hidden" name="data[css][page_button_danger_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="content-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Post Content'); ?>
                    <a class="panel-heading-review collapsed" href="#collapsePostContent" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapsePostContent">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/postcontent.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapsePostContent" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_text_color_value = isset($custom_css_arr['content_text_color']['value']) ? $custom_css_arr['content_text_color']['value'] : '' ?>
                            <input type="text" id="frm-content_text_color" class="color-picker form-control" name="data[css][content_text_color][value]" value="<?php echo $content_text_color_value ?>">
                            <input type="hidden" name="data[css][content_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Link Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_link_text_color_value = isset($custom_css_arr['content_link_text_color']['value']) ? $custom_css_arr['content_link_text_color']['value'] : '' ?>
                            <input type="text" id="frm-content_link_text_color" class="color-picker form-control" name="data[css][content_link_text_color][value]" value="<?php echo $content_link_text_color_value ?>">
                            <input type="hidden" name="data[css][content_link_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Extra Information Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_extra_info_color_value = isset($custom_css_arr['content_extra_info_color']['value']) ? $custom_css_arr['content_extra_info_color']['value'] : '' ?>
                            <input type="text" id="frm-content_extra_info_color" class="color-picker form-control" name="data[css][content_extra_info_color][value]" value="<?php echo $content_extra_info_color_value ?>">
                            <input type="hidden" name="data[css][content_extra_info_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Blockquote'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseBlockquote" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseBlockquote">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/blockquote.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseBlockquote" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Blockquote Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_blockquote_text_color_value = isset($custom_css_arr['content_blockquote_text_color']['value']) ? $custom_css_arr['content_blockquote_text_color']['value'] : '' ?>
                            <input type="text" id="frm-content_blockquote_text_color" class="color-picker form-control" name="data[css][content_blockquote_text_color][value]" value="<?php echo $content_blockquote_text_color_value ?>">
                            <input type="hidden" name="data[css][content_blockquote_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Blockquote Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_blockquote_background_color_value = isset($custom_css_arr['content_blockquote_background_color']['value']) ? $custom_css_arr['content_blockquote_background_color']['value'] : '' ?>
                            <input type="text" id="frm-content_blockquote_background_color" class="color-picker form-control" name="data[css][content_blockquote_background_color][value]" value="<?php echo $content_blockquote_background_color_value ?>">
                            <input type="hidden" name="data[css][content_blockquote_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Blockquote Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $content_blockquote_border_color_value = isset($custom_css_arr['content_blockquote_border_color']['value']) ? $custom_css_arr['content_blockquote_border_color']['value'] : '' ?>
                            <input type="text" id="frm-content_blockquote_border_color" class="color-picker form-control" name="data[css][content_blockquote_border_color][value]" value="<?php echo $content_blockquote_border_color_value ?>">
                            <input type="hidden" name="data[css][content_blockquote_border_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="mobile-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Bottom Bar'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseBottomBar" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseBottomBar">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/bottombar.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseBottomBar" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_bottom_bar_background_color_value = isset($custom_css_arr['page_bottom_bar_background_color']['value']) ? $custom_css_arr['page_bottom_bar_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_bottom_bar_background_color" class="color-picker form-control" name="data[css][page_bottom_bar_background_color][value]" value="<?php echo $page_bottom_bar_background_color_value ?>">
                            <input type="hidden" name="data[css][page_bottom_bar_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_bottom_bar_border_color_value = isset($custom_css_arr['page_bottom_bar_border_color']['value']) ? $custom_css_arr['page_bottom_bar_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_bottom_bar_border_color" class="color-picker form-control" name="data[css][page_bottom_bar_border_color][value]" value="<?php echo $page_bottom_bar_border_color_value ?>">
                            <input type="hidden" name="data[css][page_bottom_bar_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icons Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_bottom_bar_icons_color_value = isset($custom_css_arr['page_bottom_bar_icons_color']['value']) ? $custom_css_arr['page_bottom_bar_icons_color']['value'] : '' ?>
                            <input type="text" id="frm-page_bottom_bar_icons_color" class="color-picker form-control" name="data[css][page_bottom_bar_icons_color][value]" value="<?php echo $page_bottom_bar_icons_color_value ?>">
                            <input type="hidden" name="data[css][page_bottom_bar_icons_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Modal Left/Right'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseModalLeftRight" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseModalLeftRight">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/modalleftright.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseModalLeftRight" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_mobile_modal_bar_background_color_value = isset($custom_css_arr['page_mobile_modal_bar_background_color']['value']) ? $custom_css_arr['page_mobile_modal_bar_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_mobile_modal_bar_background_color" class="color-picker form-control" name="data[css][page_mobile_modal_bar_background_color][value]" value="<?php echo $page_mobile_modal_bar_background_color_value ?>">
                            <input type="hidden" name="data[css][page_mobile_modal_bar_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Close Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_mobile_modal_bar_icon_color_value = isset($custom_css_arr['page_mobile_modal_bar_icon_color']['value']) ? $custom_css_arr['page_mobile_modal_bar_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_mobile_modal_bar_icon_color" class="color-picker form-control" name="data[css][page_mobile_modal_bar_icon_color][value]" value="<?php echo $page_mobile_modal_bar_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_mobile_modal_bar_icon_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="widget-notification">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Messages/Notifications Popup'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseNotiPopup" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseNotiPopup">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/notypopup.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseNotiPopup" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_background_color_value = isset($custom_css_arr['page_notification_popup_background_color']['value']) ? $custom_css_arr['page_notification_popup_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_background_color" class="color-picker form-control" name="data[css][page_notification_popup_background_color][value]" value="<?php echo $page_notification_popup_background_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_header_text_color_value = isset($custom_css_arr['page_notification_popup_header_text_color']['value']) ? $custom_css_arr['page_notification_popup_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_header_text_color" class="color-picker form-control" name="data[css][page_notification_popup_header_text_color][value]" value="<?php echo $page_notification_popup_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Subject Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_subject_text_color_value = isset($custom_css_arr['page_notification_popup_subject_text_color']['value']) ? $custom_css_arr['page_notification_popup_subject_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_subject_text_color" class="color-picker form-control" name="data[css][page_notification_popup_subject_text_color][value]" value="<?php echo $page_notification_popup_subject_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_subject_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Message Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_message_text_color_value = isset($custom_css_arr['page_notification_popup_message_text_color']['value']) ? $custom_css_arr['page_notification_popup_message_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_message_text_color" class="color-picker form-control" name="data[css][page_notification_popup_message_text_color][value]" value="<?php echo $page_notification_popup_message_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_message_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_date_text_color_value = isset($custom_css_arr['page_notification_popup_date_text_color']['value']) ? $custom_css_arr['page_notification_popup_date_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_date_text_color" class="color-picker form-control" name="data[css][page_notification_popup_date_text_color][value]" value="<?php echo $page_notification_popup_date_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_date_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_border_color_value = isset($custom_css_arr['page_notification_popup_border_color']['value']) ? $custom_css_arr['page_notification_popup_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_border_color" class="color-picker form-control" name="data[css][page_notification_popup_border_color][value]" value="<?php echo $page_notification_popup_border_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Footer Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_footer_text_color_value = isset($custom_css_arr['page_notification_popup_footer_text_color']['value']) ? $custom_css_arr['page_notification_popup_footer_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_footer_text_color" class="color-picker form-control" name="data[css][page_notification_popup_footer_text_color][value]" value="<?php echo $page_notification_popup_footer_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_footer_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Footer Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_footer_background_color_value = isset($custom_css_arr['page_notification_popup_footer_background_color']['value']) ? $custom_css_arr['page_notification_popup_footer_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_footer_background_color" class="color-picker form-control" name="data[css][page_notification_popup_footer_background_color][value]" value="<?php echo $page_notification_popup_footer_background_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_footer_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_icon_color_value = isset($custom_css_arr['page_notification_popup_icon_color']['value']) ? $custom_css_arr['page_notification_popup_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_icon_color" class="color-picker form-control" name="data[css][page_notification_popup_icon_color][value]" value="<?php echo $page_notification_popup_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_icon_active_color_value = isset($custom_css_arr['page_notification_popup_icon_active_color']['value']) ? $custom_css_arr['page_notification_popup_icon_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_icon_active_color" class="color-picker form-control" name="data[css][page_notification_popup_icon_active_color][value]" value="<?php echo $page_notification_popup_icon_active_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_icon_active_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_popup_active_background_color_value = isset($custom_css_arr['page_notification_popup_active_background_color']['value']) ? $custom_css_arr['page_notification_popup_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_popup_active_background_color" class="color-picker form-control" name="data[css][page_notification_popup_active_background_color][value]" value="<?php echo $page_notification_popup_active_background_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_popup_active_background_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Messages/Notifications Page'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseNotiPage" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseNotiPage">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/notipage.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseNotiPage" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Subject Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_subject_text_color_value = isset($custom_css_arr['page_notification_subject_text_color']['value']) ? $custom_css_arr['page_notification_subject_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_subject_text_color" class="color-picker form-control" name="data[css][page_notification_subject_text_color][value]" value="<?php echo $page_notification_subject_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_subject_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Message Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_message_text_color_value = isset($custom_css_arr['page_notification_message_text_color']['value']) ? $custom_css_arr['page_notification_message_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_message_text_color" class="color-picker form-control" name="data[css][page_notification_message_text_color][value]" value="<?php echo $page_notification_message_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_message_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Date Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_date_text_color_value = isset($custom_css_arr['page_notification_date_text_color']['value']) ? $custom_css_arr['page_notification_date_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_date_text_color" class="color-picker form-control" name="data[css][page_notification_date_text_color][value]" value="<?php echo $page_notification_date_text_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_date_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_border_color_value = isset($custom_css_arr['page_notification_border_color']['value']) ? $custom_css_arr['page_notification_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_border_color" class="color-picker form-control" name="data[css][page_notification_border_color][value]" value="<?php echo $page_notification_border_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_icon_color_value = isset($custom_css_arr['page_notification_icon_color']['value']) ? $custom_css_arr['page_notification_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_icon_color" class="color-picker form-control" name="data[css][page_notification_icon_color][value]" value="<?php echo $page_notification_icon_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_icon_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Active Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_notification_icon_active_color_value = isset($custom_css_arr['page_notification_icon_active_color']['value']) ? $custom_css_arr['page_notification_icon_active_color']['value'] : '' ?>
                            <input type="text" id="frm-page_notification_icon_active_color" class="color-picker form-control" name="data[css][page_notification_icon_active_color][value]" value="<?php echo $page_notification_icon_active_color_value ?>">
                            <input type="hidden" name="data[css][page_notification_icon_active_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="more-setting">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Emoji'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseEmoji" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseEmoji">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/emoji.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseEmoji" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $emoji_dropdown_background_color_value = isset($custom_css_arr['emoji_dropdown_background_color']['value']) ? $custom_css_arr['emoji_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-emoji_dropdown_background_color" class="color-picker form-control" name="data[css][emoji_dropdown_background_color][value]" value="<?php echo $emoji_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][emoji_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Option Dropdown'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseOptionDropdown" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseOptionDropdown">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/optiondropdown.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseOptionDropdown" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_option_dropdown_background_color_value = isset($custom_css_arr['page_option_dropdown_background_color']['value']) ? $custom_css_arr['page_option_dropdown_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_option_dropdown_background_color" class="color-picker form-control" name="data[css][page_option_dropdown_background_color][value]" value="<?php echo $page_option_dropdown_background_color_value ?>">
                            <input type="hidden" name="data[css][page_option_dropdown_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_option_dropdown_text_color_value = isset($custom_css_arr['page_option_dropdown_text_color']['value']) ? $custom_css_arr['page_option_dropdown_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_option_dropdown_text_color" class="color-picker form-control" name="data[css][page_option_dropdown_text_color][value]" value="<?php echo $page_option_dropdown_text_color_value ?>">
                            <input type="hidden" name="data[css][page_option_dropdown_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Hover Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_option_dropdown_hover_background_color_value = isset($custom_css_arr['page_option_dropdown_hover_background_color']['value']) ? $custom_css_arr['page_option_dropdown_hover_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_option_dropdown_hover_background_color" class="color-picker form-control" name="data[css][page_option_dropdown_hover_background_color][value]" value="<?php echo $page_option_dropdown_hover_background_color_value ?>">
                            <input type="hidden" name="data[css][page_option_dropdown_hover_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Hover Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_option_dropdown_hover_text_color_value = isset($custom_css_arr['page_option_dropdown_hover_text_color']['value']) ? $custom_css_arr['page_option_dropdown_hover_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_option_dropdown_hover_text_color" class="color-picker form-control" name="data[css][page_option_dropdown_hover_text_color][value]" value="<?php echo $page_option_dropdown_hover_text_color_value ?>">
                            <input type="hidden" name="data[css][page_option_dropdown_hover_text_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('User Tooltip'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseUserTooltip" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseUserTooltip">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/usertooltip.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseUserTooltip" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_tooltip_background_color_value = isset($custom_css_arr['page_user_tooltip_background_color']['value']) ? $custom_css_arr['page_user_tooltip_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_tooltip_background_color" class="color-picker form-control" name="data[css][page_user_tooltip_background_color][value]" value="<?php echo $page_user_tooltip_background_color_value ?>">
                            <input type="hidden" name="data[css][page_user_tooltip_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_tooltip_text_color_value = isset($custom_css_arr['page_user_tooltip_text_color']['value']) ? $custom_css_arr['page_user_tooltip_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_tooltip_text_color" class="color-picker form-control" name="data[css][page_user_tooltip_text_color][value]" value="<?php echo $page_user_tooltip_text_color_value ?>">
                            <input type="hidden" name="data[css][page_user_tooltip_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_tooltip_button_background_color_value = isset($custom_css_arr['page_user_tooltip_button_background_color']['value']) ? $custom_css_arr['page_user_tooltip_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_tooltip_button_background_color" class="color-picker form-control" name="data[css][page_user_tooltip_button_background_color][value]" value="<?php echo $page_user_tooltip_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_user_tooltip_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_tooltip_button_border_color_value = isset($custom_css_arr['page_user_tooltip_button_border_color']['value']) ? $custom_css_arr['page_user_tooltip_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_tooltip_button_border_color" class="color-picker form-control" name="data[css][page_user_tooltip_button_border_color][value]" value="<?php echo $page_user_tooltip_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_user_tooltip_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_user_tooltip_button_text_color_value = isset($custom_css_arr['page_user_tooltip_button_text_color']['value']) ? $custom_css_arr['page_user_tooltip_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_user_tooltip_button_text_color" class="color-picker form-control" name="data[css][page_user_tooltip_button_text_color][value]" value="<?php echo $page_user_tooltip_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_user_tooltip_button_text_color][type]" value="color">
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Login Popup'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseLoginPopup" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseLoginPopup">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/loginpoup.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseLoginPopup" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_background_color_value = isset($custom_css_arr['page_login_popup_background_color']['value']) ? $custom_css_arr['page_login_popup_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_background_color" class="color-picker form-control" name="data[css][page_login_popup_background_color][value]" value="<?php echo $page_login_popup_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_text_color_value = isset($custom_css_arr['page_login_popup_text_color']['value']) ? $custom_css_arr['page_login_popup_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_text_color" class="color-picker form-control" name="data[css][page_login_popup_text_color][value]" value="<?php echo $page_login_popup_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_border_color_value = isset($custom_css_arr['page_login_popup_border_color']['value']) ? $custom_css_arr['page_login_popup_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_border_color" class="color-picker form-control" name="data[css][page_login_popup_border_color][value]" value="<?php echo $page_login_popup_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_input_border_color_value = isset($custom_css_arr['page_login_popup_input_border_color']['value']) ? $custom_css_arr['page_login_popup_input_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_input_border_color" class="color-picker form-control" name="data[css][page_login_popup_input_border_color][value]" value="<?php echo $page_login_popup_input_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_input_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_input_background_color_value = isset($custom_css_arr['page_login_popup_input_background_color']['value']) ? $custom_css_arr['page_login_popup_input_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_input_background_color" class="color-picker form-control" name="data[css][page_login_popup_input_background_color][value]" value="<?php echo $page_login_popup_input_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_input_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_input_text_color_value = isset($custom_css_arr['page_login_popup_input_text_color']['value']) ? $custom_css_arr['page_login_popup_input_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_input_text_color" class="color-picker form-control" name="data[css][page_login_popup_input_text_color][value]" value="<?php echo $page_login_popup_input_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_input_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_button_background_color_value = isset($custom_css_arr['page_login_popup_button_background_color']['value']) ? $custom_css_arr['page_login_popup_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_button_background_color" class="color-picker form-control" name="data[css][page_login_popup_button_background_color][value]" value="<?php echo $page_login_popup_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_button_border_color_value = isset($custom_css_arr['page_login_popup_button_border_color']['value']) ? $custom_css_arr['page_login_popup_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_button_border_color" class="color-picker form-control" name="data[css][page_login_popup_button_border_color][value]" value="<?php echo $page_login_popup_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_popup_button_text_color_value = isset($custom_css_arr['page_login_popup_button_text_color']['value']) ? $custom_css_arr['page_login_popup_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_popup_button_text_color" class="color-picker form-control" name="data[css][page_login_popup_button_text_color][value]" value="<?php echo $page_login_popup_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_popup_button_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Register Page'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseRegisterPage" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseRegisterPage">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/registerpage.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseRegisterPage" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_border_color_value = isset($custom_css_arr['page_register_border_color']['value']) ? $custom_css_arr['page_register_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_border_color" class="color-picker form-control" name="data[css][page_register_border_color][value]" value="<?php echo $page_register_border_color_value ?>">
                            <input type="hidden" name="data[css][page_register_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_background_color_value = isset($custom_css_arr['page_register_background_color']['value']) ? $custom_css_arr['page_register_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_background_color" class="color-picker form-control" name="data[css][page_register_background_color][value]" value="<?php echo $page_register_background_color_value ?>">
                            <input type="hidden" name="data[css][page_register_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_header_text_color_value = isset($custom_css_arr['page_register_header_text_color']['value']) ? $custom_css_arr['page_register_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_header_text_color" class="color-picker form-control" name="data[css][page_register_header_text_color][value]" value="<?php echo $page_register_header_text_color_value ?>">
                            <input type="hidden" name="data[css][page_register_header_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_header_border_color_value = isset($custom_css_arr['page_register_header_border_color']['value']) ? $custom_css_arr['page_register_header_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_header_border_color" class="color-picker form-control" name="data[css][page_register_header_border_color][value]" value="<?php echo $page_register_header_border_color_value ?>">
                            <input type="hidden" name="data[css][page_register_header_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_text_color_value = isset($custom_css_arr['page_register_text_color']['value']) ? $custom_css_arr['page_register_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_text_color" class="color-picker form-control" name="data[css][page_register_text_color][value]" value="<?php echo $page_register_text_color_value ?>">
                            <input type="hidden" name="data[css][page_register_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_input_border_color_value = isset($custom_css_arr['page_register_input_border_color']['value']) ? $custom_css_arr['page_register_input_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_input_border_color" class="color-picker form-control" name="data[css][page_register_input_border_color][value]" value="<?php echo $page_register_input_border_color_value ?>">
                            <input type="hidden" name="data[css][page_register_input_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_input_background_color_value = isset($custom_css_arr['page_register_input_background_color']['value']) ? $custom_css_arr['page_register_input_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_input_background_color" class="color-picker form-control" name="data[css][page_register_input_background_color][value]" value="<?php echo $page_register_input_background_color_value ?>">
                            <input type="hidden" name="data[css][page_register_input_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_input_text_color_value = isset($custom_css_arr['page_register_input_text_color']['value']) ? $custom_css_arr['page_register_input_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_input_text_color" class="color-picker form-control" name="data[css][page_register_input_text_color][value]" value="<?php echo $page_register_input_text_color_value ?>">
                            <input type="hidden" name="data[css][page_register_input_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_button_background_color_value = isset($custom_css_arr['page_register_button_background_color']['value']) ? $custom_css_arr['page_register_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_button_background_color" class="color-picker form-control" name="data[css][page_register_button_background_color][value]" value="<?php echo $page_register_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_register_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_button_border_color_value = isset($custom_css_arr['page_register_button_border_color']['value']) ? $custom_css_arr['page_register_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_button_border_color" class="color-picker form-control" name="data[css][page_register_button_border_color][value]" value="<?php echo $page_register_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_register_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_button_text_color_value = isset($custom_css_arr['page_register_button_text_color']['value']) ? $custom_css_arr['page_register_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_button_text_color" class="color-picker form-control" name="data[css][page_register_button_text_color][value]" value="<?php echo $page_register_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_register_button_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Social Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_social_background_color_value = isset($custom_css_arr['page_register_social_background_color']['value']) ? $custom_css_arr['page_register_social_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_social_background_color" class="color-picker form-control" name="data[css][page_register_social_background_color][value]" value="<?php echo $page_register_social_background_color_value ?>">
                            <input type="hidden" name="data[css][page_register_social_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Social Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_register_social_text_color_value = isset($custom_css_arr['page_register_social_text_color']['value']) ? $custom_css_arr['page_register_social_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_register_social_text_color" class="color-picker form-control" name="data[css][page_register_social_text_color][value]" value="<?php echo $page_register_social_text_color_value ?>">
                            <input type="hidden" name="data[css][page_register_social_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Login Page'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseLoginPage" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseLoginPage">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/loginpage.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseLoginPage" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_background_color_value = isset($custom_css_arr['page_login_background_color']['value']) ? $custom_css_arr['page_login_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_background_color" class="color-picker form-control" name="data[css][page_login_background_color][value]" value="<?php echo $page_login_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_border_color_value = isset($custom_css_arr['page_login_border_color']['value']) ? $custom_css_arr['page_login_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_border_color" class="color-picker form-control" name="data[css][page_login_border_color][value]" value="<?php echo $page_login_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_text_color_value = isset($custom_css_arr['page_login_text_color']['value']) ? $custom_css_arr['page_login_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_text_color" class="color-picker form-control" name="data[css][page_login_text_color][value]" value="<?php echo $page_login_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_input_border_color_value = isset($custom_css_arr['page_login_input_border_color']['value']) ? $custom_css_arr['page_login_input_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_input_border_color" class="color-picker form-control" name="data[css][page_login_input_border_color][value]" value="<?php echo $page_login_input_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_input_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_input_background_color_value = isset($custom_css_arr['page_login_input_background_color']['value']) ? $custom_css_arr['page_login_input_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_input_background_color" class="color-picker form-control" name="data[css][page_login_input_background_color][value]" value="<?php echo $page_login_input_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_input_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Input Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_input_text_color_value = isset($custom_css_arr['page_login_input_text_color']['value']) ? $custom_css_arr['page_login_input_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_input_text_color" class="color-picker form-control" name="data[css][page_login_input_text_color][value]" value="<?php echo $page_login_input_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_input_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_button_background_color_value = isset($custom_css_arr['page_login_button_background_color']['value']) ? $custom_css_arr['page_login_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_button_background_color" class="color-picker form-control" name="data[css][page_login_button_background_color][value]" value="<?php echo $page_login_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_login_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_button_border_color_value = isset($custom_css_arr['page_login_button_border_color']['value']) ? $custom_css_arr['page_login_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_button_border_color" class="color-picker form-control" name="data[css][page_login_button_border_color][value]" value="<?php echo $page_login_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_login_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_login_button_text_color_value = isset($custom_css_arr['page_login_button_text_color']['value']) ? $custom_css_arr['page_login_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_login_button_text_color" class="color-picker form-control" name="data[css][page_login_button_text_color][value]" value="<?php echo $page_login_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_login_button_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Close Network Sign up'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseCloseNetwork" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseCloseNetwork">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/closenetwork.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseCloseNetwork" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Content'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text 1 Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_text_1_color_value = isset($custom_css_arr['page_closenetworksignup_text_1_color']['value']) ? $custom_css_arr['page_closenetworksignup_text_1_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_text_1_color" class="color-picker form-control" name="data[css][page_closenetworksignup_text_1_color][value]" value="<?php echo $page_closenetworksignup_text_1_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_text_1_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text 2 Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_text_2_color_value = isset($custom_css_arr['page_closenetworksignup_text_2_color']['value']) ? $custom_css_arr['page_closenetworksignup_text_2_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_text_2_color" class="color-picker form-control" name="data[css][page_closenetworksignup_text_2_color][value]" value="<?php echo $page_closenetworksignup_text_2_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_text_2_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text 3 Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_text_3_color_value = isset($custom_css_arr['page_closenetworksignup_text_3_color']['value']) ? $custom_css_arr['page_closenetworksignup_text_3_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_text_3_color" class="color-picker form-control" name="data[css][page_closenetworksignup_text_3_color][value]" value="<?php echo $page_closenetworksignup_text_3_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_text_3_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"><?php echo __('Register Form'); ?></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_border_color_value = isset($custom_css_arr['page_closenetworksignup_border_color']['value']) ? $custom_css_arr['page_closenetworksignup_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_border_color" class="color-picker form-control" name="data[css][page_closenetworksignup_border_color][value]" value="<?php echo $page_closenetworksignup_border_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_background_color_value = isset($custom_css_arr['page_closenetworksignup_background_color']['value']) ? $custom_css_arr['page_closenetworksignup_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_background_color" class="color-picker form-control" name="data[css][page_closenetworksignup_background_color][value]" value="<?php echo $page_closenetworksignup_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_header_text_color_value = isset($custom_css_arr['page_closenetworksignup_header_text_color']['value']) ? $custom_css_arr['page_closenetworksignup_header_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_header_text_color" class="color-picker form-control" name="data[css][page_closenetworksignup_header_text_color][value]" value="<?php echo $page_closenetworksignup_header_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_header_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_text_color_value = isset($custom_css_arr['page_closenetworksignup_text_color']['value']) ? $custom_css_arr['page_closenetworksignup_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_text_color" class="color-picker form-control" name="data[css][page_closenetworksignup_text_color][value]" value="<?php echo $page_closenetworksignup_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Input Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_input_border_color_value = isset($custom_css_arr['page_closenetworksignup_input_border_color']['value']) ? $custom_css_arr['page_closenetworksignup_input_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_input_border_color" class="color-picker form-control" name="data[css][page_closenetworksignup_input_border_color][value]" value="<?php echo $page_closenetworksignup_input_border_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_input_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Input Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_input_background_color_value = isset($custom_css_arr['page_closenetworksignup_input_background_color']['value']) ? $custom_css_arr['page_closenetworksignup_input_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_input_background_color" class="color-picker form-control" name="data[css][page_closenetworksignup_input_background_color][value]" value="<?php echo $page_closenetworksignup_input_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_input_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Input Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_input_text_color_value = isset($custom_css_arr['page_closenetworksignup_input_text_color']['value']) ? $custom_css_arr['page_closenetworksignup_input_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_input_text_color" class="color-picker form-control" name="data[css][page_closenetworksignup_input_text_color][value]" value="<?php echo $page_closenetworksignup_input_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_input_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_button_background_color_value = isset($custom_css_arr['page_closenetworksignup_button_background_color']['value']) ? $custom_css_arr['page_closenetworksignup_button_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_button_background_color" class="color-picker form-control" name="data[css][page_closenetworksignup_button_background_color][value]" value="<?php echo $page_closenetworksignup_button_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_button_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_button_border_color_value = isset($custom_css_arr['page_closenetworksignup_button_border_color']['value']) ? $custom_css_arr['page_closenetworksignup_button_border_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_button_border_color" class="color-picker form-control" name="data[css][page_closenetworksignup_button_border_color][value]" value="<?php echo $page_closenetworksignup_button_border_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_button_border_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_button_text_color_value = isset($custom_css_arr['page_closenetworksignup_button_text_color']['value']) ? $custom_css_arr['page_closenetworksignup_button_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_button_text_color" class="color-picker form-control" name="data[css][page_closenetworksignup_button_text_color][value]" value="<?php echo $page_closenetworksignup_button_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_button_text_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Social Background Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_social_background_color_value = isset($custom_css_arr['page_closenetworksignup_social_background_color']['value']) ? $custom_css_arr['page_closenetworksignup_social_background_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_social_background_color" class="color-picker form-control" name="data[css][page_closenetworksignup_social_background_color][value]" value="<?php echo $page_closenetworksignup_social_background_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_social_background_color][type]" value="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo __('Social Text Color'); ?></label>
                                <div class="col-md-7">
                                    <?php $page_closenetworksignup_social_text_color_value = isset($custom_css_arr['page_closenetworksignup_social_text_color']['value']) ? $custom_css_arr['page_closenetworksignup_social_text_color']['value'] : '' ?>
                                    <input type="text" id="frm-page_closenetworksignup_social_text_color" class="color-picker form-control" name="data[css][page_closenetworksignup_social_text_color][value]" value="<?php echo $page_closenetworksignup_social_text_color_value ?>">
                                    <input type="hidden" name="data[css][page_closenetworksignup_social_text_color][type]" value="color">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Tags'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseTags" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseTags">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/tags.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseTags" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_tag_background_color_value = isset($custom_css_arr['page_tag_background_color']['value']) ? $custom_css_arr['page_tag_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_tag_background_color" class="color-picker form-control" name="data[css][page_tag_background_color][value]" value="<?php echo $page_tag_background_color_value ?>">
                            <input type="hidden" name="data[css][page_tag_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_tag_border_color_value = isset($custom_css_arr['page_tag_border_color']['value']) ? $custom_css_arr['page_tag_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_tag_border_color" class="color-picker form-control" name="data[css][page_tag_border_color][value]" value="<?php echo $page_tag_border_color_value ?>">
                            <input type="hidden" name="data[css][page_tag_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_tag_text_color_value = isset($custom_css_arr['page_tag_text_color']['value']) ? $custom_css_arr['page_tag_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_tag_text_color" class="color-picker form-control" name="data[css][page_tag_text_color][value]" value="<?php echo $page_tag_text_color_value ?>">
                            <input type="hidden" name="data[css][page_tag_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Cookies'); ?>
                    <a class="panel-heading-review collapsed" href="#collapseCookies" data-toggle="collapse"><span class="material-icons">preview</span></a>
                </div>
                <div class="collapse panel-review" id="collapseCookies">
                    <img class="image-review" src="<?php echo $this->request->webroot ?>setting-review/cookies.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseCookies" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_cookies_background_color_value = isset($custom_css_arr['page_cookies_background_color']['value']) ? $custom_css_arr['page_cookies_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_cookies_background_color" class="color-picker form-control" name="data[css][page_cookies_background_color][value]" value="<?php echo $page_cookies_background_color_value ?>">
                            <input type="hidden" name="data[css][page_cookies_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_cookies_text_color_value = isset($custom_css_arr['page_cookies_text_color']['value']) ? $custom_css_arr['page_cookies_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_cookies_text_color" class="color-picker form-control" name="data[css][page_cookies_text_color][value]" value="<?php echo $page_cookies_text_color_value ?>">
                            <input type="hidden" name="data[css][page_cookies_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_cookies_button_background_color_value = isset($custom_css_arr['page_cookies_button_background_color']['value']) ? $custom_css_arr['page_cookies_button_background_color']['value'] : '' ?>
                            <input type="text" id="frm-page_cookies_button_background_color" class="color-picker form-control" name="data[css][page_cookies_button_background_color][value]" value="<?php echo $page_cookies_button_background_color_value ?>">
                            <input type="hidden" name="data[css][page_cookies_button_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_cookies_button_border_color_value = isset($custom_css_arr['page_cookies_button_border_color']['value']) ? $custom_css_arr['page_cookies_button_border_color']['value'] : '' ?>
                            <input type="text" id="frm-page_cookies_button_border_color" class="color-picker form-control" name="data[css][page_cookies_button_border_color][value]" value="<?php echo $page_cookies_button_border_color_value ?>">
                            <input type="hidden" name="data[css][page_cookies_button_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Button Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $page_cookies_button_text_color_value = isset($custom_css_arr['page_cookies_button_text_color']['value']) ? $custom_css_arr['page_cookies_button_text_color']['value'] : '' ?>
                            <input type="text" id="frm-page_cookies_button_text_color" class="color-picker form-control" name="data[css][page_cookies_button_text_color][value]" value="<?php echo $page_cookies_button_text_color_value ?>">
                            <input type="hidden" name="data[css][page_cookies_button_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Tab'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseTab" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseTab">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/tab.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseTab" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $tab_background_color_value = isset($custom_css_arr['tab_background_color']['value']) ? $custom_css_arr['tab_background_color']['value'] : '' ?>
                            <input type="text" id="frm-tab_background_color" class="color-picker form-control" name="data[css][tab_background_color][value]" value="<?php echo $tab_background_color_value ?>">
                            <input type="hidden" name="data[css][tab_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $tab_text_color_value = isset($custom_css_arr['tab_text_color']['value']) ? $custom_css_arr['tab_text_color']['value'] : '' ?>
                            <input type="text" id="frm-tab_text_color" class="color-picker form-control" name="data[css][tab_text_color][value]" value="<?php echo $tab_text_color_value ?>">
                            <input type="hidden" name="data[css][tab_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $tab_border_color_value = isset($custom_css_arr['tab_border_color']['value']) ? $custom_css_arr['tab_border_color']['value'] : '' ?>
                            <input type="text" id="frm-tab_border_color" class="color-picker form-control" name="data[css][tab_border_color][value]" value="<?php echo $tab_border_color_value ?>">
                            <input type="hidden" name="data[css][tab_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $tab_active_background_color_value = isset($custom_css_arr['tab_active_background_color']['value']) ? $custom_css_arr['tab_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-tab_active_background_color" class="color-picker form-control" name="data[css][tab_active_background_color][value]" value="<?php echo $tab_active_background_color_value ?>">
                            <input type="hidden" name="data[css][tab_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Active Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $tab_active_text_color_value = isset($custom_css_arr['tab_active_text_color']['value']) ? $custom_css_arr['tab_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-tab_active_text_color" class="color-picker form-control" name="data[css][tab_active_text_color][value]" value="<?php echo $tab_active_text_color_value ?>">
                            <input type="hidden" name="data[css][tab_active_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Table'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseTable" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseTable">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/table.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseTab" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_border_color_value = isset($custom_css_arr['table_border_color']['value']) ? $custom_css_arr['table_border_color']['value'] : '' ?>
                            <input type="text" id="frm-table_border_color" class="color-picker form-control" name="data[css][table_border_color][value]" value="<?php echo $table_border_color_value ?>">
                            <input type="hidden" name="data[css][table_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_background_color_value = isset($custom_css_arr['table_background_color']['value']) ? $custom_css_arr['table_background_color']['value'] : '' ?>
                            <input type="text" id="frm-table_background_color" class="color-picker form-control" name="data[css][table_background_color][value]" value="<?php echo $table_background_color_value ?>">
                            <input type="hidden" name="data[css][table_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_text_color_value = isset($custom_css_arr['table_text_color']['value']) ? $custom_css_arr['table_text_color']['value'] : '' ?>
                            <input type="text" id="frm-table_text_color" class="color-picker form-control" name="data[css][table_text_color][value]" value="<?php echo $table_text_color_value ?>">
                            <input type="hidden" name="data[css][table_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_header_background_color_value = isset($custom_css_arr['table_header_background_color']['value']) ? $custom_css_arr['table_header_background_color']['value'] : '' ?>
                            <input type="text" id="frm-table_header_background_color" class="color-picker form-control" name="data[css][table_header_background_color][value]" value="<?php echo $table_header_background_color_value ?>">
                            <input type="hidden" name="data[css][table_header_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Header Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_header_text_color_value = isset($custom_css_arr['table_header_text_color']['value']) ? $custom_css_arr['table_header_text_color']['value'] : '' ?>
                            <input type="text" id="frm-table_header_text_color" class="color-picker form-control" name="data[css][table_header_text_color][value]" value="<?php echo $table_header_text_color_value ?>">
                            <input type="hidden" name="data[css][table_header_text_color][type]" value="color">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Highlight Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_highlight_background_color_value = isset($custom_css_arr['table_highlight_background_color']['value']) ? $custom_css_arr['table_highlight_background_color']['value'] : '' ?>
                            <input type="text" id="frm-table_highlight_background_color" class="color-picker form-control" name="data[css][table_highlight_background_color][value]" value="<?php echo $table_highlight_background_color_value ?>">
                            <input type="hidden" name="data[css][table_highlight_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Highlight Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_highlight_text_color_value = isset($custom_css_arr['table_highlight_text_color']['value']) ? $custom_css_arr['table_highlight_text_color']['value'] : '' ?>
                            <input type="text" id="frm-table_highlight_text_color" class="color-picker form-control" name="data[css][table_highlight_text_color][value]" value="<?php echo $table_highlight_text_color_value ?>">
                            <input type="hidden" name="data[css][table_highlight_text_color][type]" value="color">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Hover Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_active_background_color_value = isset($custom_css_arr['table_active_background_color']['value']) ? $custom_css_arr['table_active_background_color']['value'] : '' ?>
                            <input type="text" id="frm-table_active_background_color" class="color-picker form-control" name="data[css][table_active_background_color][value]" value="<?php echo $table_active_background_color_value ?>">
                            <input type="hidden" name="data[css][table_active_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Hover Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $table_active_text_color_value = isset($custom_css_arr['table_active_text_color']['value']) ? $custom_css_arr['table_active_text_color']['value'] : '' ?>
                            <input type="text" id="frm-table_active_text_color" class="color-picker form-control" name="data[css][table_active_text_color][value]" value="<?php echo $table_active_text_color_value ?>">
                            <input type="hidden" name="data[css][table_active_text_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('List'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseTable" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseTable">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/table.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseTab" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $list_border_color_value = isset($custom_css_arr['list_border_color']['value']) ? $custom_css_arr['list_border_color']['value'] : '' ?>
                            <input type="text" id="frm-list_border_color" class="color-picker form-control" name="data[css][list_border_color][value]" value="<?php echo $list_border_color_value ?>">
                            <input type="hidden" name="data[css][list_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $list_background_color_value = isset($custom_css_arr['list_background_color']['value']) ? $custom_css_arr['list_background_color']['value'] : '' ?>
                            <input type="text" id="frm-list_background_color" class="color-picker form-control" name="data[css][list_background_color][value]" value="<?php echo $list_background_color_value ?>">
                            <input type="hidden" name="data[css][list_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $list_text_color_value = isset($custom_css_arr['list_text_color']['value']) ? $custom_css_arr['list_text_color']['value'] : '' ?>
                            <input type="text" id="frm-list_text_color" class="color-picker form-control" name="data[css][list_text_color][value]" value="<?php echo $list_text_color_value ?>">
                            <input type="hidden" name="data[css][list_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Icon Color'); ?></label>
                        <div class="col-md-7">
                            <?php $list_icon_color_value = isset($custom_css_arr['list_icon_color']['value']) ? $custom_css_arr['list_icon_color']['value'] : '' ?>
                            <input type="text" id="frm-list_icon_color" class="color-picker form-control" name="data[css][list_icon_color][value]" value="<?php echo $list_icon_color_value ?>">
                            <input type="hidden" name="data[css][list_icon_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <?php echo __('Paginator'); ?>
                    <!--<a class="panel-heading-review collapsed" href="#collapseTable" data-toggle="collapse"><span class="material-icons">preview</span></a>-->
                </div>
                <!--<div class="collapse panel-review" id="collapseTable">
                    <img class="image-review" src="<?php //echo $this->request->webroot ?>setting-review/table.png">
                    <div class="panel-review-close">
                        <a class="panel-review-link" href="#collapseTab" data-toggle="collapse"><span class="material-icons">close</span></a>
                    </div>
                </div>-->
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Border Color'); ?></label>
                        <div class="col-md-7">
                            <?php $paginator_border_color_value = isset($custom_css_arr['paginator_border_color']['value']) ? $custom_css_arr['paginator_border_color']['value'] : '' ?>
                            <input type="text" id="frm-paginator_border_color" class="color-picker form-control" name="data[css][paginator_border_color][value]" value="<?php echo $paginator_border_color_value ?>">
                            <input type="hidden" name="data[css][paginator_border_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $paginator_background_color_value = isset($custom_css_arr['paginator_background_color']['value']) ? $custom_css_arr['list_background_color']['value'] : '' ?>
                            <input type="text" id="frm-paginator_background_color" class="color-picker form-control" name="data[css][paginator_background_color][value]" value="<?php echo $paginator_background_color_value ?>">
                            <input type="hidden" name="data[css][paginator_background_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $paginator_text_color_value = isset($custom_css_arr['paginator_text_color']['value']) ? $custom_css_arr['paginator_text_color']['value'] : '' ?>
                            <input type="text" id="frm-paginator_text_color" class="color-picker form-control" name="data[css][paginator_text_color][value]" value="<?php echo $paginator_text_color_value ?>">
                            <input type="hidden" name="data[css][paginator_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Current Page Text Color'); ?></label>
                        <div class="col-md-7">
                            <?php $paginator_current_text_color_value = isset($custom_css_arr['paginator_current_text_color']['value']) ? $custom_css_arr['paginator_current_text_color']['value'] : '' ?>
                            <input type="text" id="frm-paginator_current_text_color" class="color-picker form-control" name="data[css][paginator_current_text_color][value]" value="<?php echo $paginator_current_text_color_value ?>">
                            <input type="hidden" name="data[css][paginator_current_text_color][type]" value="color">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo __('Current Page Background Color'); ?></label>
                        <div class="col-md-7">
                            <?php $paginator_current_background_color_value = isset($custom_css_arr['paginator_current_background_color']['value']) ? $custom_css_arr['paginator_current_background_color']['value'] : '' ?>
                            <input type="text" id="frm-paginator_current_background_color" class="color-picker form-control" name="data[css][paginator_current_background_color][value]" value="<?php echo $paginator_current_background_color_value ?>">
                            <input type="hidden" name="data[css][paginator_current_background_color][type]" value="color">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.adminThemeSetting.settingTabContent', $this, array())); ?>
    </div>
</div>