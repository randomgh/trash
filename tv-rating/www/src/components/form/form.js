import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import { ui } from 'constants';

import FormField from './form-field';
import Button from 'components/button';

// TODO: Add SVG to sprite

import StatusPendingSVG from 'svg/status--pending.svg';
import StatusSuccessSVG from 'svg/status--success.svg';

import './form.scss';

const Form = props => {
    const className = 'form',
          fields = props.children.fields;

    let [values, setValues] = useState(fields.reduce((obj, field) => {
        obj[field.id] = field.value;
        return obj;
    }, {}));
    let [validity, setValidity] = useState(fields.reduce((obj, field) => {
        obj[field.id] = !field.required;
        return obj;
    }, {}));
    let [status, setStatus] = useState(props.status ? props.status : Form.STATUS_NONE);

    useEffect(() => {
        if (Object.keys(validity).every(field => validity[field])) setStatus(Form.STATUS_READY);
    }, [validity]);

    useEffect(() => {
        setStatus(props.status);
    }, [props.status]);

    useEffect(() => {
        switch (status) {
            case Form.STATUS_NONE:
                break;
            case Form.STATUS_READY:
                if(props.onReady) props.onReady(values);
                break;
            case Form.STATUS_PENDING:
                break;
            case Form.STATUS_COMPLETED:
                break;
            case Form.STATUS_ERROR:
                break;
        }
    }, [status]);

    const onFieldValue = data => {
        const field = props.children.fields.find(field => field.id === data.id);

        setValues({...values, [field.id]: data.value});

        if(field.onValue) field.onValue(data);
    };

    const onFieldValidity = data => {
        const field = props.children.fields.find(field => field.id === data.id);

        setValidity({...validity, [field.id]: data.validity});

        if(field.onValidity) field.onValidity(data);
    };

    const onFormInvalid = event => {
        event.preventDefault();

        if(props.onInvalid) props.onInvalid(values);
    };

    const onFormSubmit = event => {
        event.preventDefault();

        if(props.onSubmit) props.onSubmit(values);
    };

    return <form
      className={ClassNames(className, {
          [`${className}_disabled`]: props.disabled,
          [`${className}_status_${status}`]: status,
          [props.className]: props.className
      })}
      action={props.action}
      method={props.method}
      onInvalid={onFormInvalid}
      onSubmit={onFormSubmit}>
      {props.title ? <h4 className={`${className}__title`}>{props.title}</h4> : ''}
      {props.text ? <p className={`${className}__text`}>{props.text}</p> : ''}
      <div className={`${className}__body`}>
        {props.children.fields && props.children.fields.length ? <section className={`${className}__section ${className}__section_fields`}>
          {props.children.fields.map((item, i) => {
              const {description: itemDescription, ...itemProps} = item;

              itemProps.onValue = onFieldValue;
              itemProps.onValidity = onFieldValidity;

              return <FormField key={i} {...itemProps}>
                {itemDescription ? itemDescription : ''}
              </FormField>;
          })}
        </section> : ''}
        {props.children.links && props.children.links.length ? <section className={`${className}__section ${className}__section_links`}>
          {props.children.links.map((item, i) => {
              const {children: itemChildren, ...itemProps} = item;

              return <Link key={i} {...itemProps}>
                {itemChildren ? itemChildren : ''}
              </Link>;
          })}
        </section> : ''}
        {props.children.buttons && props.children.buttons.length ? <section className={`${className}__section ${className}__section_buttons`}>
          {props.children.buttons.map((item, i) => {
              let {children: itemChildren, ...itemProps} = item;

              if(item.type === ui.BUTTON_TYPE_SUBMIT){
                  switch (status) {
                      case Form.STATUS_PENDING:
                          itemChildren = <StatusPendingSVG />;
                          break;
                      case Form.STATUS_COMPLETED:
                          itemChildren = <StatusSuccessSVG />;
                          break;
                  }

                  itemProps.active = [Form.STATUS_PENDING, Form.STATUS_COMPLETED].includes(status);
                  itemProps.disabled = props.disabled;
              }

              return <Button key={i} {...itemProps}>
                {itemChildren ? itemChildren : ''}
              </Button>;
          })}
        </section> : ''}
      </div>
    </form>;
};

Form.METHOD_GET  = 'get';
Form.METHOD_POST = 'post';
Form.METHODS = [Form.METHOD_GET, Form.METHOD_POST];

Form.STATUS_NONE      = '';
Form.STATUS_READY     = 'ready';
Form.STATUS_PENDING   = 'pending';
Form.STATUS_COMPLETED = 'completed';
Form.STATUS_ERROR     = 'error';
Form.STATUSES = [Form.STATUS_NONE, Form.STATUS_READY, Form.STATUS_PENDING, Form.STATUS_COMPLETED, Form.STATUS_ERROR];

Form.propTypes = {
    className: PropTypes.string,
    action:    PropTypes.string,
    method:    PropTypes.oneOf(Form.METHODS),
    title:     PropTypes.string,
    text:      PropTypes.string,
    children:  PropTypes.shape({
        fields:  PropTypes.arrayOf(PropTypes.shape(FormField.propTypes)),
        links:   PropTypes.arrayOf(PropTypes.shape({
            className: PropTypes.string,
            to:        PropTypes.string.isRequired,
            children:  PropTypes.node
        })),
        buttons: PropTypes.arrayOf(PropTypes.shape(Button.propTypes))
    }),
    onReady:   PropTypes.func,
    onInvalid: PropTypes.func,
    onSubmit:  PropTypes.func,
    disabled:  PropTypes.bool,
    status:    PropTypes.oneOf(Form.STATUSES)
};

export default Form;