((document, window, location, $) => {
    $(() => {
        const open = event => {
            event.preventDefault();

            const target = event.currentTarget,
                metaBox = $(target).parents('.dem-field_media'),
                type = metaBox.data('type'),
                frame = wp.media({
                    library: {
                        type: type ? type.split(',') : null
                    }
                }),
                value = metaBox.find('.dem-field__value'),
                input = metaBox.find('.dem-field__input');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                switch (type) {
                    case 'video':
                        value.html(`<video class="dem-field__value__img" src="${attachment.url}"></video>`);
                        break;
                    case 'image':
                        value.html(`<img class="dem-field__value__img" src="${attachment.url}" alt="" />`);
                        break;
                }

                input.val(attachment.id);

                metaBox.toggleClass('dem-field_value', true);
                metaBox.toggleClass('dem-field_empty', false);
            });

            frame.open();
        };

        const remove = event => {
            event.preventDefault();

            const target = event.currentTarget,
                metaBox = $(target).parents('.dem-field_media'),
                value = metaBox.find('.dem-field__value'),
                input = metaBox.find('.dem-field__input');

            value.html('');
            input.val('');

            metaBox.toggleClass('dem-field_value', false);
            metaBox.toggleClass('dem-field_empty', true);
        };

        const metaBox = $('.dem-field_media'),
            actionAdd = metaBox.find('.dem-field__action_add'),
            actionEdit = metaBox.find('.dem-field__action_edit'),
            actionRemove = metaBox.find('.dem-field__action_remove'),
            value = metaBox.find('.dem-field__value'),
            input = metaBox.find('.dem-field__input');

        actionAdd.on('click', open);
        actionEdit.on('click', open);
        actionRemove.on('click', remove);
        value.on('click', open);
        input.on('focusin', open);
    });

    $(() => {
        const addUrl = event => {
            event.preventDefault();

            const target = event.currentTarget,
                metaBox = $(target).parents('.dem-field_gallery'),
                actions = metaBox.children('.dem-field__actions');

            actions.before('<div class="dem-field__item"><input class="dem-field__input dem-field__input_url ' + metaBox.data('class') + '" name="' + metaBox.data('name') + '" type="url"><span class="dem-field__actions"><a class="dem-field__action dem-field__action_remove" href="#" title="Remove icon"></a></span></div>');
        };

        const open = event => {
            event.preventDefault();

            const target = event.currentTarget,
                frame = wp.media({}),
                metaBox = $(target).parents('.dem-field_gallery'),
                actions = metaBox.children('.dem-field__actions');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                actions.before('<div class="dem-field__item"><input class="components-hidden-control__input dem-field__input dem-field__input_hidden ' + metaBox.data('class') + '" name="' + metaBox.data('name') + '" type="hidden" value="' + attachment.id + '"><span class="dem-field__value"><img class="dem-field__value__img" src="' + attachment.url + '" alt="' + attachment.id + '" /></span><span class="dem-field__actions"><a class="dem-field__action dem-field__action_edit" href="#" title="Edit icon"></a><a class="dem-field__action dem-field__action_remove" href="#" title="Remove icon"></a></span></div>');
            });

            frame.open();
        };

        const edit = event => {
            event.preventDefault();

            const target = event.currentTarget,
                frame = wp.media({}),
                item = $(target).parents('.dem-field__item'),
                input = item.find('.dem-field__input'),
                img = item.find('.dem-field__value__img');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                img.attr('src', attachment.url);
                input.val(attachment.id);
            });

            frame.open();
        };

        const remove = event => {
            event.preventDefault();

            $(event.currentTarget).parents('.dem-field__item').remove()
        };

        const metaBox = $('.dem-field_gallery'),
            actionAddUrl = metaBox.find('.dem-field__action_add-url'),
            actionAddImage = metaBox.find('.dem-field__action_add-image');

        metaBox.on('click', '.dem-field__action_edit', edit);
        metaBox.on('click', '.dem-field__value', edit);
        metaBox.on('click', '.dem-field__action_remove', remove);

        actionAddUrl.on('click', addUrl);
        actionAddImage.on('click', open);
    });
})(document, window, location, jQuery);