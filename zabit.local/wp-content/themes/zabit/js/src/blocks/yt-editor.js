((wp) => {
    const { registerBlockType } = wp.blocks,
          { __, setLocaleData } = wp.i18n,
          { BlockControls, InspectorControls, MediaUpload } = wp.editor,
          { Toolbar, BaseControl, Modal, IconButton, Button, TextControl } = wp.components,
          { Fragment } = wp.element;

    registerBlockType('zabit/yt', {
        title: __('Youtube', 'zabit'),
        icon: 'carrot',
        category: 'layout',

        supports: {
            htmlValidation: false
        },

        attributes: {
            id: {
                type: 'string',
                default: ''
            }
        },

        edit: props => {
            const onChangeID = id => {
                props.setAttributes({ id });
            };

            return <Fragment>
                <InspectorControls>
                    <Toolbar>
                        <TextControl label={__('ID', 'zabit')} value={props.attributes.id} onChange={onChangeID} />
                    </Toolbar>
                </InspectorControls>
                <div className={`${props.className} yt`}>
                    <span className="yt__video">{props.attributes.id}</span>
                </div>
            </Fragment>;
        },

        save: props => {
            return <div className={`${props.className} yt`} data-id={props.attributes.id}>
                <span className="yt__video" />
            </div>;
        }
    });
})(window.wp);