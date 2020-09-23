<template>
  <b-modal
    id="permission-create"
    title="Create Permission"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="store">
      <permission-form ref="form" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Add Permission</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import Permission from '@/api/access/permission';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import PermissionForm from './forms/PermissionForm';

export default {
  name: 'PermissionCreate',
  components: {
    PermissionForm,
  },
  data() {
    return {
      disabled: false,
    };
  },
  methods: {
    async store() {
      const form = this.$refs.form;
      const data = form.$data.permission;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Creating Permission...');
      const [err, res] = await to(Permission.store(data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('store');
      this.toggleDisable();
      this.close();
      toastSuccess('Permission has been created successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('permission-create');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    },
  },
};
</script>
