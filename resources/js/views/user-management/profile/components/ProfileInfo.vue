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
import { EventBus } from '@/utils/event-bus.js';

export default {
  name: 'ProfileCard',
  data() {
    return {
      user: {
        name: null,
        role: null
      }
    };
  },
  methods: {
    getUser() {
      const name = this.$store.getters.name;
      const role = this.$store.getters.roles;
      this.user.name = name;
      this.user.role = role[0].replace(/^\w/, c => c.toUpperCase());
    }
  },
  mounted() {
    this.getUser();

    EventBus.$on('updateProfile', () => {
      this.getUser();
    });
  }
};
</script>
