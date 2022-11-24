<?php
echo $this->Html->css(array('plugin-site'), null, array('inline' => false));
$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "dashboard"));
$this->end();
?>
<?php 
    $items = $data['items'];
    $total = 0;
?>
<div class="col-xs-12">
    <div id="step1" class="plugin_site-section">
        <div class="plugin_site-content">
            <div class="table-responsive">
                <table class="table table-dashboard table-striped">
                    <thead>
                        <tr>
                            <th width="50">&nbsp;</th>
                            <th><?php echo __('Product');?></th>
                            <th><?php echo __('Price');?></th>
                            <th><?php echo __('Total');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item):?>
                            <?php $total+= $item['price']?>
                            <tr>
                                <td>
                                    <a class="plugin_site-remove-cart remove_product" data-id="<?php echo $item['id'] ?>" data-price="<?php echo $item['price']?>" href="javascript:void(0);">
                                        <span class="material-icons">close</span>
                                    </a>
                                </td>
                                <td>
                                    <span class="plugin_site-cart-thumb">
                                        <img class="plugin_site-cart-img" src="<?php echo $item['image'];?>">
                                    </span> <?php echo $item['title'];?> x<span class="">1</span>
                                </td>
                                <td>$<?php echo $item['price'];?></td>
                                <td>$<?php echo $item['price'];?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="plugin_site-cart-info-proceed">
            <div class="form-inline">
                <div class="form-group">
                    <input id="coupon_text" type="text" value="" class="form-control" placeholder="<?php echo __('Coupon');?>">
                </div>                
                <button class="btn btn-primary btn-lg" id="coupon_apply"><?php echo __('Apply');?></button>
            </div>
            <div style="display:none;margin-top:5px;" id="coupon_error" class="alert alert-danger"></div>
            <div class="form-group">
                <div>
                    <strong><?php echo __('Cart Totals');?></strong>
                </div>
                <div>
                    <?php echo __('Sub Total');?> $<span class="total_sub_price"><?php echo $total;?></span>
                </div>
                <div class="discount_content" style="display: none;">
                    <?php echo __('Discount');?> -$<span class="total_discount">0</span>
                </div>
                <div>
                    <?php echo __('Total');?> $<span class="total_price"><?php echo $total;?></span>
                </div>
            </div>

            <button class="btn btn-primary btn-lg" id="process_checkout"><?php echo __('Proceed to checkout');?></button>
        </div>
    </div>
    <div id="step2" style="display: none" class="plugin_site-content">
        <form id="form_buy_product">
            <input type="hidden" id="coupon" name="coupon" />
            <div class="container">
                <div class="plugin_site-container">
                    <div class="form-plugin_site">
                        <div class="form-group">
                            <div class="plugin_site-bg_gray">
                                <?php echo __('Billing and account information');?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="billing_country"><?php echo __('Country')?> <span class="required">*</span></label>
                            <select id="billing_country" name="billing_country" class="form-control">
                                <option><?php echo __('Select a country…'); ?></option>
                                <?php foreach ($data['country'] as $key=>$country):?>
                                    <option <?php if ($key == $data['billing_data']['billing_country']) echo 'selected';?> value="<?php echo $key;?>"><?php echo $country;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                        <div class="row form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="billing_first_name"><?php echo __('First name');?> <span class="required">*</span></label>
                                    <input id="billing_first_name" name="billing_first_name" type="text" value="<?php echo $data['billing_data']['billing_first_name'];?>" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="billing_last_name"><?php echo __('Last Name');?> <span class="required">*</span></label>
                                    <input id="billing_last_name" name="billing_last_name" type="text" value="<?php echo $data['billing_data']['billing_last_name'];?>" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="billing_company"><?php echo __('Company Name');?></label>
                            <input id="billing_company" value="<?php echo $data['billing_data']['billing_company'];?>" type="text" class="form-control" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="billing_address_1"><?php echo __('Address')?></label>
                            <input id="billing_address_1" name="billing_address_1" value="<?php echo $data['billing_data']['billing_address_1'];?>" type="text" class="form-control" placeholder="<?php echo __('Street Address');?>">
                        </div>

                        <div class="form-group">
                            <input id="billing_address_2" name="billing_address_2" value="<?php echo $data['billing_data']['billing_address_2'];?>" type="text" class="form-control" placeholder="<?php echo __('Appartment, suit, unit etc (optional)');?>">
                        </div>

                        <div class="form-group">
                            <label for="billing_city"><?php echo __('Town / City');?></label>
                            <input id="billing_city" name="billing_city" value="<?php echo $data['billing_data']['billing_city'];?>" type="text" class="form-control" placeholder="">
                        </div>

                        <div class="row form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="billing_state"><?php echo __('State');?></label>
                                    <input id="billing_state" name="billing_state" value="<?php echo $data['billing_data']['billing_state'];?>" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="billing_postcode"><?php echo __('Zip');?></label>
                                    <input id="billing_postcode" name="billing_postcode" value="<?php echo $data['billing_data']['billing_postcode'];?>" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="billing_phone"><?php echo __('Phone');?></label>
                                    <input id="billing_phone" name="billing_phone" value="<?php echo $data['billing_data']['billing_phone'];?>" type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table table-dashboard table-striped">
                                    <thead>
                                    <tr>
                                        <th><?php echo __('Product'); ?></th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item):?>
                                            <tr id="product_<?php echo $item['id'];?>">
                                                <td>
                                                    <input type="hidden" name="product_ids[]" value="<?php echo $item['id'] ?>">
                                                    <span class="plugin_site-cart-thumb">
                                                        <img class="plugin_site-cart-img" src="<?php echo $item['image'];?>">
                                                    </span> <?php echo $item['title'] ?> x<span class="">1</span>
                                                </td>
                                                <td>$<?php echo $item['price'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td style="text-align: right">
                                            <?php echo __('Total Sub');?>
                                        </td>
                                        <td>
                                            $<span class="total_sub_price"><?php echo $total;?></span>
                                        </td> 
                                    </tr>
                                    <tr class="discount_content" style="display: none;">
                                        <td style="text-align: right">
                                            <?php echo __('Discount');?>
                                        </td>
                                        <td>
                                            -$<span class="total_discount"><?php echo $total;?></span>
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">
                                            <?php echo __('Total');?>
                                        </td>
                                        <td>
                                            $<span class="total_price"><?php echo $total;?></span>
                                        </td> 
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php foreach ($data['gateway'] as $key => $value):?>
                                <div class="plugin_site-radio">
                                    <label>
                                        <input type="radio" name="gateway" id="" value="<?php echo $key?>" checked>
                                        <img src="<?php echo $value['logo'] ?>">
                                    </label>
                                </div>
                            <?php endforeach;?>                            
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <div>
                                    <input type="checkbox" name="terms" value="terms"> <?php echo __("I've read and accept the <a href='%s'>terms & conditions</a>",'https://moosocial.com/term-of-service');?>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-block btn-lg" id="buy_checkout"><?php echo __('Proceed');?></button>
                        <div style="display:none;margin-top:5px;" id="error" class="alert alert-danger"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
</div>
<div id="payment_product" style="display:none;">
</div>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
var total = <?php echo $total;?>;
$('#coupon_apply').click(function(){
    if ($('#coupon_text').val() != '')
    {
        $('#coupon_error').hide();
        $.ajax({ 
            type: 'POST', 
            url: '<?php echo $this->request->base?>/admin/plugin_site/check_coupon', 
            data: {
                'coupon': $('#coupon_text').val(),
                'amount' : total
            }, 
            dataType: 'json',
            success: function (result) { 
               data = result.data;
               console.log(data);
               if (data.status)
               {
                    $('.total_discount').html(data.discount);
                    $('.total_price').html(data.amount);
                    $('.discount_content').show();
                    $('#coupon').val($('#coupon_text').val());
               }
               else
               {
                    $('#coupon_error').show();
                    $('#coupon_error').html(data.message);
               }
            }
        });
    }
});
$('.remove_product').click(function(){
    var price = $(this).data('price');
    total = total - parseFloat(price);
    if (total == 0)
    {
        window.location.href = '<?php echo  $this->request->base ?>/admin'
    }
    $('.total_sub_price').html(total);
    $('.total_price').html(total);
    $('#product_'+$(this).data('id')).remove();
    $(this).parent().parent().remove();

    $('#coupon').val('');
    $('.discount_content').hide();
});
$('#process_checkout').click(function(){
    $('#step1').hide();
    $('#step2').show();

    $('#buy_checkout').click(function(){
        $('#error').hide();
        $.ajax({ 
            type: 'POST', 
            url: '<?php echo $this->request->base?>/admin/plugin_site/buy_plugin', 
            data: $("#form_buy_product").serialize(), 
            dataType: 'json',
            success: function (data) { 
                if (data.status)
                {
                    $('#payment_product').html(data.data.form);
                    $('#payment_product form').submit();
                }
                else
                {
                    $('#error').html(data.message);
                    $('#error').show();
                }
            }
        });
    });
});
<?php $this->Html->scriptEnd(); ?>