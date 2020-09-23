<template>
  <b-modal
    id="user-password"
    :title="`Change Password - ${data.name}`"
    :no-close-on-backdrop="disabled"
    :no-close-on-esc="disabled"
    hide-header-close
    hide-footer
    centered
  >
    <form @submit.stop.prevent="update">
      <password-form ref="form" />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Update Password</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import User from '@/api/access/user';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import PasswordForm from './forms/PasswordForm';

export default {
  name: 'UserPassword',
  components: {
    PasswordForm,
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
      const data = form.$data.user;

      form.clearErrors();
      this.toggleDisable();

      toastLoader('Updating Password...');
      const [err, res] = await to(User.updatePassword(id, data));
      if (err) {
        form.$data.errors = err.response.data.errors;
        return this.toggleDisable();
      }

      this.$emit('update');
      this.toggleDisable();
      this.close();
      toastSuccess('Changed password successfully');
    },
    toggleDisable() {
      this.disabled = !this.disabled;
      this.$refs.form.toggleLoading();
    },
    close() {
      this.$bvModal.hide('user-password');
      this.disabled = false;
      this.$refs.form.clearErrors();
      this.$refs.form.clearInput();
    },
  },
};
</script>
