import React, { useState, useEffect } from 'react';
import { Link, withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import bsCustomFileInput from 'bs-custom-file-input';

import { requests } from 'actions';

const IndexView = props => {
    const form = React.createRef();

    let [fields, setFields] = useState({
        'name': '',
        'images': []
    });

    useEffect(() => {
        bsCustomFileInput.init();

        if (!props.requests.data.length) {
            props.requestsGetAll();
        }
    }, []);

    useEffect(() => {
        if (props.requests.meta.status === 200) {
            setFields({
                'name': '',
                'images': []
            });

            form.current.reset();
        }
    }, [props.requests]);

    const onChange = event => {
        const target = event.currentTarget;

        switch (target.name) {
            case 'name':
                setFields({...fields, name: target.value});
                break;
            case 'images':
                setFields({...fields, images: target.files});
                break;
        }
    };

    const onSubmit = event => {
        event.preventDefault();

        if(event.currentTarget.reportValidity()) {
            props.requestsCreate(fields);
        }
    };

    return <>
        {![200, 102, undefined].includes(props.requests.meta.status) || props.requests.errors.length ? <div className="alert alert-danger" role="alert">
            <h4 className="alert-heading">{`Status: ${props.requests.meta.status}`}</h4>
            {props.requests.errors.length ? <>
              <hr />
              <ul className="mb-0">
                {props.requests.errors.map((error, i) => <li key={i}>{error}</li>)}
              </ul>
            </> : ''}
        </div>: ''}
      <hr />
      <form ref={form} className="form" onSubmit={onSubmit}>
        <fieldset disabled={props.requests.meta.status === 102}>
          <div className="form-group">
            <label htmlFor="name">Name</label>
            <input className="form-control" id="name" name="name" type="text" placeholder="Name" onChange={onChange} value={fields.name} required />
          </div>
          <div className="custom-file">
            <input className="custom-file-input" id="images" name="images" type="file" multiple accept="image/jpeg,image/png" onChange={onChange} required />
            <label className="custom-file-label" htmlFor="image">Choose image</label>
          </div>
          <button className="btn btn-primary mt-4" type="submit">Submit</button>
        </fieldset>
      </form>
      <hr />
      <table className="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Files</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          {props.requests.data.map((request, i) => <tr key={i}>
            <th scope="row">{request._id}</th>
            <td>{request.name}</td>
            <td>{request.files.length}</td>
            <td><Link to={`/${request._id}`} title={request.name}>&raquo;</Link></td>
          </tr>)}
        </tbody>
      </table>
    </>;
};

IndexView.propTypes = {
    dispatch:       PropTypes.func.isRequired,
    requestsGetAll: PropTypes.func.isRequired,
    requestsCreate: PropTypes.func.isRequired,
    history:        PropTypes.object.isRequired
};

export default withRouter(withCookies(connect((state, ownProps) => {
    return {
        requests: state.requests
    };
}, (dispatch, ownProps) => {
    return {
        dispatch,
        requestsGetAll: () => dispatch(requests.getAll()),
        requestsCreate: data => dispatch(requests.create(data))
    };
})(IndexView)));