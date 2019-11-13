import React, { useState, useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import Toolbar, { ToolbarSpace, ToolbarSeparator, ToolbarSearch, ToolbarSwitch } from 'components/toolbar';
import Table from 'components/table';

import { channels, broadcasts, persons } from 'actions';

const TableView = props => {
    let [sorting, setSorting] = useState(Table.SORTING_POPULAR);

    useEffect(() => {
        props.getData();
    }, []);

    const onSortChange = data => {
        setSorting(data);
    }; 

    return <>
      <Toolbar size={ui.SIZE_MEDIUM}>
        <ToolbarSpace />
        <ToolbarSwitch onChange={onSortChange}>{[
            { id: Table.SORTING_POPULAR, children: 'Популярные', active: true },
            { id: Table.SORTING_ALPHABET, children: 'По алфавиту' }
        ]}</ToolbarSwitch>
        <ToolbarSeparator />
        <ToolbarSearch resources={['channels']} />
      </Toolbar>

      <Table title={props.title} sorting={sorting}>
        {props.data}
      </Table>
    </>;
};

TableView.propTypes = {
    dispatch: PropTypes.func.isRequired,
    getData:  PropTypes.func.isRequired,
    resource: PropTypes.oneOf(['channels', 'broadcasts', 'persons']),
    title:    PropTypes.string.isRequired,
    data:     PropTypes.array.isRequired
};

export default withRouter(withCookies(connect((state, ownProps) => {
    const path = ownProps.location.pathname.split('/').filter(part => !!part),
          resource = path[path.length - 1],
          props = {
              resource
          };

    switch (resource) {
        case 'channels':
            props.data = state[resource].data.map(item => {
                return {
                    _id: item._id,
                    title: item.name,
                    img: item.image,
                    to: `/${resource}/${item._id}`,
                    rating: 0
                };
            });
            props.title = 'Каналы';
            break;
        case 'broadcasts':
            props.data = state[resource].data.map(item => {
                return {
                    _id: item._id,
                    title: item.name,
                    img: item.image,
                    to: `/${resource}/${item.id}`,
                    rating: 0
                };
            });
            props.title = 'Программы';
            break;
        case 'persons':
            props.data = state[resource].data.map(item => {
                return {
                    _id: item._id,
                    title: item.full_name,
                    img: item.image,
                    to: `/${resource}/${item.id}`,
                    rating: 0
                };
            });
            props.title = 'Персоналии';
            break;
    }

    return props;
}, (dispatch, ownProps) => {
    const path = ownProps.location.pathname.split('/').filter(part => !!part),
          resource = path[path.length - 1];

    let action;

    switch (resource) {
        case 'channels':
            action = channels.getAll();
            break;
        case 'broadcasts':
            action = broadcasts.getAll();
            break;
        case 'persons':
            action = persons.getAll();
            break;
    }

    return {
        dispatch,
        getData: () => dispatch(action)
    };
})(TableView)));