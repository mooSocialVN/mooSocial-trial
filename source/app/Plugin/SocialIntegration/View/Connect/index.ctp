<div class="bar-content full_content p_m_10">
    <div class="content_center">
        <div class="mo_breadcrumb">
            <h1> <?php echo  __('Social Connect') ?></h1>
        </div>
        <div class="">
            <?php foreach ($providers as $key => $provider): ?>
                <?php if ($this->Moo->socialIntegrationEnable($provider['provider'])): ?>
                    <div>
                        <span><?php echo  ucfirst($provider['provider']); ?></span>
                        <?php if ($provider['connect']): ?>
                            <a href="<?php echo  $this->Html->url(array('plugin' => 'social_integration', 'controller' => 'auths', 'action' => 'disconnect', 'provider' => $provider['provider'], 'sync' => 1)) ?>"><?php echo  __('Disconnect') ?></a>
                        <?php else: ?>
                            <span class="buttonText">
                                <a href="<?php echo  $this->Html->url(array('plugin' => 'social_integration', 'controller' => 'auths', 'action' => 'login', 'provider' => $provider['provider'], 'sync' => 1)) ?>"><?php echo  __('Connect') ?></a>
                            </span>
                            <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>