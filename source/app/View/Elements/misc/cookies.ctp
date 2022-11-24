<?php
    $cookies_warning = Configure::read('core.enable_cookies');
    $deny_url = Configure::read('core.deny_url');
?>
<?php if($cookies_warning && $deny_url && empty($accepted_cookie)): ?>
    <div id="cookies-warning" class="cookies-warning">
        <div class="container">
            <div class="cookies-header">
                <?php echo __('Cookies on %s.',Configure::read('core.site_name'));?>
            </div>
            <div class="cookies-content">
                <?php echo __('This site uses cookies to store your information on your computer.') ?>
            </div>
            <div class="cookies-action">
                <a class="btn btn-cs btn-cookies" target="_blank" href="<?php echo $deny_url;?>">
                <span class="btn-cs-main">
                    <span class="btn-text"><?php echo __('Read more'); ?></span>
                    <span class="btn-icon material-icons moo-icon moo-icon-east">east</span>
                </span>
                </a>
                <a class="btn btn-cs btn-cookies accept-cookie" href="javascript:void(0);" data-answer="1">
                <span class="btn-cs-main">
                    <span class="btn-text"><?php echo __('Accept'); ?></span>
                    <span class="btn-icon material-icons moo-icon moo-icon-done">done</span>
                </span>
                </a>
                <a class="btn btn-cs btn-cookies accept-cookie" href="javascript:void(0);" data-answer="2" style="display: none;">
                <span class="btn-cs-main">
                    <span class="btn-text"><?php echo __('Deny'); ?></span>
                    <span class="btn-icon material-icons moo-icon moo-icon-remove">remove</span>
                </span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>