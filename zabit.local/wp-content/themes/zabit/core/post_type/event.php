<?php

function event_init(){
	register_post_type('event', array(
		'label' => __('Events', 'zabit'),
		'labels' => array(
			'name' => __('Events', 'zabit'),
			'singular_name' => __('Event', 'zabit'),
			'menu_name' => __('Events', 'zabit'),
			'name_admin_bar' => __('Event', 'zabit'),
			'add_new' => __('Add new', 'zabit'),
			'add_new_item' => __('Add new event', 'zabit'),
			'new_item' => __('New event', 'zabit'),
			'edit_item' => __('Edit event', 'zabit'),
			'view_item' => __('View event', 'zabit'),
			'view_items' => __('View events', 'zabit'),
			'all_items' => __('All events', 'zabit'),
			'search_items' => __('Search events', 'zabit'),
			'parent_item_colon' => __('Parent event:', 'zabit'),
			'not_found' => __('No events found.', 'zabit'),
			'not_found_in_trash' => __('No events found in Trash.', 'zabit'),
			'archives' => __('Events archives', 'zabit'),
			'attributes' => __('Events attributes', 'zabit'),
			'insert_into_item' => __('Insert into events', 'zabit'),
			'uploaded_to_this_item' => __('Uploaded to this event', 'zabit'),
			'featured_image' => __('Featured image', 'zabit'),
			'set_featured_image' => __('Set featured image', 'zabit'),
			'remove_featured_image' => __('Remove featured image', 'zabit'),
			'use_featured_image' => __('Use as featured image', 'zabit'),
			'filter_items_list' => __('Filter events list', 'zabit'),
			'items_list_navigation' => __('Events list navigation', 'zabit'),
			'items_list' => __('Events list', 'zabit'),
			'item_published' => __('Event published.', 'zabit'),
			'item_published_privately' => __('Event published privately.', 'zabit'),
			'item_reverted_to_draft' => __('Event reverted to draft.', 'zabit'),
			'item_scheduled' => __('Event scheduled.', 'zabit'),
			'item_updated' => __('Event updated.', 'zabit'),
		),
		'description' => __('Events.', 'zabit'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'events'),
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 7,
		'menu_icon' => 'dashicons-admin-site-alt3',
		'supports' => array('title'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'events'
	));

	new MetaBox(array(
		'id' => 'settings',
		'title' => __('Setting', 'zabit'),
		'screen' => 'event',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'background',
			'title'       => __('Background', 'zabit'),
			'type'        => 'media',
			'description' => __('Section background.', 'zabit'),
			'sanitize'    => 'esc_attr',
			'single'      => true,
			'default'     => '',
			'class'       => '',
			'options'     => array(
				'type' => 'image'
			)
		)
	));

	new MetaBox(array(
		'id' => 'social-fb',
		'title' => __('Facebook', 'zabit'),
		'screen' => 'event',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'enabled',
			'title'       => __('Enable', 'zabit'),
			'type'        => 'checkbox',
			'description' => __('Enable facebook meta.', 'zabit')
		),
		array(
			'id'          => 'title',
			'title'       => __('Title', 'zabit'),
			'type'        => 'text',
			'description' => __('Facebook title.', 'zabit')
		),
		array(
			'id'          => 'description',
			'title'       => __('Description', 'zabit'),
			'type'        => 'textarea',
			'description' => __('Facebook description.', 'zabit')
		),
		array(
			'id'          => 'image',
			'title'       => __('Image', 'zabit'),
			'type'        => 'media',
			'description' => __('Facebook image.', 'zabit'),
			'options'     => array(
				'type' => 'image'
			)
		)
	));

	new MetaBox(array(
		'id' => 'social-vk',
		'title' => __('VKontakte', 'zabit'),
		'screen' => 'event',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'enabled',
			'title'       => __('Enable', 'zabit'),
			'type'        => 'checkbox',
			'description' => __('Enable vk meta.', 'zabit')
		),
		array(
			'id'          => 'title',
			'title'       => __('Title', 'zabit'),
			'type'        => 'text',
			'description' => __('VKontakte title.', 'zabit')
		),
		array(
			'id'          => 'description',
			'title'       => __('Description', 'zabit'),
			'type'        => 'textarea',
			'description' => __('VKontakte description.', 'zabit')
		),
		array(
			'id'          => 'image',
			'title'       => __('Image', 'zabit'),
			'type'        => 'media',
			'description' => __('VKontakte image.', 'zabit'),
			'options'     => array(
				'type' => 'image'
			)
		)
	));

	new MetaBox(array(
		'id' => 'social-tw',
		'title' => __('Twitter', 'zabit'),
		'screen' => 'event',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'enabled',
			'title'       => __('Enable', 'zabit'),
			'type'        => 'checkbox',
			'description' => __('Enable twitter meta.', 'zabit')
		),
		array(
			'id'          => 'title',
			'title'       => __('Title', 'zabit'),
			'type'        => 'text',
			'description' => __('Twitter title.', 'zabit')
		),
		array(
			'id'          => 'description',
			'title'       => __('Description', 'zabit'),
			'type'        => 'textarea',
			'description' => __('Twitter description.', 'zabit')
		),
		array(
			'id'          => 'image',
			'title'       => __('Image', 'zabit'),
			'type'        => 'media',
			'description' => __('Twitter image.', 'zabit'),
			'options'     => array(
				'type' => 'image'
			)
		)
	));

	new MetaBox(array(
		'id'       => 'info',
		'title'    => __('Info', 'zabit'),
		'screen'   => 'event',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'date',
			'type'        => 'datetime',
			'title'       => __('Date', 'zabit'),
			'description' => __('Event date.', 'zabit'),
			'options'     => array('yy', 'mm', 'dd', 'hh', 'mn')
		),
		array(
			'id'          => 'timezone',
			'type'        => 'select',
			'title'       => __('Timezone', 'zabit'),
			'description' => __('Event date timezone.', 'zabit'),
			'placeholder' => __('Select timezone', 'zabit'),
			'options'     => array_map(function($timezone) {
				$sign = $timezone['offset'] < 0 ? '-' : '+';
				$offset = absint($timezone['offset']);

				return array(
					'title' => "(UTC{$sign}{$offset}:00) {$timezone['name']}",
					'value' => $timezone['offset']
				);
			}, json_decode(file_get_contents(get_template_directory().'/core/data/timezones.json'), true))
		),
		array(
			'id'          => 'place',
			'type'        => 'text',
			'title'       => __('Place', 'zabit'),
			'description' => __('Event place.', 'zabit'),
			'placeholder' => __('Place', 'zabit')
		),
		array(
			'id'          => 'event',
			'type'        => 'text',
			'title'       => __('Event', 'zabit'),
			'description' => __('UFC event type.', 'zabit'),
			'placeholder' => __('Event', 'zabit')
		),
		array(
			'id'          => 'ufc',
			'type'        => 'number',
			'title'       => __('UFC', 'zabit'),
			'description' => __('UFC.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'opponent',
			'type'        => 'select',
			'title'       => __('Opponent', 'zabit'),
			'description' => __('Opponent.', 'zabit'),
			'placeholder' => __('Select opponent', 'zabit'),
			'options'     => array_map(function($athlete) {
				return array(
					'title' => $athlete->post_title,
					'value' => $athlete->ID
				);
			}, get_posts(array(
				'post_type'   => 'athlete',
				'lang'        => pll_current_language('slug'),
				'numberposts' => -1,
				'exclude'     => array_filter(array(get_option('zabit_bio_general_athlete', null)))
			)))
		)
	));

	new MetaBox(array(
		'id'       => 'results',
		'title'    => __('Results', 'zabit'),
		'screen'   => 'event',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'result',
			'type'        => 'select',
			'title'       => __('Result', 'zabit'),
			'description' => __('Fight result.', 'zabit'),
			'placeholder' => __('Choose fight result', 'zabit'),
			'options'     => array(
				array(
					'title' => 'Win',
					'value' => 'win'
				),
				array(
					'title' => 'Loss',
					'value' => 'loss'
				),
				array(
					'title' => 'Draw',
					'value' => 'draw'
				)
			)
		),
		array(
			'id'          => 'round',
			'type'        => 'number',
			'title'       => __('Round', 'zabit'),
			'description' => __('Round.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'time',
			'type'        => 'datetime',
			'title'       => __('Time', 'zabit'),
			'description' => __('Fight time.', 'zabit'),
			'options'     => array('mn', 'ss')
		),
		array(
			'id'          => 'method',
			'type'        => 'select',
			'title'       => __('Method', 'zabit'),
			'description' => __('Method.', 'zabit'),
			'placeholder' => __('Choose method', 'zabit'),
			'options'     => array(
				array(
					'title' => 'Knockout',
					'value' => 'knockout'
				),
				array(
					'title' => 'Submission',
					'value' => 'submission'
				),
				array(
					'title' => 'Decision',
					'value' => 'decision'
				)
			)
		),
	));

	new MetaBox(array(
		'id'       => 'opponent2',
		'title'    => __('Zabit stats', 'zabit'),
		'screen'   => 'event',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'total_strikes',
			'type'        => 'number',
			'title'       => __('Total strikes', 'zabit'),
			'description' => __('Total strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'total_strikes_attempted',
			'type'        => 'number',
			'title'       => __('Total strikes attempted', 'zabit'),
			'description' => __('Total strikes attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sig_strikes',
			'type'        => 'number',
			'title'       => __('Significant strikes', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sig_strikes_attempted',
			'type'        => 'number',
			'title'       => __('Significant strikes attempted', 'zabit'),
			'description' => __('Significant strikes attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'standing',
			'type'        => 'number',
			'title'       => __('Standing', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'clinch',
			'type'        => 'number',
			'title'       => __('Clinch', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'ground',
			'type'        => 'number',
			'title'       => __('Ground', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'takedowns',
			'type'        => 'number',
			'title'       => __('Takedowns', 'zabit'),
			'description' => __('Takedowns.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'takedowns_attempted',
			'type'        => 'number',
			'title'       => __('Takedowns attempted', 'zabit'),
			'description' => __('Takedowns attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'knockdowns',
			'type'        => 'number',
			'title'       => __('Knockdowns', 'zabit'),
			'description' => __('Knockdowns.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sub_attempted',
			'type'        => 'number',
			'title'       => __('Submission attempted', 'zabit'),
			'description' => __('Submission attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'pass',
			'type'        => 'number',
			'title'       => __('Pass', 'zabit'),
			'description' => __('Pass.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'rev',
			'type'        => 'number',
			'title'       => __('Rev.', 'zabit'),
			'description' => __('Rev.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		)
	));

	new MetaBox(array(
		'id'       => 'opponent1',
		'title'    => __('Opponent stats', 'zabit'),
		'screen'   => 'event',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'total_strikes',
			'type'        => 'number',
			'title'       => __('Total strikes', 'zabit'),
			'description' => __('Total strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'total_strikes_attempted',
			'type'        => 'number',
			'title'       => __('Total strikes attempted', 'zabit'),
			'description' => __('Total strikes attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sig_strikes',
			'type'        => 'number',
			'title'       => __('Significant strikes', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sig_strikes_attempted',
			'type'        => 'number',
			'title'       => __('Significant strikes attempted', 'zabit'),
			'description' => __('Significant strikes attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'standing',
			'type'        => 'number',
			'title'       => __('Standing', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'clinch',
			'type'        => 'number',
			'title'       => __('Clinch', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'ground',
			'type'        => 'number',
			'title'       => __('Ground', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'takedowns',
			'type'        => 'number',
			'title'       => __('Takedowns', 'zabit'),
			'description' => __('Takedowns.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'takedowns_attempted',
			'type'        => 'number',
			'title'       => __('Takedowns attempted', 'zabit'),
			'description' => __('Takedowns attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'knockdowns',
			'type'        => 'number',
			'title'       => __('Knockdowns', 'zabit'),
			'description' => __('Knockdowns.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'sub_attempted',
			'type'        => 'number',
			'title'       => __('Submission attempted', 'zabit'),
			'description' => __('Submission attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'pass',
			'type'        => 'number',
			'title'       => __('Pass', 'zabit'),
			'description' => __('Pass.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'rev',
			'type'        => 'number',
			'title'       => __('Rev.', 'zabit'),
			'description' => __('Rev.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		)
	));

	new MetaBox(array(
		'id' => 'media',
		'title' => __('Media', 'zabit'),
		'screen' => 'event',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'    => 'gallery',
			'title' => __('Gallery', 'zabit'),
			'type'  => 'gallery'
		)
	));
}
add_action('init', 'event_init');

function event_pre_get_posts($query) {
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
		$query->set('order', 'DESC');
		$query->set('meta_key', 'info_date');
		$query->set('orderby', 'meta_value');
		$query->set('meta_query', array(
			array(
				'key'     => 'results_result',
				'compare' => 'EXISTS'
			)
		));
	}
}
add_action('pre_get_posts', 'event_pre_get_posts');

function event_item_rss() {
	global $wp_query;
	global $post;

	if ($post->post_type == 'event') {
		?>
        <query_total><?php echo $wp_query->found_posts; ?></query_total>
        <query_current><?php echo $wp_query->current_post + 1; ?></query_current>
		<?php

		$opponent = get_post_meta($post->ID, 'info_opponent', true);

		if ($opponent) :
			?>
            <opponent id="<?php echo $opponent; ?>"><?php echo get_permalink($opponent); ?></opponent>
		<?php
		endif;

		$news = get_posts(array(
			'post_type'   => 'news',
			'lang'        => pll_current_language('slug'),
			'numberposts' => -1,
			'orderby'     => 'post_date',
			'order'       => 'DESC',
			'meta_query'  => array(
				array(
					'key'     => 'attachments_events',
					'compare' => 'LIKE',
                    'value'  => '"'.$post->ID.'"'
				)
			)
		));

		?>
        <news_list>
            <?php foreach ($news as $i) : ?>
                <news id="<?php echo $i->ID; ?>" date="<?php echo get_the_date('r', $i); ?>"><?php echo get_permalink($i); ?></news>
            <?php endforeach; ?>
        </news_list>
        <?php
	}
}
add_action('rss2_item', 'event_item_rss');

function event_entity_rss() {
	global $post;

	if ($post->post_type == 'event') {
		$previous = get_previous_post();
		$next = get_next_post();

		if ($previous) :
			?>
            <previous id="<?php echo $previous->ID; ?>"><?php echo get_permalink($previous); ?></previous>
		<?php
		endif;

		if ($next) :
			?>
            <next id="<?php echo $next->ID; ?>"><?php echo get_permalink($next); ?></next>
		<?php
		endif;

		$opponent = get_post_meta($post->ID, 'info_opponent', true);

		if ($opponent) :
			?>
            <opponent id="<?php echo $opponent; ?>"><?php echo get_permalink($opponent); ?></opponent>
		<?php
		endif;

		$news = get_posts(array(
			'post_type'   => 'news',
			'lang'        => pll_current_language('slug'),
			'numberposts' => -1,
			'orderby'     => 'post_date',
            'order'       => 'DESC',
			'meta_query'  => array(
				array(
					'key'     => 'attachments_events',
					'compare' => 'LIKE',
					'value'  => '"'.$post->ID.'"'
				)
			)
		));

		?>
        <news_list>
			<?php foreach ($news as $i) : ?>
                <news id="<?php echo $i->ID; ?>" date="<?php echo get_the_date('r', $i); ?>"><?php echo get_permalink($i); ?></news>
			<?php endforeach; ?>
        </news_list>
		<?php
	}
}
add_action('commentsrss2_head', 'event_entity_rss');