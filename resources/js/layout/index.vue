<template>
  <div class="wrapper">
    <navbar />
    <sidebar />
    <router-view />
    <main-footer />
  </div>
</template>

<script>
import * as Partials from './partials';

export default {
  name: 'Layout',
  components: {
    ...Partials
  }
};
</script>
