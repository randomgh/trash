<?php

function zabit_woocommerce_general_settings($settings){
	$currency_code_options = get_woocommerce_currencies();

	foreach ($currency_code_options as $code => $name) {
		$currency_code_options[$code] = $name.' ('.get_woocommerce_currency_symbol($code).')';
	}

	$pricing_options = array();

	$languages = pll_languages_list(array(
		'hide_empty' => 0,
		'fields'     => false
	));

	$default_language = pll_default_language('slug');

	if ($default_language) {
		foreach ($languages as $language) {
			if ($language->slug == $default_language) continue;

			$pricing_options[] = array(
				'title' => __('Currency options', 'woocommerce').' ['.$language->slug.']',
				'type'  => 'title',
				'desc'  => __('The following options affect how prices are displayed on the frontend.', 'woocommerce'),
				'id'    => 'pricing_options_'.$language->slug
			);

			$pricing_options[] = array(
				'title'    => __('Currency', 'woocommerce'),
				'desc'     => __('This controls what currency prices are listed at in the catalog and which currency gateways will take payments in.', 'woocommerce'),
				'id'       => 'woocommerce_currency_'.$language->slug,
				'default'  => 'GBP',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'desc_tip' => true,
				'options'  => $currency_code_options
			);

			$pricing_options[] = array(
				'title'    => __('Currency position', 'woocommerce' ),
				'desc'     => __('This controls the position of the currency symbol.', 'woocommerce'),
				'id'       => 'woocommerce_currency_pos_'.$language->slug,
				'class'    => 'wc-enhanced-select',
				'default'  => 'left',
				'type'     => 'select',
				'options'  => array(
					'left'        => __('Left', 'woocommerce'),
					'right'       => __('Right', 'woocommerce'),
					'left_space'  => __('Left with space', 'woocommerce'),
					'right_space' => __('Right with space', 'woocommerce')
				),
				'desc_tip' => true
			);

			$pricing_options[] = array(
				'title'    => __('Thousand separator', 'woocommerce'),
				'desc'     => __('This sets the thousand separator of displayed prices.', 'woocommerce'),
				'id'       => 'woocommerce_price_thousand_sep_'.$language->slug,
				'css'      => 'width:50px;',
				'default'  => ',',
				'type'     => 'text',
				'desc_tip' => true
			);

			$pricing_options[] = array(
				'title'    => __('Decimal separator', 'woocommerce'),
				'desc'     => __('This sets the decimal separator of displayed prices.', 'woocommerce'),
				'id'       => 'woocommerce_price_decimal_sep_'.$language->slug,
				'css'      => 'width:50px;',
				'default'  => '.',
				'type'     => 'text',
				'desc_tip' => true
			);

			$pricing_options[] = array(
				'title'             => __('Number of decimals', 'woocommerce'),
				'desc'              => __('This sets the number of decimal points shown in displayed prices.', 'woocommerce'),
				'id'                => 'woocommerce_price_num_decimals_'.$language->slug,
				'css'               => 'width:50px;',
				'default'           => '2',
				'desc_tip'          => true,
				'type'              => 'number',
				'custom_attributes' => array(
					'min'  => 0,
					'step' => 1
				)
			);

			$pricing_options[] = array(
				'type' => 'sectionend',
				'id'   => 'pricing_options_'.$language->slug
			);
		}
	}

	foreach($settings as $key => $setting) {
		if ($setting['type'] == 'sectionend' && $setting['id'] == 'pricing_options') {
			$index = $key;
			break;
		}
	}

	if (isset($index)) array_splice($settings, $index + 1, 0, $pricing_options);

	return $settings;
}
add_filter('woocommerce_general_settings', 'zabit_woocommerce_general_settings', 11, 1);

function zabit_woocommerce_product_settings($settings){
	$product_measurement_options = array();

	$languages = pll_languages_list(array(
		'hide_empty' => 0,
		'fields'     => false
	));

	$default_language = pll_default_language('slug');

	if ($default_language) {
		foreach ($languages as $language) {
			if ($language->slug == $default_language) continue;

			$product_measurement_options[] = array(
				'title' => __('Measurements', 'woocommerce').' ['.$language->slug.']',
				'type'  => 'title',
				'id'    => 'product_measurement_options_'.$language->slug
			);

			$product_measurement_options[] = array(
				'title'    => __('Weight unit', 'woocommerce'),
				'desc'     => __('This controls what unit you will define weights in.', 'woocommerce'),
				'id'       => 'woocommerce_weight_unit_'.$language->slug,
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width:300px;',
				'default'  => 'kg',
				'type'     => 'select',
				'options'  => array(
					'kg'  => __('kg', 'woocommerce'),
					'g'   => __('g', 'woocommerce'),
					'lbs' => __('lbs', 'woocommerce'),
					'oz'  => __('oz', 'woocommerce')
				),
				'desc_tip' => true,
			);

			$product_measurement_options[] = array(
				'title'    => __('Dimensions unit', 'woocommerce'),
				'desc'     => __('This controls what unit you will define lengths in.', 'woocommerce'),
				'id'       => 'woocommerce_dimension_unit_'.$language->slug,
				'class'    => 'wc-enhanced-select',
				'css'      => 'min-width:300px;',
				'default'  => 'cm',
				'type'     => 'select',
				'options'  => array(
					'm'  => __('m', 'woocommerce'),
					'cm' => __('cm', 'woocommerce'),
					'mm' => __('mm', 'woocommerce'),
					'in' => __('in', 'woocommerce'),
					'yd' => __('yd', 'woocommerce')
				),
				'desc_tip' => true
			);

			$product_measurement_options[] = array(
				'type' => 'sectionend',
				'id'   => 'product_measurement_options_'.$language->slug
			);
		}
	}

	foreach($settings as $key => $setting) {
		if ($setting['type'] == 'sectionend' && $setting['id'] == 'product_measurement_options') {
			$index = $key;
			break;
		}
	}

	if (isset($index)) array_splice($settings, $index + 1, 0, $product_measurement_options);

	return $settings;
}
add_filter('woocommerce_product_settings', 'zabit_woocommerce_product_settings', 11, 1);

