import React, { Fragment, useEffect } from 'react';
import { Link, withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';

import { requests, files } from 'actions';

const EntityView = props => {
    useEffect(() => {
        if (props.request) {
            for (let file_id of props.request.files) {
                if (props.files.data.findIndex(file => file._id === file_id) < 0) {
                    props.filesGetAll();
                    break;
                }
            }
        } else {
            props.requestsGetOne({ _id: props.match.params.request_id });
        }
    }, [props.request]);

    return props.request ? <>
      <h2>{props.request.name}</h2>
      <hr />
      <dl>
        {Object.keys(props.request).map((key, i) => ['id', 'createdAt', 'updatedAt'].includes(key) ? <Fragment key={i}>
          <dt>{key}</dt>
          <dd>{props.request[key]}</dd>
        </Fragment> : '')}
      </dl>
      <hr />
      <table className="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">File name</th>
            <th scope="col">Original name</th>
            <th scope="col">Mime type</th>
            <th scope="col">Size</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          {props.request.files.map((file_id, i) => {
              const file = props.files.data.find(file => file._id === file_id);

              return file ? <tr key={i}>
                <th scope="row">{file._id}</th>
                <td>{file.file_name}</td>
                <td>{file.original_name}</td>
                <td>{file.mime_type}</td>
                <td>{file.size}</td>
                <td><Link to={`/${props.match.params.request_id}/${file._id}`} title={file.name}>&raquo;</Link></td>
              </tr> : <tr key={i} className="table-danger">
                <td colSpan={6}>{`File #${file_id} not found.`}</td>
              </tr>
          })}
        </tbody>
      </table>
    </> : <div className="alert alert-danger" role="alert">
      <h4 className="alert-heading">{'Status: 404'}</h4>
      <p>{`Request #${props.match.params.request_id} not found.`}</p>
    </div>;
};

export default withRouter(withCookies(connect((state, ownProps) => {
    return {
        request: state.requests.data.find(request => request._id === ownProps.match.params.request_id),
        files:   state.files
    };
}, (dispatch, ownProps) => {
    return {
        dispatch,
        requestsGetOne: data => dispatch(requests.getOne(data)),
        filesGetAll:    () => dispatch(files.getAll()),
        filesGetOne:    data => dispatch(files.getOne(data))
    };
})(EntityView)));