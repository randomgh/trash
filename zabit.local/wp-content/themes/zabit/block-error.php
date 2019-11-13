<?php

    $page = get_option('zabit_general_general_error_page', null);

    if ($page) {
        $page = pll_get_post($page);
    }

?>
<div class="error">
    <?php if ($page) : ?>
        <div class="error__title"><?php echo get_the_title($page); ?></div>
    <?php endif; ?>
    <a class="error__link" href="<?php echo pll_home_url(); ?>" title="<?php echo get_the_title(pll_get_post(get_option('page_on_front'))); ?>"><?php _e('The page is not found', 'zabit'); ?></a>
</div>