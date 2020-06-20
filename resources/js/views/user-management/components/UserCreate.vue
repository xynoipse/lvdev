<template>
  <b-modal id="user-create" title="Create User" hide-header-close centered>
    <b-form-group label="Name" label-for="name">
      <b-form-input
        id="name"
        required
        autocomplete="name"
        autofocus
        placeholder="Name"
        v-model="user.name"
        :disabled="disabled"
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Email Address" label-for="email">
      <b-form-input
        id="email"
        type="email"
        required
        autocomplete="email"
        placeholder="Email Address"
        v-model="user.email"
        :disabled="disabled"
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Password" label-for="password">
      <b-form-input
        id="password"
        type="password"
        required
        autocomplete="new-password"
        placeholder="Password"
        v-model="user.password"
        :disabled="disabled"
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Confirm Password" label-for="password-confirm">
      <b-form-input
        id="password-confirm"
        type="password"
        required
        autocomplete="password-confirm"
        placeholder="Confirm Password"
        v-model="user.password_confirmation"
        :disabled="disabled"
      ></b-form-input>
    </b-form-group>

    <template v-slot:modal-footer="{ cancel }">
      <b-button :disabled="disabled" @click="cancel">Cancel</b-button>
      <b-button variant="primary" :disabled="disabled" @click="store">Add User</b-button>
    </template>
  </b-modal>
</template>

<script>
import UserResource from '@/api/user';
import { toastLoader, toastSuccess } from '@/utils/alert';

export default {
  name: 'UserCreate',
  data() {
    return {
      user: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      disabled: false
    };
  },
  methods: {
    store() {
      this.disabled = true;
      toastLoader('Creating User...');
      setTimeout(() => {
        toastSuccess('User successfully created!');
        this.disabled = false;
        this.clearInput();
        this.$bvModal.hide('user-create');
      }, 3000);
    },
    clearInput() {
      Object.keys(this.$data.user).forEach(key => {
        this.user[key] = null;
      });
    }
  }
};
</script>
