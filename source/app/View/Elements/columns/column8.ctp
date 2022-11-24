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
    <div id="center" class="col-md-12">
        <?php echo $center; ?>
    </div>
</div>