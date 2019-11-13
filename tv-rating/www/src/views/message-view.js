import React, { useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

import Message from 'components/message';

import { user } from 'actions';

const MessageView = props => {
    useEffect(() => {
        return () => {
            let action;

            switch (props.parent) {
                case 'registration':
                    action = user.register();
                    break;
                case 'profile':
                    action = user.profile();
                    break;
                case 'invitation':
                    action = user.invite();
                    break;
                case 'authentication':
                    action = user.authenticate();
                    break;
                case 'debunking':
                    action = user.debunk();
                    break;
                case 'recovery':
                    action = user.recovery();
                    break;
                case 'password':
                    action = user.password();
                    break;
            }

            if (action) props.dispatch(action);
        };
    }, []);

    return <>
      <Message status={props.status} title={props.title}>
        {props.children}
      </Message>
    </>;
};

MessageView.propTypes = {
    location: PropTypes.shape({
        pathname: PropTypes.string.isRequired
    }).isRequired,
    dispatch: PropTypes.func.isRequired,
    parent:   PropTypes.string.isRequired,
    store:    PropTypes.shape({
        errors: PropTypes.arrayOf(PropTypes.shape({
            code:    PropTypes.string,
            message: PropTypes.string,
            data:    PropTypes.any
        })),
        data:   PropTypes.any,
        meta:   PropTypes.shape({
            status: PropTypes.number
        })
    }),
    status:   PropTypes.oneOf(ui.STATUSES),
    title:    PropTypes.string,
    children: PropTypes.node
};

export default withRouter(withCookies(connect((state, ownProps) => {
    const path = ownProps.location.pathname.split('/'),
          parent = path[path.length - 2],
          store = state.user[parent],
          props = {
              parent,
              store
          };

    const CONSTS = {
        title: {
            registration: {
                [ui.STATUS_WARNING]: 'Регистрация завершена',
                [ui.STATUS_SUCCESS]: 'Регистрация завершена',
            },
            profile: {
                [ui.STATUS_WARNING]: '',
                [ui.STATUS_SUCCESS]: '',
            },
            invitation: {
                [ui.STATUS_WARNING]: 'Приглашение выслано',
                [ui.STATUS_SUCCESS]: 'Приглашение выслано',
            },
            authentication: {
                [ui.STATUS_WARNING]: '',
                [ui.STATUS_SUCCESS]: '',
            },
            debunking: {
                [ui.STATUS_WARNING]: '',
                [ui.STATUS_SUCCESS]: '',
            },
            recovery: {
                [ui.STATUS_WARNING]: 'Пароль восстановлен',
                [ui.STATUS_SUCCESS]: 'Пароль восстановлен',
            },
            password: {
                [ui.STATUS_WARNING]: '',
                [ui.STATUS_SUCCESS]: '',
            }
        },
        children: {
            registration: {
                [ui.STATUS_WARNING]: <>Пароль в письме на почте (<a href={`mailto:${store.data.email}`} title={`${store.data.email}`}>{store.data.email}</a>).</>,
                [ui.STATUS_SUCCESS]: <>Теперь вы можете войти, используя указанные данные.</>,
            },
            profile: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <></>,
            },
            invitation: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <>Пароль в письме на почте (<a href={`mailto:${store.data.email}`} title={`${store.data.email}`}>{store.data.email}</a>).</>,
            },
            authentication: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <></>,
            },
            debunking: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <></>,
            },
            recovery: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <>Новый пароль в письме на почте (<a href={`mailto:${store.data.email}`} title={`${store.data.email}`}>{store.data.email}</a>).</>,
            },
            password: {
                [ui.STATUS_WARNING]: <></>,
                [ui.STATUS_SUCCESS]: <></>,
            }
        }
    };

    switch (store.meta.status) {
        case 102:
            break;
        case 200:
        case 201:
            props.status = ui.STATUS_SUCCESS;
            break;
        case 207:
            for (let error of state.user.registration.errors) {
                switch (error.code) {
                    case 'email':
                        props.status = ui.STATUS_WARNING;
                        break;
                }
            }
            break;
        case 400:
        case 500:
            break;
    }

    if (props.status) {
        props.title = CONSTS.title[parent][props.status];
        props.children = CONSTS.children[parent][props.status];
    }

    return props;
})(MessageView)));