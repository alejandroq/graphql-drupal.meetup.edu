import React from 'react';
import { render } from 'react-snapshot';
import {
    setObservableConfig
  } from 'recompose';
  import rxjsConfig from 'recompose/rxjsObservableConfig';
  
import './index.css';
import { App } from './components/App/App';
import registerServiceWorker from './registerServiceWorker';

setObservableConfig(rxjsConfig);

render(<App />, document.getElementById('root'));
registerServiceWorker();
