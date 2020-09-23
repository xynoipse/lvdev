<template>
  <b-modal
    id="role-create"
    title="Create Role"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="store">
      <role-form ref="form" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Add Role</b-button>
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
  name: 'RoleCreate',
  components: {
    RoleForm,
  },
  data() {
    return {
      disabled: false,
    };
  },
  methods: {
    async store() {
      const form = this.$refs.form;
      const data = form.$data.role;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Creating Role...');
      const [err, res] = await to(Role.store(data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('store');
      this.toggleDisable();
      this.close();
      toastSuccess('Role has been created successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('role-create');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    },
  },
};
</script>
