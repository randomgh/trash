<section class="section section_home-form home-form">
  <form class="content" id="call">
    <div class="home-form__legend">
        <p class="home-form__title">Закажите обратный звонок</p>
        <div class="home-form__text">
            <label class="home-form__checkbox" for="call-policy">
                <input id="call-policy" name="policy" type="checkbox" value="policy" required>
	            <?php echo file_get_contents(get_theme_file_path('img/icons/check.svg')); ?>
            </label>
            Я соглашаюсь на <a class="home-form__link" href="#" title="Политика обработки персональных данных">обработку персональных данных</a>
        </div>
    </div>
    <div class="home-form__fieldset">
        <div class="home-form__field">
            <label class="home-form__field__label" for="call-name">Ваше имя</label>
            <input class="home-form__field__input" id="call-name" name="name" type="text" placeholder="Андрей" required>
        </div>
        <div class="home-form__field">
            <label class="home-form__field__label" for="call-phone">Номер телефона</label>
            <input class="home-form__field__input" id="call-phone" name="phone" type="text" placeholder="+7 (xxx)-xxx-xx-xx" required>
        </div>
        <button class="home-form__button">Перезвоните мне</button>
    </div>
  </form>
</section>