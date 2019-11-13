import React from 'react';
import PropTypes from 'prop-types';

import './modal.scss';

const Modal = props => {
    const className = 'modal';

    return <div className={className} id={props.id}>
      {props.children ? props.children : ''}
    </div>;
};

Modal.propTypes = {
    id:       PropTypes.string.isRequired,
    children: PropTypes.node
};

export default Modal;