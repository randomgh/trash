import React from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';

import { ui } from 'constants';

import Form, { FormField } from 'components/form';
import Footer from 'components/footer';
import Button from 'components/button';

import { user } from 'actions';

// TODO: Consider move footer links array to children
// TODO: Set form action
// TODO: Set user name to form title

const ProfileView = props => {
    const onFormSubmit = data => {
        props.dispatch(user.profile(
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
        title="Здравствуйте, Виталий!"
        text="Здесь вы&nbsp;можете редактировать личную информацию."
        onSubmit={onFormSubmit}>{{
            fields: [{
                id: 'image',
                type: FormField.TYPE_IMAGE,
                placeholder: 'Добавить фотографию',
                label: 'Изменить фотографию'
            }, {
                id: 'name[first]',
                type: FormField.TYPE_TEXT,
                placeholder: 'Имя'
            }, {
                id: 'name[last]',
                type: FormField.TYPE_TEXT,
                placeholder: 'Фамилия'
            }, {
                id: 'email',
                type: FormField.TYPE_EMAIL,
                placeholder: 'Почта'
            }],
            buttons: [{
                to: '/password',
                style: Button.STYLE_REGULAR,
                color: ui.COLOR_BLUE,
                children: 'Изменить пароль'
            }, {
                to: '/logout',
                style: Button.STYLE_ALTERNATIVE,
                color: ui.COLOR_RED,
                children: 'Выйти'
            }]
      }}</Form>
      <Footer
        links={[
            { to: '/policy', children: 'Политика конфиденциальности' },
            { to: '/terms', children: 'Условия эксплуатации' }
        ]}
      />
    </>;
};

export default withRouter(withCookies(connect((state, props) => {
    return {
        profile: state.user.profile
    };
})(ProfileView)));