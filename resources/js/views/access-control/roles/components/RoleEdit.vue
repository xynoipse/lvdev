<template>
  <b-modal
    id="role-edit"
    title="Edit Role"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="update">
      <role-form ref="form" :data="data" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Update Role</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import Role from '@/api/access/role';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import RoleForm from './forms/RoleForm';

export default {
  name: 'RoleEdit',
  components: {
    RoleForm,
  },
  props: {
    data: {},
  },
  data() {
    return {
      disabled: false,
    };
  },
  methods: {
    async update() {
      const form = this.$refs.form;
      const id = this.data.id;
      const data = form.$data.role;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Updating Role...');
      const [err, res] = await to(Role.update(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('update');
      this.toggleDisable();
      this.close();
      toastSuccess('Role has been updated successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('role-edit');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    },
  },
};
</script>
