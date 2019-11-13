<?php

global $route;

$logo = get_option('dem_general_general_logo', null);
$index_title = get_the_title(get_option('page_on_front'));
$phone1 = get_option('dem_general_contacts_phone1', null);

?>
<!doctype html>
<html <?php language_attributes(); ?> dir="ltr" prefix="og: http://ogp.me/ns#">
  <head>
	<?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>

    <div class="app app_route_<?php echo $route; ?>" <?php /*style="background: url(<?php echo get_theme_file_uri("img/guides/$route.jpg"); ?>) center 0px no-repeat;"*/ ?>>
      <header class="header">
        <div class="content">
          <a class="header__logo" href="<?php echo home_url(); ?>" title="<?php echo $index_title; ?>">
            <?php

            if ($logo) {
                echo new SVG($logo);
            } else {
                echo $index_title;
            }

            ?>
          </a>
          <nav class="header__nav">
            <?php wp_nav_menu(array(
                'theme_location' => 'main',
                'menu_id' => false,
                'menu_class' => 'header__nav__ul',
                'container' => false,
                'container_id' => false,
                'container_class' => false,
                'depth' => 0,
                'echo' => true,
                'before' => false,
                'after' => false,
                'link_before' => '<span>',
                'link_after' => '</span>',
                'link_class' => 'header__nav__link',
                'link_active_class' => 'header__nav__link_active',
                'item_spacing' => 'discard',
                'fallback_cb' => false,
                'item_class' => 'header__nav__li',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'active' => $_SERVER['REQUEST_URI'],
                'walker' => new NavMenuWalker()
            )); ?>
          </nav>
          <div class="header__contacts">
            <?php

            if ($phone1) {
                $phone_num = preg_replace("/[^\d\+]/", "", $phone1);
                $phone_tel = preg_replace("/^8/", "7", $phone_num);
                $phone_title = preg_replace("/^(\+?\d)(\d*?)(\d{3})(\d{2})(\d{2})$/", "$1 ($2) $3-$4-$5", $phone_num);

                ?>
                <a class="header__contacts__link header__contacts__link_sized header__contacts__link_light" href="tel:<?php echo $phone_tel; ?>" title="<?php echo $phone_title; ?>">
	              <?php echo file_get_contents(get_theme_file_path('img/icons/phone_circle.svg')); ?>
                  <span><?php echo $phone_title; ?></span>
                </a>
                <?php

            }

            ?>
            <a class="header__contacts__link header__contacts__link_sized header__contacts__link_dark" href="#" title="<?php _e('Обратный звонок', 'dem'); ?>">
              <span><?php _e('Обратный звонок', 'dem'); ?></span>
            </a>
            <a class="header__contacts__link header__contacts__link header__contacts__link_gray" href="#" title="<?php _e('Личный кабинет', 'dem'); ?>">
	          <?php echo file_get_contents(get_theme_file_path('img/icons/user.svg')); ?>
            </a>
          </div>
        </div>
      </header>

      <main class="main">
