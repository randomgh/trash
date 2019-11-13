<section class="section section_authorization_registration-phone authorization">
    <form class="authorization__content content" id="registration-phone" method="post" action="">
        <p class="authorization__subtitle">Войдите в аккаунт через номер телефона</p>
        <div class="authorization__fieldset">
            <label class="authorization__field" for="authorization__phone">
                <p class="authorization__field__title">Номер телефона</p>
                <input class="authorization__field__input" id="authorization__phone" name="phone" type="phone" placeholder="+7 (xxx) xxx-xx-xx" required>
            </label>
            <div class="authorization__checkbox">
                <input class="authorization__checkbox__input" id="authorization__user-agreement" type="checkbox" name="user-agreement">
                <label class="authorization__checkbox__label" for="authorization__user-agreement">Я даю согласие на обработку моих персональных данных и соглашаюсь с пунктами пользовательского соглашения.</label>
                <div class="authorization__checkbox__input__check-mark"><?php echo file_get_contents(get_theme_file_path("img/icons/check.svg")); ?></div>
            </div>
            <button class="authorization__submit">Получить код</button>
            <input type="hidden" name="redirect_to" value="<?php echo get_site_url()?>/" />
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('register_phone_me_nonce'); ?>">
            <input type="hidden" name="action" value="register_phone_me">
        </div>
    </form>
</section>