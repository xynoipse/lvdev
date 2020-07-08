<template>
  <div class="wrapper">
    <navbar />
    <sidebar />
    <router-view />
    <main-footer />
  </div>
</template>

<script>
import { Layout } from 'admin-lte';
import * as Partials from './partials';

export default {
  name: 'Layout',
  components: {
    ...Partials
  },
  mounted() {
    $('body').Layout('init');
  }
};
</script>
