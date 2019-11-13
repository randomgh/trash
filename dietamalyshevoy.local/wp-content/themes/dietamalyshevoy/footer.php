<?php

global $route;
global $breadcrumbs;

$logo = get_option('dem_general_general_logo', null);
$index_title = get_the_title(get_option('page_on_front'));

$contacts = get_option('dem_general_general_contacts_page', null);
if ($contacts) {
    $contacts_url = get_the_permalink($contacts);
    $contacts_title = get_the_title($contacts);
}

$phones = array_filter(array(get_option('dem_general_contacts_phone1', null), get_option('dem_general_contacts_phone2', null)));

$address = get_option('dem_general_contacts_address', null);

$copy = get_option('dem_general_general_copy', null);

?>
      </main>

      <footer class="footer">
        <?php

        if (count($breadcrumbs)) {

            ?>
            <div class="block footer__block footer__block_breadcrumbs">
              <div class="content">
                <nav class="footer__breadcrumbs">
                  <?php

                  $breadcrumbs_count = count($breadcrumbs);

                  foreach ($breadcrumbs as $i => $breadcrumb) {
                      printf('%1$s<a class="%2$s" href="%3$s" title="%5$s" %4$s><span>%5$s</span></a>', $i ? '<span class="footer__breadcrumbs__separator">/</span>' : '', $i == $breadcrumbs_count - 1 ? 'footer__breadcrumbs__link footer__breadcrumbs__link_active' : 'footer__breadcrumbs__link', $breadcrumb['href'], $i == $breadcrumbs_count - 1 ? 'tabindex="-1"' : '', $breadcrumb['title']);
                  }

                  ?>
                </nav>
              </div>
            </div>
            <?php

        }

        ?>
        <div class="block footer__block footer__block_map">
          <div class="content">
            <a class="footer__logo" href="<?php echo home_url(); ?>" title="<?php echo $index_title; ?>">
	          <?php

              if ($logo) {
  	            echo new SVG($logo);
	          } else {
	            echo $index_title;
	          }

	          ?>
            </a>
            <nav class="footer__map">
              <?php wp_nav_menu(array(
                  'theme_location' => 'footer',
                  'menu_id' => false,
                  'menu_class' => 'footer__map__ul',
                  'container' => false,
                  'container_id' => false,
                  'container_class' => false,
                  'depth' => 0,
                  'echo' => true,
                  'before' => false,
                  'after' => false,
                  'link_before' => '<span>',
                  'link_after' => '</span>',
                  'link_class' => 'footer__map__link',
                  'item_spacing' => 'discard',
                  'fallback_cb' => false,
                  'item_class' => 'footer__map__li',
                  'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                  'walker' => new NavMenuWalker()
              )); ?>
              <div class="footer__contacts">
                <?php

                if ($contacts) {
                    printf('<a class="%1$s" href="%2$s" title="%3$s"><span>%3$s</span></a>', 'footer__contacts__link', $contacts_url, $contacts_title);
                }

                ?>
                <div class="footer__contacts__content">
                  <?php

                  if (count($phones)) {

                      ?>
                      <div class="footer__contacts__phones">
                        <?php

                        foreach ($phones as $phone) {
                            $phone_num = preg_replace("/[^\d\+]/", "", $phone);
                            $phone_tel = preg_replace("/^8/", "7", $phone_num);
                            $phone_title = preg_replace("/^(\+?\d)(\d*?)(\d{3})(\d{2})(\d{2})$/", "$1 ($2) $3-$4-$5", $phone_num);

                            ?>
                            <a class="footer__contacts__phone" href="tel:<?php echo $phone_tel; ?>" title="<?php echo $phone_title; ?>">
	                          <?php echo file_get_contents(get_theme_file_path('img/icons/phone_circle.svg')); ?>
                              <span><?php echo $phone_title; ?></span>
                            </a>
                            <?php

                        }

                        ?>
                      </div>
                      <?php

                  }

                  if ($address) {

                      ?>
                      <a class="footer__contacts__address" href="#" title="<?php echo $address; ?>">
	                    <?php echo file_get_contents(get_theme_file_path('img/icons/address.svg')); ?>
                        <span><?php echo $address; ?></span>
                      </a>
                      <?php

                  }

                  ?>
                  <div class="footer__contacts__links">
                    <?php

                    wp_nav_menu(array(
                        'theme_location' => 'socials',
                        'menu_id' => false,
                        'menu_class' => 'footer__contacts__socials',
                        'container' => false,
                        'container_id' => false,
                        'container_class' => false,
                        'depth' => 0,
                        'echo' => true,
                        'before' => false,
                        'after' => false,
                        'link_before' => '<span>',
                        'link_after' => '</span>',
                        'link_class' => 'footer__contacts__socials__link',
                        'item_spacing' => 'discard',
                        'fallback_cb' => false,
                        'item_class' => 'footer__contacts__socials__li',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'walker' => new NavMenuWalker()
                    ));

                    wp_nav_menu(array(
                        'theme_location' => 'apps',
                        'menu_id' => false,
                        'menu_class' => 'footer__contacts__apps',
                        'container' => false,
                        'container_id' => false,
                        'container_class' => false,
                        'depth' => 0,
                        'echo' => true,
                        'before' => false,
                        'after' => false,
                        'link_before' => '<span>',
                        'link_after' => '</span>',
                        'link_class' => 'footer__contacts__apps__link',
                        'item_spacing' => 'discard',
                        'fallback_cb' => false,
                        'item_class' => 'footer__contacts__apps__li',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'walker' => new NavMenuWalker()
                    ));

                    ?>
                  </div>
                </div>
              </div>
            </nav>
          </div>
        </div>
        <div class="block footer__block footer__block_legal">
          <div class="content">
            <?php

            if ($copy) {
                printf('<span class="%1$s">%2$s</span>', 'footer__copy', $copy);
            }

            wp_nav_menu(array(
                'theme_location' => 'legal',
                'menu_id' => false,
                'menu_class' => 'footer__legal__ul',
                'container' => 'nav',
                'container_id' => false,
                'container_class' => 'footer__legal',
                'depth' => 0,
                'echo' => true,
                'before' => false,
                'after' => false,
                'link_before' => '<span>',
                'link_after' => '</span>',
                'link_class' => 'footer__legal__link',
                'item_spacing' => 'discard',
                'fallback_cb' => false,
                'item_class' => 'footer__legal__li',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker' => new NavMenuWalker()
            ));

            ?>
          </div>
        </div>
      </footer>
    </div>
<!--
    <div class="modals">
      <div class="modal modal-calc">
        <div class="content">
          <p class="modal-calc__title">Ваш индекс массы тела:</p>
          <p class="modal-calc__index">100</p>
          <p class="modal-calc__normal">Ваш нормальный вес:<span class="modal-calc__normal_result">90 - 110 кг</span></p>
          <p class="modal-calc__message">Переданы некорректные параметры для расчета</p>
          <p class="modal-calc__description">Индекс массы тела позволяет оценить степень соответствия массы человека и его роста</p>
          <a class="modal-calc__btn" href="#">Заказать здоровую диету</a>
          <div class="modal-calc__close"><?php /*echo file_get_contents(get_theme_file_path("images/btn_close.svg"));*/ ?></div>
        </div>
      </div>
    </div>
-->
    <?php wp_footer(); ?>

  </body>
</html>