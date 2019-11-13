<section class="section section_about-main about-main">
  <div class="content">
    <div class="about-main__column">
      <p class="about-main__title">О Диете</p>
      <p class="about-main__subtitle">Готовые наборы<br>еды для похудения</p>
      <?php echo file_get_contents(get_theme_file_path("images/about_head.svg")); ?>
    </div>
    <div class="about-main__column">
      <div class="about-main__img">
        <?php echo file_get_contents(get_theme_file_path("images/video_background.svg")); ?>
        <img class="about-main__img__btn" src="<?php echo get_theme_file_uri('/images/videoPlaceholder.png'); ?>" alt="заглушка для видео" title="заглушка для видео">
      </div>
      <p class="about-main__quote">“Все очень просто и удобно! И теперь у вас точно получится.”<br>- Елена Малышева</p>
    </div>
  </div>
  <div class="about-main__video"></div>
</section>
