<?php if ( !isset( $this->request->params['admin'] ) && empty($no_right_column) ): ?>
    <div id="right" class="col-md-2">
        
        <br />

        <?php if ( Configure::read('core.select_language') ): ?>
            <?php echo __('Language')?>: <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "home",
                                            "action" => "ajax_lang",
                                            "plugin" => false,
                                           
                                        )),
             'title' =>  __('Language'),
             'innerHtml'=> (!empty($site_langs[Configure::read('Config.language')])) ? $site_langs[Configure::read('Config.language')] : __('Change'),
     ));
 ?><br />
        <?php endif; ?>

        <?php if ( Configure::read('core.select_theme') ): ?>
            <?php echo __('Theme')?>: <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "home",
                                            "action" => "ajax_theme",
                                            "plugin" => false,
                                           
                                        )),
             'title' => __('Theme'),
             'innerHtml'=> (!empty($site_themes[$this->theme])) ? $site_themes[$this->theme] : __('Change'),
     ));
 ?>
        <?php endif; ?>
    </div>
<?php endif; ?>