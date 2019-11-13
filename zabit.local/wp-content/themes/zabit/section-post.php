<?php

    global $route;
    global $overlay;

    the_post();

?>
<section class="section section_<?php echo $route; ?>">
	<?php
        if (in_array($route, array('news', 'post'))) {
	        $youtube = get_post_meta(get_the_ID(), 'settings_youtube', true);
	        if ($youtube) get_youtube($youtube);

            get_aside('post');
        } elseif (in_array($route, array('index', 'about'))) {
	        $background = get_post_meta(get_the_ID(), 'settings_background', true);
	        if ($background) get_background($background, 'full');

	        $background_video = get_post_meta(get_the_ID(), 'settings_background-video', true);
	        if ($background_video) get_video($background_video);

	        get_aside($route);
        } elseif ($route == 'event') {
	        $background = get_post_meta(get_the_ID(), 'settings_background', true);
	        if ($background) get_background($background, 'static');

	        $background_video = get_post_meta(get_the_ID(), 'settings_background-video', true);
	        if ($background_video) get_video($background_video);
        } elseif ($overlay['left']) {
            get_aside('left');
        }

        if ($overlay['right']) get_aside('right');
	?>
	<div class="content <?php echo $route == 'index' ? 'content_empty' : ''; ?>">
		<?php if (in_array($route, array('news'))) {
		    get_block('meta');
        }

        if ($route == 'event') {
            if (get_post_meta(get_the_ID(), 'results_result', true)) {
	            get_block('results');
            } else {
	            get_block('matchup');
            }
        } else {
	        get_block('mce');
        }

        if (in_array($route, array('news', 'post'))) {
			get_block('social');
		} ?>
	</div>
</section>