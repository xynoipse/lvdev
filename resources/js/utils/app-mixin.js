/**
 * Global App Mixin
 */

import Vue from 'vue';
import store from '@/store';

Vue.mixin({
  data() {
    return {
      app: store.getters.app
    }
  },
});
