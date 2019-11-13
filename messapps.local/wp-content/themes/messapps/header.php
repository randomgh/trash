<!doctype html>
<html <?php language_attributes(); ?> dir="ltr" prefix="og: http://ogp.me/ns#">
  <head>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <div class="app">
        <header class="header">
            <div class="content header__content">
                <a class="header__logo" href="<?php echo home_url(); ?>" title="messapps"><?php echo file_get_contents(get_theme_file_path("img/logo.svg")); ?></a>
                <nav class="header__nav">
                  <ul class="header__nav__list">
                    <li class="header__nav__item"><a class="header__link" href="#" title="Services">Services</a></li>
                    <li class="header__nav__item"><a class="header__link" href="#" title="Projects">Projects</a></li>
                    <li class="header__nav__item"><a class="header__link" href="#" title="About">About</a></li>
                    <li class="header__nav__item"><a class="header__link" href="#" title="Blog">Blog</a></li>
                    <li class="header__nav__item"><a class="header__link" href="#" title="Contact">Contact</a></li>
                  </ul>
                </nav>
                <a class="header__proposal" href="#" title="Get proposal"><?php echo file_get_contents(get_theme_file_path("img/btn-proposal.svg")); ?></a>
            </div>
        </header>
        <main class="main">
