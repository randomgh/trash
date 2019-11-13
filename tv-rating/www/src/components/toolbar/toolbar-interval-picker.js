import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

// TODO: Add SVG to sprite

import ArrowNSVG from 'svg/arrow--n.svg';
import ArrowSSVG from 'svg/arrow--s.svg';
import ArrowWSVG from 'svg/arrow--w.svg';
import ArrowESVG from 'svg/arrow--e.svg';

import './toolbar-interval-picker.scss';

const ToolbarIntervalPicker = props => {
    const className = 'toolbar-interval-picker',
          options = [];

    let [shown, setShown] = useState(false);
    let [current, setCurrent] = useState(props.current ? props.current : 0);

    useEffect(() => {
        if (props.onChange) props.onChange(current);
    }, [current]);

    const zero = value => {
        return value < 10 && value >= 0 ? `0${value}` : `${value}`;
    };

    let label,
        begin,
        end;

    for (let i = props.max; i <= props.min; i++) {
        switch (props.interval) {
            case ToolbarIntervalPicker.INTERVAL_YEAR:
                label = new Date().getFullYear() - i;
                break;
            case ToolbarIntervalPicker.INTERVAL_MONTH:
                label = (new Date().getMonth() + 1 - i) % 12;

                if (label <= 0) label = 12 + label;

                label = `${zero(label)} (${ToolbarIntervalPicker.MONTHS[label - 1]})`;
                break;
            case ToolbarIntervalPicker.INTERVAL_WEEK:
                begin = new Date();
                end = new Date();

                label = begin.getDate() - begin.getDay() + props.weekStart - i * 7;

                if (begin.getDay() < props.weekStart) label -= 7;

                begin.setDate(label);
                end.setDate(label + 7 - 1);

                label = `${zero(begin.getDate())}.${zero(begin.getMonth() + 1)} - ${zero(end.getDate())}.${zero(end.getMonth() + 1)}`;
                break;
            case ToolbarIntervalPicker.INTERVAL_DAY:
                begin = new Date();

                begin.setDate(begin.getDate() - i);

                label = `${zero(begin.getDate())}.${zero(begin.getMonth() + 1)} (${ToolbarIntervalPicker.WEEK[begin.getDay()]})`;
                break;
        }

        options.push({ label, value: i });
    }

    const onStep = event => {
        event.preventDefault();

        if(shown) setShown(false);

        const direction = event.currentTarget.classList.contains(`${className}__control_next`),
              index = options.findIndex(option => option.value === current);

        if (direction && index > 0) {
            setCurrent(options[index - 1].value);
        } else if (!direction && index < options.length - 1) {
            setCurrent(options[index + 1].value);
        }
    };

    const onDrop = event => {
        event.preventDefault();

        setShown(!shown);
    };

    const onOption = event => {
        event.preventDefault();

        if (shown) {
            setCurrent(parseInt(event.currentTarget.getAttribute('data-value')));

            setShown(false);
        } else {
            setShown(true);
        }
    };

    const onOutside = event => {
        if (!event.target.closest(`.${className}`)) setShown(false);
    };

    useEffect(() => {
        if (shown) document.addEventListener('click', onOutside);

        return shown ? () => document.removeEventListener('click', onOutside) : () => {};
    }, [shown]);

    return <div className={ClassNames(className, {
        [`${className}_interval_${props.interval}`]: props.interval,
        [`${className}_shown`]: shown,
        [props.className]: props.className
    })}>
      <div className={`${className}__value`}>
        <div className={`${className}__list`}>
          {options.map((item, i) => <a
            key={i}
            className={ClassNames(`${className}__option`, {
                [`${className}__option_current`]: item.value === current
            })}
            href="#"
            title={item.label}
            data-value={item.value}
            onClick={onOption}>
            {item.label}
          </a>)}
        </div>
      </div>
      {((type) => {
          const index = options.findIndex(option => option.value === current);

          switch (type) {
              case ToolbarIntervalPicker.CONTROL_STEP:
                  return <>
                    <a
                      className={ClassNames(`${className}__control ${className}__control_previous`, {
                          [`${className}__control_disabled`]: index < options.length - 1
                      })}
                      href="#"
                      title={props.interval === ToolbarIntervalPicker.INTERVAL_WEEK ? 'Предыдущая' : 'Предыдущий'}
                      onClick={onStep}>
                      <ArrowWSVG />
                    </a>
                    <a
                      className={ClassNames(`${className}__control ${className}__control_next`, {
                        [`${className}__control_disabled`]: index > 0
                      })}
                      href="#"
                      title={props.interval === ToolbarIntervalPicker.INTERVAL_WEEK ? 'Следующая' : 'Следующий'}
                      onClick={onStep}>
                      <ArrowESVG />
                    </a>
                  </>;
              case ToolbarIntervalPicker.CONTROL_DROP:
              default:
                  return <>
                    <a
                      className={`${className}__control ${className}__control_drop`}
                      href="#"
                      title="Список"
                      onClick={onDrop}>
                      {shown ? <ArrowNSVG /> : <ArrowSSVG />}
                    </a>
                  </>;
          }
      })(props.controls)}
    </div>;
};

