<?php

    global $route;
    global $overlay;

    the_post();

    $cart = get_option('zabit_general_general_cart', null);

    $cart_id = pll_get_post(wc_get_page_id('cart'));
    $cart_title = get_the_title($cart_id);
    $cart_link = get_permalink($cart_id);

?>
<section class="section section_<?php echo $route; ?>">
	<div class="content">
        <div class="meta">
            <div class="meta__title"><?php the_title(); ?></div>
        </div>
        <div class="woo">
            <?php if (!in_array($route, array('myaccount', 'cart', 'checkout', 'view_order'))) { ?>
                <a class="woo__cart <?php echo WC()->cart->is_empty() ? 'woo__cart_empty' : '' ?>" href="<?php echo $cart_link; ?>" title="<?php echo $cart_title; ?>">
                    <?php echo $cart ? new SVG($cart) : $cart_title; ?>
                </a>
            <?php }

	        $shop_opt = get_option('woocommerce_shop_page_id', null);
	        $shop_pll = pll_get_post(get_option('woocommerce_shop_page_id', null));
	        $page_id = get_the_ID();

            if ($page_id == $shop_pll && $page_id != $shop_opt) {
	            $shortcode = new WC_Shortcode_Products(array(
		            'page'     => 1,
		            'rows'     => 4,
		            'paginate' => true
	            ));

	            echo $shortcode->get_content();
            } else {
	            the_content();
            }

            ?>
        </div>
	</div>
</section>