<section class="section section_authorization_restore-password authorization">
    <form class="authorization__content content" id="restore-password" method="post" action="">
        <p class="authorization__subtitle">На вашу почту придет ссылка на<br>восстановление пароля</p>
        <div class="authorization__fieldset">
            <label class="authorization__field" for="authorization__email">
                <p class="authorization__field__title">Почта</p>
                <input class="authorization__field__input" id="authorization__email" name="email" type="email" placeholder="address@email.com" required>
            </label>
            <button class="authorization__submit">Получить ссылку</button>
        </div>
        <input type="hidden" name="redirect_to" value="<?php echo get_site_url()?>/" />
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('restore_pass_nonce'); ?>">
        <input type="hidden" name="action" value="restore_pass">
    </form>
</section>