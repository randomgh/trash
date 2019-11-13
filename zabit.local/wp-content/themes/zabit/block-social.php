<?php

    $fb = get_post_meta(get_the_ID(), 'social-fb_enabled', true);
    $tw = get_post_meta(get_the_ID(), 'social-tw_enabled', true);
    $vk = get_post_meta(get_the_ID(), 'social-vk_enabled', true);

    $url = urlencode(is_front_page() || is_home() ? get_home_url() : get_permalink());

    if ($fb || $tw || $vk) : ?>
        <div class="social">
            <div class="social__text"><?php _e('Did you like this article? Share it!', 'zabit'); ?></div>
            <div class="social__links">
                <?php if ($fb) :
                    $icon = get_option('zabit_general_social_fb', null);
                    ?>
                    <a class="social__link social__link_fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" title="<?php _e('Share Facebook', 'zabit'); ?>" target="_blank" data-window_id="FacebookSharing" data-window_width="550" data-window_height="450">
                        <?php echo $icon ? new SVG($icon) : __('Facebook', 'zabit'); ?>
                    </a>
                <?php endif; ?>
                <?php if ($tw) :
                    $icon = get_option('zabit_general_social_tw', null);
                    ?>
                    <a class="social__link social__link_tw" href="https://twitter.com/share?url=<?php echo $url; ?>" title="<?php _e('Share Twitter', 'zabit'); ?>" target="_blank" data-window_id="TwitterSharing" data-window_width="640" data-window_height="480">
                        <?php echo $icon ? new SVG($icon) : __('Twitter', 'zabit'); ?>
                    </a>
                <?php endif; ?>
                <?php if ($vk) :
                    $icon = get_option('zabit_general_social_vk', null);

                    $title = get_post_meta(get_the_ID(), 'social-vk_title', true);
                    $description = get_post_meta(get_the_ID(), 'social-vk_description', true);
                    $image = get_post_meta(get_the_ID(), 'social-vk_image', true);
                    list($src, $width, $height) = $image ? wp_get_attachment_image_src($image, 'social-vk') : array('', 0, 0);

                    $parameters = array_filter(array(
                        'url='.$url,
                        $title ? 'title='.$title : null,
                        $description ? 'description='.$description : null,
                        $src ? 'image='.urlencode($src) : null
                    ));
                    ?>
                    <a class="social__link social__link_vk" href="http://vk.com/share.php?<?php echo implode('&', $parameters); ?>" title="<?php _e('Share VKontakte', 'zabit'); ?>" target="_blank" data-window_id="VKontakteSharing" data-window_width="640" data-window_height="480">
                        <?php echo $icon ? new SVG($icon) : __('VKontakte', 'zabit'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif;