<div class="plugin-list-item">
    <div class="plugin-list-warp">
        <div class="plugin-list-thumb">
            <img class="plugin-list-img" src="<?php echo $product['image'];?>">
        </div>
        <div class="plugin-list-info">
            <div class="plugin-list-title">
                <?php if ($project_id):?>
                    <?php echo $product['title']?>
                <?php else:?>
                    <a target="_blank" href="<?php echo $product['link']?>">
                        <?php echo $product['title']?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="plugin-list-price">
                $<?php echo $product['price'];?>
            </div>
            <div class="plugin-list-desc">
                <?php echo $product['description']?>
            </div>
            <?php if ($project_id):?>
                <div class="plugin-list-action">
                    <input type="checkbox" class="check_product"  data-price="<?php echo $product['price'];?>" style="display: none" id="product_<?php echo $product['id'];?>" value="<?php echo $product['id'];?>" name="product_ids[]">
                    <button type="button" class="btn btn-default add_to_cart" data-id="<?php echo $product['id'];?>"><?php echo __('Add to cart') ?></button>
                    <button type="button" class="btn btn-default buy_product" data-id="<?php echo $product['id'];?>"><?php echo __('Checkout') ?></button>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>