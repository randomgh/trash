<section class="section section_authorization_login authorization">
    <form class="authorization__content content" id="login" method="post" action="">
        <p class="authorization__title">Войдите в аккаунт</p>
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
            <a class="authorization__restore-password" href="/restore-password" >Востановить пароль</a>
            <button class="authorization__submit">Войти</button>
            <a class="authorization__link" href="/registration" >Создать новый аккаунт</a>
            <input type="hidden" name="redirect_to" value="<?php echo get_site_url()?>/" />
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('login_me_nonce'); ?>">
            <input type="hidden" name="action" value="login_me">
        </div>
    </form>
</section>