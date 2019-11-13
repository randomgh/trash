<?php

function menu_after_setup_theme() {
	register_nav_menus(array(
		'main' => __('Main menu', 'dem'),
        'footer' => __('Footer menu', 'dem'),
        'socials' => __('Socials menu', 'dem'),
        'apps' => __('Apps menu', 'dem'),
        'legal' => __('Legal menu', 'dem')
	));
}
add_action('after_setup_theme', 'menu_after_setup_theme');

function menu_wp_edit_nav_menu_walker($walker) {
	require_once 'walkers/EditNavMenuWalker.php';

	return 'EditNavMenuWalker';
}
add_filter('wp_edit_nav_menu_walker', 'menu_wp_edit_nav_menu_walker');

function menu_update_nav_menu_item($menu_id = 0, $menu_item_db_id = 0, $menu_item_data = array()) {
	$request_post = stripslashes_deep($_POST);

	foreach (array('dem-menu-item-icon') as $i => $input_var) {
		$menu_item_data = array_merge($menu_item_data, array(
			$input_var => isset($request_post[$input_var]) ? $request_post[$input_var] : ''
		));

		if (isset($menu_item_data[$input_var]) && isset($menu_item_data[$input_var][$menu_item_db_id]) && $menu_item_data[$input_var][$menu_item_db_id] != '') {
			update_post_meta($menu_item_db_id, $input_var, $menu_item_data[$input_var][$menu_item_db_id]);
		} else {
			delete_post_meta($menu_item_db_id, $input_var);
		}
	}
}
add_action('wp_update_nav_menu_item', 'menu_update_nav_menu_item', 10, 3);