import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import ScheduleTimeline from './schedule-timeline';
import ScheduleChannel from './schedule-channel';
import ScheduleBroadcasts from './schedule-broadcasts';

import { schedule } from 'actions';

// TODO: Add SVG to sprite

import ActionTimeSVG from 'svg/action--time.svg';

import './schedule.scss';

const Schedule = props => {
    const className = 'schedule';

    useEffect(() => {
        console.log(props.channels);
    }, [props.channels]);

    const onTime = event => {
        event.preventDefault();

        console.log('time');
    };

    return <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      <div className={`${className}__days`}>
        <div className={`${className}__day`}>
          <ScheduleTimeline className={`${className}__day__timeline`} />
          <div className={`${className}__channels`}>
            {props.channels.map((channel, i) => {
                return <div key={i} className={`${className}__channel`}>
                  <ScheduleBroadcasts />
                </div>;
            })}
          </div>
        </div>
      </div>
      <div className={`${className}__header`}>
        <div className={`${className}__header__corner`}>
          <a className={`${className}__header__corner__action`} href="#" title="" onClick={onTime}>
            <ActionTimeSVG />
          </a>
        </div>
        <div className={`${className}__channels`}>
          {props.channels.map((channel, i) => {
              const { _id, ...channelProps } = channel;

              return <div key={i} className={`${className}__channel`}>
                <ScheduleChannel {...channelProps} />
              </div>;
          })}
        </div>
      </div>
    </div>;
};

Schedule.TYPE_SCHEDULED  = 'scheduled';
Schedule.TYPE_15_MINUTED = '15-minuted';
Schedule.TYPES = [Schedule.TYPE_SCHEDULED, Schedule.TYPE_15_MINUTED];

Schedule.propTypes = {
    className: PropTypes.string,
    type:      PropTypes.oneOf(Schedule.TYPES),
    interval:  PropTypes.number,
    channels:  PropTypes.array
};

Schedule.defaultProps = {

};

export default connect((state, ownProps) => {
    const props = {};

    props.channels = state.channels.data.filter(channel => ownProps.channels.includes(channel._id));
    props.schedule = state.schedule;

    return props;
}, (dispatch, ownProps) => {
    return {
        dispatch,
        getShedule: data => dispatch(schedule.get(data))
    };
})(Schedule);