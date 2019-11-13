import React from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import './text.scss';

const Text = props => {
    const className = 'text';

    return <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.children ? props.children : ''}
    </div>;
};

Text.propTypes = {
    className: PropTypes.string,
    children:  PropTypes.node
};

export default Text;