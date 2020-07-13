<template>
  <b-modal
    id="user-permissions"
    :title="`User Permissions - ${data.name}`"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <permissions-form ref="form" :data="data" />
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
import User from '@/api/user';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import PermissionsForm from './PermissionsForm';

export default {
  name: 'UserPermissions',
  components: {
    PermissionsForm
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
      const data = form.$data.user.permissions;

      this.toggleDisable();

      toastLoader('Updating Permissions...');
      const [err, res] = await to(User.updatePermissions(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.toggleDisable();
      this.close();
      toastSuccess('User permissions has been updated successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('user-permissions');
      this.disabled = false;
    }
  }
};
</script>

<style lang="scss" scoped>
#permissions-list {
  .permission-col {
    height: 20rem;
    .form-group {
      overflow-y: auto;
      height: 90%;
    }
  }
}
</style>
