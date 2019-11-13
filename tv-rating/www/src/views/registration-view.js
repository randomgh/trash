import React, { useState, useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';
import { withCookies } from 'react-cookie';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import Footer from 'components/footer';
import Form, { FormField, FormConditions } from 'components/form';

import { user } from 'actions';

// TODO: Consider move footer links array to children
// TODO: Consider using nodes array for footer links
// TODO: Set form action
// TODO: Consider changing Conditions children to array

const RegistrationView = props => {
    let [password, setPassword] = useState(undefined);

    useEffect(() => {
        switch (props.status) {
            case Form.STATUS_NONE:
                break;
            case Form.STATUS_PENDING:
                break;
            case Form.STATUS_COMPLETED:
                setTimeout(() => {
                    props.history.push(`/registration/completed`);
                }, 2000);
                break;
            case Form.STATUS_ERROR:
                break;
        }
    }, [props.status]);

    const onPasswordValue = data => {
        setPassword(data.value ? data.value : undefined);
    };

    const onFormSubmit = data => {
        props.dispatch(user.register(
            Object.keys(data)
            .filter(field => typeof data[field] !== 'undefined')
            .reduce((obj, field) => {
                obj[field] = data[field];
                return obj;
            }, {})
        ));
    };

    return <>
      <Form
        title="Регистрация"
        onSubmit={onFormSubmit}
        status={props.status}>{{
            fields: [{
                id: 'email',
                type: FormField.TYPE_EMAIL,
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
                type: FormField.TYPE_PASSWORD,
                placeholder: 'Пароль',
                pattern: '^(?=.*[a-zа-я])(?=.*[A-ZА-Я])(?=.*[0-9])(?=.{6,}).*$',
                required: true,
                tooltip: props.passwordTooltip,
                tooltips: {
                    empty: {
                        type: ui.STATUS_DANGER,
                        children: <>Поле обязательно для заполнения.</>
                    },
                    invalid: {
                        type: ui.STATUS_DANGER,
                        children: <>Пароль должен содержать <b>6&nbsp;символов, заглавную букву и&nbsp;одну цифру.</b></>
                    }
                },
                description: <FormConditions htmlFor="password" title="Пароль должен содержать:" value={password}>{{
                    '[A-ZА-Я]': 'одну заглавную букву',
                    '[0-9]': 'одну цифру',
                    '.{6,}': 'больше пяти символов'
                }}</FormConditions>,
                onValue: onPasswordValue
            }],
            buttons: [{
                type: ui.BUTTON_TYPE_SUBMIT,
                style: ui.STYLE_REGULAR,
                color: ui.COLOR_BLUE,
                children: 'Зарегистрироваться'
            }]
      }}</Form>
      <Footer
        text="Нажимая &quot;Зарегистрироваться&quot; вы&nbsp;автоматически соглашаетесь с&nbsp;нашими Полтикой&nbsp;конфиденциальности и&nbsp;Условиями&nbsp;эксплуатации."
        links={[
            { to: '/policy', children: 'Политика конфиденциальности' },
            { to: '/terms', children: 'Условия эксплуатации' }
        ]}
      />
    </>;
};

RegistrationView.propTypes = {
    history:         PropTypes.object.isRequired,
    dispatch:        PropTypes.func.isRequired,
    emailTooltip:    PropTypes.shape(FormField.TOOLTIP),
    passwordTooltip: PropTypes.shape(FormField.TOOLTIP),
    registration:    PropTypes.shape({
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
    status:          PropTypes.oneOf(Form.STATUSES)
};

export default withRouter(withCookies(connect((state, ownProps) => {
    const props = {
        registration: state.user.registration
    };

    if (state.user.registration.meta) {
        switch (state.user.registration.meta.status) {
            case 102:
                props.status = Form.STATUS_PENDING;
                break;
            case 200:
            case 201:
            case 207:
                props.status = Form.STATUS_COMPLETED;
                break;
            case 400:
            case 500:
                for (let error of state.user.registration.errors) {
                    switch (error.code) {
                        case 'item_conflict':
                            props.emailTooltip = {
                                type: ui.STATUS_DANGER,
                                children: <>Пользователь уже существует</>
                            };
                            break;
                        case 'parameter_invalid':
                            switch (error.data) {
                                case 'email':
                                    props.emailTooltip = {
                                        type: ui.STATUS_DANGER,
                                        children: <>Поле заполнено некорректно</>
                                    };
                                    break;
                                case 'password':
                                    props.passwordTooltip = {
                                        type: ui.STATUS_DANGER,
                                        children: <>Поле заполнено некорректно</>
                                    };
                                    break;
                            }
                            break;
                    }
                }

                props.status = Form.STATUS_ERROR;
                break;
        }
    } else {
        props.status = Form.STATUS_NONE;
    }

    return props;
})(RegistrationView)));