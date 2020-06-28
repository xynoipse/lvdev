<template>
  <b-table :fields="fields" :items="data" :busy="busy" striped hover responsive>
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions">
        <b-button variant="primary" size="sm" v-b-modal.user-edit @click="edit(row)">
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
import to from '@/utils/async-await';
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
    edit(row) {
      const user = row.item;
      this.$emit('edit', user);
    },
    async destroy(row, target) {
      const { index, item } = row;

      const res = await alertConfirm('Delete User?', 'This is irreversible!');

      if (res.value) {
        disableRow(target);
        toastLoader('Deleting User...');

        const [err] = await to(UserResource.destroy(item.id));
        if (!err) {
          this.$emit('onChange');
          this.data.splice(index, 1);
          toastSuccess('User successfully deleted');
        }
        enableRow(target);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.table-responsive {
  margin-bottom: 0;
}
.btn-actions {
  display: flex;
  justify-content: flex-end;
  .btn {
    width: 4.5rem;
    &:first-child {
      margin-right: 5px;
    }
  }
}
</style>
