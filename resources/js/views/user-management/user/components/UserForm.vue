<template>
  <div>
    <b-form-group label="Role" label-for="role">
      <b-form-select
        autofocus
        v-model="user.role"
        :options="roles"
        :class="{ 'is-invalid': errors.role }"
        @input="clearErrors('role')"
      >
        <template v-slot:first>
          <b-form-select-option :value="null" disabled>-- Please select a role --</b-form-select-option>
        </template>
      </b-form-select>
      <span v-if="errors.role" class="invalid-feedback" role="alert">
        <strong v-text="errors.role[0]"></strong>
      </span>
    </b-form-group>

    <b-form-group label="Name" label-for="name">
      <b-form-input
        id="name"
        autocomplete="name"
        placeholder="Name"
        v-model="user.name"
        :class="{ 'is-invalid': errors.name }"
        @input="clearErrors('name')"
      />
      <span v-if="errors.name" class="invalid-feedback" role="alert">
        <strong v-text="errors.name[0]"></strong>
      </span>
    </b-form-group>

    <b-form-group label="Email Address" label-for="email">
      <b-form-input
        id="email"
        type="email"
        autocomplete="email"
        placeholder="Email Address"
        v-model="user.email"
        :class="{ 'is-invalid': errors.email }"
        @input="clearErrors('email')"
      />
      <span v-if="errors.email" class="invalid-feedback" role="alert">
        <strong v-text="errors.email[0]"></strong>
      </span>
    </b-form-group>

    <b-form-group v-if="!nopwd" label="Password" label-for="password">
      <password
        size="24"
        v-if="!password"
        v-model="user.password"
        :error="{ 'is-invalid': errors.password }"
        @input="clearErrors('password')"
      >
        <b-button v-if="resetpwd" variant="outline-danger" class="ml-1" @click="resetPassword">
          <i class="fa fa-times-circle"></i>
          <span class="d-none d-sm-inline">Cancel</span>
        </b-button>
        <span v-if="errors.password" class="invalid-feedback" role="alert">
          <strong v-text="errors.password[0]"></strong>
        </span>
      </password>
      <b-button variant="outline-danger" v-if="password" @click="resetPassword">Reset Password</b-button>
    </b-form-group>
    <b-overlay :show="loading" no-wrap />
  </div>
</template>

<script>
import User from '@/api/user';
import Role from '@/api/role';
import to from '@/utils/async-await';
import { Password } from '@/components/password';

export default {
  name: 'UserForm',
  components: {
    Password
  },
  props: {
    data: { type: Object },
    nopwd: { type: Boolean, default: false },
    resetpwd: { type: Boolean, default: false }
  },
  data() {
    return {
      user: {
        role: null,
        name: null,
        email: null,
        password: null
      },
      roles: [],
      loading: true,
      password: this.resetpwd,
      errors: {}
    };
  },
  methods: {
    async getUser() {
      const id = this.data ? this.data.id : null;

      if (id) {
        const [err, res] = await to(User.get(id));
        const { role, name, email } = res.data;
        this.user = { role: role[0], name, email, password: null };
      }

      this.getRoles();
    },
    async getRoles() {
      const [err, res] = await to(Role.list());

      res.data.forEach(role => {
        const { name: value, name: text } = role;
        this.roles.push({ value, text });
      });

      this.toggleLoading();
    },
    resetPassword() {
      this.user.password = null;
      this.password = !this.password;
    },
    toggleLoading() {
      if (this.resetpwd && !this.user.password) this.password = true;
      this.loading = !this.loading;
    },
    clearInput() {
      Object.keys(this.user).forEach(key => {
        this.user[key] = null;
      });
    },
    clearErrors(field = null) {
      if (field) return (this.errors[field] = null);
      this.errors = {};
    }
  },
  mounted() {
    this.getUser();
  }
};
</script>
