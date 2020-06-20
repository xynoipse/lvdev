<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href class="brand-link" @click.prevent="dashboard">
      <img src="@/assets/img/app.png" alt="LVCMS" class="brand-image" style="opacity: .8" />
      <span class="brand-text font-weight-light">Lvdev</span>
    </a>

    <sidebar-menu />
  </aside>
</template>

<script>
import SidebarMenu from './SidebarMenu';

export default {
  name: 'Sidebar',
  components: {
    SidebarMenu
  },
  methods: {
    dashboard() {
      this.$router.push({ name: 'dashboard' });
    }
  }
};
</script>

<style lang="scss">
.nav-legacy {
  .nav-item {
    .nav-link {
      padding-left: 0.75rem;
      &:not(.active) {
        border-left: 3px solid transparent !important;
      }
    }
    .nav-treeview {
      .nav-link {
        border-left: 3px solid transparent;
      }
    }
  }
}
</style>
