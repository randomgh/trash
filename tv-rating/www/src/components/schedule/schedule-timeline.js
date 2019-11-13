import React from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import './schedule-timeline.scss';

const ScheduleTimeline = props => {
    const className = 'schedule-timeline';

    return <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {[...new Array(24)].map((v, i) => <div key={i} className={`${className}__hour ${className}__hour_${i}`}>
        <span className={`${className}__hour__title`}>{`${i < 10 ? `0${i}` : i}:00`}</span>
        {[...new Array(3)].map((v, j) => <span key={j + 1} className={`${className}__quarter ${className}__quarter_${j + 1}`} />)}
      </div>)}
    </div>
};

ScheduleTimeline.propTypes = {
    className: PropTypes.string,
    hours:     PropTypes.number.isRequired
};

ScheduleTimeline.defaultProps = {
    hours: 24
};

export default ScheduleTimeline;