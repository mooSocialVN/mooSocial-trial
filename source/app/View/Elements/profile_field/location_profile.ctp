<?php
    $userCountryModel = MooCore::getInstance()->getModel("UserCountry");
    $user_country = $userCountryModel->getUserCountryByUser($user['User']['id']);
    if (!$user_country)
        return;

    $text = ($user_country['UserCountry']['address'] ? $user_country['UserCountry']['address'].", " : "");
    $text .= ($user_country['City'] && $user_country['City']['name'] ? $user_country['City']['name'].", " : "");
    $text .= ($user_country['State'] && $user_country['State']['name'] ? $user_country['State']['name'].", " : "");
    $text .= ($user_country['UserCountry']['zip'] ? $user_country['UserCountry']['zip'].", " : "");
    $text .= ($user_country['Country'] ? $user_country['Country']['name']." " : "");
    $url = $this->request->base."/users/index/profile_type:".$field['ProfileField']['profile_type_id']."/field_".$field['ProfileField']['id'].":1";
    if ($user_country['Country'])
    {
     	$url.="/country_id:".$user_country['Country']['id'];
    }
        
    if ($user_country['State'])
    {
      	$url.="/state_id:".$user_country['State']['id'];
    }
        
    if ($user_country['City'])
    {
      	$url.="/city_id:".$user_country['City']['id'];
    }
?>
<?php if(!empty(trim($text))):?>
<li><span class="date"><?php echo $field['ProfileField']['name'];?>: </span>
    <?php if ( $field['ProfileField']['searchable'] ): ?>
        <a href="<?php echo $url; ?>"><?php echo $text; ?></a>
    <?php else :?>
        <?php echo $text; ?>
    <?php endif;?>
    </li>
<?php endif;?>