function zabit_woocommerce_currency($value) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = get_option('woocommerce_currency_'.$current_language);

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}
add_filter('woocommerce_currency', 'zabit_woocommerce_currency', 11, 1);

function zabit_woocommerce_price_format($format, $currency_pos) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) {
		$currency_pos_language = get_option('woocommerce_currency_pos_'.$current_language);

		if (!empty($currency_pos_language) && $currency_pos != $currency_pos_language) {
			switch ($currency_pos_language) {
				case 'left':
					$format = '%1$s%2$s';
					break;
				case 'right':
					$format = '%2$s%1$s';
					break;
				case 'left_space':
					$format = '%1$s&nbsp;%2$s';
					break;
				case 'right_space':
					$format = '%2$s&nbsp;%1$s';
					break;
			}
		}
	}

	return $format;
}
add_filter('woocommerce_price_format', 'zabit_woocommerce_price_format', 11, 2);

function zabit_wc_get_price_thousand_separator($value) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = get_option('woocommerce_price_thousand_sep_'.$current_language);

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}
add_filter('wc_get_price_thousand_separator', 'zabit_wc_get_price_thousand_separator', 11, 1);

function zabit_wc_get_price_decimal_separator($value) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = get_option('woocommerce_price_decimal_sep_'.$current_language);

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}
add_filter('wc_get_price_decimal_separator', 'zabit_wc_get_price_decimal_separator', 11, 1);

function zabit_wc_get_price_decimals($value) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = get_option('woocommerce_price_num_decimals_'.$current_language);

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}
add_filter('wc_get_price_decimals', 'zabit_wc_get_price_decimals', 11, 1);

function zabit_woocommerce_get_page_id($value) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = pll_get_post($value, $current_language);

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}

foreach (array('myaccount', 'shop', 'cart', 'checkout', 'view_order', 'terms') as $page) {
	add_filter('woocommerce_get_'.$page.'_page_id', 'zabit_woocommerce_get_page_id', 11, 1);
}

function zabit_woocommerce_ajax_get_endpoint($value, $request) {
	$default_language = pll_default_language('slug');
	$current_language = pll_current_language('slug');

	if ($default_language != $current_language) $value_language = add_query_arg('wc-ajax', $request, remove_query_arg(array('remove_item', 'add-to-cart', 'added-to-cart', 'order_again', '_wpnonce'), pll_home_url()));

	return isset($value_language) && !empty($value_language) ? $value_language : $value;
}
add_filter('woocommerce_ajax_get_endpoint', 'zabit_woocommerce_ajax_get_endpoint', 11, 2);

function zabit_woocommerce_wp_footer(){
	global $route;

	if (!in_array($route, array('myaccount', 'cart', 'checkout', 'view_order')) && WC()->cart->is_empty()) {

		?>
		<script type="text/javascript">
            (($) => {

                $(document.body).on('added_to_cart', event => {
                    $('.woo__cart').toggleClass('woo__cart_empty', false);
                });

            })(jQuery);
		</script>
		<?php

	}
}
add_action('wp_footer','zabit_woocommerce_wp_footer');
/*
function zabit_woocommerce_cart_item_product($data, $cart_item, $cart_item_key) {
	return new WC_Product_Simple(pll_get_post($data->get_id()));
}
add_filter('woocommerce_cart_item_product', 'zabit_woocommerce_cart_item_product', 10, 3);

function zabit_woocommerce_cart_item_product_id($id, $cart_item, $cart_item_key) {
	return pll_get_post($id);
}
add_filter('woocommerce_cart_item_product_id', 'zabit_woocommerce_cart_item_product_id', 10, 3);

function zabit_woocommerce_get_cart_contents($cart_contents) {
	return $cart_contents;
}
add_filter('woocommerce_get_cart_contents', 'zabit_woocommerce_get_cart_contents', 10, 1);

do_action( 'woocommerce_add_to_cart', $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data );
$cart_item_data = (array) apply_filters( 'woocommerce_add_cart_item_data', $cart_item_data, $product_id, $variation_id, $quantity );
*/
