<?php

    global $route;
    global $overlay;

    $logo = get_option('zabit_general_general_logo', null);
    $menu = get_option('zabit_general_general_menu', null);

    $index_title = get_the_title(pll_get_post(get_option('page_on_front')));

?>
<!doctype html>
<html <?php language_attributes(); ?> dir="ltr" prefix="og: http://ogp.me/ns#">
	<head>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>

        <input class="state state_menu" id="state-menu" name="state[menu]" type="checkbox" value="1">

        <div class="<?php echo implode(' ', array_filter(array('app', 'app_'.pll_current_language('slug'), 'app_'.$route, $overlay['left'] ? 'app_overlay_left' : null, $overlay['right'] ? 'app_overlay_right' : null))); ?>">
            <header class="header">
                <div class="aside aside_left">
                    <a class="nav__link <?php echo $logo ? 'nav__link_imaged' : ''; ?> nav__link_index" href="<?php echo pll_home_url(); ?>" title="<?php echo $index_title; ?>">
		                <?php echo $logo ? new SVG($logo) : $index_title; ?>
                    </a>
                    <label class="nav__link <?php echo $menu ? 'nav__link_imaged' : ''; ?> nav__link_menu" for="state-menu">
		                <?php echo $menu ? new SVG($menu) : __('Menu', 'zabit'); ?>
                    </label>
                </div>
                <div class="aside aside_right">
	                <?php wp_nav_menu(array(
		                'theme_location' => 'language',
		                'menu_id' => false,
		                'menu_class' => false,
		                'container' => 'nav',
		                'container_id' => false,
		                'container_class' => 'nav nav_language',
		                'depth' => 0,
		                'echo' => true,
		                'before' => false,
		                'after' => false,
		                'link_before' => false,
		                'link_after' => false,
		                'item_spacing' => 'discard',
		                'fallback_cb' => false,
		                'items_wrap' => '%3$s',
		                'active' => pll_current_language('name'),
		                'walker' => new LanguageMenuWalker()
	                )); ?>
                </div>
                <div class="content">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'main',
                        'menu_id' => false,
                        'menu_class' => false,
                        'container' => 'nav',
                        'container_id' => false,
                        'container_class' => 'nav nav_header',
                        'depth' => 0,
                        'echo' => true,
                        'before' => false,
                        'after' => false,
                        'link_before' => false,
                        'link_after' => false,
                        'item_spacing' => 'discard',
                        'fallback_cb' => false,
                        'items_wrap' => '%3$s',
                        'active' => $_SERVER['REQUEST_URI'],
                        'walker' => new NavMenuWalker()
                    )); ?>
                </div>
            </header>
            <main class="main">
                <div class="overlay">
                    <aside class="aside aside_left <?php echo !isset($overlay['left']) || $overlay['left'] == '' || $overlay['left'] == ' ' ? 'aside_empty' : '' ?>">
                        <?php echo $overlay['left']; ?>
                    </aside>
                    <aside class="aside aside_right <?php echo !isset($overlay['right']) || $overlay['right'] == '' || $overlay['right'] == ' ' ? 'aside_empty' : '' ?>">
	                    <?php echo $overlay['right']; ?>
                    </aside>
                    <div class="content"></div>
                </div>