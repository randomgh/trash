<aside class="aside aside_left aside_full aside_about">
	<?php
        if (has_post_thumbnail()) {
	        get_background(get_post_thumbnail_id(get_the_ID()), 'left');
        }

        get_title();
        get_block('bio');
	?>
</aside>