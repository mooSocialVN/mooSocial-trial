<div id="footer">
    <?php echo html_entity_decode( Configure::read('core.footer_code') )?>
    <?php if (Configure::read('core.show_credit')): ?>
    <span class="date"><?php echo __('Powered by')?> <a href="http://www.moosocial.com" target="_blank">mooSocial <?php echo Configure::read('core.version')?></a></span>
    <?php endif; ?>
</div>