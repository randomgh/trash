import React, { useState } from 'react';

import { ui } from 'constants';

import Form, { FormField, FormConditions } from 'components/form';
import Button from 'components/button';

// TODO: Set form action
// TODO: Must be 2 steps on this view
// TODO: Consider changing Conditions children to array

const PasswordView = props => {
    let [password, setPassword] = useState(undefined);

    const onPasswordChange = value => {
        console.log('onPasswordChange', value);

        setPassword(value);
    };

    const onFormReady = event => {
        console.log('onFormReady', event);
    };

    const onFormInvalid = event => {
        console.log('onFormInvalid', event);
    };

    const onFormSubmit = values => {
        console.log('onFormSubmit', values);
    };

    return <>
      <Form
        title="Введите новый пароль, который вы&nbsp;сможете запомнить."
        onReady={onFormReady}
        onInvalid={onFormInvalid}
        onSubmit={onFormSubmit}>{{
            fields: [{
                id: 'password',
                type: FormField.TYPE_PASSWORD,
                placeholder: 'Новый пароль',
                pattern: '^(?=.*[a-zа-я])(?=.*[A-ZА-Я])(?=.*[0-9])(?=.{6,}).*$',
                required: true,
                tooltip: {
                    type: ui.STATUS_DANGER,
                    children: <>Пароль должен содержать <b>6&nbsp;символов, заглавную букву и&nbsp;одну цифру.</b></>
                },
                description: <FormConditions htmlFor="password" title="Пароль должен содержать:" value={password}>{{
                    '[A-ZА-Я]': 'одну заглавную букву',
                    '[0-9]': 'одну цифру',
                    '.{6,}': 'больше пяти символов'
                }}</FormConditions>,
                onChange: onPasswordChange
            }],
            buttons: [{
                type: ui.BUTTON_TYPE_SUBMIT,
                style: Button.STYLE_REGULAR,
                color: ui.COLOR_BLUE,
                children: 'Сохранить пароль'
            }]
      }}</Form>
    </>;
};

export default PasswordView;