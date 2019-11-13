<?php

function news_init(){
	register_post_type('news', array(
		'label' => __('News', 'zabit'),
		'labels' => array(
			'name' => __('News', 'zabit'),
			'singular_name' => __('News post', 'zabit'),
			'menu_name' => __('News', 'zabit'),
			'name_admin_bar' => __('News post', 'zabit'),
			'add_new' => __('Add new', 'zabit'),
			'add_new_item' => __('Add new news post', 'zabit'),
			'new_item' => __('New news post', 'zabit'),
			'edit_item' => __('Edit news post', 'zabit'),
			'view_item' => __('View news post', 'zabit'),
			'view_items' => __('View news', 'zabit'),
			'all_items' => __('All news', 'zabit'),
			'search_items' => __('Search news', 'zabit'),
			'parent_item_colon' => __('Parent news post:', 'zabit'),
			'not_found' => __('No news found.', 'zabit'),
			'not_found_in_trash' => __('No news found in Trash.', 'zabit'),
			'archives' => __('News archives', 'zabit'),
			'attributes' => __('News attributes', 'zabit'),
			'insert_into_item' => __('Insert into news', 'zabit'),
			'uploaded_to_this_item' => __('Uploaded to this news post', 'zabit'),
			'featured_image' => __('Featured image', 'zabit'),
			'set_featured_image' => __('Set featured image', 'zabit'),
			'remove_featured_image' => __('Remove featured image', 'zabit'),
			'use_featured_image' => __('Use as featured image', 'zabit'),
			'filter_items_list' => __('Filter news list', 'zabit'),
			'items_list_navigation' => __('News list navigation', 'zabit'),
			'items_list' => __('News list', 'zabit'),
			'item_published' => __('News post published.', 'zabit'),
			'item_published_privately' => __('News post published privately.', 'zabit'),
			'item_reverted_to_draft' => __('News post reverted to draft.', 'zabit'),
			'item_scheduled' => __('News post scheduled.', 'zabit'),
			'item_updated' => __('News post updated.', 'zabit'),
		),
		'description' => __('News.', 'zabit'),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'news'),
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-media-document',
		'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
		'delete_with_user' => false,
		'map_meta_cap' => null,
		'show_in_rest' => true,
		'rest_base' => 'news'
	));

	new MetaBox(array(
		'id' => 'settings',
		'title' => __('Setting', 'zabit'),
		'screen' => 'news',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'youtube',
			'title'       => __('Video', 'zabit'),
			'type'        => 'text',
			'description' => __('YouTube video ID.', 'zabit'),
			'sanitize'    => 'esc_attr',
			'single'      => true,
			'default'     => '',
			'class'       => ''
		)
	));

	//TODO: remove apps non-html fix
	new MetaBox(array(
		'id'       => 'apps',
		'title'    => __('Apps', 'zabit'),
		'screen'   => 'news',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'text',
		'type'        => 'textarea',
		'description' => __('Content for apps.', 'zabit'),
		'placeholder' => __('Content', 'zabit')
	)));

	new MetaBox(array(
		'id'       => 'excerpt',
		'title'    => __('Excerpt', 'zabit'),
		'screen'   => 'news',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'text',
		'type'        => 'editor',
		'description' => __('Excerpt description.', 'zabit'),
		'placeholder' => __('Excerpt', 'zabit')
	)));

	new MetaBox(array(
		'id' => 'social-fb',
		'title' => __('Facebook', 'zabit'),
		'screen' => 'news',
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
		'screen' => 'news',
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
		'screen' => 'news',
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
		'id' => 'attachments',
		'title' => __('Attachments', 'zabit'),
		'screen' => 'news',
		'context' => 'side',
		'priority' => 'default'
	), array(
		array(
			'id'          => 'events',
			'title'       => __('Events', 'zabit'),
			'type'        => 'select',
			'options'     => array_map(function($news) {
				return array(
					'title' => $news->post_title,
					'value' => $news->ID
				);
			}, get_posts(array(
				'post_type'   => 'event',
				'lang'        => pll_current_language('slug'),
				'numberposts' => -1
			))),
			'multiple'    => true
		)
	));

	new MetaBox(array(
		'id' => 'media',
		'title' => __('Media', 'zabit'),
		'screen' => 'news',
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
add_action('init', 'news_init');

function news_item_rss() {
	global $wp_query;
	global $post;

	if ($post->post_type == 'news') {
		?>
        <query_total><?php echo $wp_query->found_posts; ?></query_total>
        <query_current><?php echo $wp_query->current_post + 1; ?></query_current>
		<?php

		if (has_post_thumbnail($post)) {
			$id = get_post_thumbnail_id($post);
			list($src, $width, $height) = wp_get_attachment_image_src($id, 'full');

			printf('<%1$s id="%3$s" width="%4$d" height="%5$d">%2$s</%1$s>', 'thumbnail', $src, $id, $width, $height);
		}

		$attachments_events = get_post_meta($post->ID, 'attachments_events', true);

		?>
        <events_list>
			<?php foreach ($attachments_events as $i) : ?>
                <event id="<?php echo $i->ID; ?>"><?php echo get_permalink($i); ?></event>
			<?php endforeach; ?>
        </events_list>
		<?php
	}
}
add_action('rss2_item', 'news_item_rss');

function news_entity_rss() {
	global $post;

	if ($post->post_type == 'news') {
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

		$attachments_events = get_post_meta($post->ID, 'attachments_events', true);

		?>
        <events_list>
			<?php foreach ($attachments_events as $i) : ?>
                <event id="<?php echo $i->ID; ?>"><?php echo get_permalink($i); ?></event>
			<?php endforeach; ?>
        </events_list>
		<?php

		if (get_option('rss_use_excerpt')) : ?>
            <excerpt><![CDATA[<?php the_excerpt_rss(); ?>]]></excerpt>
		<?php else : ?>
            <excerpt><![CDATA[<?php the_excerpt_rss(); ?>]]></excerpt>

			<?php
			$content = get_the_content_feed('rss2');
			if (strlen( $content ) > 0) :
				?>
                <content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
			<?php else : ?>
                <content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
			<?php endif;
		endif;
	}
}
add_action('commentsrss2_head', 'news_entity_rss');