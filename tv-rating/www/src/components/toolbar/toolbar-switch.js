import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';
import { Link, NavLink } from 'react-router-dom';

import { ui } from 'constants';

import './toolbar-switch.scss';

const ToolbarSwitch = props => {
    const className = 'toolbar-switch';

    let [active, setActive] = useState(undefined);

    useEffect(() => {
        const selected = props.children.find(item => item.active);

        if (selected) setActive(selected.id);
    }, []);

    useEffect(() => {
        if (active && props.onChange) props.onChange(active);
    }, [active]);

    const onClick = event => {
        event.preventDefault();

        const dataId = event.currentTarget.getAttribute('data-id'),
              dataOnClick = event.currentTarget.getAttribute('data-onclick');

        setActive(dataId);

        if (dataOnClick) dataOnClick(event);
    };

    return props.children && props.children.length ? <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.children.map((item, i) => {
          const classNames = ClassNames(`${className}__button`, {
              [`${className}__button_disabled`]: item.disabled,
              [`${className}__button_id_${item.id}`]: item.id,
              [item.className]: item.className
          });

          switch (true) {
              case !!item.to && !!item.activeClassName:
                  return <NavLink
                    key={i}
                    className={classNames}
                    exact={item.exact}
                    to={item.to}
                    activeClassName={ClassNames(`${className}__button_active`, {
                        [item.activeClassName]: item.activeClassName
                    })}
                    title={React.isValidElement(item.children) ? null : item.children}
                    onClick={item.onClick}>
                    {item.children}
                  </NavLink>;
              case !!item.to:
                  return <Link
                    key={i}
                    className={classNames}
                    exact={item.exact}
                    to={item.to}
                    title={React.isValidElement(item.children) ? null : item.children}
                    onClick={item.onClick}>
                    {item.children}
                  </Link>;
              case !!item.href:
                  return <a
                    key={i}
                    className={classNames}
                    href={item.href}
                    title={React.isValidElement(item.children) ? null : item.children}
                    onClick={item.onClick}>
                    {item.children}
                  </a>;
              case !!item.htmlFor:
                  return <label
                    key={i}
                    className={classNames}
                    htmlFor={item.htmlFor}
                    onClick={item.onClick}>
                    {item.children}
                  </label>;
              default:
                  return <a
                    key={i}
                    className={ClassNames(classNames, {
                        [`${className}__button_active`]: item.id === active
                    })}
                    href="#"
                    title={React.isValidElement(item.children) ? null : item.children}
                    onClick={onClick}
                    data-id={item.id}
                    data-onclick={item.onClick}>
                    {item.children}
                  </a>;
          }
      })}
    </div> : '';
};

ToolbarSwitch.propTypes = {
    className: PropTypes.string,
    onChange:  PropTypes.func,
    children:  PropTypes.arrayOf(PropTypes.shape({
        className:       PropTypes.string,
        id:              PropTypes.string,
        to:              PropTypes.string,
        exact:           PropTypes.bool,
        activeClassName: PropTypes.string,
        href:            PropTypes.string,
        htmlFor:         PropTypes.string,
        onClick:         PropTypes.func,
        children:        PropTypes.node,
        active:          PropTypes.bool,
        disabled:        PropTypes.bool
    }))
};

ToolbarSwitch.defaultProps = {

};

export default ToolbarSwitch;