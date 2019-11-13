((document, window, location, $, WP = {}) => {
    const READY_TIMEOUT = 500;

    const $document = $(document),
          $window = $(window);

    let $body,
        $app,
        $header,
        $footer,
        $main,
        $sections;

    const init = () => {
        $body = $document.find('body');
        $app = $body.find('.app');
        $header = $app.find('.header');
        $footer = $app.find('.footer');
        $main = $app.find('.main');
        $sections = $main.find('.section');

        $window.on('scroll', onWindowScroll);
        $window.on('resize', onWindowResize);

        onWindowResize();

        setTimeout(() => $body.addClass('ready'), READY_TIMEOUT);
    };

    const onWindowScroll = event => {
        let $current = $sections.first(),
            $this;

        $sections.each(function(index) {
            $this = $(this);

            if (Math.ceil($this.offset().top - $window.scrollTop()) > $window.height() / 2) {
                return false;
            } else {
                $current = $this;
            }
        });
    };

    const onWindowResize = event => {
        onWindowScroll();
    };

    let $cardsSection,
        $cardsCards;

    const initCards = () => {
        $cardsSection = $body.find('.section_home-cards');
        $cardsCards = $cardsSection.find('.home-cards__card');

        $cardsCards.on('mouseenter mouseover mousemove mouseout mouseleave', onCardMouseMove);
    };

    const onCardMouseMove = event => {
        const $target = $(event.currentTarget),
              circle = $target.find('.home-cards__card__circle');

        const offset = $target.offset(),
              top = event.pageY - offset.top - circle.outerWidth() * .75,
              left = event.pageX - offset.left - circle.outerHeight() * .75;

        circle.css({
            top: Math.max(0, Math.min(top, $target.outerHeight() - circle.outerHeight())),
            left: Math.max(0, Math.min(left, $target.outerWidth() - circle.outerWidth()))
        });
    };
/*
    let $calcForm,
        $calcFormFields,
        $calcValidation,
        $calcModal;

    const initCalcForm = () => {
      $calcForm = $('.home-form form.content');
      $calcFormFields = $('.home-form__field');
      $calcModal = $('.modal-calc');

      if($calcForm.length){
        $calcForm.on('submit', onCalcFormSubmit);
      }

      if($calcModal.length){
        $calcModal.on('click','.modal-calc__close', onCalcFormClose);
        $calcModal[0].addEventListener('click', e => {
            if (e.target == e.currentTarget) { onCalcFormClose(); }
        });
      }
    };

    const onCalcFormClose = () => {
        $calcModal.removeClass('modal-calc_display');
    };

    const onCalcFormSubmit = event => {
        event.preventDefault();

        $calcValidation = true;

        $calcFormFields.each((i, e) => {
            const $this = $(e);
            
            if (!$this.find('.home-form__field__input').val()) {
                if (!$this.hasClass('home-form__field_error')) $this.addClass('home-form__field_error');

                $calcValidation = false;

            } else if($this.hasClass('home-form__field_error')) {
                $this.removeClass('home-form__field_error');
            }
        });

        if ($calcValidation) calcFormSend();
    };
    
    const calcFormSend = () => {
        //TODO: Make request for Mass Index From 

        $calcModal.addClass('modal-calc_display');
    };

    let player,
        $aboutVideo,
        $aboutVideoPlay;

    const initAboutVideo = () => {
        $aboutVideo = $('.about-main__video');
        $aboutVideoPlay = $('.about-main__img__btn');

        if ($aboutVideo.length && $aboutVideoPlay.length) {
            player = new YT.Player($aboutVideo[0], {
                videoId: 'Mv39yQbsezQ',
                host: 'https://www.youtube.com',
                playerVars: {
                    showinfo: 0,
                    enablejsapi: 1,
                    fs: 1,
                    origin: location.origin
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerState
                }
            });

            if ($aboutVideoPlay.length) {
                $aboutVideoPlay.on('click', onAboutVideoPlay);
            }

            $document.bind('fscreenchange', onAboutVideoFullscreen);
        }
    };

    const onPlayerReady = event => {
        $aboutVideo = $('.about-main__video');
        $aboutVideo.addClass('about-main__video_ready');
    };

    const onPlayerState = event => {
        if (event.data === YT.PlayerState.ENDED) $.fullscreen.exit();
    };

    const onAboutVideoPlay = event => {
        event.preventDefault();

        $aboutVideo.fullscreen();
    };

    const onAboutVideoFullscreen = event => {
        if ($.fullscreen.isFullScreen()) {
            $aboutVideo.addClass('about-main__video_playing');

            player.playVideo();
        } else {
            $aboutVideo.removeClass('about-main__video_playing');

            player.stopVideo();
        }
    };

    let $formRegistration,
        $formRegistrationPhone,
        $formLogin,
        $formRestorePassword,
        $formNewPassword,
        $inputPassword,
        $inputEmail,
        $inputPhone,
        $inputCode,
        $inputName,
        $inputBirthday,
        $inputGender,
        $inputPasswordHint,
        $inputPasswordHintCapital,
        $inputPasswordHintNumber,
        $inputPasswordHintMin,
        $inputPasswordHintBlock,
        $inputPasswordChangeType,
        $inputSubmit,
        $ajaxSent,
        $ajaxArgs;

    const initFormValidation = () => {
        $formRegistration = $app.find('#registration');
        $formRegistrationPhone = $app.find('#authorization-phone');
        $formLogin = $app.find('#login');
        $formRestorePassword = $app.find('#restore-password');
        $formNewPassword = $app.find('#new-password');

        $inputPhone = $app.find('#authorization__phone');
        $inputEmail = $app.find('#authorization__email');
        $inputPassword = $app.find('#authorization__password');
        $inputCode = $app.find('#authorization__code');
        $inputName = $app.find('#authorization__name');
        $inputBirthday = $app.find('#authorization__birthday');
        $inputGender = $app.find('#authorization__gender');

        $inputPasswordHint = $app.find('.authorization__password-hint');
        $inputPasswordHintCapital = $app.find('.authorization__password-hint_capital');
        $inputPasswordHintNumber = $app.find('.authorization__password-hint_number');
        $inputPasswordHintMin = $app.find('.authorization__password-hint_min');
        $inputPasswordHintBlock = 'authorization__password-hint__block_active';

        $inputSubmit = $app.find('.authorization__submit');
        $inputPasswordChangeType = $app.find('.authorization__field__change-type');

        $ajaxSent = false;
        $ajaxArgs = {
            dataType:  'json',
            beforeSubmit: ajaxReqGo,
            success: ajaxReqCome,
            error: function(data) {
                console.log(arguments);
            },
            url: ajax_var.url
        };

        if ($formRegistration.length){
            $inputEmail.on('keyup', onFormRegistrationCheck);
            $inputPassword.on('keyup', onFormRegistrationCheck);
            $inputPassword.on('focus', onPasswordFocus);
            $inputPasswordChangeType.on('click', onPasswordChangeType);
            $formRegistration.on('submit', onFormRegistrationSubmit);
        }

        if ($formRegistrationPhone.length){
            $inputPhone.on('keyup', onFormRegistrationPhoneCheck);
            $formRegistrationPhone.on('submit', onFormRegistrationPhoneSubmit);
        }

        if ($formLogin.length){
            $inputEmail.on('keyup', onFormLoginCheck);
            $inputPassword.on('keyup', onFormLoginCheck);
            $inputPasswordChangeType.on('click', onPasswordChangeType);
            $formLogin.on('submit', onFormLoginSubmit);
        }

        if ($formRestorePassword.length){
            $inputEmail.on('keyup', onFormRestorePasswordCheck);
            $formRestorePassword.on('submit', onFormRestorePasswordSubmit);
        }

        if ($formNewPassword.length){
            $inputPassword.on('focus', onPasswordFocus);
            $inputPassword.on('keyup', onFormNewPasswordCheck);
            $formNewPassword.on('submit', onFormNewPasswordSubmit);
        }

    };

    const ajaxReqGo = data => {
        if ($ajaxSent){
            return false
        }

        $inputSubmit.attr('disabled', 'disabled');
        $ajaxSent = true;
    };

    const ajaxReqCome = data => {
        $inputSubmit.removeAttr('disabled');
        if (data.data.redirect) window.location.href = data.data.redirect;
        $ajaxSent = false;
    };

    const onFormNewPasswordSubmit = event => {
        event.preventDefault();
        if (onFormNewPasswordCheck()){
            $formNewPassword.ajaxSubmit($ajaxArgs);
        }
    };

    const onFormNewPasswordCheck = () => {
        if (onPasswordCheckHint()) {
            $inputSubmit.addClass('authorization__submit_active');
            return true;
        }else if ($inputSubmit.hasClass('authorization__submit_active')) {
            $inputSubmit.removeClass('authorization__submit_active');
        }
    };

    const onFormRestorePasswordSubmit = event => {
        event.preventDefault();
        if (onFormRestorePasswordCheck()){
            $formRestorePassword.ajaxSubmit($ajaxArgs);
        }
    };

    const onFormRestorePasswordCheck = () => {
        if (onEmailCheck()) {
            $inputSubmit.addClass('authorization__submit_active');
            return true;
        }else if ($inputSubmit.hasClass('authorization__submit_active')) {
            $inputSubmit.removeClass('authorization__submit_active');
        }
    };

    const onFormLoginSubmit = event => {
        event.preventDefault();
        if (onFormLoginCheck()){
            $formLogin.ajaxSubmit($ajaxArgs);
        }
    };

    const onFormLoginCheck = () => {
        if (onEmailCheck() && onPasswordCheck()) {
            $inputSubmit.addClass('authorization__submit_active');
            return true;
        }else if ($inputSubmit.hasClass('authorization__submit_active')) {
            $inputSubmit.removeClass('authorization__submit_active');
        }
    };

    const onFormRegistrationPhoneSubmit = event => {
        event.preventDefault();
        if (onFormRegistrationPhoneCheck()){
            $formRegistrationPhone.ajaxSubmit($ajaxArgs);
        }
    };

    const onFormRegistrationPhoneCheck = () => {
        if (onPhoneCheck()) {
            $inputSubmit.addClass('authorization__submit_active');
            return true;
        }else if ($inputSubmit.hasClass('authorization__submit_active')) {
            $inputSubmit.removeClass('authorization__submit_active');
        }
    };

    const onFormRegistrationSubmit = event => {
            event.preventDefault();
            if (onFormRegistrationCheck()){
                $formRegistration.ajaxSubmit($ajaxArgs);
            }
    };

    const onFormRegistrationCheck = () => {
        if (onPasswordCheckHint() && onEmailCheck()) {
            $inputSubmit.addClass('authorization__submit_active');
            return true;
        }else if ($inputSubmit.hasClass('authorization__submit_active')) {
            $inputSubmit.removeClass('authorization__submit_active');
        }
    };

    const onEmailCheck = () => {
        if ($inputEmail.val().match(/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i)) {
            return true;
        }
    };

    //TODO: create validation for phone field

    const onPhoneCheck = () => {
        if ($inputPhone.val().length === 12) {
            return true;
        }
    };

    const onPasswordCheckHint = () => {
        let validated = true;

        if($inputPassword.val().length > 5) {
            $inputPasswordHintMin.addClass($inputPasswordHintBlock);
        }else {
            $inputPasswordHintMin.removeClass($inputPasswordHintBlock);
            validated = false;
        }
        if($inputPassword.val().match(/[A-Z]/g)) {
            $inputPasswordHintCapital.addClass($inputPasswordHintBlock);
        }else {
            $inputPasswordHintCapital.removeClass($inputPasswordHintBlock);
            validated = false;
        }
        if($inputPassword.val().match(/\d/g)) {
            $inputPasswordHintNumber.addClass($inputPasswordHintBlock);
        }else {
            $inputPasswordHintNumber.removeClass($inputPasswordHintBlock);
            validated = false;
        }
        return validated;
    };

    const onPasswordCheck = () => {
        let validated = true;

        if($inputPassword.val().length < 5) validated = false;
        if(!$inputPassword.val().match(/[A-Z]/g)) validated = false;
        if(!$inputPassword.val().match(/\d/g)) validated = false;

        return validated;
    };

    const onPasswordFocus = () => {
        if (!$inputPasswordHint.hasClass('authorization__password-hint_active')) {
            $inputPasswordHint.addClass('authorization__password-hint_active');
        }
    };

    const onPasswordChangeType = () => {
        $inputPassword.attr('type') === 'text' ? $inputPassword.attr('type', 'password') : $inputPassword.attr('type', 'text');
    };


    $(() => {
        init();
        initCards();
        /*
        initCalcForm();

        let interval = setInterval(() => {
            if (aboutVideo) {
                initAboutVideo();
                clearInterval(interval);
            }
        }, 500);
    });*/
})(document, window, location, jQuery, WP);

let aboutVideo = false;

function onYouTubePlayerAPIReady() {
    aboutVideo = true;
}
