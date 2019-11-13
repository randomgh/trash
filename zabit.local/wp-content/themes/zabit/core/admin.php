<?php

add_filter('show_admin_bar', '__return_false');

function zabit_admin_init(){
	new AdminPage(array(
		'page_title' => __('Zabit settings', 'zabit'),
		'menu_title' => __('Zabit', 'zabit'),
		'capability' => 'manage_options',
		'menu_slug'  => 'zabit',
		'icon_url'   => 'dashicons-welcome-widgets-menus',
		'position'   => 20
	), array(
		'general' => array(
			array(
				'id'          => 'general',
				'title'       => __('General', 'zabit'),
				'description' => function() {
					_e('Zabit general settings', 'zabit');
				},
				'fields'      => array(
					array(
						'id'       => 'logo',
						'title'    => __('Logo', 'zabit'),
						'type'     => 'media',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'       => 'menu',
						'title'    => __('Menu', 'zabit'),
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
						'title'       => __('About page', 'zabit'),
						'type'        => 'select',
						'description' => __('About page.', 'zabit'),
						'sanitize'    => 'esc_attr',
						'empty'       => __('There are no pages. Make one first.', 'zabit'),
						'placeholder' => __('Select page', 'zabit'),
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
							'lang'      => pll_default_language('slug'),
							'numberposts' => -1
						)))
					),
					array(
						'id'          => 'error_page',
						'title'       => __('Error page', 'zabit'),
						'type'        => 'select',
						'description' => __('404 error page.', 'zabit'),
						'sanitize'    => 'esc_attr',
						'empty'       => __('There are no pages. Make one first.', 'zabit'),
						'placeholder' => __('Select page', 'zabit'),
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
							'lang'      => pll_default_language('slug'),
							'numberposts' => -1
						)))
					),
					array(
						'id'          => 'left_image',
						'title'       => __('Left background', 'zabit'),
						'description' => __('Left sidebar background.', 'zabit'),
						'type'        => 'media',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'          => 'right_image',
						'title'       => __('Right background', 'zabit'),
						'description' => __('Right sidebar background.', 'zabit'),
						'type'        => 'media',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'          => 'athlete',
						'title'       => __('Athlete', 'zabit'),
						'description' => __('Athlete dummy.', 'zabit'),
						'type'        => 'media',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'          => 'youtube',
						'title'       => __('Youtube', 'zabit'),
						'description' => __('Youtube play button.', 'zabit'),
						'type'        => 'media',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'          => 'cart',
						'title'       => __('Cart', 'zabit'),
						'description' => __('Cart icon.', 'zabit'),
						'type'        => 'media',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
						'options'     => array(
							'type' => 'image'
						)
					)
				)
			),
			array(
				'id'          => 'social',
				'title'       => __('Social', 'zabit'),
				'description' => function() {
					_e('Zabit social settings', 'zabit');
				},
				'fields'      => array(
					array(
						'id'       => 'fb',
						'title'    => __('Facebook icon', 'zabit'),
						'type'     => 'media',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'       => 'tw',
						'title'    => __('Twitter icon', 'zabit'),
						'type'     => 'media',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'       => 'vk',
						'title'    => __('VKontakte icon', 'zabit'),
						'type'     => 'media',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => '',
						'options'     => array(
							'type' => 'image'
						)
					)
				)
			)
		),
		'bio' => array(
			array(
				'id'          => 'general',
				'title'       => __('Bio', 'zabit'),
				'description' => function() {
					_e('Zabit bio settings', 'zabit');
				},
				'fields'      => array(
					array(
						'id'          => 'athlete',
						'title'       => __('Athlete', 'zabit'),
						'type'        => 'select',
						'description' => __('Default athlete.', 'zabit'),
						'sanitize'    => 'esc_attr',
						'empty'       => __('There are no athletes. Make one first.', 'zabit'),
						'placeholder' => __('Select athlete', 'zabit'),
						'rest'        => true,
						'default'     => '',
						'class'       => 'regular-text ltr',
						'options'     => array_map(function($athlete) {
							return array(
								'title' => $athlete->post_title,
								'value' => $athlete->ID
							);
						}, get_posts(array(
							'post_type'   => 'athlete',
							'lang'        => pll_default_language('slug'),
							'numberposts' => -1
						)))
					)
				)
			)
		),
		'powered' => array(
			array(
				'id'          => 'developer',
				'title'       => __('Developer', 'zabit'),
				'description' => function() {
					_e('Developer', 'zabit');
				},
				'fields'      => array(
					array(
						'id'       => 'logo',
						'title'    => __('Developer logo', 'zabit'),
						'type'     => 'media',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => '',
						'options'     => array(
							'type' => 'image'
						)
					),
					array(
						'id'       => 'title',
						'title'    => __('Developer title', 'zabit'),
						'type'     => 'text',
						'sanitize' => 'esc_attr',
						'rest'     => true,
						'default'  => ''
					),
					array(
						'id'          => 'link',
						'title'       => __('Developer link', 'zabit'),
						'type'        => 'text',
						'sanitize'    => 'esc_attr',
						'rest'        => true,
						'default'     => '',
                        'placeholder' => __('http://...', 'zabit')
					)
				)
			)
		)
	));
}
add_action('init', 'zabit_admin_init');

