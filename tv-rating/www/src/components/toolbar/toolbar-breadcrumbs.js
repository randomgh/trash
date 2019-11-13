import React, { Fragment } from 'react';
import ClassNames from 'classnames';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import { ToolbarSeparator, ToolbarButton } from './';

import './toolbar-breadcrumbs.scss';

const ToolbarBreadcrumbs = props => {
    const className = 'toolbar-breadcrumbs';

    return props.children && props.children.length ? <div className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.children.map((item, i) => {
          let {className: itemClassName, size: itemSize, activeClassName: itemActiveClassName, ...itemProps} = item;

          switch (true) {
              case !itemSize && i === 0 && (!!props.rootSize || !!props.crumbsSize):
                  itemSize = props.rootSize ? props.rootSize : props.crumbsSize;
                  break;
              case !itemSize && i === props.children.length - 1 && (!!props.currentSize || !!props.crumbsSize):
                  itemSize = props.currentSize ? props.currentSize : props.crumbsSize;
                  break;
              case !itemSize && !!props.crumbsSize:
                  itemSize = props.crumbsSize;
                  break;
          }

          if(itemActiveClassName) itemActiveClassName = `${itemActiveClassName} ${className}__button_active`;

          return <Fragment key={i}>
            {i > 0 ? <ToolbarSeparator className={`${className}__separator`} /> : ''}
            <ToolbarButton className={ClassNames(`${className}__button`, {
                [itemClassName]: itemClassName
            })} size={itemSize} activeClassName={itemActiveClassName} {...itemProps} />
          </Fragment>;
      })}
    </div> : '';
};

ToolbarBreadcrumbs.propTypes = {
    className:   PropTypes.string,
    rootSize:    PropTypes.oneOf(ui.SIZES),
    crumbsSize:  PropTypes.oneOf(ui.SIZES),
    currentSize: PropTypes.oneOf(ui.SIZES),
    children:    PropTypes.arrayOf(PropTypes.shape(ToolbarButton.propTypes))
};

export default ToolbarBreadcrumbs;