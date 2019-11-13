                <?php

                $logo = get_option('zabit_general_general_logo', null);

                $index_title = get_the_title(pll_get_post(get_option('page_on_front')));

                $developer_logo = get_option('zabit_powered_developer_logo', null);
                $developer_title = get_option('zabit_powered_developer_title', null);
                $developer_link = get_option('zabit_powered_developer_link', null);

                ?>
            </main>
            <footer class="footer">
                <div class="aside aside_left">
                        <a class="nav__link <?php echo $logo ? 'nav__link_imaged' : ''; ?>" href="<?php echo pll_home_url(); ?>" title="<?php echo $index_title; ?>">
	                        <?php echo $logo ? new SVG($logo) : $index_title; ?>
                        </a>
                </div>
                <div class="aside aside_right">
		            <?php wp_nav_menu(array(
			            'theme_location' => 'social',
			            'menu_id' => false,
			            'menu_class' => 'nav',
			            'container' => 'nav',
			            'container_id' => false,
			            'container_class' => 'nav nav_social',
			            'depth' => 0,
			            'echo' => true,
			            'before' => false,
			            'after' => false,
			            'link_before' => false,
			            'link_after' => false,
			            'item_spacing' => 'discard',
			            'fallback_cb' => false,
			            'items_wrap' => '%3$s',
			            'walker' => new NavMenuWalker()
		            )); ?>
                </div>
                <div class="content">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'main',
                        'menu_id' => false,
                        'menu_class' => false,
                        'container' => 'nav',
                        'container_id' => false,
                        'container_class' => 'nav nav_footer',
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
            </footer>
            <aside class="powered">
                <div class="aside aside_left">
                    <a class="nav__link <?php echo $developer_logo ? 'nav__link_inline' : ''; ?>" href="<?php echo $developer_link ? $developer_link : '#'; ?>" title="<?php echo $developer_title; ?>">
		                <?php echo $developer_logo ? new SVG($developer_logo) : $developer_title; ?>
                    </a>
                </div>
                <div class="aside aside_right">
		            <?php wp_nav_menu(array(
			            'theme_location' => 'partners',
			            'menu_id' => false,
			            'menu_class' => 'nav',
			            'container' => 'nav',
			            'container_id' => false,
			            'container_class' => 'nav nav_partners',
			            'depth' => 0,
			            'echo' => true,
			            'before' => false,
			            'after' => false,
			            'link_before' => false,
			            'link_after' => false,
			            'item_spacing' => 'discard',
			            'fallback_cb' => false,
			            'items_wrap' => '%3$s',
			            'walker' => new NavMenuWalker()
		            )); ?>
                </div>
                <div class="content"></div>
            </aside>
        </div>
        <?php
            get_block('preloader');
            wp_footer();
        ?>
	</body>
</html>
