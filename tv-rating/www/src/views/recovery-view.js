import React, { useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';
import { withCookies } from 'react-cookie';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import Form, { FormField } from 'components/form';

import { user } from 'actions';

// TODO: Consider move footer links array to children
// TODO: Consider using nodes array for footer links
// TODO: Set form action
// TODO: Consider changing Conditions children to array

const RecoveryView = props => {
    useEffect(() => {
        switch (props.status) {
            case Form.STATUS_NONE:
                break;
            case Form.STATUS_PENDING:
                break;
            case Form.STATUS_COMPLETED:
                setTimeout(() => {
                    props.history.push(`/recovery/completed`);
                }, 2000);
                break;
            case Form.STATUS_ERROR:
                break;
        }
    }, [props.status]);

    const onFormSubmit = data => {
        props.dispatch(user.recovery(
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
        title="Введите вашу почту и мы пришлем ссылку на восстановление пароля."
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
          }],
          buttons: [{
              type: ui.BUTTON_TYPE_SUBMIT,
              style: ui.STYLE_REGULAR,
              color: ui.COLOR_BLUE,
              children: 'Получить ссылку'
          }, {
              type: ui.BUTTON_TYPE_SUBMIT,
              style: ui.STYLE_ALTERNATIVE,
              color: ui.COLOR_WHITE,
              children: 'Я вспомнил пароль'
          }]
      }}</Form>
    </>;
};

RecoveryView.propTypes = {
    history:         PropTypes.object.isRequired,
    dispatch:        PropTypes.func.isRequired,
    emailTooltip:    PropTypes.shape(FormField.TOOLTIP),
    recovery:        PropTypes.shape({
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
    const recovery = state.user.recovery,
        props = {
            recovery
        };

    if (recovery.meta) {
        switch (recovery.meta.status) {
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
                for (let error of recovery.errors) {
                    switch (error.code) {
                        case 'not_found':
                            props.emailTooltip = {
                                type: ui.STATUS_DANGER,
                                children: <>Пользователя не существует</>
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
})(RecoveryView)));