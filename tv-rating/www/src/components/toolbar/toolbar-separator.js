import React from 'react';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';

import './toolbar-separator.scss';

const ToolbarSeparator = props => <div className={ClassNames('toolbar-separator', {
    [props.className]: props.className
})} />;

ToolbarSeparator.propTypes = {
    className: PropTypes.string
};

export default ToolbarSeparator;