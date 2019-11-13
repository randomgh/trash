<section class="section section_authorization_new-password authorization">
    <form class="authorization__content content" id="new-password" method="post" action="">
        <p class="authorization__title">Создайте новый пароль</p>
        <div class="authorization__fieldset">
            <label class="authorization__field" for="authorization__password">
                <p class="authorization__field__title">Пароль</p>
                <input class="authorization__field__input" id="authorization__password" name="password" type="password" placeholder="Создайте надежный пароль" required>
                <a class="authorization__field__change-type" href="#" ><?php echo file_get_contents(get_theme_file_path("img/icons/eye.svg")); ?></a>
            </label>
            <div class="authorization__password-hint">
                <p class="authorization__password-hint__title">Убедитесь, что ваш пароль надежный и соответствует нашим критериям безопасности. Ваш пароль должен содержать::</p>
                <div class="authorization__password-hint__block authorization__password-hint_capital">1 заглваную букву</div>
                <div class="authorization__password-hint__block authorization__password-hint_number">1 цифру</div>
                <div class="authorization__password-hint__block authorization__password-hint_min"> Минимум 6 символов</div>
            </div>
            <button class="authorization__submit">Сохранть пароль</button>
            <input type="hidden" name="user" value="<?php echo $_GET['user']; ?>">
            <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
            <input type="hidden" name="redirect_to" value="<?php echo get_site_url()?>/login" />
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('new_pass_nonce'); ?>">
            <input type="hidden" name="action" value="new_pass">
        </div>
    </form>
</section>