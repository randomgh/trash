import React, {useEffect, useState} from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';

import { ui } from 'constants';

import Form from 'components/form';
import Footer from 'components/footer';

import { user as UserActions } from 'actions';

// TODO: Consider move footer links array to children
// TODO: Consider using nodes array for footer links
// TODO: Set form action

const LoginView = props => {
    let [message, setMessage] = useState(false);

    useEffect(() => {
        if (props.authentication === 'completed') setTimeout(() => { setMessage(true); }, 2000);
    }, [props.authentication]);

    const onFormReady = event => {
        console.log('onFormReady', event);
    };

    const onFormInvalid = event => {
        console.log('onFormInvalid', event);
    };

    const onFormSubmit = data => {
        console.log('onFormSubmit', data);

        props.dispatch(UserActions.authenticate(Object.keys(data)
            .filter(field => typeof data[field] !== 'undefined')
            .reduce((obj, field) => {
                obj[field] = data[field];
                return obj;
            },
        {})));
    };

    return <>
      <Form
        title="Добро пожаловать!"
        text="Здесь вы&nbsp;можете найти самую надежную статистику по&nbsp;каналам."
        onReady={onFormReady}
        onInvalid={onFormInvalid}
        onSubmit={onFormSubmit}>{{
            fields: [{
                id: 'email',
                type: 'email',
                placeholder: 'Почта',
                pattern: '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$',
                required: true,
                tooltip: props.emailTooltip,
                tooltips: {
                    empty: {
                        type: ui.STATUS_DANGER,
                        children: <>Поле обязательно для заполнения.</>
                    },
                    invalid: {
                        type: ui.STATUS_DANGER,
                        children: <>Проверьте, что вы&nbsp;ввели правильную почту (например, <b>name@email.com</b>).</>
                    }
                }
            }, {
                id: 'password',
                type: 'password',
                placeholder: 'Пароль',
                pattern: '^(?=.*[a-zа-я])(?=.*[A-ZА-Я])(?=.*[0-9])(?=.{6,}).*$',
                required: true,
                tooltips: {
                    empty: {
                        type: ui.STATUS_DANGER,
                        children: <>Поле обязательно для заполнения.</>
                    },
                    invalid: {
                        type: ui.STATUS_DANGER,
                        children: <>Пароль должен содержать <b>6&nbsp;символов, заглавную букву и&nbsp;одну цифру.</b></>
                    }
                }
            }],
            links: [{
                className: 'link',
                to: '/recovery',
                children: 'Восстановить пароль'
            }],
            buttons: [{
                type: 'submit',
                style: 'regular',
                color: 'blue',
                children: 'Войти'
            }]
      }}</Form>
      <Footer
        text="Нажимая &quot;Войти&quot; вы&nbsp;автоматически соглашаетесь с&nbsp;нашими Полтикой&nbsp;конфиденциальности и&nbsp;Условиями&nbsp;эксплуатации."
        links={[
            { to: '/policy', children: 'Политика конфиденциальности' },
            { to: '/terms', children: 'Условия эксплуатации' }
        ]}
      />
    </>;
};

export default withRouter(withCookies(connect((state, props) => {
    const data = {
        authentication: state.authentication.status
    };

    if (state.authentication.status === 'error') {
        switch (state.authentication.payload.code) {
            case 0:
                data.emailTooltip = {
                    type: ui.STATUS_DANGER,
                    children: <>Неправильные данные</>
                };
                break;
            default:
                data.emailTooltip = {
                    type: ui.STATUS_DANGER,
                    children: <></>
                };
        }
    }

    return data;
})(LoginView)));