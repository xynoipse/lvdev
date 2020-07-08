<template>
  <sidebar-container>
    <sidebar-item text="Dashboard" :to="{ name: 'dashboard' }" icon="fas fa-tachometer-alt" />

    <sidebar-header text="System" />
    <sidebar-dropdown text="User Management" icon="fas fa-users-cog">
      <sidebar-item text="Users" :to="{ name: 'users' }" icon="fas fa-users" exact />
      <sidebar-item text="Profile" :to="{ name: 'profile' }" icon="fas fa-user-alt" exact />
    </sidebar-dropdown>
    <sidebar-dropdown v-role="['admin']" text="Access Control" icon="fas fa-user-lock">
      <sidebar-item text="Roles" :to="{ name: 'roles' }" icon="fas fa-briefcase" />
      <sidebar-item text="Permissions" :to="{ name: 'permissions' }" icon="fas fa-unlock-alt" />
    </sidebar-dropdown>
  </sidebar-container>
</template>

<script>
import { Treeview } from 'admin-lte';
import { role, permission } from '@/directives';
import * as SidebarComponents from './components';

export default {
  name: 'SidebarMenu',
  components: {
    ...SidebarComponents
  },
  directives: { role, permission },
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
