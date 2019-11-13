import React, { useState, useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import Toolbar, {
    ToolbarSpace, ToolbarSeparator, ToolbarSwitch, ToolbarBreadcrumbs, ToolbarCheckbox
} from 'components/toolbar';
import Button from 'components/button';
import { ModalComparisonPicker } from 'components/modal';
import Dashboard from 'components/dashboard';

import ActionDashboardSVG from 'svg/action--dashboard.svg';
import ActionScheduleSVG from 'svg/action--schedule.svg';

// TODO: Add SVG to sprite

import { channels, broadcasts, persons, modals } from 'actions';

const DashboardView = props => {
    let [title, setTitle] = useState(undefined);
    let [selected, setSelected] = useState([]);

    const onAddComparison = event => {
        console.log(selected);

        props.dispatch(modals.open({
            id: 'comparison-channels',
            children: <ModalComparisonPicker resource={props.resource} selected={selected} onClose={onComparisonClose} />
        }));
    };

    const onComparisonClose = data => {
        setSelected(data);

        console.log(data);

        props.dispatch(modals.close('comparison-channels'));
    };


    useEffect(() => {
        if (!props.data || !props.data.schedule) {
            props.getData({ _id: props.match.params._id });

            setTitle(undefined);
            setSelected([]);
        } else {
            switch (props.resource) {
                case 'channels':
                    setTitle({
                        to:    `/${props.resource}/${props.data._id}/`,
                        title: props.data.name,
                        img:   props.data.image
                    });
                    break;
                case 'broadcasts':
                    setTitle({
                        to:    `/${props.resource}/${props.data._id}/`,
                        title: props.data.name,
                        img:   props.data.image
                    });
                    break;
                case 'persons':
                    setTitle({
                        to:    `/${props.resource}/${props.data._id}/`,
                        title: props.data.full_name,
                        img:   props.data.image
                    });
                    break;
            }
            setSelected([props.data._id]);
        }
    }, [props.data, props.match.params._id]);

    return <>
      <Toolbar size={ui.SIZE_MEDIUM}>
        {title ? <ToolbarBreadcrumbs
          rootSize={ui.SIZE_NORMAL}
          crumbsSize={ui.SIZE_MEDIUM}>{[{
          exact: true,
          ...title
        }]}</ToolbarBreadcrumbs> : ''}
        <ToolbarSpace />
        <ToolbarCheckbox onChange={data => console.log(data)}>Live Рейтинг</ToolbarCheckbox>
        <ToolbarSeparator />
        <Button
          style={Button.STYLE_REGULAR}
          color={ui.COLOR_GREEN}
          size={ui.SIZE_MEDIUM}
          onClick={onAddComparison}>
          Сравнить
        </Button>
        <ToolbarSeparator />
        <ToolbarSwitch onChange={data => console.log(data)}>{[
            { id: DashboardView.VIEW_DASHBOARD, children: <ActionDashboardSVG />, active: true },
            { id: DashboardView.VIEW_SCHEDULE, children: <ActionScheduleSVG /> }
        ]}</ToolbarSwitch>
      </Toolbar>

      <Dashboard resource={props.resource}>
        {props.data}
      </Dashboard>
    </>;
};


DashboardView.VIEW_DASHBOARD = 'dashboard';
DashboardView.VIEW_SCHEDULE  = 'schedule';
DashboardView.VIEWS = [DashboardView.VIEW_DASHBOARD, DashboardView.VIEW_SCHEDULE];

DashboardView.propTypes = {
    dispatch: PropTypes.func.isRequired,
    getData:  PropTypes.func.isRequired,
    resource: PropTypes.oneOf(['channels', 'broadcasts', 'persons']),
    data:     PropTypes.object
};

export default withRouter(withCookies(connect((state, ownProps) => {
    const path = ownProps.location.pathname.split('/').filter(part => !!part),
          resource = path[path.length - 2];

    return {
        resource,
        data: state[resource].data.find(item => {
            return item._id === ownProps.match.params._id;
        })
    };
}, (dispatch, ownProps) => {
    const path = ownProps.location.pathname.split('/').filter(part => !!part),
          resource = path[path.length - 2];

    let action;

    switch (resource) {
        case 'channels':
            action = channels.getOne;
            break;
        case 'broadcasts':
            action = broadcasts.getOne;
            break;
        case 'persons':
            action = persons.getOne;
            break;
    }

    return {
        dispatch,
        getData: data => dispatch(action(data))
    };
})(DashboardView)));