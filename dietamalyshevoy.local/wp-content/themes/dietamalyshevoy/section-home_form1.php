<section class="section section_home-form home-form">
  <form class="content" id="calc">
    <div class="home-form__legend">
        <p class="home-form__title">На сколько мне похудеть?</p>
        <p class="home-form__text">Введите свои параметры, чтобы узнать результат</p>
    </div>
    <div class="home-form__fieldset">
        <div class="home-form__field">
            <label class="home-form__field__label" for="calc-height">Рост</label>
            <input class="home-form__field__input" id="calc-height" name="height" type="number" min="0" step="1" placeholder="172 см" required>
        </div>
        <div class="home-form__field">
            <label class="home-form__field__label" for="calc-weight">Вес</label>
            <input class="home-form__field__input" id="calc-weight" name="weight" type="number" min="0" step="1" placeholder="80 кг" required>
        </div>
        <button class="home-form__button">Рассчитать</button>
    </div>
  </form>
</section>