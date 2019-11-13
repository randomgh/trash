<?php

function athlete_init(){
	register_post_type('athlete', array(
		'label' => __('Athletes', 'zabit'),
		'labels' => array(
			'name' => __('Athletes', 'zabit'),
			'singular_name' => __('Athlete', 'zabit'),
			'menu_name' => __('Athletes', 'zabit'),
			'name_admin_bar' => __('Athlete', 'zabit'),
			'add_new' => __('Add new', 'zabit'),
			'add_new_item' => __('Add new athlete', 'zabit'),
			'new_item' => __('New athlete', 'zabit'),
			'edit_item' => __('Edit athlete', 'zabit'),
			'view_item' => __('View athlete', 'zabit'),
			'view_items' => __('View athletes', 'zabit'),
			'all_items' => __('All athletes', 'zabit'),
			'search_items' => __('Search athletes', 'zabit'),
			'parent_item_colon' => __('Parent athlete:', 'zabit'),
			'not_found' => __('No athletes found.', 'zabit'),
			'not_found_in_trash' => __('No athletes found in Trash.', 'zabit'),
			'archives' => __('Athletes archives', 'zabit'),
			'attributes' => __('Athletes attributes', 'zabit'),
			'insert_into_item' => __('Insert into athletes', 'zabit'),
			'uploaded_to_this_item' => __('Uploaded to this athlete', 'zabit'),
			'featured_image' => __('Featured image', 'zabit'),
			'set_featured_image' => __('Set featured image', 'zabit'),
			'remove_featured_image' => __('Remove featured image', 'zabit'),
			'use_featured_image' => __('Use as featured image', 'zabit'),
			'filter_items_list' => __('Filter athletes list', 'zabit'),
			'items_list_navigation' => __('Athletes list navigation', 'zabit'),
			'items_list' => __('Athletes list', 'zabit'),
			'item_published' => __('Athlete published.', 'zabit'),
			'item_published_privately' => __('Athlete published privately.', 'zabit'),
			'item_reverted_to_draft' => __('Athlete reverted to draft.', 'zabit'),
			'item_scheduled' => __('Athlete scheduled.', 'zabit'),
			'item_updated' => __('Athlete updated.', 'zabit'),
		),
		'description' => __('Athletes.', 'zabit'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'athletes'),
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-groups',
		'supports' => array('title', 'thumbnail'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'athletes'
	));

	new MetaBox(array(
		'id'       => 'bio',
		'title'    => __('Bio', 'zabit'),
		'screen'   => 'athlete',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'country',
			'type'        => 'select',
			'title'       => __('Homeland', 'zabit'),
			'description' => __('Athlete\'s homeland.', 'zabit'),
			'placeholder' => __('Select country', 'zabit'),
			'options'     => array_map(function($country) {
				return array(
					'title' => $country['name'],
					'value' => $country['code']
				);
			}, json_decode(file_get_contents(get_template_directory().'/core/data/countries.json'), true))
		),
		array(
			'id'          => 'town',
			'type'        => 'text',
			'title'       => __('Hometown', 'zabit'),
			'description' => __('Athlete\'s home town.', 'zabit'),
			'placeholder' => __('Town', 'zabit')
		),
		array(
			'id'          => 'birthday',
			'type'        => 'datetime',
			'title'       => __('Birthday', 'zabit'),
			'description' => __('Athlete\'s birthday.', 'zabit'),
			'options'     => array('yy', 'mm', 'dd')
		),
		array(
			'id'          => 'height',
			'type'        => 'number',
			'title'       => __('Height', 'zabit'),
			'description' => __('Athlete\'s height.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'weight',
			'type'        => 'number',
			'title'       => __('Weight', 'zabit'),
			'description' => __('Athlete\'s weight.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'hand_reach',
			'type'        => 'number',
			'title'       => __('Hand reach', 'zabit'),
			'description' => __('Athlete\'s hand reach.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'leg_reach',
			'type'        => 'number',
			'title'       => __('Leg reach', 'zabit'),
			'description' => __('Athlete\'s leg reach.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'mma_debut',
			'type'        => 'datetime',
			'title'       => __('Debut in MMA', 'zabit'),
			'description' => __('Athlete\'s debut in MMA.', 'zabit'),
			'options'     => array('yy', 'mm', 'dd')
		),
		array(
			'id'          => 'octagon_debut',
			'type'        => 'datetime',
			'title'       => __('Debut in UFC', 'zabit'),
			'description' => __('Athlete\'s octagon debut.', 'zabit'),
			'options'     => array('yy', 'mm', 'dd')
		),
		array(
			'id'          => 'division',
			'type'        => 'select',
			'title'       => __('Division', 'zabit'),
			'description' => __('Athlete\'s weight division.', 'zabit'),
			'placeholder' => __('Select division', 'zabit'),
			'options'     => array_map(function($division) {
				return array(
					'title' => $division['name'],
					'value' => $division['slug']
				);
			}, json_decode(file_get_contents(get_template_directory().'/core/data/divisions.json'), true))
		),
		array(
			'id'          => 'division_rank',
			'type'        => 'number',
			'title'       => __('Division rank', 'zabit'),
			'description' => __('Athlete\'s division rank.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'rank',
			'type'        => 'number',
			'title'       => __('Rank', 'zabit'),
			'description' => __('Athlete\'s total rank.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		)
	));

	new MetaBox(array(
		'id'       => 'fights',
		'title'    => __('Fights', 'zabit'),
		'screen'   => 'athlete',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'record_streak',
			'type'        => 'number',
			'title'       => __('Record win streak', 'zabit'),
			'description' => __('Record fight win streak.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'record_knockouts',
			'type'        => 'number',
			'title'       => __('Record win knockouts', 'zabit'),
			'description' => __('Record wins by knockout.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'record_submissions',
			'type'        => 'number',
			'title'       => __('Record win submissions', 'zabit'),
			'description' => __('Record wins by submission.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'win_knockouts',
			'type'        => 'number',
			'title'       => __('Win knockouts', 'zabit'),
			'description' => __('Wins by knockout.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'win_submissions',
			'type'        => 'number',
			'title'       => __('Win submissions', 'zabit'),
			'description' => __('Wins by submission.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'win_decisions',
			'type'        => 'number',
			'title'       => __('Win decisions', 'zabit'),
			'description' => __('Wins by decision.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'loss_knockouts',
			'type'        => 'number',
			'title'       => __('Loss knockouts', 'zabit'),
			'description' => __('Losses by knockout.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'loss_submissions',
			'type'        => 'number',
			'title'       => __('Loss submissions', 'zabit'),
			'description' => __('Losses by submission.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'loss_decisions',
			'type'        => 'number',
			'title'       => __('Loss decisions', 'zabit'),
			'description' => __('Losses by decision.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'draws',
			'type'        => 'number',
			'title'       => __('Draws', 'zabit'),
			'description' => __('Draws.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'last',
			'type'        => 'select',
			'title'       => __('Last', 'zabit'),
			'description' => __('Last fight result.', 'zabit'),
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
		)
	));

	new MetaBox(array(
		'id'       => 'stats',
		'title'    => __('Stats', 'zabit'),
		'screen'   => 'athlete',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'time',
			'type'        => 'datetime',
			'title'       => __('Fight time', 'zabit'),
			'description' => __('Average fight time.', 'zabit'),
			'options'     => array('mn', 'ss')
		),
		array(
			'id'          => 'knockdown',
			'type'        => 'number',
			'title'       => __('Knockdown average', 'zabit'),
			'description' => __('Knockdown average per 15 min.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		)
	));

	new MetaBox(array(
		'id'       => 'strikes',
		'title'    => __('Significant strikes', 'zabit'),
		'screen'   => 'athlete',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'landed',
			'type'        => 'number',
			'title'       => __('Landed', 'zabit'),
			'description' => __('Significant strikes landed.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'attempted',
			'type'        => 'number',
			'title'       => __('Attempted', 'zabit'),
			'description' => __('Significant strikes attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'landed_ratio',
			'type'        => 'number',
			'title'       => __('Landed ratio', 'zabit'),
			'description' => __('Significant strikes landed per minute.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'absorbed_ratio',
			'type'        => 'number',
			'title'       => __('Absorbed ratio', 'zabit'),
			'description' => __('Absorbed per minute.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'defence',
			'type'        => 'number',
			'title'       => __('Defence', 'zabit'),
			'description' => __('Defence.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1
			)
		),
		array(
			'id'          => 'head',
			'type'        => 'number',
			'title'       => __('Head', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'body',
			'type'        => 'number',
			'title'       => __('Body', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'leg',
			'type'        => 'number',
			'title'       => __('Leg', 'zabit'),
			'description' => __('Significant strikes.', 'zabit'),
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
		)
	));

	new MetaBox(array(
		'id'       => 'grappling',
		'title'    => __('Grappling', 'zabit'),
		'screen'   => 'athlete',
		'context'  => 'normal',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'landed',
			'type'        => 'number',
			'title'       => __('Landed', 'zabit'),
			'description' => __('Takedowns landed.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'attempted',
			'type'        => 'number',
			'title'       => __('Attempted', 'zabit'),
			'description' => __('Takedowns attempted.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 1
			)
		),
		array(
			'id'          => 'landed_ratio',
			'type'        => 'number',
			'title'       => __('Landed ratio', 'zabit'),
			'description' => __('Takedowns landed per 15 minute.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'submission_ratio',
			'type'        => 'number',
			'title'       => __('Submission ratio', 'zabit'),
			'description' => __('Submission per 15 minute.', 'zabit'),
			'options'     => array(
				'min' => 0,
				'step' => 0.01
			)
		),
		array(
			'id'          => 'defence',
			'type'        => 'number',
			'title'       => __('Defence', 'zabit'),
			'description' => __('Takedown defence.', 'zabit'),
			'options'     => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1
			)
		)
	));
}
add_action('init', 'athlete_init');

function athlete_item_rss() {
	global $post;

	if ($post->post_type == 'athlete') {
		if (has_post_thumbnail($post)) {
			$id = get_post_thumbnail_id($post);
			list($src, $width, $height) = wp_get_attachment_image_src($id, 'full');

			printf('<%1$s id="%3$s" width="%4$d" height="%5$d">%2$s</%1$s>', 'thumbnail', $src, $id, $width, $height);
		}

		$countries = json_decode(file_get_contents(get_template_directory().'/core/data/countries.json'), true);
		$country = get_post_meta($post->ID, 'bio_country', true);

		if ($country) :
			$country_found = array_values(array_filter($countries, function($country_object) use ($country) {
				return $country_object['code'] == $country;
			}));

			if (count($country_found) == 1) :
				?>
                <country code="<?php echo $country_found[0]['code']; ?>"><?php echo $country_found[0]['name']; ?></country>
			<?php
			endif;
		endif;

		$division = get_post_meta($post->ID, 'bio_division', true);

		$divisions = json_decode(file_get_contents(get_template_directory().'/core/data/divisions.json'), true);

		if ($division) {
			$division_found = array_values(array_filter($divisions, function($division_object) use ($division) {
				return $division_object['slug'] == $division;
			}));

			if (count($division_found) == 1) :
				?>
                <division slug="<?php echo $division_found[0]['slug']; ?>"><?php echo $division_found[0]['name']; ?></division>
			<?php
			endif;
		}
	}
}
add_action('rss2_item', 'athlete_item_rss');

function athlete_entity_rss() {
	global $post;

	if ($post->post_type == 'athlete') {
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

		if (has_post_thumbnail($post)) {
			$id = get_post_thumbnail_id($post);
			list($src, $width, $height) = wp_get_attachment_image_src($id, 'full');

			printf('<%1$s id="%3$s" width="%4$d" height="%5$d">%2$s</%1$s>', 'thumbnail', $src, $id, $width, $height);
		}

		$countries = json_decode(file_get_contents(get_template_directory().'/core/data/countries.json'), true);
		$country = get_post_meta($post->ID, 'bio_country', true);

		if ($country) :
			$country_found = array_values(array_filter($countries, function($country_object) use ($country) {
				return $country_object['code'] == $country;
			}));

		    if (count($country_found) == 1) :
                ?>
                <country code="<?php echo $country_found[0]['code']; ?>"><?php echo $country_found[0]['name']; ?></country>
                <?php
            endif;
		endif;

		$division = get_post_meta($post->ID, 'bio_division', true);

		$divisions = json_decode(file_get_contents(get_template_directory().'/core/data/divisions.json'), true);

		if ($division) {
			$division_found = array_values(array_filter($divisions, function($division_object) use ($division) {
				return $division_object['slug'] == $division;
			}));

			if (count($division_found) == 1) :
				?>
                <division slug="<?php echo $division_found[0]['slug']; ?>"><?php echo $division_found[0]['name']; ?></division>
			<?php
			endif;
		}
	}
}
add_action('commentsrss2_head', 'athlete_entity_rss');