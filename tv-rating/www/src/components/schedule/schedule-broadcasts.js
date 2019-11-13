import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

import './schedule-broadcasts.scss';

const ScheduleBroadcasts = props => {
    const className = 'schedule-broadcast',
          url = '/broadcasts';

    return <Link
      className={ClassNames(className, {
          [`${className}_imaged`]: props.image,
          [props.className]: props.className
      })}
      to={`${url}/`} />
};

ScheduleBroadcasts.propTypes = {
    className: PropTypes.string
};

ScheduleBroadcasts.defaultProps = {
    rating: 0
};

export default ScheduleBroadcasts;