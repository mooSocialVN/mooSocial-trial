<?php if(!empty($uid) || (!$this->isEmpty('east') && $this->isActive('east')) || (!$this->isEmpty('west') && $this->isActive('west')) ):  ?>
<div class="mobile-footer">
    <?php if( !$this->isEmpty('west') && $this->isActive('west') ): ?>
        <a class="mobile-footer-btn mobile-footer-left" href="#" data-target="#leftnav" data-toggle="sidebarModal">
            <span class="mobile-footer-icon material-icons moo-icon moo-icon-arrow_forward">arrow_forward</span>
        </a>
    <?php endif; ?>
    <?php if( !$this->isEmpty('east') && $this->isActive('east') ): ?>
        <a class="mobile-footer-btn mobile-footer-right" href="#" data-target="#right" data-toggle="sidebarModal">
            <span class="mobile-footer-icon material-icons moo-icon moo-icon-arrow_back">arrow_back</span>
        </a>
    <?php endif; ?>
 </div>
<?php endif; ?>