<template>
  <b-modal
    id="user-create"
    title="Create User"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="store">
      <user-form ref="form" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Add User</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import User from '@/api/user';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import UserForm from './UserForm';

export default {
  name: 'UserCreate',
  components: {
    UserForm
  },
  data() {
    return {
      disabled: false
    };
  },
  methods: {
    async store() {
      const form = this.$refs.form;
      const data = form.$data.user;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Creating User...');
      const [err, res] = await to(User.store(data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('store');
      this.toggleDisable();
      this.close();
      toastSuccess('User has been created successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('user-create');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    }
  }
};
</script>
