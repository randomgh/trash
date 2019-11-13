import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import './form-conditions.scss';

// TODO: Consider changing props.children to array

const FormConditions = props => {
    const className = 'form-conditions',
          patterns = Object.keys(props.children);

    let [conditions, setConditions] = useState(patterns.reduce((obj, pattern) => {
        obj[pattern] = undefined;
        return obj;
    }, {}));

    useEffect(() => {
        if (typeof props.value !== 'undefined') {
            const result = {};

            for (let pattern in conditions) {
                result[pattern] = new RegExp(pattern).test(props.value);
            }

            setConditions(result);
        } else {
            setConditions(patterns.reduce((obj, pattern) => {
                obj[pattern] = undefined;
                return obj;
            }, {}));
        }
    }, [props.value]);

    return <div className={ClassNames(className, {
        [`${className}_${props.htmlFor}`]: props.htmlFor,
        [props.className]: props.className
    })}>
      {props.title ? <p className={`${className}__title`}>{props.title}</p> : ''}
      {patterns && patterns.length ? <ul className={`${className}__list`}>
        {patterns.map((item, i) => {
            return <li key={i} className={ClassNames(`${className}__item`, {
                [`${className}__item_valid`]: typeof conditions[item] !== 'undefined' && conditions[item],
                [`${className}__item_invalid`]: typeof conditions[item] !== 'undefined' && !conditions[item]
            })}>{props.children[item]}</li>;
        })}
      </ul> : ''}
    </div>;
};

FormConditions.propTypes = {
    className: PropTypes.string,
    htmlFor:   PropTypes.string,
    title:     PropTypes.string,
    children:  PropTypes.object.isRequired,
    value:     PropTypes.string
};

export default FormConditions;