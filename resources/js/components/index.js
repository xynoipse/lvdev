import Vue from 'vue';

// Plugins
import { Plugin as Fragment } from 'vue-fragment'
import BootstrapVue from 'bootstrap-vue';

const plugins = [
  Fragment,
  BootstrapVue
]

plugins.forEach(plugin => {
  Vue.use(plugin)
});

// Global components
import * as Contents from './content';
import * as Cards from './card';

const globalComponents = {
  ...Contents,
  ...Cards
};

Object.keys(globalComponents).forEach(key =>
  Vue.component(globalComponents[key].name, globalComponents[key])
);

Vue.component('pagination', require('laravel-vue-pagination'));
