import React, { useState, useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import ToolbarSuggestions from './toolbar-suggestions';

import { search } from 'actions';

// TODO: Add SVG to sprite
// TODO: Bug - click reset while value === '' => no focus
// TODO: Combine with HeaderSearch

import ActionSearchSVG from 'svg/action--search.svg';
import ActionCloseSVG from 'svg/action--close.svg';

import './toolbar-search.scss';

const ToolbarSearch = props => {
    const className = 'toolbar-search';

    const getSuggestions = options => {
        const result = [];

        for (let i in options) {
            switch (i) {
                case 'types':
                    result.push(...options[i].map(item => {
                        return {
                            text: item.name
                        };
                    }));
                    break;
                case 'genres':
                    result.push(...options[i].map(item => {
                        return {
                            img: item.image,
                            text: item.name
                        };
                    }));
                    break;
                case 'roles':
                    result.push(...options[i].map(item => {
                        return {
                            text: item.name
                        };
                    }));
                    break;
                case 'channels':
                    result.push(...options[i].map(item => {
                        return {
                            to: `/channels/${item._id}`,
                            img: item.image,
                            text: item.name
                        };
                    }));
                    break;
                case 'broadcasts':
                    result.push(...options[i].map(item => {
                        return {
                            to: `/broadcasts/${item._id}`,
                            img: item.image,
                            text: item.name
                        };
                    }));
                    break;
                case 'persons':
                    result.push(...options[i].map(item => {
                        return {
                            to: `/persons/${item._id}`,
                            img: item.image,
                            text: item.full_name
                        };
                    }));
                    break;
            }
        }

        return result;
    };

    let [value, setValue] = useState('');
    let [suggestions, setSuggestions] = useState(props.suggestions ? getSuggestions(props.suggestions) : []);

    useEffect(() => {
        if (props.suggestions) {
            setSuggestions(getSuggestions(props.suggestions));
        } else {
            setSuggestions([]);
        }
    }, [props.suggestions]);

    useEffect(() => {
        if (value) {
            const query = { q: value, page: { limit: props.limit, offset: props.offset } };

            if (props.resources) query.resources = props.resources;

            props.dispatch(search.search(query));
        } else {
            setSuggestions([]);
        }
    }, [value]);

    const onChange = event => {
        setValue(event.currentTarget.value);
    };

    const onReset = event => {
        event.preventDefault();

        setValue('');

        event.currentTarget.getElementsByClassName(`${className}__input`)[0].focus();
    };

    const onSubmit = event => {
        event.preventDefault();
    };

    return <form className={ClassNames(className,{
        [`${className}_size_${props.size}`]: props.size,
        [props.className]: props.className
    })} onReset={onReset} onSubmit={onSubmit}>
      <input className={`${className}__input`} name="q" type="search" placeholder="Поиск" value={value} autoComplete="off" onChange={onChange} onBlur={onChange} />
      <button className={`${className}__submit`} type="submit"><ActionSearchSVG /></button>
      <button className={`${className}__reset`} type="reset"><ActionCloseSVG /></button>
      <ToolbarSuggestions className={`${className}__suggestions`} options={suggestions} />
      <div className={`${className}__background`} />
    </form>;
};

// TODO: Adjust PropTypes

ToolbarSearch.RESOURCE_CHANNELS   = 'channels';
ToolbarSearch.RESOURCE_BROADCASTS = 'broadcasts';
ToolbarSearch.RESOURCE_PERSONS    = 'persons';
ToolbarSearch.RESOURCES = [
    ToolbarSearch.RESOURCE_CHANNELS, ToolbarSearch.RESOURCE_BROADCASTS, ToolbarSearch.RESOURCE_PERSONS
];

ToolbarSearch.propTypes = {
    dispatch:    PropTypes.func,
    className:   PropTypes.string,
    size:        PropTypes.oneOf(ui.SIZES),
    resources:   PropTypes.arrayOf(PropTypes.oneOf(ToolbarSearch.RESOURCES)),
    suggestions: PropTypes.object,
    limit:       PropTypes.number.isRequired,
    offset:      PropTypes.number.isRequired
};

// TODO: Move default props to css

ToolbarSearch.defaultProps = {
    size:   ui.SIZE_MEDIUM,
    limit:  10,
    offset: 0
};

export default withRouter(withCookies(connect((state, ownProps) => {
    const search = state.search,
          props = {
              search
          };

    if (search.data) props.suggestions = search.data;

    return props;
})(ToolbarSearch)));