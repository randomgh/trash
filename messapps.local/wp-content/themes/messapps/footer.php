    </main>
    <footer class="footer">
      <div class="content footer__content">
        <a class="footer__logo" href="<?php echo home_url(); ?>" title="messapps"><?php echo file_get_contents(get_theme_file_path("img/logo.svg")); ?></a>
        <p class="footer__text">1460 Broadway, New York </p>
        <a class="footer__link" href="mailto:team@messapps.com" title="team@messapps.com">team@messapps.com</a>
        <a class="footer__link" href="tel:16467414814" title="+1 (646) 741-4814">+1 (646) 741-4814</a>
        <div class="footer__soc">
          <a class="footer__soc__link" href="https://www.facebook.com/MESSApps/" title="Share link on Facebook"><?php echo file_get_contents(get_theme_file_path("img/facebook.svg")); ?></a>
          <a class="footer__soc__link" href="https://twitter.com/Messapps" title="Share link on Twitter"><?php echo file_get_contents(get_theme_file_path("img/twitter.svg")); ?></a>
          <a class="footer__soc__link" href="https://www.instagram.com/messapps/" title="Share link on Instagram"><?php echo file_get_contents(get_theme_file_path("img/instagram.svg")); ?></a>
          <a class="footer__soc__link" href="https://dribbble.com/messapps" title="Share link on Dribbble"><?php echo file_get_contents(get_theme_file_path("img/dribbble.svg")); ?></a>
          <a class="footer__soc__link" href="https://www.behance.net/messapps" title="Share link on Behance"><?php echo file_get_contents(get_theme_file_path("img/behance.svg")); ?></a>
          <a class="footer__soc__link" href="https://www.linkedin.com/company/messapps/" title="Share link on Linkedin"><?php echo file_get_contents(get_theme_file_path("img/linkedin.svg")); ?></a>
        </div>
      </div>
    </footer>
  </div>
  <?php wp_footer(); ?>
  </body>
</html>
