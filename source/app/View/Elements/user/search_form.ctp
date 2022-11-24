<?php if (!Configure::read('core.guest_search') && empty($uid)): ?>
<?php else: ?>
    <div class="box2 bar-content-warp search-friend">
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __('Search') ?></h3>
            </div>
        </div>
        <div class="box_content">
            <form id="filters" method="">
                <div class="form-group">
                    <label for="name"><?php echo __('Name') ?></label>
                    <?php echo $this->Form->text('name', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <label><?php echo __('Email') ?></label>
                    <?php echo $this->Form->text('email', array('class' => 'form-control')); ?>
                </div>
                <div class="form-group">
                    <label><?php echo __('Gender') ?></label>
                    <?php echo $this->Form->select('gender', $this->Moo->getGenderList(), array('multiple' => 'multiple', 'class' => 'form-control multi')); ?>
                </div>
                <?php if (Configure::read('core.show_about_search')):?>
                    <div class="form-group">
                        <label><?php echo __('About') ?></label>
                        <?php echo $this->Form->textarea('about',array('value'=>$about, 'class' => 'form-control')); ?>
                    </div>
                <?php endif;?>
                <?php echo $this->element('custom_fields',array('is_search'=>true, 'custom_field_for' => 'custom_field_search_form')); ?>
                <div class="form-group">
                    <label class="checkbox-control">
                        <?php echo __('Profile Picture') ?>
                        <?php echo $this->Form->checkbox('picture'); ?>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="checkbox-control">
                        <?php echo __('Online Users') ?>
                        <?php
                        if (!empty($online_filter))
                            echo $this->Form->checkbox('online', array('checked' => true));
                        else
                            echo $this->Form->checkbox('online');
                        ?>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.User.searchForm.afterRender', $this)); ?>
                <input id="searchPeople" class="btn btn-primary" type="button" value="<?php echo __('Search') ?>">
            </form>
        </div>
    </div>
<?php endif; ?>