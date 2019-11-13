import React from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

// TODO: Add SVG to sprite

import SuccessSVG from 'svg/status--success.svg';
import WarningSVG from 'svg/status--warning.svg';
import DangerSVG from 'svg/status--danger.svg';
import InfoSVG from 'svg/status--info.svg';

import './message.scss';

const Message = props => {
    const className = 'message';

    let status;

    switch(props.status){
        case ui.STATUS_SUCCESS:
            status = <SuccessSVG />;
            break;
        case ui.STATUS_WARNING:
            status = <WarningSVG />;
            break;
        case ui.STATUS_DANGER:
            status = <DangerSVG />;
            break;
        case ui.STATUS_INFO:
            status = <InfoSVG />;
            break;
    }

    return <div className={ClassNames(className, {
        [`${className}_status_${props.status}`]: props.status,
        [props.className]: props.className
    })}>
      {status ? <div className={`${className}__icon`}>{status}</div> : ''}
      {props.title ? <h4 className={`${className}__title`}>{props.title}</h4> : ''}
      {props.children ? <p className={`${className}__text`}>{props.children}</p> : ''}
    </div>;
};

Message.propTypes = {
    className: PropTypes.string,
    title:     PropTypes.string,
    status:    PropTypes.oneOf(ui.STATUSES),
    children:  PropTypes.node
};

export default Message;