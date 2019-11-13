import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

import './schedule-channel.scss';

const ScheduleChannel = props => {
    const className = 'schedule-channel',
          url = '/channels';

    return <Link
      className={ClassNames(className, {
          [`${className}_imaged`]: props.image,
          [props.className]: props.className
      })}
      to={`${url}/${props.slug}`}
      title={props.name}>
      {props.image ? <div className={`${className}__image`} style={{ backgroundImage: `url(${props.image})` }} /> : ''}
      <div className={`${className}__caption`}>
        <span className={`${className}__name`}>{props.name}</span>
        {props.rating !== null && typeof props.rating !== 'undefined' ? <span className={`${className}__rating`}>{props.rating}</span> : ''}
      </div>
    </Link>
};

ScheduleChannel.propTypes = {
    className: PropTypes.string,
    image:     PropTypes.string,
    slug:      PropTypes.string.isRequired,
    name:      PropTypes.string.isRequired,
    rating:    PropTypes.number
};

ScheduleChannel.defaultProps = {
    rating: 0
};

export default ScheduleChannel;