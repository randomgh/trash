import React, { useState, useEffect } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { channels, broadcasts, persons } from 'actions';

// TODO: Add SVG to sprite

import ActionSearchSVG from 'svg/action--search.svg';
import ActionCloseSVG from 'svg/action--close.svg';

import './modal-comparison-picker.scss';

const ModalComparisonPicker = props => {
    const className = 'modal-comparison-picker';

    let [searchValue, setSearchValue] = useState('');
    let [selected, setSelected] = useState(props.selected ? props.selected : []);

    useEffect(() => {
        props.getResources();
    }, []);

    useEffect(() => {
        if(props.onChange) props.onChange(selected);
    }, [selected]);

    const onClose = event => {
        event.preventDefault();

        if(props.onClose) props.onClose(selected);
    };

    const onSearchPlaceholder = event => {
        event.preventDefault();

        event.currentTarget.parentElement.getElementsByClassName(`${className}__search__input`)[0].focus();
    };

    const onSearchChange = event => {
        setSearchValue(event.currentTarget.value);
    };

    const onSearchReset = event => {
        event.preventDefault();

        setSearchValue('');

        event.currentTarget.getElementsByClassName(`${className}__search__input`)[0].focus();
    };

    const onSearchSubmit = event => {
        event.preventDefault();
    };

    const onSelect = event => {
        event.preventDefault();

        setSelected([...selected, event.currentTarget.getAttribute('data-id')]);
    };

    const onDeselect = event => {
        event.preventDefault();

        setSelected(selected.filter(id => id !== event.currentTarget.getAttribute('data-id')));
    };

    return <div className={ClassNames(className, {
        [`${className}_resource_${props.resource}`]: props.resource,
        [props.className]: props.className
    })}>
      <div className={`${className}__header`}>
        <div className={`${className}__column ${className}__column_left`}>
          <form className={`${className}__search`} onReset={onSearchReset} onSubmit={onSearchSubmit}>
            <input className={`${className}__search__input`} name="q" type="search" placeholder={props.search} value={searchValue} autoComplete="off" onChange={onSearchChange} onBlur={onSearchChange} />
            <button className={`${className}__search__submit`} type="submit"><ActionSearchSVG /></button>
            <button className={`${className}__search__reset`} type="reset"><ActionCloseSVG /></button>
            <div className={`${className}__search__placeholder`} onClick={onSearchPlaceholder}>
              <span className={`${className}__search__placeholder__text`}>{props.title}</span>
              <a className={`${className}__search__placeholder__icon`} href="#" title={props.search}>
                <ActionSearchSVG />
              </a>
            </div>
          </form>
        </div>
        <div className={`${className}__column ${className}__column_right`}>
          <a className={`${className}__close`} href="#" title="Закрыть" onClick={onClose}>
            <ActionCloseSVG />
          </a>
        </div>
      </div>
      <div className={`${className}__body`}>
        <div className={`${className}__resources ${className}__list ${className}__column ${className}__column_left`}>
          {props.resources.map((resource, i) => {
              const classNames = ClassNames(`${className}__list__item`, {
                  [`${className}__list__item_filtered`]: !searchValue || !!resource.title.match(new RegExp(searchValue, 'gim')),
                  [resource.className]: resource.className
              });

              return selected.includes(resource._id) ? '' : <a key={i} className={classNames} href="#" title={resource.title} data-id={resource._id} onClick={onSelect}>
                <span className={`${className}__list__item__body`}>
                  {resource.img ? <span className={`${className}__list__item__image`} style={{ backgroundImage: `url(${resource.img})` }} /> : ''}
                  <span className={`${className}__list__item__title`}>{resource.title}</span>
                </span>
              </a>;
          })}
        </div>
        <div className={`${className}__selected ${className}__column ${className}__column_right`}>
          <div className={`${className}__selected__header`}>Добавленные</div>
          <div className={`${className}__selected__list ${className}__list`}>
            {props.resources.map((resource, i) => {
                const classNames = ClassNames(`${className}__list__item`, {
                    [resource.className]: resource.className
                });

                return selected.includes(resource._id) ? <a key={i} className={classNames} href="#" title={resource.title} data-id={resource._id} onClick={onDeselect}>
                  <span className={`${className}__list__item__body`}>
                    {resource.img ? <span className={`${className}__list__item__image`} style={{ backgroundImage: `url(${resource.img})` }} /> : ''}
                    <span className={`${className}__list__item__title`}>{resource.title}</span>
                    <span className={`${className}__list__item__action ${className}__list__item__action_type_danger`}>
                      <ActionCloseSVG />
                    </span>
                  </span>
                </a> : '';
              })}
          </div>
        </div>
      </div>
    </div>;
};

ModalComparisonPicker.propTypes = {
    dispatch:     PropTypes.func.isRequired,
    getResources: PropTypes.func.isRequired,
    className:    PropTypes.string,
    resource:     PropTypes.oneOf(['channels', 'broadcasts', 'persons']),
    resources:    PropTypes.array,
    selected:     PropTypes.array,
    title:        PropTypes.string.isRequired,
    search:       PropTypes.string.isRequired,
    onChange:     PropTypes.func,
    onClose:      PropTypes.func
};

ModalComparisonPicker.defaultProps = {

};

export default connect((state, ownProps) => {
    const props = {};

    switch (ownProps.resource) {
        case 'channels':
            props.resources = state[ownProps.resource].data.map(item => {
                return {
                    _id:   item._id,
                    title: item.name,
                    img:   item.image
                };
            });
            props.title = 'Добавить каналы для сравнения';
            props.search = 'Поиск каналов';
            break;
        case 'broadcasts':
            props.resources = state[ownProps.resource].data.map(item => {
                return {
                    _id:   item._id,
                    title: item.name,
                    img:   item.image
                };
            });
            props.title = 'Добавить программы для сравнения';
            props.search = 'Поиск программ';
            break;
        case 'persons':
            props.resources = state[ownProps.resource].data.map(item => {
                return {
                    _id:   item._id,
                    title: item.full_name,
                    img:   item.image
                };
            });
            props.title = 'Добавить персоналии для сравнения';
            props.search = 'Поиск персоналий';
            break;
    }

    return props;
}, (dispatch, ownProps) => {
    let action;

    switch (ownProps.resource) {
        case 'channels':
            action = channels.getAll();
            break;
        case 'broadcasts':
            action = broadcasts.getAll();
            break;
        case 'persons':
            action = persons.getAll();
            break;
    }

    return {
        dispatch,
        getResources: () => dispatch(action)
    };
})(ModalComparisonPicker);