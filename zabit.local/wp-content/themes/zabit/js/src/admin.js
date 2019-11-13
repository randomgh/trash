(($) => {
    $(document).ready(event => {
        const open = event => {
            event.preventDefault();

            const target = event.currentTarget,
                  metaBox = $(target).parents('.zabit-field_media'),
                  type = metaBox.data('type'),
                  frame = wp.media({
                      library: {
                          type: type ? type.split(',') : null
                      }
                  }),
                  value = metaBox.find('.zabit-field__value'),
                  input = metaBox.find('.zabit-field__input');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                switch (type) {
                    case 'video':
                        value.html(`<video class="zabit-field__value__img" src="${attachment.url}"></video>`);
                        break;
                    case 'image':
                        value.html(`<img class="zabit-field__value__img" src="${attachment.url}" alt="" />`);
                        break;
                }

                input.val(attachment.id);

                metaBox.toggleClass('zabit-field_value', true);
                metaBox.toggleClass('zabit-field_empty', false);
            });

            frame.open();
        };

        const remove = event => {
            event.preventDefault();

            const target = event.currentTarget,
                  metaBox = $(target).parents('.zabit-field_media'),
                  value = metaBox.find('.zabit-field__value'),
                  input = metaBox.find('.zabit-field__input');

            value.html('');
            input.val('');

            metaBox.toggleClass('zabit-field_value', false);
            metaBox.toggleClass('zabit-field_empty', true);
        };

        const metaBox = $('.zabit-field_media'),
              actionAdd = metaBox.find('.zabit-field__action_add'),
              actionEdit = metaBox.find('.zabit-field__action_edit'),
              actionRemove = metaBox.find('.zabit-field__action_remove'),
              value = metaBox.find('.zabit-field__value'),
              input = metaBox.find('.zabit-field__input');

        actionAdd.on('click', open);
        actionEdit.on('click', open);
        actionRemove.on('click', remove);
        value.on('click', open);
        input.on('focusin', open);
    });
})(jQuery);

(($) => {
    $(document).ready(event => {
        const addUrl = event => {
            event.preventDefault();

            const target = event.currentTarget,
                  metaBox = $(target).parents('.zabit-field_gallery'),
                  actions = metaBox.children('.zabit-field__actions');

            actions.before('<div class="zabit-field__item"><input class="zabit-field__input zabit-field__input_url ' + metaBox.data('class') + '" name="' + metaBox.data('name') + '" type="url"><span class="zabit-field__actions"><a class="zabit-field__action zabit-field__action_remove" href="#" title="Remove icon"></a></span></div>');
        };

        const open = event => {
            event.preventDefault();

            const target = event.currentTarget,
                frame = wp.media({}),
                metaBox = $(target).parents('.zabit-field_gallery'),
                actions = metaBox.children('.zabit-field__actions');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                actions.before('<div class="zabit-field__item"><input class="components-hidden-control__input zabit-field__input zabit-field__input_hidden ' + metaBox.data('class') + '" name="' + metaBox.data('name') + '" type="hidden" value="' + attachment.id + '"><span class="zabit-field__value"><img class="zabit-field__value__img" src="' + attachment.url + '" alt="' + attachment.id + '" /></span><span class="zabit-field__actions"><a class="zabit-field__action zabit-field__action_edit" href="#" title="Edit icon"></a><a class="zabit-field__action zabit-field__action_remove" href="#" title="Remove icon"></a></span></div>');
            });

            frame.open();
        };

        const edit = event => {
            event.preventDefault();

            const target = event.currentTarget,
                frame = wp.media({}),
                item = $(target).parents('.zabit-field__item'),
                input = item.find('.zabit-field__input'),
                img = item.find('.zabit-field__value__img');

            frame.on('select', function(){
                const attachment = frame.state().get('selection').first().toJSON();

                img.attr('src', attachment.url);
                input.val(attachment.id);
            });

            frame.open();
        };

        const remove = event => {
            event.preventDefault();

            $(event.currentTarget).parents('.zabit-field__item').remove()
        };

        const metaBox = $('.zabit-field_gallery'),
            actionAddUrl = metaBox.find('.zabit-field__action_add-url'),
            actionAddImage = metaBox.find('.zabit-field__action_add-image');

        metaBox.on('click', '.zabit-field__action_edit', edit);
        metaBox.on('click', '.zabit-field__value', edit);
        metaBox.on('click', '.zabit-field__action_remove', remove);

        actionAddUrl.on('click', addUrl);
        actionAddImage.on('click', open);
    });
})(jQuery);