<div class="row">
    <?php if (!empty($is_profile_page)): ?>
    <div id="headerProfile" class="col-md-12">
        <?php echo $this->element('user/header_profile'); ?>
    </div>
    <?php endif; ?>
    <div id="center" class="col-md-12">
        <?php echo $center; ?>
    </div>
    <?php if( !$this->isEmpty('south') ): ?>
    <div id="south" class="col-md-12">
        <?php echo $south; ?>
    </div>
    <?php endif; ?>
</div>