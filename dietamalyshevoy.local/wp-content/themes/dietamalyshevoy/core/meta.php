<?php

add_filter( 'feed_links_show_comments_feed', '__return_false' );

remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

add_filter('the_generator', '__return_empty_string');

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

remove_action('wp_head', 'wp_resource_hints', 2);

remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

function meta_wp_head() {
    $current = get_the_ID();
    $home = get_option('page_on_front');

	if (get_post_meta($current, 'social-fb_enabled', true)) {
		$fb_page = $current;
	} elseif (get_post_meta($home, 'social-fb_enabled', true)) {
		$fb_page = $home;
	} else {
		$fb_page = null;
	}

	if (get_post_meta($current, 'social-tw_enabled', true)) {
		$tw_page = $current;
	} elseif (get_post_meta($home, 'social-tw_enabled', true)) {
		$tw_page = $home;
	} else {
		$tw_page = null;
	}

	if (get_post_meta($current, 'social-vk_enabled', true)) {
		$vk_page = $current;
	} elseif (get_post_meta($home, 'social-vk_enabled', true)) {
		$vk_page = $home;
	} else {
		$vk_page = null;
	}

    ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, minimal-ui">
    <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() || is_home() ? bloginfo('description') : wp_title(''); ?></title>

	<?php if ($vk_page) :
		$title = get_post_meta($tw_page, 'social-vk_title', true);
		$description = get_post_meta($tw_page, 'social-vk_description', true);
		$image = get_post_meta($tw_page, 'social-vk_image', true);
		list($src, $width, $height) = $image ? wp_get_attachment_image_src($image, 'social-vk') : array('', 0, 0);

		if ($title) : ?>
            <meta name="mrc__share_title" content="<?php echo $title; ?>" />
	    <?php endif;
        if ($description) : ?>
            <meta name="description" content="<?php echo $description; ?>" />
        <?php endif;
        if ($image) : ?>
            <meta name="vk:image" content="<?php echo $src; ?>" />
        <?php endif;
	endif;

	if ($tw_page) :
		$title = get_post_meta($tw_page, 'social-tw_title', true);
		$description = get_post_meta($tw_page, 'social-tw_description', true);
		$image = get_post_meta($tw_page, 'social-tw_image', true);
		list($src, $width, $height) = $image ? wp_get_attachment_image_src($image, 'social-tw') : array('', 0, 0);
		?>
        <meta name="twitter:card" content="summary" />
		<?php if ($title) : ?>
        <meta name="twitter:title" content="<?php echo $title; ?>" />
	    <?php endif;
		if ($description) : ?>
            <meta name="twitter:description" content="<?php echo $description; ?>" />
		<?php endif;
		if ($image) : ?>
            <meta name="twitter:image" content="<?php echo $src; ?>" />
		<?php endif;
	endif;

    if ($fb_page) :
		$title = get_post_meta($tw_page, 'social-fb_title', true);
		$description = get_post_meta($tw_page, 'social-fb_description', true);
		$image = get_post_meta($tw_page, 'social-fb_image', true);
		list($src, $width, $height) = $image ? wp_get_attachment_image_src($image, 'social-fb') : array('', 0, 0);
		?>
        <meta property="og:url" content="<?php the_permalink(); ?>" />
		<?php if ($title) : ?>
            <meta property="og:title" content="<?php echo $title; ?>" />
		<?php endif;
		if ($description) : ?>
            <meta property="og:description" content="<?php echo $description; ?>" />
		<?php endif;
		if ($image) : ?>
            <meta property="og:image" content="<?php echo $src; ?>" />
            <meta property="og:image:width" content="<?php echo $width; ?>" />
            <meta property="og:image:height" content="<?php echo $height; ?>" />
		<?php endif;
    endif;
}
add_action('wp_head', 'meta_wp_head', 0);