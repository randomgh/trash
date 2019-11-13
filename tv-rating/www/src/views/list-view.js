import React from 'react';

import { ui } from 'constants';

import Toolbar, { ToolbarSpace, ToolbarSeparator, ToolbarBreadcrumbs, ToolbarSearch, ToolbarSwitch } from 'components/toolbar';

import IconTopSVG from 'svg/icon--top.svg';

const ListView = props => <>
  <Toolbar size={ui.SIZE_MEDIUM}>
    <ToolbarBreadcrumbs
      rootSize={ui.SIZE_NORMAL}
      crumbsSize={ui.SIZE_MEDIUM}>{[{
        to: '/channels/first',
        exact: true,
        svg: IconTopSVG,
        title: 'Первый канал'
    }, {
        to: '/channels/first/persons',
        exact: true,
        title: 'Персоналии'
    }]}</ToolbarBreadcrumbs>
    <ToolbarSpace />
    <ToolbarSwitch onChange={data => console.log(data)}>{[
        { id: 'popular', children: 'Популярные', active: true },
        { id: 'alphabet', children: 'По алфавиту' }
    ]}</ToolbarSwitch>
    <ToolbarSeparator />
    <ToolbarSearch />
  </Toolbar>
</>;

export default ListView;