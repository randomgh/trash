import http from 'http';
import functions from 'firebase-functions';

import gql from './gql';
import giql from './giql';
import rest from './rest';
import swagger from './swagger';

const apps = { gql, giql, rest, swagger };

const getApp = i => apps[i],
      getServer = app => http.createServer(app).listen(app.get('port'), err => {
          const bind = `Port ${app.get('port')}`;
        
          if (err) {
              if (err.syscall !== 'listen') throw err;
            
              switch (err.code) {
                  case 'EACCES':
                      console.error(`${bind} requires elevated privileges`);
                      process.exit(1);
                  case 'EADDRINUSE':
                      console.error(`${bind} is already in use`);
                      process.exit(1);
                  default:
                      throw err;
              }
          } else {
              console.info(`Listening on ${bind}`);
          }
      }),
      getRequest = app => functions.https.onRequest(app);

module.exports = Object.keys(apps).reduce((i, result) => {
    const app = getApp(i);
    
    return { ...result, [i]: process.argv.includes('--local') ? getServer(app) : getRequest(app) };
}, {});
