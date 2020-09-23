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
      <user-form ref="form" :data="data" nopwd />
      <div id="modal-btn">
        <b-button :disabled="disabled" @click="close">Cancel</b-button>
        <b-button type="submit" variant="primary" :disabled="disabled">Update User</b-button>
      </div>
    </form>
  </b-modal>
</template>

<script>
import User from '@/api/access/user';
import to from '@/utils/async-await';
import { toastLoader, toastSuccess } from '@/utils/alert';
import UserForm from './forms/UserForm';

export default {
  name: 'UserEdit',
  components: {
    UserForm,
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

      toastLoader('Updating User...');
      const [err, res] = await to(User.update(id, data));
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
    },
  },
};
</script>
