<?php 
    if ($results['status']):
?>
<form method="post" action="<?php echo $this->request->base ?>/admin/plugin_site/confirm" id="form_buy_product">
    <div class="col-md-12">
        <div class="plugin_site-section">
            <div class="plugin_site-header">
                <div class="plugin_site-header-l">
                    <ul class="plugin_site-tab">
                        <li class="active">
                            <a href="javascript:void(0)" data-type="plugin" class="plugin_site_tab"><?php echo __('Plugins') ?></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-type="theme" class="plugin_site_tab"><?php echo __('Themes') ?></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-type="service" class="plugin_site_tab"><?php echo __('Services') ?></a>
                        </li>
                    </ul>
                </div>
                <div class="plugin_site-header-r">
                    <div class="plugin_site-action-bar">
                        <div class="plugin_site-search">
                            <input onkeydown="return event.key != 'Enter';" id="search_product" class="plugin_site-search-input" type="text" value="" placeholder="<?php echo __('Search') ?>">
                            <button class="plugin_site-search-submit" type="button">
                                <span class="global-search-icon-submit material-icons">search</span>
                            </button>
                        </div>
                        <?php if ($project_id):?>
                            <div class="plugin_site-cart-total">
                                <span class="plugin_site-cart-icon material-icons">shopping_cart</span>
                                <span class="plugin_site-cart-price" id="cart_price">$0</span>
                            </div>
                            <div class="plugin_site-cart-checkout">
                                <a class="btn-cart-checkout btn btn-success" id="cart_checkout" href="javascript:void(0);"><?php echo __('Checkout') ?></a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="plugin_site-content content-plugin">
            <div class="plugin_site-plugin_lists">
                <?php foreach ($results['data'] as $product):?>
                    <?php if ($product['type'] == 1):?>
                        <?php echo $this->element('lists/plugin_list',array('product'=>$product))?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
        <div class="plugin_site-content content-theme" style="display: none;">
            <div class="plugin_site-plugin_lists">
                <?php foreach ($results['data'] as $product):?>
                    <?php if ($product['type'] == 2):?>
                        <?php echo $this->element('lists/plugin_list',array('project_id'=> $project_id,'product'=>$product))?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
        <div class="plugin_site-content content-service" style="display: none;">
            <div class="plugin_site-plugin_lists">
                <?php foreach ($results['data'] as $product):?>
                    <?php if ($product['type'] == 3):?>
                        <?php echo $this->element('lists/plugin_list',array('project_id'=> $project_id,'product'=>$product))?>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>    
        <script>
            $('.buy_product').click(function() {
                $('.check_product').prop('checked', false);
                $('#product_' + $(this).data('id')).prop('checked', true);
                $('#cart_checkout').click();
            });

            $('.add_to_cart').click(function() {
                check = $('#product_' + $(this).data('id')).prop('checked');
                $('#product_' + $(this).data('id')).prop('checked',!check)
                if (check)
                {
                    $(this).html('<?php echo __('Add to cart');?>');
                }
                else
                {
                    $(this).html('<?php echo __('Remove');?>');
                }
                var price = 0;
                $.each($("input[name='product_ids[]']:checked"), function(){
                    price+= parseInt($(this).data('price'));
                });
                console.log(price);
                $('#cart_price').html('$' + price);
            });

            $('#cart_checkout').click(function(){
                var count = 0;
                $.each($("input[name='product_ids[]']:checked"), function(){
                    count++;
                });
                if (count > 0)
                {
                    $('#form_buy_product').submit();
                }
            });

            $('.plugin_site_tab').click(function(){
                $('.plugin_site-content').hide();
                $(this).parent().parent().find('.active').removeClass('active');
                $(this).parent().addClass('active');
                $('.content-' + $(this).data('type')).show();
            });
            var timerid;
            $('#search_product').on("input", function(e) {
                var value = $(this).val();
                if ($(this).data("lastval") != value) {

                    $(this).data("lastval", value);
                    clearTimeout(timerid);

                    timerid = setTimeout(function() {
                    //your change action goes here 
                        if (value == '')
                        {
                            $('.plugin-list-item').show();
                        }
                        else
                        {
                            $('.plugin-list-item').hide();
                            $('.plugin-list-item').each(function() {
                                if ($(this).find('.plugin-list-title').html().toLowerCase().indexOf(value.toLowerCase()) != -1){
                                    $(this).show();
                                };
                            });
                        }
                    }, 500);
                };
            });
        </script>
    </div>
</form>
<?php endif;?>