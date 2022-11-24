<div class="row">
    <?php if( !$this->isEmpty('north') ): ?>
    <div id="north" class="col-md-12">
        <?php echo $north ;?>
    </div>
    <?php endif; ?>
    <?php if (!empty($is_profile_page)): ?>
    <div id="headerProfile" class="col-md-12">
       <?php echo $this->element('user/header_profile'); ?>
    </div>
    <?php endif; ?>
    <?php if( !$this->isEmpty('west') ): ?>
    <div id="leftnav" class="sl-rsp-modal sidebar-modal col-md-3">
        <div class="visible-xs visible-sm closeButton">
            <button type="button" class="close" data-dismiss="sidebarModal"><span class="closeButtonIcon material-icons moo-icon moo-icon-cancel">cancel</span></button>
        </div>
        <?php echo $west; ?>
    </div>
    <?php endif; ?>
    <?php if( !$this->isEmpty('east') ): ?>
    <div id="right" class="sl-rsp-modal sidebar-modal col-md-3">
        <div class="visible-xs visible-sm closeButton">
            <button type="button" class="close" data-dismiss="sidebarModal"><span class="closeButtonIcon material-icons moo-icon moo-icon-cancel">cancel</span></button>
        </div>
        <?php echo $east; ?>
    </div>
    <?php endif; ?>
    <div id="center" class="<?php if( !$this->isEmpty('east') &&  !$this->isEmpty('west') ): echo 'col-md-6'; elseif (($this->isEmpty('east') && !$this->isEmpty('west')) || (!$this->isEmpty('east') && $this->isEmpty('west'))): echo 'col-md-9'; else: echo 'col-md-12'; endif; ?>">
        <?php echo $center; ?>
    </div>
</div>