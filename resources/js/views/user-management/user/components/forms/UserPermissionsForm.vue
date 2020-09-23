<template>
  <b-row id="user-permissions-form">
    <b-col cols="6" class="permission-col">
      <h5>Role Permissions</h5>
      <b-form-group>
        <b-form-checkbox-group
          id="role-permissions"
          v-model="role.selected"
          :options="role.permissions"
          stacked
          disabled
        />
      </b-form-group>
    </b-col>
    <b-col cols="6" class="permission-col">
      <h5>Permissions</h5>
      <b-form-group>
        <b-form-checkbox-group
          id="permissions"
          v-model="user.permissions"
          :options="permissions"
          stacked
        />
      </b-form-group>
    </b-col>
    <b-overlay :show="loading" no-wrap />
  </b-row>
</template>

<script>
import { User, Permission } from '@/api/access';
import to from '@/utils/async-await';

export default {
  name: 'UserPermissionsForm',
  props: {
    data: { type: Object },
  },
  data() {
    return {
      user: {
        permissions: [],
      },
      role: {
        permissions: [],
        selected: [],
      },
      permissions: [],
      loading: true,
    };
  },
  methods: {
    async getRolePermissions() {
      const [err, res] = await to(User.permissions(this.data.id));

      res.data.role.forEach((permission) => {
        const { name: value, name: text } = permission;
        this.role.permissions.push({ value, text });
        this.role.selected.push(permission.name);
      });

      res.data.user.forEach((permission) => {
        this.user.permissions.push(permission.name);
      });

      this.getPermissions();
    },
    async getPermissions() {
      const [err, res] = await to(Permission.list());

      res.data.forEach((permissions) => {
        const { name: value, name: text } = permissions;
        if (!this.role.selected.includes(permissions.name))
          this.permissions.push({ value, text });
      });

      this.toggleLoading();
    },
    toggleLoading() {
      this.loading = !this.loading;
    },
  },
  mounted() {
    this.getRolePermissions();
  },
};
</script>

<style lang="scss" scoped>
#user-permissions-form {
  .permission-col {
    height: auto;
    max-height: 20rem;
    #role-permissions,
    #permissions {
      overflow-y: auto;
      max-height: 18rem;
    }
  }
}
</style>
