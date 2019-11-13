((document, window, location, $, WP = {}) => {
    const BREAKPOINTS = {
              xxxxxs: 320,
              xxxxs:  375,
              xxxs:   425,
              xxs:    480,
              xs:     640,
              s:      768,
              m:      960,
              l:      1024,
              xl:     1280,
              xxl:    1440,
              xxxl:   1600,
              xxxxl:  1920,
              xxxxxl: 2560
          },
          ADAPTATIONS = ['mobile-s', 'mobile-l', 'tablet-l', 'desktop-s', 'desktop-l'],
          READY_TIMEOUT = 500,
          QUALITIES = {
              'small': 240,
              'medium': 360,
              'large': 480,
              'hd720': 720,
              'hd1080': 1080,
              'highres': 0
          };

    let adaptation,
        size = {
            width: 0,
            height: 0
        };

    const $document = $(document),
          $window = $(window);

    let $body,
        $app,
        $header,
        $footer,
        $main,
        $overlay,
        $overlayAsides,
        $sections,
        $sectionAsides;

    const init = () => {
        $body = $document.find('body');
        $app = $body.find('.app');
        $header = $app.find('.header');
        $footer = $app.find('.footer');
        $main = $app.find('.main');
        $overlay = $main.find('.overlay');
        $overlayAsides = $overlay.find('.aside');
        $sections = $main.find('.section');
        $sectionAsides = $sections.find('.aside');

        $body.find('.social__link').click(onShare);

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

        resize();

        $app.toggleClass('app_overlay_transparent', $current.children('.background').length !== 0);
        $app.toggleClass('app_overlay_border-transparent', $current.children('.video').length !== 0);
    };

    const onWindowResize = event => {
        resize();

        onWindowScroll();
    };

    const onShare = event => {
        event.preventDefault();

        const $target = $(event.currentTarget),
              id = $target.data('window_id'),
              width = parseInt($target.data('window_width')),
              height = parseInt($target.data('window_height')),
              left = ($window.width() - width) / 2,
              top = ($window.height() - height) / 2,
              toolbar = 0,
              location = 0,
              menubar = 0,
              directories = 0,
              scrollbars = 0;

        window.open($target.attr('href'), id, `width=${width}, height=${height}, left=${left}, top=${top}, toolbar=${toolbar}, location=${location}, menubar=${menubar}, directories=${directories}, scrollbars=${scrollbars}`);

        return false;
    };

    // TODO: Add app min height
    const resize = () => {
        const appWidth = $window[0].outerWidth,
              appHeight = $window[0].innerHeight;

        let newAdaptation;
        switch (true) {
            case appWidth <= BREAKPOINTS.xxxxs:
                newAdaptation = ADAPTATIONS[0];
                break;
            case appWidth > BREAKPOINTS.xxxxs && appWidth <= BREAKPOINTS.xs:
                newAdaptation = ADAPTATIONS[1];
                break;
            case appWidth > BREAKPOINTS.xs && appWidth <= BREAKPOINTS.l:
                newAdaptation = ADAPTATIONS[2];
                break;
            case appWidth > BREAKPOINTS.l && appWidth <= BREAKPOINTS.xxl:
                newAdaptation = ADAPTATIONS[3];
                break;
            case appWidth > BREAKPOINTS.xxl:
                newAdaptation = ADAPTATIONS[4];
                break;
        }

        if (adaptation !== newAdaptation) {
            $app.removeClass(`app_adaptation_${adaptation}`).addClass(`app_adaptation_${newAdaptation}`);

            adaptation = newAdaptation;
        }

        if (size.width !== appWidth || size.height !== appHeight) {
            $overlay.css({ height: `${appHeight}px` });
            $main.css({ minHeight: `${appHeight}px` });
            $sections.css({ minHeight: `${appHeight}px` }).first().css({ marginTop: `-${appHeight}px` });
            $sectionAsides.end().find('.aside_full').css({ height: `${appHeight}px` });

            size = {
                width: appWidth,
                height: appHeight
            };
        }
        
        if ($overlay.css('position') === 'fixed') {
            $overlay.css('margin-top', Math.min(0, Math.ceil($footer.offset().top - $window.scrollTop() - $window.height())) + 'px')
        }
    };

    let $sectionNews,
        $newsAside,
        $newsAsideSVG,
        $newsAsideIMG,
        $newsList,
        $newsExcerpts,
        $news,
        $newsImage,
        $newsSVG,
        $newsIMG,
        $newsText,
        $newsDate,
        $newsLink;

    const initNews = () => {
        $sectionNews = $main.find('.section_news');
        $newsList = $sectionNews.find('.content .news-list');
        $newsExcerpts = $newsList.find('.news-excerpt');
        $newsAside = $sectionNews.find('.aside_news');
        $newsAsideSVG = $newsAside.find('.background');
        $newsAsideIMG = $newsAsideSVG.find('.background__img');
        $news = $newsAside.find('.news');
        $newsImage = $news.find('.news__image');
        $newsSVG = $newsImage.find('.background');
        $newsIMG = $newsSVG.find('.background__img');
        $newsText = $news.find('.news__caption__text');
        $newsDate = $news.find('.news__caption__date');
        $newsLink = $news.find('.news__caption__link');

        if ($newsAside.length) {
            $newsList.on('mouseover', '.news-excerpt', onNewsExcerpt);

            showNews(0);
        }
    };

    const onNewsExcerpt = event => {
        event.preventDefault();

        if (![ADAPTATIONS[0], ADAPTATIONS[1]].indexOf(adaptation) >= 0) {
            showNews($(event.currentTarget).index());
        }
    };

    const showNews = i => {
        const $target = $newsExcerpts.eq(i),
              imageSRC = $target.data('image_src'),
              imageWidth = $target.data('image_width'),
              imageHeight = $target.data('image_height'),
              title = $target.attr('title'),
              url = $target.attr('href'),
              text = $target.find('.news-excerpt__text').html(),
              date = $target.find('.news-excerpt__date').text();

        $newsAsideSVG.toggleClass('background_hidden', !imageSRC).attr('viewBox', imageWidth && imageHeight ? `0 0 ${imageWidth} ${imageHeight}` : '').data('title', title).data('width', imageWidth).data('height', imageHeight);
        $newsAsideIMG.attr('xlink:href', imageSRC ? imageSRC : '');
        $newsText.html(text);
        $newsDate.text(date);
        $newsLink.attr('href', url);

        if ($news.hasClass('news_hidden')) $news.removeClass('news_hidden');
    };

    let $charts;

    const initCharts = () => {
        $charts = $('.chart');

        if ($charts.length) {
            $window.on('scroll', onChartsScroll);

            onChartsScroll();
        }
    };

    const onChartsScroll = event => {
        let $this;

        $charts.end().find('.chart_hidden').each(function() {
            $this = $(this);

            if ($this.visible()) $this.removeClass('chart_hidden');
        });
    };

    let $pagination;

    const initPagination = () => {
        $pagination = $('.pagination');

        if ($pagination.length) {
            $window.on('scroll', onPaginationScroll);

            onPaginationScroll();
        }
    };

    const onPaginationScroll = event => {
        let $this;

        $pagination.end().find('.pagination_hidden').each(function() {
            $this = $(this);

            if ($this.visible()) {
                let page = parseInt($this.data('page')),
                    pages = parseInt($this.data('pages'));

                if (pages > page) {
                    $.ajax({
                        method: 'post',
                        url: WP.url,
                        dataType: 'html',
                        data: {
                            action: 'pagination',
                            type:   $this.data('type'),
                            lang:   $this.data('lang'),
                            page:   ++page
                        },
                        beforeSend: (xhr, settings) => {
                            $this.removeClass('pagination_hidden');
                        },
                        error: (xhr, status, error) => {
                            $this.addClass('pagination_hidden');
                        },
                        success: (data, status, xhr) => {
                            $this.data('page', page).addClass(pages > page ? 'pagination_hidden' : 'pagination_completed').before(data);
                        }
                    });
                }
            }
        });
    };

    let player,
        $youtube,
        $youtubePlay;

    const initYoutube = () => {
        $youtube = $('.youtube');
        $youtubePlay = $('.youtube-play');

        if ($youtube.length && $youtubePlay.length) {
            player = new YT.Player($youtube[0], {
                videoId: $youtube.data('id'),
                host: 'https://www.youtube.com',
                playerVars: {
                    showinfo: 0,
                    enablejsapi: 1,
                    fs: 0,
                    origin: location.origin
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerState
                }
            });

            if ($youtubePlay.length) {
                $youtubePlay.on('click', onYoutubePlay);
            }

            $document.bind('fscreenchange', onYoutubeFullscreen);
        }
    };

    const onPlayerReady = event => {
        $youtube = $('.youtube');
        $youtube.addClass('youtube_ready');
    };

    const onPlayerState = event => {
        if (event.data === YT.PlayerState.ENDED) $.fullscreen.exit();
    };

    const onYoutubePlay = event => {
        event.preventDefault();

        $youtube.fullscreen();
    };

    const onYoutubeFullscreen = event => {
        if ($.fullscreen.isFullScreen()) {
            $youtube.addClass('youtube_playing');

            player.playVideo();
        } else {
            $youtube.removeClass('youtube_playing');

            player.stopVideo();
        }
    };

    let $video;

    const initVideo = () => {
        $video = $('.video');

        if ($video.length) {
            $video.children('.video__video')[0].addEventListener("play", onVideoReady);
        }
    };

    const onVideoReady = event => {
        event.target.removeEventListener(event.type, onVideoReady);

        $app.addClass('app_video');
        $video.addClass('video_ready');
    };

    $(() => {
        init();
        initVideo();
        initNews();
        initCharts();
        initPagination();

        let interval = setInterval(() => {
            if (youtube) {
                initYoutube();
                clearInterval(interval);
            }
        }, 500);
    });
})(document, window, location, jQuery, WP);

let youtube = false;

function onYouTubePlayerAPIReady() {
    youtube = true;
}