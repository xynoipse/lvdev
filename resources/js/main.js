import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store';

import 'core-js/stable';
import './components';
import './utils/app-mixin';

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
});
