import React from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';
import { Link, NavLink } from 'react-router-dom';

// TODO: Add SVG to sprite

import IconRatingSVG from 'svg/icon--rating.svg';
import ArrowESVG from 'svg/arrow--e.svg';

import './table.scss';

const Table = props => {
    const className = 'table',
          field = props.sorting === Table.SORTING_ALPHABET ? 'title' : 'rating';

    let lastId;

    return props.children ? <div className={ClassNames(className, {
        [`${className}_sorting_${props.sorting}`]: props.sorting,
        [props.className]: props.className
    })}>
      <div className={`${className}__header`}>
        <div className={`${className}__header__title`}>
          <span>{props.title}</span>
          {props.more ? <Link className={`${className}__header__title__more`} to={props.more} title={props.title} >
            <ArrowESVG />
          </Link> : ''}
        </div>

        <div className={`${className}__header__rating`}>
          <IconRatingSVG />
        </div>
      </div>
      <div className={`${className}__body`}>
        {props.children.sort((a, b) => {
            if (a[field] > b[field]) {
                return 1;
            } else if (a[field] < b[field]) {
                return -1;
            }

            return 0;
        }).map((item, i) => {
            const first = item.title.charAt(0),
                  id = isNaN(parseInt(first)) ? first.toUpperCase() : '#',
                  classNames = ClassNames(`${className}__row`, {
                      [`${className}__row_disabled`]: item.disabled,
                      [`${className}__row_first`]: props.sorting === Table.SORTING_ALPHABET && lastId !== id,
                      [item.className]: item.className
                  }),
                  children = <>
                    <div className={`${className}__row__id`}><span>{props.sorting === Table.SORTING_ALPHABET ? id : i + 1}</span></div>
                    {item.img ? <div className={`${className}__row__image`}><span style={{ backgroundImage: `url(${item.img})` }} /></div> : ''}
                    <div className={`${className}__row__title`}><span>{item.title}</span></div>
                    <div className={`${className}__row__rating`}><span>{item.rating}</span></div>
                  </>;

            lastId = id;

            switch (true) {
                case !!item.to && !!item.activeClassName:
                    return <NavLink
                      key={i}
                      className={classNames}
                      exact={item.exact}
                      to={item.to}
                      activeClassName={item.activeClassName}
                      title={item.title}
                      onClick={item.onClick}>
                      {children}
                    </NavLink>;
                case !!item.to:
                    return <Link
                      key={i}
                      className={classNames}
                      exact={item.exact}
                      to={item.to}
                      title={item.title}
                      onClick={item.onClick}>
                      {children}
                    </Link>;
                case !!item.href:
                    return <a
                      key={i}
                      className={classNames}
                      href={item.href}
                      title={item.title}
                      onClick={item.onClick}>
                      {children}
                    </a>;
                case !!item.htmlFor:
                    return <label
                      key={i}
                      className={classNames}
                      htmlFor={item.htmlFor}
                      onClick={item.onClick}>
                      {children}
                    </label>;
                default:
                    return <a
                      key={i}
                      className={classNames}
                      href="#"
                      title={item.title}
                      onClick={item.onClick}>
                      {children}
                    </a>;
            }
        })}
      </div>
    </div> : '';
};

Table.SORTING_POPULAR  = 'popular';
Table.SORTING_ALPHABET = 'alphabet';
Table.SORTINGS = [Table.SORTING_POPULAR, Table.SORTING_ALPHABET];

Table.propTypes = {
    className: PropTypes.string,
    title:     PropTypes.string.isRequired,
    more:      PropTypes.string.isRequired,
    sorting:   PropTypes.oneOf(Table.SORTINGS),
    children:  PropTypes.arrayOf(PropTypes.shape({
        className:       PropTypes.string,
        id:              PropTypes.string,
        to:              PropTypes.string,
        exact:           PropTypes.bool,
        activeClassName: PropTypes.string,
        href:            PropTypes.string,
        htmlFor:         PropTypes.string,
        onClick:         PropTypes.func,
        disabled:        PropTypes.bool,
        title:           PropTypes.string.isRequired,
        img:             PropTypes.string,
        rating:          PropTypes.number.isRequired
    }))
};

Table.defaultProps = {
    sorting: Table.SORTING_POPULAR
};

export default Table;
