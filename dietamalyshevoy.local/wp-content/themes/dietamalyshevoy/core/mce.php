<?php

function dem_allowed_block_types($allowed_blocks, $post) {
	return array_merge(array(
		'core/paragraph',
//		'core/image',
//		'core/heading',
//		'core/gallery',
//		'core/list',
//		'core/quote',
//		'core/audio',
//		'core/cover',
//		'core/file',
//		'core/video',
//		'core/table',
//		'core/verse',
//		'core/code',
//		'core/freeform',
//		'core/html',
//		'core/preformatted',
//		'core/pullquote',
//		'core/button',
//		'core/text-columns',
//		'core/media-text',
//		'core/more',
//		'core/nextpage',
//		'core/separator',
//		'core/spacer',
//		'core/shortcode',
//		'core/archives',
//		'core/categories',
//		'core/latest-comments',
//		'core/latest-posts',
//		'core/embed',
//		'core-embed/twitter',
//		'core-embed/youtube',
//		'core-embed/facebook',
//		'core-embed/instagram',
//		'core-embed/wordpress',
//		'core-embed/soundcloud',
//		'core-embed/spotify',
//		'core-embed/flickr',
//		'core-embed/vimeo',
//		'core-embed/animoto',
//		'core-embed/cloudup',
//		'core-embed/collegehumor',
//		'core-embed/dailymotion',
//		'core-embed/funnyordie',
//		'core-embed/hulu',
//		'core-embed/imgur',
//		'core-embed/issuu',
//		'core-embed/kickstarter',
//		'core-embed/meetup-com',
//		'core-embed/mixcloud',
//		'core-embed/photobucket',
//		'core-embed/polldaddy',
//		'core-embed/reddit',
//		'core-embed/reverbnation',
//		'core-embed/screencast',
//		'core-embed/scribd',
//		'core-embed/slideshare',
//		'core-embed/smugmug',
//		'core-embed/speaker',
//		'core-embed/ted',
//		'core-embed/tumblr',
//		'core-embed/videopress',
//		'core-embed/wordpress-tv'
	), array_map(function($block) {
		return "dem/$block";
	}, array('head1', 'error')));
}
add_filter('allowed_block_types', 'dem_allowed_block_types', 10, 2);

function dem_mce_init() {
	$type_prefix = 'dem';
	$id_prefix = "$type_prefix-mce";

	$style_path = '/css/build/blocks';
	$script_path = '/js/build/blocks';

	$style_deps = array('wp-edit-blocks');
	$script_deps = array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor');

	foreach (array('head1', 'error') as $block) {
		$block_id = "$id_prefix-$block";
		$block_editor_id = "$id_prefix-$block-editor";

		$style_file = "$style_path/$block.css";
		$style_file_editor = "$style_path/$block-editor.css";

		$script_file = "$script_path/$block.js";
		$script_file_editor = "$script_path/$block-editor.js";

		$style_file_uri = get_theme_file_uri($style_file);
		$style_file_uri_editor = get_theme_file_uri($style_file_editor);

		$style_file_path = get_theme_file_path($style_file);
		$style_file_path_editor = get_theme_file_path($style_file_editor);

		$script_file_uri = get_theme_file_uri($script_file);
		$script_file_uri_editor = get_theme_file_uri($script_file_editor);

		$script_file_path = get_theme_file_path($script_file);
		$script_file_path_editor = get_theme_file_path($script_file_editor);

		$options = array();

		if (file_exists($style_file_path)) {
			wp_register_style($block_id, $style_file_uri, array('dem'), filemtime($style_file_path));

			$options['style'] = $block_id;
		}

		if (file_exists($style_file_path_editor)) {
			wp_register_style($block_editor_id, $style_file_uri_editor, $style_deps, filemtime($style_file_path_editor));

			$options['editor_style'] = $block_editor_id;
		}

		if (file_exists($script_file_path)) {
			wp_register_script($block_id, $script_file_uri, array('dem'), filemtime($script_file_path));

			$options['script'] = $block_id;
		}

		if (file_exists($script_file_path_editor)) {
			wp_register_script($block_editor_id, $script_file_uri_editor, $script_deps, filemtime($script_file_path_editor));

			$options['editor_script'] = $block_editor_id;
		}

		if (count($options) > 0) {
			register_block_type("$type_prefix/$block", $options);
		}
	}

}
add_action('init', 'dem_mce_init');