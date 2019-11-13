<?php

    global $overlay;

?>
<section class="section section_accomplishments">
    <?php
        get_aside('accomplishments');

        if ($overlay['right']) get_aside('right');
	?>
	<div class="content">
        <?php get_block('accomplishments'); ?>
	</div>
</section>