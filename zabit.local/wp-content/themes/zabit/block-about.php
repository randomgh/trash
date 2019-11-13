<?php

    $about = pll_get_post(get_option('zabit_general_general_about_page', null));

    if ($about) {
        $excerpt = get_the_excerpt($about);
    }

    $athlete = get_option('zabit_bio_general_athlete', null);

    if ($athlete) {
        $athlete = pll_get_post($athlete);

        $athleteTitle = explode(' ', get_the_title($athlete));
        $athleteTitleCount = count($athleteTitle);

        $first_name = implode(' ', $athleteTitleCount > 1 ? array_slice($athleteTitle, 0, -1) : $athleteTitle);
        $last_name = $athleteTitleCount > 1 ? $athleteTitle[$athleteTitleCount - 1] : '';
    }

    $aboutLink = isset($athleteTitleCount) && $athleteTitleCount ? sprintf(__('about %s', 'zabit'), $first_name) : __('about', 'zabit');

?>
<div class="about">
	<?php if ($athlete && isset($athleteTitleCount) && $athleteTitleCount) : ?>
        <div class="about__name">
	        <?php echo $first_name;

	        if (isset($last_name) && $last_name) : ?>
                <strong><?php echo $last_name; ?></strong>
	        <?php endif; ?>
        </div>
	<?php endif;
	if (isset($excerpt)) : ?>
        <p class="about__text"><?php echo $excerpt; ?></p>
    <?php endif;
    if ($about) : ?>
        <a class="about__link" href="<?php the_permalink(pll_get_post($about)); ?>" title="<?php echo $aboutLink; ?>"><?php echo $aboutLink; ?></a>
    <?php endif; ?>
</div>