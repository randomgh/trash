<?php

    global $overlay;

?>
<section class="section section_news">
	<?php
	    get_aside('news');

        if ($overlay['right']) get_aside('right');
	?>
    <div class="content">
        <?php get_block('list'); ?>
    </div>
</section>