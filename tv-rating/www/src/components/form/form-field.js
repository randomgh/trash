import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import Button from 'components/button';

import { ui } from 'constants';

// TODO: Add SVG to sprite

import ActionShowSVG from 'svg/action--show.svg';
import ActionHideSVG from 'svg/action--hide.svg';

import StatusSuccessSVG from 'svg/status--success.svg';
import StatusWarningSVG from 'svg/status--warning.svg';
import StatusDangerSVG from 'svg/status--danger.svg';
import StatusInfoSVG from 'svg/status--info.svg';

import IconUserSVG from 'svg/icon--user.svg';

import './form-field.scss';

const FormField = props => {
    let [value, setValue] = useState(props.value ? props.value : '');
    let [validity, setValidity] = useState(!props.required);
    let [invalid, setInvalid] = useState(!!props.tooltip);

    let [preview, setPreview] = useState(props.type === FormField.TYPE_IMAGE && props.value ? props.value : undefined);

    const className = 'form-field',
          required = props.required ? 'required' : null,
          description = props.children ? `${props.id}_description` : null,
          actions = [],
          images = ['image/jpeg', 'image/png'];

    useEffect(() => {
        setInvalid(!!props.tooltip);
    }, [props.tooltip]);

    useEffect(() => {
        if(props.onValue) props.onValue({ id: props.id, value });
    }, [value]);

    useEffect(() => {
        if(props.onValidity) props.onValidity({ id: props.id, value });
    }, [validity]);

    let type = props.type,
        accept;

    const onChange = event => {
        const target = event.currentTarget,
              isFile = [FormField.TYPE_FILE, FormField.TYPE_IMAGE].includes(props.type),
              value = isFile ? target.files[0] : target.value;

//        setValidity(isFile ? images.includes(target.files[0].type) : target.checkValidity());
        if (invalid) setInvalid(false);

        setValue(value);

        if (isFile) {
            // TODO: Disable field while loading

            const reader = new FileReader();

            reader.onload = event => {
                setPreview(event.target.result);

                if(props.onChange) props.onChange(value);
            };

            reader.readAsDataURL(target.files[0]);
        } else {
            if(props.onChange) props.onChange(value);
        }
    };

    const onBlur = event => {
        onChange(event);

        if(props.onBlur) props.onBlur(event);
    };

    const onInvalid = event => {
        event.preventDefault();

        setInvalid(true);
//        setValidity(false);

        if(props.onInvalid) props.onInvalid(event);
    };

    const onPasswordShow = event => {
        event.preventDefault();

        const newClass = `${className}__field_shown`,
              field = event.currentTarget.parentElement,
              input = event.currentTarget.parentElement.getElementsByTagName('input')[0];

        if (field.classList.contains(newClass)) {
            field.classList.remove(newClass);
            input.setAttribute('type', 'password');
        } else {
            field.classList.add(newClass);
            input.setAttribute('type', 'text');
        }

        input.focus();
    };

    switch (props.type) {
        case FormField.TYPE_TEXT:
            break;
        case FormField.TYPE_EMAIL:
            break;
        case FormField.TYPE_PASSWORD:
            actions.push({ id: 'show', onClick: onPasswordShow, icon: <><ActionShowSVG className="on" /><ActionHideSVG className="off" /></> });
            break;
        case FormField.TYPE_IMAGE:
            type = FormField.TYPE_FILE;
            accept = images.join(',');
            actions.push({ htmlFor: props.id, title: props.placeholder });
            break;
    }

    return <div className={ClassNames(className, {
        [`${className}_type_${props.type}`]: props.type,
        [`${className}_size_${props.size}`]: props.size,
        [props.className]: props.className
    })}>
      <p className={`${className}__field`}>
        <input
          className={`${className}__input`}
          id={props.id}
          name={props.id}
          type={type}
          accept={accept}
          placeholder={props.placeholder}
          pattern={props.pattern}
          required={required}
          value={value && type === FormField.TYPE_FILE ? '' : value}
          onChange={onChange}
          onBlur={onBlur}
          onInvalid={onInvalid}
          aria-describedby={description}
        />
        {props.type !== FormField.TYPE_IMAGE && props.placeholder ? <label
          className={`${className}__placeholder`}
          htmlFor={props.id}>
          {value && props.label ? props.label : props.placeholder}
        </label> : ''}
        {props.type === FormField.TYPE_IMAGE ? <label
          className={`${className}__placeholder`}
          htmlFor={props.id}
          style={{ backgroundImage: preview ? `url(${preview})` : 'none' }}
        >
          { preview ? '' : <IconUserSVG /> }
        </label> : ''}
        {actions.map((item, i) => {
            const classNames = ClassNames(`${className}__action`, {
                [`${className}__action_${item.id}`]: item.id
            });

            return props.type === FormField.TYPE_IMAGE ? <Button
              key={i}
              className={classNames}
              htmlFor={item.htmlFor}
              style="regular"
              color="white"
              size="medium"
              onClick={item.onClick}>
              {item.title}
            </Button> : <a
              key={i}
              className={classNames}
              href="#"
              title={item.title}
              onClick={item.onClick}>
              {item.icon}
            </a>
        })}
        {invalid ? (() => {
            let tooltip;

            switch (true) {
                case !!props.tooltip:
                    tooltip = props.tooltip;
                    break;
                case !value && !!props.tooltips && !!props.tooltips.empty:
                    tooltip = props.tooltips.empty;
                    break;
                case !validity && !!props.tooltips && !!props.tooltips.invalid:
                    tooltip = props.tooltips.invalid;
                    break;
            }

            return tooltip ? <span className={ClassNames(`${className}__tooltip`, {
                [`${className}__tooltip_type_${tooltip.type}`]: tooltip.type
            })}>
              <span className={`${className}__tooltip__body`}>
                <span className={`${className}__tooltip__icon`}>{((type) => {
                    switch (type) {
                        case ui.STATUS_SUCCESS:
                            return <StatusSuccessSVG />;
                        case ui.STATUS_WARNING:
                            return <StatusWarningSVG />;
                        case ui.STATUS_DANGER:
                            return <StatusDangerSVG />;
                        case ui.STATUS_INFO:
                        default:
                            return <StatusInfoSVG />;
                    }
                })(tooltip.type)}</span>
                <span className={`${className}__tooltip__text`}>
                  {tooltip.children}
                </span>
              </span>
            </span> : '';
        })() : ''}
        {props.type !== FormField.TYPE_IMAGE ? <span className={`${className}__background`} /> : ''}
      </p>
      {props.children ? <small id={description} className={`${className}__description`}>{props.children}</small> : ''}
    </div>;
};

