<?php

    global $overlay;

    $page = get_option('zabit_general_general_error_page', null);

    if ($page) {
        $background = get_post_meta($page, 'settings_background', true);
    }

?>
<section class="section section_error">
	<?php if (isset($background)) get_background($background, 'full'); ?>
    <div class="content content_flex">
        <?php get_block('error'); ?>
    </div>
</section>