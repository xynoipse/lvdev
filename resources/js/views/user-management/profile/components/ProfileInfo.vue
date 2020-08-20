<template>
  <b-card class="card-primary card-outline" no-body>
    <div class="card-body box-profile">
      <div class="text-center">
        <img
          class="profile-user-img img-fluid img-circle"
          src="@/assets/img/profile.png"
          alt="User profile picture"
        />
      </div>

      <h3 class="profile-username text-center">{{ user.name }}</h3>
      <p class="text-muted text-center">{{ user.role }}</p>
    </div>
  </b-card>
</template>

<script>
import { auth } from '@/api/auth';
import to from '@/utils/async-await';
import eventBus from '@/utils/event-bus.js';

export default {
  name: 'ProfileInfo',
  data() {
    return {
      user: {
        name: null,
        role: null,
      },
    };
  },
  methods: {
    getUser() {
      const user = this.$store.getters.user;
      this.user.name = user.name;
      this.user.role = user.roles[0].replace(/^\w/, (c) => c.toUpperCase());
    },
  },
  mounted() {
    this.getUser();

    eventBus.$on('updateProfile', () => {
      this.getUser();
    });
  },
};
</script>
