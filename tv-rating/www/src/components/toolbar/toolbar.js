import React from 'react';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import './toolbar.scss';

const Toolbar = props => {
    const className = 'toolbar';

    return <nav className={ClassNames(className, {
        [`${className}_size_${props.size}`]: props.size,
        [props.className]: props.className
    })}>
      {props.children ? props.children : ''}
    </nav>;
};

Toolbar.propTypes = {
    className: PropTypes.string,
    size:      PropTypes.oneOf([ui.SIZE_SMALL, ui.SIZE_MEDIUM, ui.SIZE_NORMAL, ui.SIZE_BIG]),
    children:  PropTypes.node
};

// TODO: Move default props to css

Toolbar.defaultProps = {
    size: ui.SIZE_NORMAL
};

export default Toolbar;