FormField.TYPE_TEXT     = 'text';
FormField.TYPE_EMAIL    = 'email';
FormField.TYPE_PASSWORD = 'password';
FormField.TYPE_FILE     = 'file';
FormField.TYPE_IMAGE    = 'image';
FormField.TYPES = [FormField.TYPE_TEXT, FormField.TYPE_EMAIL, FormField.TYPE_PASSWORD, FormField.TYPE_FILE, FormField.TYPE_IMAGE];

FormField.TOOLTIP = {
    type:     PropTypes.oneOf(ui.STATUSES),
    children: PropTypes.node.isRequired
};

FormField.propTypes = {
    className:   PropTypes.string,
    type:        PropTypes.oneOf(FormField.TYPES),
    id:          PropTypes.string.isRequired,
    size:        PropTypes.oneOf(ui.SIZES),
    placeholder: PropTypes.string,
    label:       PropTypes.string,
    pattern:     PropTypes.string,
    required:    PropTypes.bool,
    value:       PropTypes.string,
    children:    PropTypes.node,
    tooltip:     PropTypes.shape(FormField.TOOLTIP),
    tooltips:    PropTypes.shape({
        empty:   PropTypes.shape(FormField.TOOLTIP),
        invalid: PropTypes.shape(FormField.TOOLTIP)
    }),
    onChange:    PropTypes.func,
    onBlur:      PropTypes.func,
    onInvalid:   PropTypes.func,
    onValue:     PropTypes.func,
    onValidity:  PropTypes.func
};

// TODO: Move default props to css

FormField.defaultProps = {
    type: FormField.TYPE_TEXT,
    size: ui.SIZE_NORMAL
};

export default FormField;