import React from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import Button from 'components/button';

import './error.scss';

// TODO: Consider using nav for error__nav
// TODO: Consider move buttons array to children

const Error = props => {
    const className = 'error';

    return <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.number ? <h5 className={`${className}__number`}>{props.number}</h5> : ''}
      {props.title ? <h1 className={`${className}__title`}>{props.title}</h1> : ''}
      {props.children ? <p className={`${className}__text`}>{props.children}</p> : ''}
      {props.buttons && props.buttons.length ? <div className={`${className}__nav`}>
        {props.buttons.map((item, i) => {
            const { children: itemChildren, ...itemProps } = item;

            return <Button key={i} className={`${className}__nav__button`} {...itemProps}>{itemChildren ? itemChildren : ''}</Button>;
        })}
      </div> : ''}
    </div>;
};

Error.propTypes = {
    className: PropTypes.string,
    number:    PropTypes.number,
    title:     PropTypes.string,
    buttons:   PropTypes.arrayOf(PropTypes.shape(Button.propTypes)),
    children:  PropTypes.node
};

Error.defaultProps = {
    buttons: []
};

export default Error;