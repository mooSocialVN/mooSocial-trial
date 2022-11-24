
<?php if (Configure::read('core.select_language') || Configure::read('core.select_theme')): ?>
    <div class="box2 languagebox">
        <h3 class='visible-xs visible-sm'><?php echo  __('Theme') ?> </h3>

        <div class="box_content">
            <ul>

                <?php if (Configure::read('core.select_language')): ?>
                    <li>
                        <?php echo  __('Language') ?>: <a href="<?php echo  $this->request->base ?>/home/ajax_lang"
                                                  data-target="#langModal" data-toggle="modal"
                                                  title="<?php echo  __('Language') ?>"><?php echo  (!empty($site_langs[Configure::read('Config.language')])) ? $site_langs[Configure::read('Config.language')] : __('Change') ?></a><br/>
                    </li>
                <?php endif; ?>
                <?php //if(empty($isMobile)): ?>
                    <?php if (Configure::read('core.select_theme')): ?>
                        <li>
                            <?php echo  __('Theme') ?>: <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "home",
                                            "action" => "ajax_theme",
                                            "plugin" => false,
                                            
                                        )),
             'title' =>  __('Theme'),
             'innerHtml'=> (!empty($site_themes[$this->theme])) ? $site_themes[$this->theme] : __('Change'),
     ));
 ?>
                        </li>
                    <?php endif; ?>
                <?php //endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>