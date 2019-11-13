import React from 'react';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';

import { ui } from 'constants';

import './toolbar-suggestions.scss';

// TODO: Replace div suggestions__option with Link

const ToolbarSuggestions = props => {
    const className = 'toolbar-suggestions';

    return <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.options && props.options.length ? props.options.map((item, i) => {
          return <Link key={i} to={item.to} className={`${className}__option`}>
            {item.img ? <span className={`${className}__option__image`} style={{ backgroundImage: `url(${item.img})` }} /> : ''}
            <span className={`${className}__option__text`}>{item.text}</span>
          </Link>;
      }) : <div className={`${className}__empty`}>По запросу ничего не найдено.</div>}
    </div>;
};

ToolbarSuggestions.propTypes = {
    className: PropTypes.string,
    options:   PropTypes.arrayOf(PropTypes.shape({
        to:   PropTypes.string.isRequired,
        img:  PropTypes.string,
        text: PropTypes.string.isRequired
    }))
};

export default ToolbarSuggestions;