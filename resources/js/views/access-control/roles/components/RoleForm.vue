<template>
  <div id="role-form">
    <b-form-group v-if="!noname" label="Role Name" label-for="name">
      <b-form-input
        id="name"
        autocomplete="name"
        placeholder="Role Name"
        v-model="role.name"
        :class="{ 'is-invalid': errors.name }"
        @input="clearErrors('name')"
      />
      <span v-if="errors.name" class="invalid-feedback" role="alert">
        <strong v-text="errors.name[0]"></strong>
      </span>
    </b-form-group>

    <b-form-group label="Permissions" label-for="permissions">
      <div class="permissions-form" :class="{ 'is-invalid': errors.permissions }">
        <b-form-checkbox-group
          id="permissions"
          v-model="role.permissions"
          :options="permissions"
          stacked
        />
      </div>
      <span v-if="errors.permissions" class="invalid-feedback" role="alert">
        <strong v-text="errors.permissions[0]"></strong>
      </span>
    </b-form-group>

    <b-overlay :show="loading" no-wrap />
  </div>
</template>

<script>
import Role from '@/api/role';
import Permission from '@/api/permission';
import to from '@/utils/async-await';

export default {
  name: 'RoleForm',
  props: {
    data: { type: Object },
    noname: { type: Boolean, default: false }
  },
  data() {
    return {
      role: {
        name: null,
        permissions: []
      },
      permissions: [],
      loading: true,
      errors: {}
    };
  },
  methods: {
    async getRole() {
      const id = this.data ? this.data.id : null;

      if (id) {
        let [err, res] = await to(Role.get(id));
        const { name } = res.data;
        this.role.name = name;

        this.getRolePermissions();
      }

      this.getPermissions();
    },
    async getRolePermissions() {
      let [err, res] = await to(Role.permissions(this.data.id));

      res.data.forEach(permission => {
        this.role.permissions.push(permission.name);
      });
    },
    async getPermissions() {
      const [err, res] = await to(Permission.list());

      res.data.forEach(permissions => {
        const { name: value, name: text } = permissions;
        this.permissions.push({ value, text });
      });

      this.toggleLoading();
    },
    toggleLoading() {
      this.loading = !this.loading;
    },
    clearInput() {
      Object.keys(this.role).forEach(key => {
        this.role[key] = null;
      });
    },
    clearErrors(field = null) {
      if (field) return (this.errors[field] = null);
      this.errors = {};
    }
  },
  mounted() {
    this.getRole();
  }
};
</script>

<style lang="scss" scoped>
#role-form {
  .permissions-form {
    height: auto;
    overflow-y: auto;
    max-height: 10.05rem;
    #permissions {
      column-count: 2;
    }
  }
}
</style>
