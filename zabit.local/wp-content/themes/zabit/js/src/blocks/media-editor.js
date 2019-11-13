((wp, location) => {
    const { registerBlockType } = wp.blocks,
          { __, setLocaleData } = wp.i18n,
          { BlockControls, InspectorControls, MediaUpload } = wp.editor,
          { Toolbar, BaseControl, Modal, IconButton, Button, TextControl } = wp.components,
          { Fragment } = wp.element;

    registerBlockType('zabit/media', {
        title: __('Media', 'zabit'),
        icon: 'images-alt',
        category: 'layout',

        supports: {
            htmlValidation: false
        },

        attributes: {
            content: {
                type: 'array',
                default: []
            },

            youtube: {
                type: 'string',
                default: ''
            },

            vimeo: {
                type: 'string',
                default: ''
            },

            iframe: {
                type: 'string',
                default: ''
            },

            openedYT: {
                type: 'boolean',
                default: false
            },

            openedVimeo: {
                type: 'boolean',
                default: false
            },

            openedIFrame: {
                type: 'boolean',
                default: false
            }
        },

        edit: props => {
            const ID = `zabit/media:${Math.round(Math.random() * 1024 * 1024)}`;

            const onSelectImages = media => {
                props.setAttributes({ content: [...props.attributes.content, ...media.map(data => {
                        return {
                            type: 'image',
                            data
                        };
                    })] });
            };

            const onSelectVideo = media => {
                props.setAttributes({ content: [...props.attributes.content, ...media.map(data => {
                        return {
                            type: 'video',
                            data
                        };
                    })] });
            };

            const onOpenYT = () => {
                props.setAttributes({ openedYT: true });
            };

            const onCloseYT = () => {
                props.setAttributes({ openedYT: false });
            };

            const onSelectYT = () => {
                if (props.attributes.youtube !== '') {
                    props.setAttributes({
                        content: [...props.attributes.content, {
                            type: 'youtube',
                            data: props.attributes.youtube
                        }],
                        youtube: ''
                    });

                    onCloseYT();
                }
            };

            const onChangeYT = youtube => {
                props.setAttributes({ youtube });
            };

            const onOpenVimeo = () => {
                props.setAttributes({ openedVimeo: true });
            };

            const onCloseVimeo = () => {
                props.setAttributes({ openedVimeo: false });
            };

            const onSelectVimeo = () => {
                if (props.attributes.vimeo !== '') {
                    props.setAttributes({
                        content: [...props.attributes.content, {
                            type: 'vimeo',
                            data: props.attributes.vimeo
                        }],
                        vimeo: ''
                    });

                    onCloseVimeo();
                }
            };

            const onChangeVimeo = vimeo => {
                props.setAttributes({ vimeo });
            };

            const onOpenIFrame = () => {
                props.setAttributes({ openedIFrame: true });
            };

            const onCloseIFrame = () => {
                props.setAttributes({ openedIFrame: false });
            };

            const onSelectIFrame = () => {
                if (props.attributes.iframe !== '') {
                    props.setAttributes({
                        content: [...props.attributes.content, {
                            type: 'iframe',
                            data: props.attributes.iframe
                        }],
                        iframe: ''
                    });

                    onCloseIFrame();
                }
            };

            const onChangeIFrame = iframe => {
                props.setAttributes({ iframe });
            };

            return <div className={`${props.className} media`}>
                <BlockControls>
                    <Toolbar>
                        <MediaUpload onSelect={onSelectImages} allowedTypes={['image/jpeg', 'image/jpg', 'image/png']} multiple={true} render={({ open }) => <IconButton icon="plus" label={__('Upload', 'zabit')} onClick={open} />}/>
                        <MediaUpload onSelect={onSelectVideo} allowedTypes={['video']} multiple={true} render={({ open }) => <IconButton icon="plus" label={__('Upload', 'zabit')} onClick={open} />}/>
                        <IconButton icon="format-video" label="Add" onClick={onOpenYT} />
                        <IconButton icon="format-video" label="Add" onClick={onOpenVimeo} />
                        <IconButton icon="format-video" label="Add" onClick={onOpenIFrame} />
                    </Toolbar>
                </BlockControls>
                {props.attributes.content.map(item => <div className="media__item">
                    {(item => {
                        switch (item.type) {
                            case 'image':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data.url} data-fancybox={ID} data-caption={item.data.caption}>{item.data.id}</a>;
                            case 'video':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data.url} data-fancybox={ID} data-caption={item.data.caption}>{item.data.id}</a>;
                            case 'vimeo':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={`https://vimeo.com/${item.data}`} data-fancybox={ID}>{item.data}</a>;
                            case 'youtube':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={`https://www.youtube.com/watch?v=${item.data}`} data-fancybox={ID}>{item.data}</a>;
                            case 'iframe':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data} data-fancybox={ID} data-src={item.data}>{item.data}</a>;
                        }
                    })(item)}
                </div>)}
                {props.attributes.openedYT && <Modal title={__('Youtube', 'zabit')} onRequestClose={onCloseYT}>
                    <TextControl label={__('Youtube ID', 'zabit')} value={props.attributes.youtube} onChange={onChangeYT} />
                    <Button isDefault onClick={onSelectYT}>{__('Add', 'zabit')}</Button>
                </Modal>}
                {props.attributes.openedVimeo && <Modal title={__('Vimeo', 'zabit')} onRequestClose={onCloseVimeo}>
                    <TextControl label={__('Vimeo ID', 'zabit')} value={props.attributes.vimeo} onChange={onChangeVimeo} />
                    <Button isDefault onClick={onSelectVimeo}>{__('Add', 'zabit')}</Button>
                </Modal>}
                {props.attributes.openedIFrame && <Modal title={__('IFrame', 'zabit')} onRequestClose={onCloseIFrame}>
                    <TextControl label={__('IFrame URL', 'zabit')} value={props.attributes.iframe} onChange={onChangeIFrame} />
                    <Button isDefault onClick={onSelectIFrame}>{__('Add', 'zabit')}</Button>
                </Modal>}
            </div>;
        },

        save: props => {
            const ID = `zabit/media:${Math.round(Math.random() * 1024 * 1024)}`;

            return <div className={`${props.className} media`}>
                {props.attributes.content.map(item => <div className="media__item">
                    {(item => {
                        switch (item.type) {
                            case 'image':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data.url} data-fancybox={ID} data-caption={item.data.caption}>
                                    <img src={item.data.url} title={item.data.title} alt={item.data.alt} />
                                </a>;
                            case 'video':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data.url} data-fancybox={ID} data-caption={item.data.caption}>
                                    <video>
                                        <source src={item.data.url} type="video/mp4" />
                                        {__("Your browser doesn't support HTML5 video tag.", 'zabit')}
                                    </video>
                                </a>;
                            case 'vimeo':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={`https://vimeo.com/${item.data}`} data-src={`https://vimeo.com/${item.data}`} data-fancybox={ID}>
                                    <iframe src={`http://player.vimeo.com/video/${item.data}`} frameBorder="0" />
                                </a>;
                            case 'youtube':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={`https://www.youtube.com/watch?v=${item.data}`} data-src={`https://www.youtube.com/watch?v=${item.data}`} data-fancybox={ID}>
                                    <iframe src={`http://www.youtube.com/embed/${item.data}?autoplay=0&controls=0&origin=${location.origin}`} frameBorder="0" />
                                </a>;
                            case 'iframe':
                                return <a className={`media__item__content media__item__content_${item.type}`} href={item.data} data-fancybox={ID} data-src={item.data}>
                                    <iframe src={item.data} frameBorder="0" />
                                </a>;
                        }
                    })(item)}
                </div>)}
            </div>;
        }
    });
})(window.wp, location);
