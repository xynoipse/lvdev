<template>
  <b-modal
    id="user-edit"
    :title="`Edit User - ${data.name}`"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="update">
      <user-form ref="form" :data="data" :resetpwd="resetPassword" :nopwd="!resetPassword" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Update User</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import UserResource from '@/api/user';
import to from '@/utils/async-await';
import { hasRole } from '@/utils/role-permission';
import { toastLoader, toastSuccess } from '@/utils/alert';
import UserForm from './UserForm';

export default {
  name: 'UserEdit',
  components: {
    UserForm
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
      const data = form.$data.user;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Updating User...');
      const [err, res] = await to(UserResource.update(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('update');
      this.toggleDisable();
      this.close();
      toastSuccess('User has been updated successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('user-edit');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    }
  },
  computed: {
    resetPassword() {
      return hasRole(['superadmin']);
    }
  }
};
</script>

<style lang="scss" scoped>
#modal-btn {
  display: flex;
  justify-content: flex-end;
  padding-top: 0.5rem;
  .btn:first-child {
    margin-right: 0.5rem;
  }
}
</style>
