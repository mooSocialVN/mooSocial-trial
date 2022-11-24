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
        }
    }
?>

<?php if($this->request->is('ajax')): ?>
	<script>
<?php else: ?>
	<?php $this->Html->scriptStart(array('inline' => false)); ?>
<?php endif;?>
$('#country_id').unbind('change');
        $('#country_id').change(function(){
            $('.country_state').hide();
            $('.country_city').hide();
            $('#state_id').html("<option value=''></option>");
            $('#city_id').html("<option value=''></option>");
            if ($('#country').val() != '') {
                $.getJSON(mooConfig.url.base + "/countries/ajax_get_state/" + $('#country_id').val(), function (result) {
                    if (result.count > 0)
                    {
                        $('.country_state').show();                        
                        $.each(result.data, function(field){
                            $('#state_id').append("<option value='"+result.data[field].id+"'>" + result.data[field].name + "</option>");
                        });
                    }
                });
            }
        });
        
        $('#state_id').unbind('change');
        $('#state_id').change(function(){
            $('.country_city').hide();
            $('#city_id').html("<option value=''></option>");
            if ($('#state_id').val() != '') {
                $.getJSON(mooConfig.url.base + "/countries/ajax_get_city/" + $('#state_id').val(), function (result) {
                    if (result.count > 0)
                    {
                        $('.country_city').show();                        
                        $.each(result.data, function(field){
                            $('#city_id').append("<option value='"+result.data[field].id+"'>" + result.data[field].name + "</option>");
                        });
                    }
                });
            }
        });
<?php if($this->request->is('ajax')): ?>
	</script>
<?php else: ?>
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div class="form-group">
    <label class="col-md-3 control-label">
        <?php echo __('Country'); ?>
        <?php if ( !empty( $show_require ) && $field['ProfileField']['required'] )
            echo '<span class="profile-tip"> *</span>';
        ?>
    </label>
    <div class="col-md-9 ">
        <?php echo $this->Form->select( 'country_id', $options, array( 'value'=>$country_id,'class' => 'form-control') ); ?>
    </div>
    <div class="clear"></div>
</div>

<div class="form-group country_state" style="<?php if (!$country_id || !count($option_state)) echo 'display:none;' ?>">
    <label class="col-md-3 control-label">
        <?php echo __('State/Province'); ?>
    </label>
    <div class="col-md-9 ">
        <?php echo $this->Form->select( 'state_id', $option_state, array( 'value'=>$state_id,'class' => 'form-control') ); ?>
    </div>
    <div class="clear"></div>
</div>

<div class="form-group country_city" style="<?php if (!$state_id || !count($option_city)) echo 'display:none;' ?>">
    <label class="col-md-3 control-label">
        <?php echo __('District'); ?>
    </label>
    <div class="col-md-9 ">
        <?php echo $this->Form->select( 'city_id', $option_city, array( 'value'=>$city_id,'class' => 'form-control') ); ?>
    </div>
    <div class="clear"></div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">
        <?php echo __('City/Address'); ?>
    </label>
    <div class="col-md-9 ">
        <?php echo $this->Form->text( 'address', array( 'value'=>$address,'class' => 'form-control') ); ?>
    </div>
    <div class="clear"></div>
</div>

<div class="form-group">
    <label class="col-md-3 control-label">
        <?php echo __('Zip/Postal Code'); ?>
    </label>
    <div class="col-md-9 ">
        <?php echo $this->Form->text( 'zip', array( 'value'=>$zip,'class' => 'form-control') ); ?>
    </div>
    <div class="clear"></div>
</div>