import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import { CookiesProvider } from 'react-cookie';

import store from './store';

import { Index, Entity, Analysis, Error } from 'views';

import 'bootstrap/scss/bootstrap.scss';

import './index.scss';

ReactDOM.render(<Provider store={store}>
  <CookiesProvider>
    <BrowserRouter>
      <Switch>
        <Route exact path='/' component={Index} />

        <Route exact path='/:request_id' component={Entity} />
        <Route exact path='/:request_id/:file_id' component={Analysis} />

        <Route component={Error} />
      </Switch>
    </BrowserRouter>
  </CookiesProvider>
</Provider>, document.getElementById('app'));