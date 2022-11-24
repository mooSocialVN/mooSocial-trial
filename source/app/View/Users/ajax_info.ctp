<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<div id="profile_information">
    <div class="box2 bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Basic Information')?></h1>
            </div>
        </div>
        <div class="box_content">
            <div class="core-list-info group-info">
                <?php if ( !empty( $user['User']['username'] ) ): ?>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('Profile Address')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php echo $this->Text->autoLink(FULL_BASE_URL . $this->request->base . '/-' . $user['User']['username'])?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('Gender')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php $this->Moo->getGenderTxt($user['User']['gender']); ?>
                    </div>
                </div>
                <?php if ( !empty($user['User']['birthday']) && $user['User']['birthday'] != '0000-00-00' ): ?>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('Birthday')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php echo $this->Time->event_format($user['User']['birthday'], '%B %d', false, $utz)?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('Registered Date')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php echo $this->Moo->getTime($user['User']['created'], Configure::read('core.date_format'), $utz)?>
                    </div>
                </div>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('Last login')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php echo $this->Moo->getTime($user['User']['last_login'], Configure::read('core.date_format'), $utz)?>
                    </div>
                </div>
                <?php if ( !empty( $user['User']['about'] ) ): ?>
                <div class="core-list-info-item">
                    <div class="core-list-info-l">
                        <?php echo __('About')?>:
                    </div>
                    <div class="core-list-info-r">
                        <?php if (Configure::read('core.show_about_search')):?>
                            <a href="<?php echo $this->request->base?>/users/index/about:<?php echo $this->Moo->formatText( $user['User']['about'] , false, true, array('no_replace_ssl' => 1))?>">
                                <?php echo $this->Moo->formatText( $user['User']['about'] , false, true, array('no_replace_ssl' => 1))?>
                            </a>
                        <?php else:?>
                            <?php echo $this->Moo->formatText( $user['User']['about'] , false, true, array('no_replace_ssl' => 1))?>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($user['ProfileType']['id']):?>
                    <?php if (Configure::read('core.enable_show_profile_type')):?>
                    <div class="core-list-info-item">
                        <div class="core-list-info-l">
                            <?php echo __('Profile type');?>:
                        </div>
                        <div class="core-list-info-r">
                            <a href="<?php echo $this->request->base;?>/users/index/profile_type:<?php echo $user['ProfileType']['id'];?>"><?php echo $user['ProfileType']['name'];?></a>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php
                    $helper = MooCore::getInstance()->getHelper("Core_Moo");
                    foreach ($fields as $field):
                        if (!empty($field['ProfileField']['hide_from_info_tab']) && (empty($cuser) || ($cuser['id'] != $user['User']['id'] && empty($cuser['Role']['is_admin'])))) {
                            continue;
                        }

                        if (!in_array($field['ProfileField']['type'],$helper->profile_fields_default))
                        {
                            $options = array();
                            if ($field['ProfileField']['plugin'])
                            {
                                $options = array('plugin' => $field['ProfileField']['plugin']);
                            }

                            echo $this->element('profile_field/' . $field['ProfileField']['type'].'_info', array('field' => $field,'user'=>$user),$options);
                            continue;
                        }
                        if ( $field['ProfileField']['type'] == 'heading' ):
                            ?>
                            <div class="core-list-info-item">
                                <div class="core-list-heading">
                                    <?php echo $field['ProfileField']['name']?>
                                </div>
                            </div>
                        <?php
                        elseif ( !empty( $field['ProfileFieldValue']['value'] ) ) :
                            ?>
                            <div class="core-list-info-item">
                                <div class="core-list-info-l">
                                    <?php echo $field['ProfileField']['name']?>:
                                </div>
                                <div class="core-list-info-r">
                                    <?php echo $this->element( 'misc/custom_field_value', array( 'field' => $field ) ); ?>
                                </div>
                            </div>
                        <?php
                        endif;
                    endforeach;
                    ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>