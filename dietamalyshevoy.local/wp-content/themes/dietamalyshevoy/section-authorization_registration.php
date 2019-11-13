<section class="section section_authorization_registration authorization">
    <form class="authorization__content content" id="registration" method="post" action="">
        <p class="authorization__title">Создайте аккаунт</p>
        <div class="authorization__fieldset">
            <label class="authorization__field" for="authorization__email">
                <p class="authorization__field__title">Почта</p>
                <input class="authorization__field__input" id="authorization__email" name="email" type="email" placeholder="address@email.com" required>
            </label>
            <label class="authorization__field" for="authorization__password">
                <p class="authorization__field__title">Пароль</p>
                <input class="authorization__field__input" id="authorization__password" name="password" type="password" placeholder="Создайте надежный пароль" required>
                <a class="authorization__field__change-type" href="#" ><?php echo file_get_contents(get_theme_file_path("img/icons/eye.svg")); ?></a>
            </label>
            <div class="authorization__password-hint">
                <p class="authorization__password-hint__title">Надежный пароль должен содержать:</p>
                <div class="authorization__password-hint__block authorization__password-hint_capital">1 заглваную букву</div>
                <div class="authorization__password-hint__block authorization__password-hint_number">1 цифру</div>
                <div class="authorization__password-hint__block authorization__password-hint_min"> Минимум 6 символов</div>
            </div>
            <div class="authorization__checkbox">
                <input class="authorization__checkbox__input" id="authorization__user-agreement" type="checkbox" name="user-agreement">
                <label class="authorization__checkbox__label" for="authorization__user-agreement">Я даю согласие на обработку моих персональных данных и соглашаюсь с пунктами пользовательского соглашения.</label>
                <div class="authorization__checkbox__input__check-mark"><?php echo file_get_contents(get_theme_file_path("img/icons/check.svg")); ?></div>
            </div>
            <div class="authorization__checkbox">
                <input class="authorization__checkbox__input" id="authorization__rss" type="checkbox" name="rss">
                <label class="authorization__checkbox__label" for="authorization__rss">Я хочу получать рассылку о новых сервисах и акциях сайта.</label>
                <div class="authorization__checkbox__input__check-mark"><?php echo file_get_contents(get_theme_file_path("img/icons/check.svg")); ?></div>
            </div>
            <button class="authorization__submit">Продолжить</button>
            <a class="authorization__link" href="/login" >У меня есть аккаунт</a>
            <input type="hidden" name="redirect_to" value="<?php echo get_site_url()?>/" />
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('register_me_nonce'); ?>">
            <input type="hidden" name="action" value="register_me">
        </div>
    </form>
</section>