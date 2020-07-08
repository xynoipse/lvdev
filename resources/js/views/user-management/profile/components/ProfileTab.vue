<template>
  <b-card no-body>
    <b-tabs pills card>
      <b-tab title="Account" active>
        <form class="form-horizontal" @submit.prevent="updateProfile">
          <b-form-group label="Name" label-cols-sm="2" label-for="name">
            <b-form-input id="name" v-model="user.name" autocomplete="name" placeholder="Name" />
          </b-form-group>
          <b-form-group label="Email" label-cols-sm="2" label-for="email">
            <b-form-input id="email" v-model="user.email" autocomplete="email" placeholder="Email" />
          </b-form-group>

          <b-button type="submit" variant="primary">Update Profile</b-button>
          <b-overlay :show="loading" no-wrap />
        </form>
      </b-tab>
    </b-tabs>
  </b-card>
</template>

<script>
import { auth } from '@/api/auth';
import User from '@/api/user';
import to from '@/utils/async-await';
import { EventBus } from '@/utils/event-bus.js';
import { toastLoader, toastSuccess } from '@/utils/alert';

export default {
  name: 'ProfileTab',
  props: {
    data: { type: Array }
  },
  data() {
    return {
      user: {},
      loading: true,
      errors: {}
    };
  },
  methods: {
    async getUser() {
      const [err, res] = await to(auth());
      const { id, name, email } = res.data;
      this.user = { id, name, email };
      this.loading = false;
    },
    async updateProfile() {
      this.loading = true;
      toastLoader('Updating Profile...');

      const [err, res] = await to(User.updateProfile(this.user));
      if (err) {
        this.errors = err.response.data.errors;
        return (this.loading = false);
      }

      await to(this.$store.dispatch('auth/user'));

      EventBus.$emit('updateProfile');
      this.loading = false;
      toastSuccess('Profile has been updated successfully');
    }
  },
  mounted() {
    this.getUser();
  }
};
</script>
