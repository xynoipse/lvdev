<template>
  <div>
    <b-form-group label="Password" label-for="password">
      <password
        size="24"
        v-model="user.password"
        :error="{ 'is-invalid': errors.password }"
        @input="clearErrors('password')"
      >
        <span v-if="errors.password" class="invalid-feedback" role="alert">
          <strong v-text="errors.password[0]"></strong>
        </span>
      </password>
    </b-form-group>

    <b-form-group label="Confirm Password" label-for="password_confirmation">
      <b-form-input
        type="password"
        autocomplete="password"
        placeholder="Confirm Password"
        v-model="user.password_confirmation"
      />
    </b-form-group>

    <b-overlay :show="loading" no-wrap />
  </div>
</template>

<script>
import User from '@/api/access/user';
import { Password } from '@/components/password';
import to from '@/utils/async-await';

export default {
  name: 'UserForm',
  components: {
    Password,
  },
  data() {
    return {
      user: {
        password: null,
        password_confirmation: null,
      },
      loading: true,
      errors: {},
    };
  },
  methods: {
    toggleLoading() {
      this.loading = !this.loading;
    },
    clearInput() {
      Object.keys(this.user).forEach((key) => {
        this.user[key] = null;
      });
    },
    clearErrors(field = null) {
      if (field) return (this.errors[field] = null);
      this.errors = {};
    },
  },
  mounted() {
    this.toggleLoading();
  },
};
</script>
