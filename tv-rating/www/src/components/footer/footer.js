import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import ClassNames from 'classnames';

import './footer.scss';

// TODO: Consider move links array to children

const Footer = props => {
    const className = 'footer';

    return <footer className={ClassNames(className, {
        [props.className]: props.className
    })}>
      {props.text ? <p className={`${className}__text`}>{props.text}</p> : ''}
      {props.links && props.links.length ? <ul className={`${className}__links`}>
        {props.links.map((item, i) => <li key={i} className={`${className}__links__item`}>
          <Link className={`${className}__links__link`} to={item.to}>{item.children ? item.children : ''}</Link>
        </li>)}
      </ul> : ''}
    </footer>;
};

Footer.propTypes = {
    className: PropTypes.string,
    text: PropTypes.string,
    links: PropTypes.arrayOf(PropTypes.shape({
        to: PropTypes.string.isRequired,
        children: PropTypes.string
    }))
};

export default Footer;