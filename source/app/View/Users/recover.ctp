<?php //$this->setCurrentStyle(4);?>
<div class="section-page recover-page">
    <div class="section-content">
        <h1 class="section-page-header recover-page-header"><?php echo __('Forgot Password')?></h1>
        <div class="recover-form">
            <?php if ($state == 'sent'):
                echo __('An email has been sent to the email address that you entered<br />Please follow the instructions to reset your password<br />Check your spam folder if you don\'t see it');
            else: ?>
            <?php
                $recaptcha_publickey = Configure::read('core.recaptcha_publickey');
                $isRecaptchaEnabled = $this->Moo->isRecaptchaEnabled();
            ?>
                <form action="<?php echo $this->request->base?>/users/recover" method="post" class="<?php if ($isRecaptchaEnabled): ?><?php else: ?>form-inline<?php endif; ?> forgot-form">
                    <?php if ($isRecaptchaEnabled): ?>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <?php echo $this->Form->text('email', array('class' => 'form-control')); ?>
                                <div class="help-block">
                                    <?php echo __('Please enter your email to reset your password')?>
                                </div>
                            </div>
                            <div class="form-group">
                                <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                                <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_publickey?>"></div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="help-block">
                            <?php echo __('Please enter your email to reset your password')?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->text('email', array('class' => 'form-control')); ?>
                        </div>
					<?php endif; ?>
                    <input type="submit" value="<?php echo __('Submit')?>" class="btn btn-primary">
                </form>
            <?php
            endif;
            ?>
        </div>
    </div>

</div>