
<?php if (Configure::read('core.select_language') || Configure::read('core.select_theme')): ?>
    <div class="box2 bar-content-warp">
        <!--<div class="box_header visible-xs visible-sm">
            <div class="box_header_main">
                <h3 class="box_header_title">
                    <?php //echo  __('Theme') ?>
                </h3>
            </div>
        </div>-->
        <div class="box_content languagebox">
            <div class="select-template-warp">
                <?php if (Configure::read('core.select_language')): ?>
                    <div class="select-lang">
                        <?php echo  __('Language') ?>: <a href="<?php echo  $this->request->base ?>/home/ajax_lang" data-dismiss="sidebarModal" data-target="#langModal" data-toggle="modal" title="<?php echo  __('Language') ?>"><?php echo  (!empty($site_langs[Configure::read('Config.language')])) ? $site_langs[Configure::read('Config.language')] : __('Change') ?></a>
                    </div>
                <?php endif; ?>
                <?php //if(empty($isMobile)): ?>
                    <?php if (Configure::read('core.select_theme')): ?>
                        <div class="select-theme">
                            <?php echo  __('Theme') ?>: <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "home",
                                            "action" => "ajax_theme",
                                            "plugin" => false,
                                            
                                        )),
             'title' => __('Theme'),
             'innerHtml'=>   (!empty($site_themes[$this->theme])) ? $site_themes[$this->theme] : __('Change'),
             'data-dismiss' => "sidebarModal"
     ));
 ?>
                        </div>
                    <?php endif; ?>
                <?php //endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>