ToolbarIntervalPicker.MONTH_JANUARY   = 'Январь';
ToolbarIntervalPicker.MONTH_FEBRARY   = 'Февраль';
ToolbarIntervalPicker.MONTH_MARCH     = 'Март';
ToolbarIntervalPicker.MONTH_APRIL     = 'Апрель';
ToolbarIntervalPicker.MONTH_MAY       = 'Май';
ToolbarIntervalPicker.MONTH_JUNE      = 'Июнь';
ToolbarIntervalPicker.MONTH_JULY      = 'Июль';
ToolbarIntervalPicker.MONTH_AUGUST    = 'Август';
ToolbarIntervalPicker.MONTH_SEPTEMBER = 'Сентябрь';
ToolbarIntervalPicker.MONTH_OCTOBER   = 'Октябрь';
ToolbarIntervalPicker.MONTH_NOVEMBER  = 'Ноябрь';
ToolbarIntervalPicker.MONTH_DECEMBER  = 'Декабрь';
ToolbarIntervalPicker.MONTHS = [
    ToolbarIntervalPicker.MONTH_JANUARY,
    ToolbarIntervalPicker.MONTH_FEBRARY,
    ToolbarIntervalPicker.MONTH_MARCH,
    ToolbarIntervalPicker.MONTH_APRIL,
    ToolbarIntervalPicker.MONTH_MAY,
    ToolbarIntervalPicker.MONTH_JUNE,
    ToolbarIntervalPicker.MONTH_JULY,
    ToolbarIntervalPicker.MONTH_AUGUST,
    ToolbarIntervalPicker.MONTH_SEPTEMBER,
    ToolbarIntervalPicker.MONTH_OCTOBER,
    ToolbarIntervalPicker.MONTH_NOVEMBER,
    ToolbarIntervalPicker.MONTH_DECEMBER
];

ToolbarIntervalPicker.WEEK_SUNDAY    = 'Воскресенье';
ToolbarIntervalPicker.WEEK_MONDAY    = 'Понедельник';
ToolbarIntervalPicker.WEEK_TUESDAY   = 'Вторник';
ToolbarIntervalPicker.WEEK_WEDNESDAY = 'Среда';
ToolbarIntervalPicker.WEEK_THURSDAY  = 'Четверг';
ToolbarIntervalPicker.WEEK_FRIDAY    = 'Пятница';
ToolbarIntervalPicker.WEEK_SATURDAY  = 'Суббота';
ToolbarIntervalPicker.WEEK = [
    ToolbarIntervalPicker.WEEK_SUNDAY,
    ToolbarIntervalPicker.WEEK_MONDAY,
    ToolbarIntervalPicker.WEEK_TUESDAY,
    ToolbarIntervalPicker.WEEK_WEDNESDAY,
    ToolbarIntervalPicker.WEEK_THURSDAY,
    ToolbarIntervalPicker.WEEK_FRIDAY,
    ToolbarIntervalPicker.WEEK_SATURDAY
];

ToolbarIntervalPicker.INTERVAL_YEAR  = 'year';
ToolbarIntervalPicker.INTERVAL_MONTH = 'month';
ToolbarIntervalPicker.INTERVAL_WEEK  = 'week';
ToolbarIntervalPicker.INTERVAL_DAY   = 'day';
ToolbarIntervalPicker.INTERVALS = [
    ToolbarIntervalPicker.INTERVAL_YEAR,
    ToolbarIntervalPicker.INTERVAL_MONTH,
    ToolbarIntervalPicker.INTERVAL_WEEK,
    ToolbarIntervalPicker.INTERVAL_DAY
];

ToolbarIntervalPicker.CONTROL_STEP = 'step';
ToolbarIntervalPicker.CONTROL_DROP = 'drop';
ToolbarIntervalPicker.CONTROLS = [
    ToolbarIntervalPicker.CONTROL_DROP,
    ToolbarIntervalPicker.CONTROL_STEP
];

const isInt = (props, propName, componentName) => {
    if (typeof props[propName] !== 'undefined' && !Number.isInteger(props[propName])) {
        return new Error(`Invalid prop ${propName} (${props[propName]}) supplied to ${componentName}. Validation failed.`);
    }
};

const isWeek = (props, propName, componentName) => {
    if (typeof props[propName] !== 'undefined' && (!Number.isInteger(props[propName]) || props[propName] < 0 || props[propName] > 6)) {
        return new Error(`Invalid prop ${propName} (${props[propName]}) supplied to ${componentName}. Validation failed.`);
    }
};

ToolbarIntervalPicker.propTypes = {
    className: PropTypes.string,
    interval:  PropTypes.oneOf(ToolbarIntervalPicker.INTERVALS).isRequired,
    controls:  PropTypes.oneOf(ToolbarIntervalPicker.CONTROLS),
    current:   isInt,
    min:       isInt,
    max:       isInt,
    weekStart: isWeek,
    onChange:  PropTypes.func
};

ToolbarIntervalPicker.defaultProps = {
    controls:  ToolbarIntervalPicker.CONTROL_DROP,
    weekStart: 1
};

export default ToolbarIntervalPicker;