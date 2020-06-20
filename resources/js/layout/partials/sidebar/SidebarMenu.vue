<template>
  <sidebar-container>
    <sidebar-item text="Dashboard" :to="{ name: 'dashboard' }" icon="fas fa-tachometer-alt"></sidebar-item>

    <sidebar-header text="System" />
    <sidebar-dropdown text="User Management" icon="fas fa-users-cog">
      <sidebar-item text="Users" :to="{ name: 'users' }" icon="fas fa-users" exact></sidebar-item>
    </sidebar-dropdown>
    <sidebar-dropdown text="Access Control" icon="fas fa-user-lock">
      <sidebar-item text="Roles" :to="{ name: 'roles' }" icon="fas fa-briefcase"></sidebar-item>
      <sidebar-item text="Permissions" :to="{ name: 'permissions' }" icon="fas fa-unlock-alt"></sidebar-item>
    </sidebar-dropdown>
  </sidebar-container>
</template>

<script>
import { Treeview } from 'admin-lte';
import * as SidebarComponents from './components';

export default {
  name: 'SidebarMenu',
  components: {
    ...SidebarComponents
  },
  data() {
    return {
      treeview: null
    };
  },
  created() {
    this.treeview = this.$store.getters.sidebar.treeview;
  },
  mounted() {
    if (this.treeview) {
      $('ul[data-widget="treeview"]').Treeview('init');
    }
  },
  beforeDestroy() {
    this.$store.dispatch('app/setTreeview', false);
  }
};
</script>
