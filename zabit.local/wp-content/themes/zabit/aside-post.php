<?php

$thumbnail = has_post_thumbnail() ? get_post_thumbnail_id() : '';
$youtube = get_post_meta(get_the_ID(), 'settings_youtube', true);

if ($thumbnail || $youtube) { ?>
<aside class="aside aside_left aside_full aside_post">
	<?php if ($thumbnail) get_background($thumbnail, 'left');

    if ($youtube) : ?>
        <a class="youtube-play" href="#" title="<?php _e('Watch video', 'zabit'); ?>">
	        <?php
                $play = get_option('zabit_general_general_youtube', null);

                if ($play) echo new SVG($play);
            ?>
        </a>
    <?php endif; ?>
</aside>
<?php }