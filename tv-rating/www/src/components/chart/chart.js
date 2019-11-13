import React from 'react';


import {BarChart, Bar, Cell, XAxis, YAxis, CartesianGrid, Tooltip, Legend, Line, LineChart} from 'recharts';

import './chart.scss';

const Chart = props => {
    const className = 'chart';

    return <div className={className}>
      <div className={`${className}__header`}>
        {props.title}
      </div>
      {(type => {
          switch (type) {
              case Chart.TYPE_LINE:
                  return <LineChart width={630} height={345} data={props.children} >
                    <CartesianGrid strokeDasharray="0" vertical={false} />
                    <XAxis dataKey="name" tickMargin={18}  padding={{ bottom: 15, left: 15, right: 15 }} tickSize={0} axisLine={false} />
                    <YAxis axisLine={false}  tickMargin={18} tickSize={0} />
                    <Tooltip />
                    <Line type="monotone" dataKey="pv" stroke="#584ac6" strokeWidth={2} dot={{ r: 8 }}  activeDot={{ r: 8 }} />
                    <Line type="monotone" dataKey="uv" stroke="#21b15e" strokeWidth={2}  />
                  </LineChart>;
              case Chart.TYPE_BAR:
                  return <BarChart width={630} height={345} data={props.children}>
                    <CartesianGrid strokeDasharray="0" vertical={false} />
                    <XAxis dataKey="name" tickMargin={18} strokeDasharray="0" tickSize={0} axisLine={false} />
                    <YAxis tickSize={0} tickMargin={18}  axisLine={false} />
                    <Tooltip />
                    <Bar dataKey="pv" fill="#584ac6" />
                    <Bar dataKey="uv" fill="#21b15e" />
                  </BarChart>;
          }
      })(props.type)}
    </div>;
};

Chart.TYPE_LINE = 'line';
Chart.TYPE_BAR  = 'bar';
Chart.TYPES = [Chart.TYPE_LINE, Chart.TYPE_BAR];

export default Chart;