function zabit_admin_enqueue_scripts($hook){
	wp_register_style('zabit-admin', get_theme_file_uri('/css/build/admin.css'));
	wp_register_script('zabit-admin', get_theme_file_uri('/js/build/admin.js'));

	switch ($hook) {
		case 'toplevel_page_zabit':
		case 'post.php':
		case 'post-new.php':
		case 'nav-menus.php':
			wp_enqueue_media();
			wp_enqueue_script('zabit-admin');
			wp_enqueue_style('zabit-admin');
			break;
	}
}
add_action('admin_enqueue_scripts', 'zabit_admin_enqueue_scripts');

function zabit_custom_menu_order($menu_order) {
	return array(
		'index.php',
		'separator1',
		'edit.php?post_type=page',
		'edit.php',
		'edit.php?post_type=news',
		'edit.php?post_type=athlete',
		'edit.php?post_type=event',
		'edit.php?post_type=goal',
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
add_filter('menu_order', 'zabit_custom_menu_order');

function zabit_excerpt_length($length) {
	return 1000;
}
add_filter('excerpt_length', 'zabit_excerpt_length', 10, 1);

function zabit_rss() {
	$athlete = get_option('zabit_bio_general_athlete', null);

	if ($athlete) :
		$athlete = pll_get_post($athlete);
		?>
        <athlete id="<?php echo $athlete; ?>"><?php echo get_permalink($athlete); ?></athlete>
	<?php
	endif;

	$about = get_option('zabit_general_general_about_page', null);

	if ($about) :
		$about = pll_get_post($about);
		?>
        <about_page id="<?php echo $about; ?>"><?php echo get_permalink($about); ?></about_page>
	<?php
	endif;

	$error = get_option('zabit_general_general_error_page', null);

	if ($error) :
		$error = pll_get_post($error);
		?>
        <error_page id="<?php echo $error; ?>"><?php echo get_permalink($error); ?></error_page>
	<?php
	endif;

	$events = get_posts(array(
		'post_type'  => 'event',
		'lang'       => pll_current_language('slug'),
		'showposts'  => 1,
		'order'      => 'DESC',
		'meta_key'   => 'info_date',
		'orderby'    => 'meta_value',
		'meta_query' => array(
			array(
				'key'     => 'results_result',
				'compare' => 'NOT EXISTS'
			)
		)
	));

	?>
	<upcoming_events>
		<?php foreach ($events as $i) : ?>
			<event id="<?php echo $i->ID; ?>"><?php echo get_permalink($i); ?></event>
		<?php endforeach; ?>
	</upcoming_events>
	<?php

	$taxonomies = get_terms(array(
		'taxonomy'     => 'accomplishment',
		'hide_empty'   => true,
		'fields'       => 'all',
		'hierarchical' => false
	));

	$accomplishments = array();

	foreach($taxonomies as $taxonomy){
		$taxonomy_option = get_option("taxonomy_".$taxonomy->term_id, 0);

		$accomplishments[] = array(
			'taxonomy' => $taxonomy,
			'priority' => esc_attr($taxonomy_option['priority'])
		);
	}

	usort($accomplishments, function($a, $b) {
		if ($a['priority'] == $b['priority']) {
			return 0;
		} else if ($a['priority'] > $b['priority']) {
			return 1;
		} else {
			return -1;
		}
	});

	?>
    <accomplishments>
		<?php array_map(function($accomplishment) { ?>
            <accomplishment id="<?php echo $accomplishment['taxonomy']->term_id; ?>" priority="<?php echo $accomplishment['priority']; ?>"><?php echo $accomplishment['taxonomy']->name; ?></accomplishment>
			<?php return $accomplishment;
		}, $accomplishments); ?>
    </accomplishments>
	<?php
}
add_action('rss2_head', 'zabit_rss');

function zabit_teeny_mce_buttons($buttons, $editor_id) {
    return array('bold', 'italic', 'underline', 'undo', 'redo');
}
add_filter('teeny_mce_buttons', 'zabit_teeny_mce_buttons', 10, 2);
