import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import { Provider } from 'react-redux';
import { CookiesProvider } from 'react-cookie';

import store from './store';

import { Default as Layout } from 'layouts';

import { Home, Login, Logout, Registration, Invitation, Recovery, Password, Profile, Top, Policy, Terms, Message, Schedule, Dashboard, Table, List, Error } from 'views';

// TODO: Replace message route

ReactDOM.render(<Provider store={store}>
  <CookiesProvider>
    <BrowserRouter>
      <Layout>
        <Switch>
          <Route exact path="/" component={Home} />

          <Route exact path="/login" component={Login} />
          <Route exact path="/logout" component={Logout} />

          <Route exact path="/registration" component={Registration} />
          <Route exact path="/registration/completed" component={Message} />

          <Route exact path="/invitation" component={Invitation} />
          <Route exact path="/invitation/completed" component={Message} />

          <Route exact path="/recovery" component={Recovery} />
          <Route exact path="/recovery/completed" component={Message} />

          <Route exact path="/password" component={Password} />
          <Route exact path="/password/completed" component={Message} />

          <Route exact path="/profile" component={Profile} />
          <Route exact path="/profile/completed" component={Message} />

          <Route exact path="/top" component={Top} />

          <Route exact path="/policy" component={Policy} />
          <Route exact path="/terms" component={Terms} />

          <Route exact path="/schedule" component={Schedule} />

          <Route exact path="/channels/:_id/persons" component={Table} />
          <Route exact path="/channels/:_id/broadcasts" component={Table} />
          <Route exact path="/channels/:_id/schedule" component={Schedule} />
          <Route exact path="/channels/:_id" component={Dashboard} />
          <Route exact path="/channels" component={Table} />

          <Route exact path="/broadcasts/:_id/persons" component={Table} />
          <Route exact path="/broadcasts/:_id" component={Dashboard} />
          <Route exact path="/broadcasts" component={Table} />

          <Route exact path="/persons/:_id" component={Dashboard} />
          <Route exact path="/persons" component={Table} />

          <Route>
            <Error number={404} title="Страница не найдена">
              Мы не&nbsp;нашли страницу с&nbsp;указанным адресом.<br />Возможно ее&nbsp;адрес введен неверно или она была удалена.
            </Error>
          </Route>
        </Switch>
      </Layout>
    </BrowserRouter>
  </CookiesProvider>
</Provider>, document.getElementById('app'));

