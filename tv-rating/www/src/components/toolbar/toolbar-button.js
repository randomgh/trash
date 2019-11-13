import React from 'react';
import { Link, NavLink } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

import './toolbar-button.scss';

const ToolbarButton = props => {
    const className = 'toolbar-button',
          imaged = props.svg || props.img,
          labeled = props.title || props.subtitle,
          classNames = ClassNames(className, {
              [`${className}_size_${props.size}`]: props.size,
              [`${className}_imaged`]: imaged,
              [`${className}_labeled`]: labeled,
              [`${className}_circle`]: props.circleImage,
              [`${className}_active`]: props.active,
              [`${className}_disabled`]: props.disabled,
              [props.className]: props.className
          }),
          children = <>
            {imaged ? <div className={ClassNames(`${className}__image`, {
                [`${className}__image_svg`]: props.svg,
                [`${className}__image_img`]: props.img
            })}>
              {props.svg ? React.createElement(props.svg) : ''}
              {props.img ? <span style={{ backgroundImage: `url(${props.img})` }} /> : ''}
            </div> : ''}
            {labeled ? <div className={`${className}__caption`}>
              {props.title ? <span className={`${className}__title`}>{props.title}</span> : ''}
              {props.subtitle ? <span className={`${className}__subtitle`}>{props.subtitle}</span> : ''}
            </div> : ''}
          </>;

    switch (true) {
        case !!props.to && (!!props.activeClassName || !!props.exact):
            return <NavLink
              className={classNames}
              to={props.to}
              exact={props.exact}
              activeClassName={ClassNames(`${className}_active`, {
                  [props.activeClassName]: props.activeClassName
              })}
              title={props.title}
              onClick={props.onClick}>
              {children}
            </NavLink>;
        case !!props.to:
            return <Link
              className={classNames}
              to={props.to}
              title={props.title}
              onClick={props.onClick}>
              {children}
            </Link>;
        case !!props.href:
            return <a
              className={classNames}
              href={props.href}
              title={props.title}
              onClick={props.onClick}>
              {children}
            </a>;
        case !!props.htmlFor:
            return <label
              className={classNames}
              htmlFor={props.htmlFor}
              onClick={props.onClick}>
              {children}
            </label>;
        default:
            return <button
              className={classNames}
              type={props.type}
              onClick={props.onClick}>
              {children}
            </button>;
    }
};

ToolbarButton.propTypes = {
    className:       PropTypes.string,
    size:            PropTypes.oneOf(ui.SIZES),
    type:            PropTypes.oneOf(ui.BUTTON_TYPES),
    circleImage:     PropTypes.bool,
    svg:             PropTypes.func,
    img:             PropTypes.string,
    title:           PropTypes.string,
    subtitle:        PropTypes.string,
    to:              PropTypes.string,
    exact:           PropTypes.bool,
    activeClassName: PropTypes.string,
    href:            PropTypes.string,
    htmlFor:         PropTypes.string,
    onClick:         PropTypes.func,
    active:          PropTypes.bool,
    disabled:        PropTypes.bool
};

// TODO: Move default props to css

ToolbarButton.defaultProps = {
    size: ui.SIZE_NORMAL
};

export default ToolbarButton;