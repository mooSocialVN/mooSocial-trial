<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_content inner404">
            <h1 class="inner_header_title"><?php echo __('Access Denied');?></h1>
            <div class="inner_text">
                <?php
                $oHelper = MooCore::getInstance()->getHelper('Subscription_Subscription');
                if ($oHelper->checkEnableSubscription()) :
                    echo __('You do NOT have permission to access this page. Please <a href="%s">Upgrade</a> membership to continue.', $this->request->base . '/subscription/subscribes');
                else:
                    echo __('You do NOT have permission to access this page. Please contact your site administrator(s) request access.');
                endif;
                ?>
            </div>
        </div>
    </div>
</div>