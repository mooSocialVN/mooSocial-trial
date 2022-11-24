<?php

if (isset($title_enable) && ($title_enable) === "") $title_enable = false; else $title_enable = true;
?>

<?php if (!$this->Moo->loggedIn()): ?>
    <div class="box2 bar-content-warp">
        <?php if ($title_enable): ?>
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo  __('Login') ?></h3>
                </div>
            </div>
        <?php endif; ?>
        <div class="box_content box_login box-region-<?php echo $region ?>">
            <?php echo $this->element('signin' ); ?>
        </div>
    </div>
<?php endif; ?>