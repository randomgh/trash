import React from 'react';

import { ui } from 'constants';

import Toolbar, { ToolbarSpace, ToolbarBreadcrumbs, ToolbarIntervalPicker } from 'components/toolbar';

// TODO: Add SVG to sprite

import IconTopSVG from 'svg/icon--top.svg';

const TopView = props => <>
  <Toolbar size={ui.SIZE_MEDIUM}>
    <ToolbarBreadcrumbs
      rootSize={ui.SIZE_NORMAL}
      crumbsSize={ui.SIZE_MEDIUM}>{[{
        to: '/top',
        exact: true,
        svg: IconTopSVG,
        title: 'Топ 10'
    }]}</ToolbarBreadcrumbs>
    <ToolbarSpace />
    <ToolbarIntervalPicker
      interval={ToolbarIntervalPicker.INTERVAL_YEAR}
      controls={ToolbarIntervalPicker.CONTROL_STEP}
      min={5}
      max={-1}
      onChange={data => console.log(data)}
    />
  </Toolbar>
</>;

export default TopView;