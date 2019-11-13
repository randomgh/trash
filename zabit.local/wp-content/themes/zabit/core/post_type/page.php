<?php

function page_init(){
	foreach (array('post-formats', 'trackbacks', 'comments', 'author', 'custom-fields', 'page-attributes') as $feature) {
		remove_post_type_support('page', $feature);
	}

	foreach (array('excerpt', 'thumbnail') as $feature) {
		add_post_type_support('page', $feature);
	}

	new MetaBox(array(
		'id' => 'settings',
		'title' => __('Setting', 'zabit'),
		'screen' => 'page',
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
		),
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
		),
		array(
			'id'          => 'background-video',
			'title'       => __('Video', 'zabit'),
			'type'        => 'media',
			'description' => __('Background video.', 'zabit'),
			'sanitize'    => 'esc_attr',
			'single'      => true,
			'default'     => '',
			'class'       => '',
            'options'     => array(
                'type' => 'video'
            )
		)
	));

	//TODO: remove apps non-html fix
	new MetaBox(array(
		'id'       => 'apps',
		'title'    => __('Apps', 'zabit'),
		'screen'   => 'page',
		'context'  => 'normal',
		'priority' => 'default'
	), array(array(
		'id'          => 'text',
		'type'        => 'textarea',
		'description' => __('Content for apps.', 'zabit'),
		'placeholder' => __('Content', 'zabit')
	)));

	new MetaBox(array(
		'id' => 'social-fb',
		'title' => __('Facebook', 'zabit'),
		'screen' => 'page',
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
		'screen' => 'page',
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
		'screen' => 'page',
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
}
add_action('init', 'page_init');

function page_item_rss() {
	global $wp_query;
	global $post;

	if ($post->post_type == 'page') {
		?>
		<query_total><?php echo $wp_query->found_posts; ?></query_total>
		<query_current><?php echo $wp_query->current_post + 1; ?></query_current>
		<?php

		if (has_post_thumbnail($post)) {
			$id = get_post_thumbnail_id($post);
			list($src, $width, $height) = wp_get_attachment_image_src($id, 'full');

			printf('<%1$s id="%3$s" width="%4$d" height="%5$d">%2$s</%1$s>', 'thumbnail', $src, $id, $width, $height);
		}
            ?>
			<excerpt><![CDATA[<?php the_excerpt_rss(); ?>]]></excerpt>
            <content:encoded><![CDATA[<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)); ?>]]></content:encoded>
            <?php
	}
}
add_action('rss2_item', 'page_item_rss');

function page_entity_rss() {
	global $post;

	if ($post->post_type == 'page') {
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

		?>
        <excerpt><![CDATA[<?php the_excerpt_rss(); ?>]]></excerpt>
        <content:encoded><![CDATA[<?php echo apply_filters('the_content', get_post_field('post_content', $post->ID)); ?>]]></content:encoded>
		<?php
	}
}
add_action('commentsrss2_head', 'page_entity_rss');