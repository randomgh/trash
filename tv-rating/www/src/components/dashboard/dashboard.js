import React from 'react';

import Table from 'components/table';
import Chart from 'components/chart';

import './dashboard.scss';

const Dashboard = props => {
  const RESOURCES = {
            channels: {
                chart1: 'Популярность канала',
                chart2: 'Распределение по сетям',
                table1: {
                    title:    'Персоналии',
                    resource: 'persons'
                },
                table2: {
                    title:    'Программы',
                    resource: 'broadcasts'
                }
            },
            broadcasts: {
                chart1: 'Популярность программмы',
                chart2: 'Распределение по сетям',
                table1: {
                    title:    'Персоналии',
                    resource: 'persons'
                },
                table2: {
                    title:    'Популярные выпуски',
                    resource: 'broadcasts'
                }
            },
            persons: {
                chart1: 'Популярность персоналии',
                chart2: 'Распределение по сетям',
                table1: {
                    title:    'Программы',
                    resource: 'broadcasts'
                },
                table2: {
                    title:    'Популярные выпуски',
                    resource: 'broadcasts'
                }
            }
        },
        MONTHS = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];

  const className = 'dashboard';

  return <div className={className}>
    {props.children ? <>
      <Chart type={Chart.TYPE_LINE} title={RESOURCES[props.resource].chart1}>{[{
          name: `Page A`, uv: 4000, pv: 2400, amt: 2400,
      }, {
          name: 'Page B', uv: 3000, pv: 1398, amt: 2210,
      }, {
          name: 'Page C', uv: 2000, pv: 9800, amt: 2290,
      }, {
          name: 'Page D', uv: 2780, pv: 3908, amt: 2000,
      }, {
          name: 'Page E', uv: 1890, pv: 4800, amt: 2181,
      }, {
          name: 'Page F', uv: 2390, pv: 3800, amt: 2500,
      }, {
          name: 'Page G', uv: 3490, pv: 4300, amt: 2100,
      }]}</Chart>

      <Chart type={Chart.TYPE_BAR} title={RESOURCES[props.resource].chart2}>{[{
          name: `Page A`, uv: 4000, pv: 2400, amt: 2400
      }, {
          name: 'Page B', uv: 3000, pv: 1398, amt: 2210
      }, {
          name: 'Page C', uv: 2000, pv: 9800, amt: 2290
      }, {
          name: 'Page D', uv: 2780, pv: 3908, amt: 2000
      }, {
          name: 'Page E', uv: 1890, pv: 4800, amt: 2181
      }, {
          name: 'Page F', uv: 2390, pv: 3800, amt: 2500
      }, {
          name: 'Page G', uv: 3490, pv: 4300, amt: 2100
      }]}</Chart>

      {props.children.schedule ? <>
        <Table title={RESOURCES[props.resource].table1.title} more={`/${props.resource}/${props.children._id}/${RESOURCES[props.resource].table1.resource}`}>
          {((resource, schedule, limit) => {
              const result = [];

              let item;
              switch (resource) {
                  case 'channels':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          for (let j = 0; j < schedule[i].members.length && q < limit; j++) {
                              item = schedule[i].members[j].person;

                              if (!result.find(resultItem => {
                                  return resultItem._id === item._id;
                              })) {
                                  result.push({
                                      _id:    item._id,
                                      title:  item.full_name,
                                      img:    item.image,
                                      to:     `/persons/${item._id}`,
                                      rating: 0
                                  });

                                  q++;
                              }
                          }
                      }
                      break;
                  case 'broadcasts':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          for (let j = 0; j < schedule[i].members.length && q < limit; j++) {
                              item = schedule[i].members[j].person;

                              if (!result.find(resultItem => {
                                  return resultItem._id === item._id;
                              })) {
                                  result.push({
                                      _id:    item._id,
                                      title:  item.full_name,
                                      img:    item.image,
                                      to:     `/persons/${item._id}`,
                                      rating: 0
                                  });

                                  q++;
                              }
                          }
                      }
                      break;
                  case 'persons':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          item = schedule[i].broadcast;

                          if (!result.find(resultItem => {
                              return resultItem._id === item._id;
                          })) {
                              result.push({
                                  _id:    item._id,
                                  title:  item.name,
                                  img:    item.image,
                                  to:     `/broadcasts/${item._id}`,
                                  rating: 0
                              });

                              q++;
                          }
                      }
                      break;
              }

              return result;
          })(props.resource, props.children.schedule, 10)}
        </Table>
        <Table title={RESOURCES[props.resource].table2.title} more={`/${props.resource}/${props.children._id}/${RESOURCES[props.resource].table2.resource}`}>
          {((resource, schedule, limit) => {
              const result = [];

              let item,
                  date;
              switch (resource) {
                  case 'channels':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          item = schedule[i].broadcast;

                          if (!result.find(resultItem => {
                              return resultItem._id === item._id;
                          })) {
                              result.push({
                                  _id:    item._id,
                                  title:  item.name,
                                  img:    item.image,
                                  to:     `/broadcasts/${item._id}`,
                                  rating: 0
                              });

                              q++;
                          }
                      }
                      break;
                  case 'broadcasts':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          item = schedule[i];

                          if (!result.find(resultItem => {
                              return resultItem._id === item._id;
                          })) {
                              date = new Date(item.starts);

                              result.push({
                                  _id:    item._id,
                                  title:  `от ${date.getDate()} ${MONTHS[date.getMonth()]}`,
                                  img:    props.children.image,
                                  to:     `/broadcasts/${props.children._id}`,
                                  rating: 0
                              });

                              q++;
                          }
                      }
                      break;
                  case 'persons':
                      for (let i = 0, q = 0; i < schedule.length && q < limit; i++) {
                          item = schedule[i];

                          if (!result.find(resultItem => {
                              return resultItem._id === item._id;
                          })) {
                              date = new Date(item.starts);

                              result.push({
                                  _id:    item._id,
                                  title:  `от ${date.getDate()} ${MONTHS[date.getMonth()]}`,
                                  img:    item.broadcast.image,
                                  to:     `/broadcasts/${item.broadcast._id}`,
                                  rating: 0
                              });

                              q++;
                          }
                      }
                      break;
              }

              return result;
          })(props.resource, props.children.schedule, 10)}
        </Table>
      </> : ''}
    </> : ''}
  </div>;
};

export default Dashboard;
