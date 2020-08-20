<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <navbar-nav>
      <nav-item>
        <nav-link data-widget="pushmenu" role="button" @click="toggleSidebar">
          <i class="fas fa-bars"></i>
        </nav-link>
      </nav-item>
    </navbar-nav>

    <navbar-nav class="ml-auto">
      <nav-item dropdown class="user-menu">
        <nav-link dropdown data-toggle="dropdown">
          <img
            src="@/assets/img/profile.png"
            class="user-image img-circle elevation-2"
            alt="Profile"
          />
          <span class="d-none d-md-inline">{{ name }}</span>
        </nav-link>
        <dropdown-menu right>
          <user-header variant="primary">
            <img src="@/assets/img/profile.png" class="img-circle elevation-2" alt="Profile" />
            <p>
              <span>{{ name }}</span>
              <small>{{ role }}</small>
            </p>
          </user-header>
          <user-footer>
            <b-button :to="{ name: 'profile' }" variant="default" class="btn-flat">Profile</b-button>
            <b-button variant="default" class="btn-flat float-right" @click="logout">Log out</b-button>
          </user-footer>
        </dropdown-menu>
      </nav-item>
    </navbar-nav>
  </nav>
</template>

<script>
import { auth } from '@/api/auth';
import to from '@/utils/async-await';
import eventBus from '@/utils/event-bus.js';
import { DropdownMenu } from '@/components/dropdown';
import * as NavbarComponents from './components';

export default {
  name: 'Navbar',
  components: {
    DropdownMenu,
    ...NavbarComponents,
  },
  data() {
    return {
      name: null,
      role: null,
    };
  },
  methods: {
    async logout() {
      await to(this.$store.dispatch('user/logout'));
      this.$router.push({ name: 'login' });
    },
    async getUser() {
      const name = this.$store.getters.user.name;
      const role = this.$store.getters.user.roles;
      this.name = name;
      this.role = role[0].replace(/^\w/, (c) => c.toUpperCase());
    },
    toggleSidebar() {
      this.$store.dispatch('app/toggleSidebar');
    },
    setSidebarStatus() {
      const sidebarStatus = this.$store.getters.app.sidebar.status;
      if (sidebarStatus == 0) {
        document.body.classList.add('sidebar-collapse');
      }
    },
  },
  created() {
    this.getUser();
    this.setSidebarStatus();

    eventBus.$on('updateProfile', () => {
      this.getUser();
    });
  },
};
</script>

<style lang="scss" scoped>
.dropdown-menu {
  width: 230px !important;
}
.user-header {
  height: auto !important;
  img {
    height: 75px !important;
    width: 75px !important;
  }
  p {
    margin-bottom: 0;
  }
}
</style>
