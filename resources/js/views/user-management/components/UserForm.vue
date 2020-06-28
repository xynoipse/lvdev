<template>
  <fragment>
    <b-form-group label="Role" label-for="role">
      <b-form-select
        autofocus
        v-model="user.role"
        :options="roles"
        :disabled="disabled"
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
        :disabled="disabled"
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
        :disabled="disabled"
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
        v-model="user.password"
        :disabled="disabled"
        :error="{ 'is-invalid': errors.password }"
        @input="clearErrors('password')"
      >
        <span v-if="errors.password" class="invalid-feedback" role="alert">
          <strong v-text="errors.password[0]"></strong>
        </span>
      </password>
    </b-form-group>
  </fragment>
</template>

<script>
import RoleResource from '@/api/role';
import to from '@/utils/async-await';
import { Password } from '@/components/password';

export default {
  name: 'UserForm',
  components: {
    Password
  },
  props: {
    data: { type: Object },
    nopwd: { type: Boolean, default: false }
  },
  data() {
    const data = this.data || {};
    return {
      user: {
        role: data.role ? data.role[0] : null,
        name: data.name || null,
        email: data.email || null,
        password: null
      },
      roles: [],
      disabled: false,
      errors: {}
    };
  },
  methods: {
    async getRoles() {
      const [err, res] = await to(RoleResource.list());
      res.data.forEach(role => {
        const { name: value, name: text } = role;
        this.roles.push({ value, text });
      });
    },
    toggleDisable() {
      this.disabled = !this.disabled;
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
    this.getRoles();
  }
};
</script>

<style>
</style>