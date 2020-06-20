<template>
  <b-table striped hover :fields="fields" :items="data" :busy="busy">
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions">
        <b-button variant="primary" size="sm" @click="edit">
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button variant="danger" size="sm" @click="destroy(row, $event.target)">
          <i class="fas fa-trash"></i>
          Delete
        </b-button>
      </div>
    </template>
  </b-table>
</template>

<script>
import UserResource from '@/api/user';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import { enableRow, disableRow } from '@/utils/row';

export default {
  name: 'UsersTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Name' },
        { key: 'email', label: 'Email' },
        { key: 'role[0]', label: 'Role' },
        { key: 'actions', label: '' }
      ]
    };
  },
  methods: {
    async edit() {},
    async destroy(row, target) {
      const { index, item } = row;

      const res = await alertConfirm('Delete User?', 'This is irreversible!');

      if (res.value) {
        disableRow(target);
        toastLoader('Deleting User...');

        const res = await UserResource.destroy(item.id);
        this.$emit('onChange');
        this.data.splice(index, 1);
        toastSuccess('User successfully deleted');
        enableRow(target);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-actions {
  float: right;
}
</style>
