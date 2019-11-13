import React, { Fragment, useState, useEffect } from 'react';
import ClassNames from 'classnames';
import DeltaE from 'delta-e';
import space from 'color-space';

import './index.scss';

const Summary = props => {
    const source = 'source',
          replacer = [255, 0, 0],
          scale = 3;

    let result = React.createRef();

    let [filter, setFilter] = useState(source);

    useEffect(() => {
        const results = result.current.childNodes;

        for (let i = 0, target; i < results.length; i++) {
            target = results[i];

            target.style.opacity = props.indexes[target.getAttribute('data-method')];
        }

    }, [props.indexes]);

    const clearReport = (canvas, image, report, width, height) => {
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        const ctx = canvas.getContext('2d');

        ctx.drawImage(image, 0, 0, width, height);

        const data = ctx.getImageData(0, 0, width, height),
            pixels = data.data,
            step = 100 / scale;

        let key;

        switch (report) {
            case 'dq':
                key = { L: 6.6680279313903945, A: 36.68052261753675, B: -50.29645105821452 };
                break;
            case 'dwNoise':
                key = { L: 6.6680279313903945, A: 36.68052261753675, B: -50.29645105821452 };
                break;
            case 'ghost':
                key = { L: 6.6680279313903945, A: 36.68052261753675, B: -50.29645105821452 };
                break;
            case 'ela':
                key = { L: 0, A: 0, B: 0 };
                break;
            case 'blocking':
                key = { L: 6.6680279313903945, A: 36.68052261753675, B: -50.29645105821452 };
                break;
            case 'medianNoise':
                key = { L: 0, A: 0, B: 0 };
                break;
            case 'grids-normal':
                key = { L: 6.6680279313903945, A: 36.68052261753675, B: -50.29645105821452 };
                break;
            case 'grids-inversed':
                key = { L: 13.858842702172808, A: 34.549641883024535, B: 21.680019426402136 };
                break;
            case 'source':
            default:
        }

        if (key) {
            let lab,
                delta;

            for (let i = 0, l = pixels.length; i < l; i += 4) {
                lab = space.rgb.lab([pixels[i], pixels[i + 1], pixels[i + 2]]).reduce((obj, value, i) => {
                    switch (i) {
                        case 0:
                            i = 'L';
                            break;
                        case 1:
                            i = 'A';
                            break;
                        case 2:
                            i = 'B';
                            break;
                    }
                    obj[i] = value;
                    return obj;
                }, {});

                delta = Math.round(DeltaE.getDeltaE00(key, lab) / step) * step / 100;

                [pixels[i], pixels[i + 1], pixels[i + 2]] = replacer;

                pixels[i + 3] = 255 * delta;
            }
        }

        ctx.putImageData(data, 0, 0);

        return {
            className: ClassNames({
                'result_source': report === source,
                'result_filter': report !== source,
                [`result_filter_${report}`]: report
            }),
            src: canvas.toDataURL('image/png'),
            alt: report
        };
    };

    const onClick = event => {
        event.preventDefault();

        setFilter(event.target.getAttribute('data-filter'));
    };

    const onLoad = event => {
        const target = event.currentTarget,
              classList = target.classList,
              parent = target.parentElement,
              source = parent.getElementsByClassName('report_filter_source')[0],
              width = source.clientWidth,
              height = source.clientHeight,
              canvases = parent.parentElement.getElementsByClassName('canvas')[0],
              result = parent.parentElement.getElementsByClassName('result')[0];

        let image;

        switch (true) {
            case classList.contains('report_filter_source'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_source')[0], target, 'source', width, height);
                break;
            case classList.contains('report_filter_dq'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_dq')[0], target, 'dq', width, height);
                break;
            case classList.contains('report_filter_dwNoise'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_dwNoise')[0], target, 'dwNoise', width, height);
                break;
            case classList.contains('report_filter_ghost'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_ghost')[0], target, 'ghost', width, height);
                break;
            case classList.contains('report_filter_ela'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_ela')[0], target, 'ela', width, height);
                break;
            case classList.contains('report_filter_blocking'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_blocking')[0], target, 'blocking', width, height);
                break;
            case classList.contains('report_filter_medianNoise'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_medianNoise')[0], target, 'medianNoise', width, height);
                break;
            case classList.contains('report_filter_grids-normal'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_grids-normal')[0], target, 'grids-normal', width, height);
                break;
            case classList.contains('report_filter_grids-inversed'):
                image = clearReport(canvases.getElementsByClassName('canvas_filter_grids-inversed')[0], target, 'grids-inversed', width, height);
                break;
        }

        const img = document.createElement('img');
        img.className = image.className;
        img.src = image.src;
        img.alt = image.alt;
        img.setAttribute('data-method', target.getAttribute('data-method'));
        img.style.opacity = props.indexes[target.getAttribute('data-method')];

        result.appendChild(img);
    };

    return <div className="summary">
      <ul className={ClassNames('nav', 'nav-tabs', {
          [`nav--${filter}`]: filter
      }, 'mb-4')}>
        {props.methods.map((method, i) => {
            if (method.report) {
                switch (method.slug) {
                    case 'ghost':
                        return method.report.result.maps.map((map, j) => <li key={`${i}-${j}`} className="nav-item">
                          <a className={ClassNames('nav-link', {
                              [`nav-link_${method.slug}`]: method.slug,
                              [`nav-link_${method.slug}-${j}`]: method.slug,
                              'active': `${method.slug}-${j}` === filter
                          })} href="#" title={method.name} data-filter={`${method.slug}-${j}`} onClick={onClick}>{method.name}</a>
                        </li>);
                    case 'grids':
                        return <Fragment key={i}>
                          <li key={`${i}-normal`} className="nav-item">
                            <a className={ClassNames('nav-link', {
                                [`nav-link_${method.slug}`]: method.slug,
                                [`nav-link_${method.slug}-normal`]: method.slug,
                                'active': `${method.slug}-normal` === filter
                            })} href="#" title={method.name} data-filter={`${method.slug}-normal`} onClick={onClick}>{method.name}</a>
                          </li>
                          <li key={`${i}-inversed`} className="nav-item">
                            <a className={ClassNames('nav-link', {
                                [`nav-link_${method.slug}`]: method.slug,
                                [`nav-link_${method.slug}-inversed`]: method.slug,
                                'active': `${method.slug}-inversed` === filter
                            })} href="#" title={method.name} data-filter={`${method.slug}-inversed`} onClick={onClick}>{method.name}</a>
                          </li>
                        </Fragment>;
                    default:
                        return <li key={i} className="nav-item">
                          <a className={ClassNames('nav-link', {
                              [`nav-link_${method.slug}`]: method.slug,
                              'active': method.slug === filter
                          })} href="#" title={method.name} data-filter={method.slug} onClick={onClick}>{method.name}</a>
                        </li>;
                }
            } else {
                return <Fragment key={i} />;
            }
        })}
      </ul>
      <div className="reports">
        <div className={ClassNames('report', {
            [`report--${filter}`]: filter
        }, 'mb-4')}>
          {props.methods.map((method, i) => {
              if (method.report) {
                  switch (method.slug) {
                        case 'ghost':
                            return method.report.result.maps.map((map, j) => <img key={`${i}-${j}`} className={ClassNames({
                                'report_source': `${method.slug}-${j}` === source,
                                'report_filter': `${method.slug}-${j}` !== source,
                                'report_active': `${method.slug}-${j}` === filter,
                                [`report_filter_${method.slug}`]: method.slug,
                                [`report_filter_${method.slug}-${j}`]: method.slug
                            })} src={`/uploads${map}`} alt={method.name} title={method.name} data-method={method.slug} onLoad={onLoad} />);
                        case 'grids':
                            return <Fragment key={i}>
                              <img key={`${i}-normal`} className={ClassNames({
                                  'report_source': `${method.slug}-normal` === source,
                                  'report_filter': `${method.slug}-normal` !== source,
                                  'report_active': `${method.slug}-normal` === filter,
                                  [`report_filter_${method.slug}`]: method.slug,
                                  [`report_filter_${method.slug}-normal`]: method.slug
                              })} src={`/uploads${method.report.result.mapG}`} alt={method.name} data-method={method.slug} title={method.name} onLoad={onLoad} />
                              <img key={`${i}-inversed`} className={ClassNames({
                                  'report_source': `${method.slug}-inversed` === source,
                                  'report_filter': `${method.slug}-inversed` !== source,
                                  'report_active': `${method.slug}-inversed` === filter,
                                  [`report_filter_${method.slug}`]: method.slug,
                                  [`report_filter_${method.slug}-inversed`]: method.slug
                              })} src={`/uploads${method.report.result.mapGI}`} alt={method.name} data-method={method.slug} title={method.name} onLoad={onLoad} />
                            </Fragment>;
                        default:
                            return <img key={i} className={ClassNames({
                                'report_source': method.slug === source,
                                'report_filter': method.slug !== source,
                                'report_active': method.slug === filter,
                                [`report_filter_${method.slug}`]: method.slug
                            })} src={`/uploads${method.report.result.map}`} alt={method.name} data-method={method.slug} title={method.name} onLoad={onLoad} />;
                    }
              } else {
                  return <Fragment key={i} />;
              }
            })}
        </div>
        <div className={ClassNames('canvas', {
            [`canvas--${filter}`]: filter
        }, 'mb-4')}>
          {props.methods.map((method, i) => {
              if (method.report) {
                  switch (method.slug) {
                      case 'ghost':
                          return method.report.result.maps.map((map, j) => <canvas key={`${i}-${j}`} className={ClassNames({
                              'canvas_source': `${method.slug}-${j}` === source,
                              'canvas_filter': `${method.slug}-${j}` !== source,
                              'canvas_active': `${method.slug}-${j}` === filter,
                              [`canvas_filter_${method.slug}`]: method.slug,
                              [`canvas_filter_${method.slug}-${j}`]: method.slug
                          })} />);
                      case 'grids':
                          return <Fragment key={i}>
                            <canvas key={`${i}-normal`} className={ClassNames({
                                'canvas_source': `${method.slug}-normal` === source,
                                'canvas_filter': `${method.slug}-normal` !== source,
                                'canvas_active': `${method.slug}-normal` === filter,
                                [`canvas_filter_${method.slug}`]: method.slug,
                                [`canvas_filter_${method.slug}-normal`]: method.slug
                            })} />
                            <canvas key={`${i}-inversed`} className={ClassNames({
                                'canvas_source': `${method.slug}-inversed` === source,
                                'canvas_filter': `${method.slug}-inversed` !== source,
                                'canvas_active': `${method.slug}-inversed` === filter,
                                [`canvas_filter_${method.slug}`]: method.slug,
                                [`canvas_filter_${method.slug}-inversed`]: method.slug
                            })} />
                          </Fragment>;
                      default:
                          return <canvas key={i} className={ClassNames({
                              'canvas_source': method.slug === source,
                              'canvas_filter': method.slug !== source,
                              'canvas_active': method.slug === filter,
                              [`canvas_filter_${method.slug}`]: method.slug
                          })} />;
                  }
              } else {
                  return <Fragment key={i} />;
              }
          })}
        </div>
        <div ref={result} className="result" />
      </div>
    </div>;
};

export default Summary;