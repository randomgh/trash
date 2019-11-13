import React, { Fragment, useState, useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';

import { files, methods, reports } from 'actions';

import Summary from 'components/summary';

import 'jquery';
import 'bootstrap/dist/js/bootstrap.min';

const AnalysisView = props => {
    let [indexes, setIndexes] = useState({});

    useEffect(() => {
        if (!props.file) {
            props.filesGetOne({ _id: props.match.params.file_id });
        }

        return () => {
            props.reportsClear();
        };
    }, []);

    useEffect(() => {
        if (props.file) {
            if (!props.methods.data.length) {
                props.methodsGetAll();
            }
        }
    }, [props.file]);

    useEffect(() => {
        if (props.methods) {
            const methodsIndexes = {};

            for (let method of props.methods.data) {
                methodsIndexes[method.slug] = method.index;
            }

            setIndexes({ ...methodsIndexes, ...indexes });
        }
    }, [props.methods]);

    useEffect(() => {
        for (let method of props.methods.data) {
            $(`#collapse-${method.slug}`).on('show.bs.collapse', onShow);
        }

        $(`#collapse-source`).collapse('show');

        return () => {
            for (let method of props.methods.data) {
                $(`#collapse-${method.slug}`).off('show.bs.collapse', onShow);
            }
        };
    }, [props.methods.data, props.reports.data]);

    const onShow = event => {
        const method_id = $(event.currentTarget).data('method_id'),
              method_slug = $(event.currentTarget).data('method_slug');

        if (!props.reports.data[method_id]) {
            props.reportsCreate({
                request_id: props.match.params.request_id,
                file_id: props.file._id,
                file_name: props.file.file_name,
                file_mime: props.file.mime_type,
                method_id,
                method_slug
            });
        }
    };

    const onIndexChange = event => {
        const target = event.currentTarget;

        setIndexes({...indexes, [target.getAttribute('data-method')]: parseFloat(target.value)});
    };

    return props.file ? <>
      <h2>{props.file.original_name}</h2>
      <hr />
      <dl>
        {Object.keys(props.file).map((key, i) => ['id', 'file_name', 'mime_type', 'size', 'createdAt', 'updatedAt'].includes(key) ? <Fragment key={i}>
          <dt>{key}</dt>
          <dd>{props.file[key]}</dd>
        </Fragment> : '')}
      </dl>
      <hr />
      <div className="accordion">
        {props.methods.data.map((method, i) =>
          <div key={i} className="card">
            <div className="card-header" id={`heading-${method.slug}`}>
              <h2 className="btn-toolbar justify-content-between mb-0">
                <button className="btn btn-link" type="button" data-toggle="collapse" data-target={`#collapse-${method.slug}`} aria-expanded="false" aria-controls={`collapse-${method.slug}`}>{method.name}</button>
                <form className="form-inline" onSubmit={event => event.preventDefault()}>
                  <input className="form-control" id={`index-${method.slug}`} type={method.slug === 'source' ? 'hidden' : 'number'} step={0.01} min={0} max={1} data-method={method.slug} value={indexes[method.slug]} onChange={onIndexChange} />
                </form>
              </h2>
            </div>
            <div className="collapse" id={`collapse-${method.slug}`} aria-labelledby={`heading-${method.slug}`} data-method_id={method._id} data-method_slug={method.slug}>
              <div className="card-body">
                {props.reports.data[method._id] ? ((report, method) => {
                    switch (method.slug) {
                        case 'source':
                        case 'medianNoise':
                            return <>
                              <img className="w-100" src={`/uploads${report.result.map}`} alt={method.name} title={method.name} />
                            </>;
                        case 'ghost':
                            return <>
                              <dl>
                                {Object.keys(report.result).map((key, i) => !['maps', 'completed'].includes(key) ? <Fragment key={i}>
                                  <dt>{key}</dt>
                                  <dd>{report.result[key]}</dd>
                                </Fragment> : '')}
                              </dl>
                              {report.result.maps.map((map, i) => <Fragment key={i}>
                                <hr />
                                <img className="w-100" src={`/uploads${map}`} alt={method.name} title={method.name} />
                              </Fragment>)}
                            </>;
                        case 'grids':
                            return <>
                              <dl>
                                {Object.keys(report.result).map((key, i) => !['mapG', 'mapGI', 'completed'].includes(key) ? <Fragment key={i}>
                                  <dt>{key}</dt>
                                  <dd>{report.result[key]}</dd>
                                </Fragment> : '')}
                              </dl>
                              <hr />
                              <img className="w-100" src={`/uploads${report.result.mapG}`} alt={method.name} title={method.name} />
                              <hr />
                              <img className="w-100" src={`/uploads${report.result.mapGI}`} alt={method.name} title={method.name} />
                            </>;
                        default:
                            return <>
                              <dl>
                                {Object.keys(report.result).map((key, i) => !['map', 'completed'].includes(key) ? <Fragment key={i}>
                                  <dt>{key}</dt>
                                  <dd>{report.result[key]}</dd>
                                </Fragment> : '')}
                              </dl>
                              <hr />
                              <img className="w-100" src={`/uploads${report.result.map}`} alt={method.name} title={method.name} />
                            </>;
                    }
                })(props.reports.data[method._id], method) : <div className="progress">
                  <div className="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style={{ width: '100%' }} />
                </div>}
              </div>
            </div>
          </div>)}
      </div>
      <hr />
      <Summary methods={props.methods.data.map(method => {
          return { ...method, report: props.reports.data[method._id] };
      })} indexes={indexes} />
    </> : <div className="alert alert-danger" role="alert">
      <h4 className="alert-heading">{'Status: 404'}</h4>
      <p>{`File #${props.match.params.file_id} not found.`}</p>
    </div>;
};

export default withRouter(withCookies(connect((state, ownProps) => {
    return {
        methods: state.methods,
        reports: state.reports,
        file: state.files.data.find(file => file._id === ownProps.match.params.file_id)
    };
}, (dispatch, ownProps) => {
    return {
        dispatch,
        methodsGetAll: () => dispatch(methods.getAll()),
        filesGetOne: data => dispatch(files.getOne(data)),
        reportsCreate: data => dispatch(reports.create(data)),
        reportsClear: () => dispatch(reports.clear())
    };
})(AnalysisView)));