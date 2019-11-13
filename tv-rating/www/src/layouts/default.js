import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';

import { ui } from 'constants';

import Toolbar, { ToolbarSpace, ToolbarButton, ToolbarSearch } from 'components/toolbar';
import Modal from 'components/modal';

import { modals } from 'actions';

// TODO: Add SVG to sprite

import IconLogoSVG from 'svg/icon--logo.svg';
import IconTopSVG from 'svg/icon--top.svg';
import IconUserSVG from 'svg/icon--user.svg';

import './default.scss';

const Default = props => {
    const onClose = event => {
        event.preventDefault();

        props.dispatch(modals.clear());
    };

    return <>
      <header className="header">
        <Toolbar className="header__toolbar" size={ui.SIZE_NORMAL}>
          <ToolbarButton
            className="header__toolbar__item header__toolbar__logo"
            to="/"
            exact
            activeClassName="header__toolbar__item_active"
            size={ui.SIZE_MEDIUM}
            svg={IconLogoSVG}
          />
          <ToolbarSearch className="header__item header__search" resources={['channels', 'broadcasts', 'persons']} />
          <ToolbarSpace className="header__toolbar__space" />
          <ToolbarButton
            className="header__toolbar__item header__toolbar__top"
            to="/top"
            exact
            activeClassName="header__toolbar__item_active"
            size={ui.SIZE_MEDIUM}
            svg={IconTopSVG}
            title="Топ 10"
          />
          <ToolbarButton
            className="header__toolbar__item header__toolbar__profile"
            to="/profile"
            exact
            activeClassName="header__toolbar__item_active"
            size={ui.SIZE_MEDIUM}
            circleImage
            svg={IconUserSVG}
          />
        </Toolbar>
      </header>
      <main className="main">
        {props.children ? props.children : ''}
      </main>
      {props.modals && props.modals.length ? <div className="modals">
        <a className="modals__background" href="#" title="Закрыть" onClick={onClose} />
        {props.modals.map((item, i) => {
            const {children: itemChildren, ...itemProps} = item;

            return <Modal key={i} {...itemProps}>
              {itemChildren ? itemChildren : ''}
            </Modal>
        })}
      </div> : ''}
    </>;
};

Default.propTypes = {
    children: PropTypes.node,
    modals:   PropTypes.arrayOf(PropTypes.shape(Modal.propTypes))
};

export default withRouter(connect((state, props) => {
    return {
        modals: state.modals
    };
})(Default));