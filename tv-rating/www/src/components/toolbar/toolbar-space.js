import React from 'react';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';

import './toolbar-space.scss';

const ToolbarSpace = props => <div className={ClassNames('toolbar-space', {
    [props.className]: props.className
})} />;

ToolbarSpace.propTypes = {
    className: PropTypes.string
};

export default ToolbarSpace;