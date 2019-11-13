<?php

if (!defined('ABSPATH')) {
	exit;
}

global $post, $product;

?>
<?php if ($product->is_on_sale()) : ?>

	<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.esc_html__('discount', 'zabit').'</span>', $post, $product); ?>

<?php endif;