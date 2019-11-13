<?php

    $excerpt = get_post_meta(get_the_ID(), 'excerpt_text', true);
    $date = get_the_date();

?>
<div class="meta">
    <?php if ($excerpt) : ?>
        <div class="meta__excerpt"><?php echo $excerpt; ?></div>
    <?php else: ?>
        <div class="meta__title"><?php echo get_the_title(); ?></div>
    <?php endif;
    if ($date) : ?>
        <div class="meta__date"><?php echo $date; ?></div>
    <?php endif; ?>
</div>