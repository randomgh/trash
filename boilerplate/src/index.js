import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import { CookiesProvider } from 'react-cookie';

import store from './store';

ReactDOM.render(<Provider store={store}>
  <CookiesProvider>
    <BrowserRouter>
      <Switch>


        <Route>

        </Route>
      </Switch>
    </BrowserRouter>
  </CookiesProvider>
</Provider>, document.getElementById('app'));

