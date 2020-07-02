<template>
  <b-table :fields="fields" :items="data" :busy="busy" striped hover responsive>
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions" v-role="['admin']">
        <b-button variant="primary" size="sm" v-b-modal.user-edit @click="edit(row)">
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button
          variant="info"
          size="sm"
          v-if="!row.item.role.includes('admin')"
          v-b-modal.user-permissions
          @click="edit(row)"
        >
          <i class="fas fa-pencil-alt"></i>
          Permissions
        </b-button>
        <b-button
          v-role="['superadmin']"
          variant="danger"
          size="sm"
          @click="destroy(row, $event.target)"
        >
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
import { role } from '@/directives';

export default {
  name: 'UsersTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  directives: { role },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Name' },
        { key: 'email', label: 'Email' },
        { key: 'role[0]', label: 'Role' },
        { key: 'actions', label: '', class: 'actions' }
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
          toastSuccess('User has been deleted successfully');
        }
        enableRow(target);
      }
    }
  }
};
</script>
