import React from 'react';
import { Link, NavLink } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import ui from 'constants/ui-constants';

import './button.scss';

// TODO: Consider using "link" type for a tag
// TODO: Consider using "label" type for label tag
// TODO: Add loading and completed state

const Button = props => {
    const className = 'button',
          classNames = ClassNames(className, {
              [`${className}_type_${props.type}`]: props.type,
              [`${className}_style_${props.style}`]: props.style,
              [`${className}_color_${props.color}`]: props.color,
              [`${className}_size_${props.size}`]: props.size,
              [`${className}_disabled`]: props.disabled,
              [`${className}_active`]: props.active,
              [props.className]: props.className
          }),
          children = props.children ? props.children : '';

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

Button.STYLE_REGULAR     = 'regular';
Button.STYLE_ALTERNATIVE = 'alternative';
Button.STYLES = [Button.STYLE_REGULAR, Button.STYLE_ALTERNATIVE];

Button.propTypes = {
    className:       PropTypes.string,
    type:            PropTypes.oneOf(ui.BUTTON_TYPES),
    style:           PropTypes.oneOf(Button.STYLES),
    color:           PropTypes.oneOf(ui.COLORS),
    size:            PropTypes.oneOf(ui.SIZES),
    to:              PropTypes.string,
    exact:           PropTypes.bool,
    activeClassName: PropTypes.string,
    href:            PropTypes.string,
    title:           PropTypes.string,
    htmlFor:         PropTypes.string,
    onClick:         PropTypes.func,
    children:        PropTypes.node,
    disabled:        PropTypes.bool,
    active:          PropTypes.bool
};

// TODO: Move default props to css

Button.defaultProps = {
    style: Button.STYLE_REGULAR,
    color: ui.COLOR_BLUE,
    size:  ui.SIZE_NORMAL
};

export default Button;