<template>
  <b-modal
    id="role-permissions"
    :title="`Edit Permissions - ${data.name}`"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <role-form ref="form" :data="data" noname />
    <div id="modal-btn">
      <b-button :disabled="disabled" @click="close">Cancel</b-button>
      <b-button
        type="submit"
        variant="primary"
        :disabled="disabled"
        @click="update"
      >Update Permissions</b-button>
    </div>
  </b-modal>
</template>

<script>
import Role from '@/api/role';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import RoleForm from './RoleForm';

export default {
  name: 'RolePermissions',
  components: {
    RoleForm
  },
  props: {
    data: {}
  },
  data() {
    return {
      disabled: false
    };
  },
  methods: {
    async update() {
      const form = this.$refs.form;
      const id = this.data.id;
      const data = form.$data.role.permissions;

      this.toggleDisable();

      toastLoader('Updating Permissions...');
      const [err, res] = await to(Role.updatePermissions(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('update');
      this.toggleDisable();
      this.close();
      toastSuccess('Role permissions has been updated successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('role-permissions');
      this.disabled = false;
    }
  }
};
</script>
