<div id="footer">
    <div class="container footer_container">
        <div class="footer-menu">
            <?php $this->doLoadingFooter();?>
        </div>
        <?php echo html_entity_decode( Configure::read('core.footer_code') )?>

        <span class="copyright">
      	<?php echo __('Copyright © %s %s. All rights reserved',date("Y"),Configure::read('core.site_name'));?>
    </span>
        <?php if (Configure::read('core.select_language') || Configure::read('core.select_theme')): ?>
            <?php if (Configure::read('core.select_language')): ?>

                &nbsp;.&nbsp;
                <a href="<?php echo  $this->request->base ?>/home/ajax_lang"
                   data-target="#langModal" data-toggle="modal"
                   title="<?php echo  __('Language') ?>">
                    <?php echo  (!empty($site_langs[Configure::read('Config.language')])) ? $site_langs[Configure::read('Config.language')] : __('Change') ?>
                </a>

            <?php endif; ?>
            <?php if(empty($isMobile)): ?>

                <?php if (Configure::read('core.select_theme')): ?>
                    <?php if (Configure::read('core.select_language')): ?>&nbsp;.&nbsp;<?php endif; ?>
                    <?php
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
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>