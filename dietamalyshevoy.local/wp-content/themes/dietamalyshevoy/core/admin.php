<?php

add_filter('show_admin_bar', '__return_false');

function dem_admin_init() {
    new AdminPage(array(
        'page_title' => __('Dietamalyshevoy settings', 'dem'),
        'menu_title' => __('Dietamalyshevoy', 'dem'),
        'capability' => 'manage_options',
        'menu_slug'  => 'dem',
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 20
    ), array(
        'general' => array(
            array(
                'id'          => 'general',
                'title'       => __('General', 'dem'),
                'description' => function() {
                    _e('Dietamalyshevoy general settings', 'dem');
                },
                'fields'      => array(
                    array(
                        'id'       => 'logo',
                        'title'    => __('Logo', 'dem'),
                        'type'     => 'media',
                        'sanitize' => 'esc_attr',
                        'rest'     => true,
                        'default'  => '',
                        'options'     => array(
                            'type' => 'image'
                        )
                    ),
                    array(
                        'id'          => 'about_page',
                        'title'       => __('About page', 'dem'),
                        'type'        => 'select',
                        'description' => __('About page.', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'     => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'contacts_page',
                        'title'       => __('Contacts page', 'dem'),
                        'type'        => 'select',
                        'description' => __('Contacts page.', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'     => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'error_page',
                        'title'       => __('Error page', 'dem'),
                        'type'        => 'select',
                        'description' => __('404 error page.', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    )/*,
                    array(
                        'id'          => 'registration_page',
                        'title'       => __('Registration page', 'dem'),
                        'type'        => 'select',
                        'description' => __('Registration form', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'registration-phone_page',
                        'title'       => __('Registration phone page', 'dem'),
                        'type'        => 'select',
                        'description' => __('Registration phone form', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'login_page',
                        'title'       => __('Login page', 'dem'),
                        'type'        => 'select',
                        'description' => __('Login form', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'restore-password_page',
                        'title'       => __('Restore password page', 'dem'),
                        'type'        => 'select',
                        'description' => __('Restore password form', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    ),
                    array(
                        'id'          => 'new-password_page',
                        'title'       => __('New password page', 'dem'),
                        'type'        => 'select',
                        'description' => __('New password form', 'dem'),
                        'sanitize'    => 'esc_attr',
                        'empty'       => __('There are no pages. Make one first.', 'dem'),
                        'placeholder' => __('Select page', 'dem'),
                        'rest'        => true,
                        'default'     => '',
                        'class'       => 'regular-text ltr',
                        'options'     => array_map(function($page) {
                            return array(
                                'title' => $page->post_title,
                                'value' => $page->ID
                            );
                        }, get_posts(array(
                            'post_type' => 'page',
                            'numberposts' => -1
                        )))
                    )*/,
                    array(
                        'id'       => 'copy',
                        'title'    => __('Copy', 'dem'),
                        'type'     => 'text',
                        'sanitize' => 'esc_attr',
                        'rest'     => true,
                        'default'  => ''
                    )
                )
            ),
            array(
                'id'          => 'contacts',
                'title'       => __('Contacts', 'dem'),
                'description' => function() {
                    _e('Dietamalyshevoy contacts settings', 'dem');
                },
                'fields'      => array(
                    array(
                        'id'       => 'phone1',
                        'title'    => __('Phone #1', 'dem'),
                        'type'     => 'text',
                        'sanitize' => 'esc_attr',
                        'rest'     => true,
                        'default'  => ''
                    ),
                    array(
                        'id'       => 'phone2',
                        'title'    => __('Phone #2', 'dem'),
                        'type'     => 'text',
                        'sanitize' => 'esc_attr',
                        'rest'     => true,
                        'default'  => ''
                    ),
	                array(
		                'id'       => 'address',
		                'title'    => __('Address', 'dem'),
		                'type'     => 'text',
		                'sanitize' => 'esc_attr',
		                'rest'     => true,
		                'default'  => ''
	                )
                )
            )
        )
    ));
}
add_action('init', 'dem_admin_init');

function dem_admin_enqueue_scripts($hook) {
    $cache = '0.0.1';

	wp_register_style('dem-admin', get_theme_file_uri('/css/build/admin.css'), array(), $cache);
	wp_register_script('dem-admin', get_theme_file_uri('/js/build/admin.js'), array(), $cache);

	switch ($hook) {
        case 'toplevel_page_dem':
		case 'post.php':
		case 'post-new.php':
		case 'nav-menus.php':
			wp_enqueue_media();
			wp_enqueue_script('dem-admin');
			wp_enqueue_style('dem-admin');
			break;
	}
}
add_action('admin_enqueue_scripts', 'dem_admin_enqueue_scripts');

function dem_custom_menu_order($menu_order) {
	return array(
		'index.php',
		'separator1',
		'edit.php?post_type=page',
		'edit.php',
        'edit.php?post_type=landing',
		'edit.php?post_type=news',
        'edit.php?post_type=story',
		'upload.php',
		'edit-comments.php',
		'separator2',
		'themes.php',
		'plugins.php',
		'users.php',
		'tools.php',
		'options-general.php',
		'separator-last'
	);
}
add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'dem_custom_menu_order');