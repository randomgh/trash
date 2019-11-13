import dotenv from 'dotenv';
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { CookiesProvider } from 'react-cookie';
import { ApolloProvider } from 'react-apollo';

import client from './client';

import { Home, Error } from 'views';

import './index.scss';

dotenv.config();

ReactDOM.render(<ApolloProvider client={client}>
  <CookiesProvider>
    <BrowserRouter>
      <Switch>
        <Route exact path="/" component={Home} />

        <Route>
          <Error />
        </Route>
      </Switch>
    </BrowserRouter>
  </CookiesProvider>
</ApolloProvider>, document.getElementById('app'));