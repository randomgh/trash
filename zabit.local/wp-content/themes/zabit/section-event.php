<?php

    global $overlay;

?>
<section class="section section_event">
	<?php
	    get_aside('event');

        if ($overlay['right']) get_aside('right');
	?>
    <div class="content">
        <?php get_block('list'); ?>
    </div>
</section>