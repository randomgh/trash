<?php

    the_post();

?>
<section class="section">
    <?php
        if ($overlay['left']) get_aside('left');
        if ($overlay['right']) get_aside('right');
    ?>
	<div class="content">
		<?php get_block('mce'); ?>
	</div>
</section>