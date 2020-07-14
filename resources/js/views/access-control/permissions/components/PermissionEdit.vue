<template>
  <b-modal
    id="permission-edit"
    title="Edit Permission"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="update">
      <permission-form ref="form" :data="data" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Update Permission</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import Permission from '@/api/permission';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import PermissionForm from './PermissionForm';

export default {
  name: 'PermissionEdit',
  components: {
    PermissionForm
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
      const data = form.$data.permission;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Updating Permission...');
      const [err, res] = await to(Permission.update(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('update');
      this.toggleDisable();
      this.close();
      toastSuccess('Permission has been updated successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('permission-edit');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    }
  }
};
</script>
