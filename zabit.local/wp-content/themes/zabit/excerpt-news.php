<?php

    if (has_post_thumbnail()) {
        $dataImage = array();
        $attachment = wp_get_attachment_image_src(get_post_thumbnail_id(), 'excerpt');

        foreach (array('src', 'width', 'height') as $i => $key) {
            array_push($dataImage, sprintf('data-image_%s="%s"', $key, $attachment[$i]));
        }
    }

?>
<a class="news-excerpt" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" <?php echo isset($dataImage) ? implode(' ', $dataImage) : ''; ?>>
    <div class="news-excerpt__text"><?php echo get_post_meta(get_the_ID(), 'excerpt_text', true); ?></div>
    <span class="news-excerpt__date"><?php echo get_the_date(); ?></span>
</a>