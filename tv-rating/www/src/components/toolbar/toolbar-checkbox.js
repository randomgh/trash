import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

// TODO: Add SVG to sprite

import UICheckSVG from 'svg/ui--check.svg';

import './toolbar-checkbox.scss';

const ToolbarCheckbox = props => {
    const className = 'toolbar-checkbox';

    let [checked, setChecked] = useState(props.checked ? props.checked : false);

    useEffect(() => {
        if (props.onChange) props.onChange(checked);
    }, [checked]);

    const onClick = event => {
        event.preventDefault();

        setChecked(!checked);
    };

    return <a className={ClassNames(className, {
        [`${className}_checked`]: checked
    })} href="#" title={typeof props.children === 'string' || props.children instanceof String ? props.children : null} onClick={onClick}>
      <span className={`${className}__check`}>
        <UICheckSVG />
      </span>
      {props.children ? <span className={`${className}__label`}>
        {props.children}
      </span> : ''}
    </a>;
};

ToolbarCheckbox.propTypes = {
    className: PropTypes.string,
    checked:   PropTypes.bool,
    disabled:  PropTypes.bool,
    children:  PropTypes.node,
    onChange:  PropTypes.func
};

// TODO: Move default props to css

ToolbarCheckbox.defaultProps = {
    
};

export default ToolbarCheckbox;