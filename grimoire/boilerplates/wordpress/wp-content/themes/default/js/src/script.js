((document, window, location, $, WP = {}) => {
    const $document = $(document),
          $window = $(window);

    let $body,
        $app;

    const init = () => {
        $body = $document.find('body');
        $app = $body.find('.app');
    };
    
    $(() => {
        init();
    });
})(document, window, location, jQuery, WP);