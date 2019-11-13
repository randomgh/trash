((document, window, location, $, WP = {}) => {
    const INTERVAL = 500;

    let $yt;

    const init = () => {
        $yt = $('.yt');

        if ($yt.length) {
            $yt.each(function() {
                const $this = $(this);

                new YT.Player($this.find('.yt__video')[0], {
                    videoId: $this.data('id'),
                    host: 'https://www.youtube.com',
                    playerVars: {
                        showinfo: 1,
                        enablejsapi: 0,
                        fs: 0,
                        origin: location.origin
                    }
                });
            });
        }
    };

    $(() => {
        let interval = setInterval(() => {
            if (youtube) {
                init();
                clearInterval(interval);
            }
        }, INTERVAL);
    });
})(document, window, location, jQuery, WP);