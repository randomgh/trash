import React, { useState } from 'react';
import { withRouter } from 'react-router-dom';
import { withCookies } from 'react-cookie';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import { ui } from 'constants';

import Toolbar, {
    ToolbarSpace, ToolbarSeparator, ToolbarIntervalPicker, ToolbarSwitch, ToolbarCheckbox
} from 'components/toolbar';
import Button from 'components/button';
import { ModalComparisonPicker } from 'components/modal';
import Schedule from 'components/schedule';

import { modals } from 'actions';

const ScheduleView = props => {
    let [type, setType] = useState(Schedule.TYPE_SCHEDULED);
    let [interval, setInterval] = useState(undefined);
    let [channels, setChannels] = useState([]);

    const onAddChannel = event => {
        props.dispatch(modals.open({
            id: 'comparison-channels',
            children: <ModalComparisonPicker resource="channels" selected={channels} onClose={onComparisonClose} />
          }));
    };

    const onComparisonClose = data => {
        setChannels(data);

        props.dispatch(modals.close('comparison-channels'));
    };

    const onIntervalChange = data => {
        setInterval(data);
    };

    const onTypeChange = data => {
        setType(data);
    };

    return <>
      <Toolbar size={ui.SIZE_MEDIUM}>
        <ToolbarIntervalPicker
          interval={ToolbarIntervalPicker.INTERVAL_DAY}
          controls={ToolbarIntervalPicker.CONTROL_STEP}
          min={5}
          max={-1}
          onChange={onIntervalChange}
        />
        <ToolbarCheckbox onChange={data => console.log(data)}>Live Рейтинг</ToolbarCheckbox>
        <ToolbarSeparator />
        <ToolbarSwitch onChange={onTypeChange}>{[
            { id: Schedule.TYPE_SCHEDULED, children: 'Программный', active: true },
            { id: Schedule.TYPE_15_MINUTED, children: '15-минутный' }
        ]}</ToolbarSwitch>
        <ToolbarCheckbox onChange={data => console.log(data)}>Ручное сравнение</ToolbarCheckbox>
        <ToolbarSpace />
        <Button
          style={Button.STYLE_REGULAR}
          color={ui.COLOR_GREEN}
          size={ui.SIZE_MEDIUM}
          onClick={onAddChannel}>
          Добавить каналы
        </Button>
      </Toolbar>
      <Schedule type={type} interval={interval} channels={channels} />
    </>;
};

ScheduleView.propTypes = {
    dispatch: PropTypes.func.isRequired
};

export default withRouter(withCookies(connect((state, props) => {
    return {};
})(ScheduleView)));
