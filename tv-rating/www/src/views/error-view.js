import React from 'react';
import PropTypes from 'prop-types';
import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';

import Error from 'components/error';
import Button from 'components/button';

// TODO: Consider move buttons array to children

const ErrorView = props => <>
  <Error
    number={props.number}
    title={props.title}
    buttons={props.back && props.history && props.history.length ?
        [...props.buttons, { onClick: props.history.goBack, children: props.back, color: 'white' }] :
        props.buttons}>
    {props.children}
  </Error>
</>;

ErrorView.propTypes = {
    history: PropTypes.object,
    number: PropTypes.number,
    title: PropTypes.string,
    children: PropTypes.node,
    buttons: PropTypes.arrayOf(PropTypes.shape(Button.propTypes)),
    back: PropTypes.string
};

ErrorView.defaultProps = {
    buttons: [
        { to: '/', children: 'Перейти на главную' }
    ],
    back: 'Вернуться обратно'
};

// TODO: Remove redux connect

export default withRouter(connect((state, props) => {
    return {};
})(ErrorView));