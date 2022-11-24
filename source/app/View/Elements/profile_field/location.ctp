<?php
    $countryModel = MooCore::getInstance()->getModel("Country");
    $countries = $countryModel->find('all',array(
        'conditions' => array(
            'enable' => true
        )
    ));
    $options = array();
    foreach ($countries as $country)
    {
        $options[$country['Country']['id']] = $country['Country']['name'];
    }

    $user_country = null;
    $userCountryModel = MooCore::getInstance()->getModel("UserCountry");
    $country_id = 0;
    $state_id = 0;
    $city_id = 0;
    $option_state = array();
    $option_city = array();
    $address = '';
    $zip = '';
    $is_search = isset($is_search) ? $is_search : null;
    if ($is_search)
    {
        if (isset($this->request->params['named']['country_id']))
            $country_id = $this->request->params['named']['country_id'];

        if (isset($this->request->params['named']['state_id']))
            $state_id = $this->request->params['named']['state_id'];
        
        if (isset($this->request->params['named']['city_id']))
        	$city_id = $this->request->params['named']['city_id'];
    }

    if (isset($user_edit_id) && $user_edit_id)
    {
        $user_country = $userCountryModel->find('first',array(
            'conditions'=>array('user_id' => $user_edit_id)
        ));
        if ($user_country) {
            $country_id = $user_country['UserCountry']['country_id'];
            $state_id = $user_country['UserCountry']['state_id'];
            $city_id= $user_country['UserCountry']['city_id'];
            $address = $user_country['UserCountry']['address'];
            $zip = $user_country['UserCountry']['zip'];
        }
    }

    if (count($options) == 1)
    {
        $country_id = array_key_first($options);
    }
    
    if ($country_id)
    {
        $stateModel = MooCore::getInstance()->getModel("State");
        $states = $stateModel->find('all',array(
            'conditions'=>array(
                'country_id'=>$country_id,
                'State.enable' => true
            )            
        ));

        foreach ($states as $state)
        {
            $option_state[$state['State']['id']] = $state['State']['name'];
        }
        
        if (count($option_state) == 1)
        {
            $state_id = array_key_first($option_state);
        }

        if ($state_id)
        {
        	$cityModel = MooCore::getInstance()->getModel("City");
        	$cities = $cityModel->find('all',array(
        		'conditions'=>array('state_id'=>$state_id,'City.enable' => true)
        	));
        	
        	foreach ($cities as $city)
        	{
        		$option_city[$city['City']['id']] = $city['City']['name'];
        	}

            if (count($option_city) == 1)
            {
                $city_id = array_key_first($option_city);
            }
        }
    }
    
    if( isset($form_type) && $form_type == 'horizontal' ){
        $form_style_type = 'horizontal';
    }else{
        $form_style_type = '';
    }
?>
<?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooUser"], function($,mooUser) {
            mooUser.initOnSignupStep1FieldCountry();
        });
    </script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
    mooUser.initOnSignupStep1FieldCountry();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div class="form-group" style="<?php if (count($options) == 1) echo 'display:none;' ?>">

    <label class="<?php if( $form_style_type == 'horizontal' ): ?>col-sm-3 control-label<?php endif; ?>">
        <?php echo __('Country'); ?>
        <?php if ( !empty( $show_require ) && $field['ProfileField']['required'] )
            echo '<span class="profile-tip"> *</span>';
        ?>
    </label>
    <?php if( $form_style_type == 'horizontal' ): ?>
    <div class="col-sm-9">
    <?php endif; ?>
    <?php echo $this->Form->select( 'country_id', $options, array( 'value'=>$country_id,'class' => 'form-control') ); ?>
    <?php if( $form_style_type == 'horizontal' ): ?>
    </div>
    <?php endif; ?>
</div>

<div class="form-group country_state" style="<?php if (!$country_id || !count($option_state) || count($option_state) == 1) echo 'display:none;' ?>">
    <label class="<?php if( $form_style_type == 'horizontal' ): ?>col-sm-3 control-label<?php endif; ?>">
        <?php echo __('State/Province'); ?>
    </label>
    <?php if( $form_style_type == 'horizontal' ): ?>
    <div class="col-sm-9">
    <?php endif; ?>
    <?php echo $this->Form->select( 'state_id', $option_state, array( 'value'=>$state_id,'class' => 'form-control') ); ?>
    <?php if( $form_style_type == 'horizontal' ): ?>
    </div>
    <?php endif; ?>
</div>

<div class="form-group country_city" style="<?php if (!$state_id || !count($option_city) || count($option_city) == 1) echo 'display:none;' ?>">
    <label class="<?php if( $form_style_type == 'horizontal' ): ?>col-sm-3 control-label<?php endif;?>">
        <?php echo __('City'); ?>
    </label>
    <?php if( $form_style_type == 'horizontal' ): ?>
    <div class="col-sm-9">
    <?php endif; ?>
        <?php echo $this->Form->select( 'city_id', $option_city, array( 'value'=>$city_id,'class' => 'form-control') ); ?>
        <?php if( $form_style_type == 'horizontal' ): ?>
    </div>
    <?php endif; ?>
</div>

<div class="form-group">
    <label class="<?php if( $form_style_type == 'horizontal' ): ?>col-sm-3 control-label<?php endif; ?>">
    	<?php echo __('Address'); ?>
	</label>
    <?php if( $form_style_type == 'horizontal' ): ?>
    <div class="col-sm-9">
    <?php endif; ?>
    <?php echo $this->Form->text( 'address', array( 'value'=>$address,'class' => 'form-control') ); ?>
    <?php if( $form_style_type == 'horizontal' ): ?>
    </div>
    <?php endif; ?>
</div>
<div class="form-group">
    <label class="<?php if( $form_style_type == 'horizontal' ): ?>col-sm-3 control-label<?php endif; ?>">
        <?php echo __('Zip/Postal Code'); ?>
    </label>
    <?php if( $form_style_type == 'horizontal' ): ?>
    <div class="col-sm-9">
    <?php endif; ?>
    <?php echo $this->Form->text( 'zip', array( 'value'=>$zip,'class' => 'form-control') ); ?>
    <?php if( $form_style_type == 'horizontal' ): ?>
    </div>
    <?php endif; ?>
</div>