<section class="section section_error error">
  <div class="content">
    <span class="error_icon"><?php echo file_get_contents(get_theme_file_path('img/icons/close_circle.svg')); ?></span>
    <p class="error__title"><?php _e('Страница удалена или не существует', 'dem'); ?></p>
    <p class="error__text"><?php _e('Приносим свои извинения за неудобства, вы можете вернуться на главную страницу.', 'dem'); ?></p>
    <a class="error__button" href="<?php echo home_url(); ?>" title="<?php _e('Вернуться на главную', 'dem'); ?>"><?php _e('Вернуться на главную', 'dem'); ?></a>
  </div>
</section>