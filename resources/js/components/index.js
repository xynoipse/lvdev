import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);

// Global components
import * as Contents from './content';

const globalComponents = {
  ...Contents
};

Object.keys(globalComponents).forEach(key =>
  Vue.component(globalComponents[key].name, globalComponents[key])
);

Vue.component('pagination', require('laravel-vue-pagination'));
