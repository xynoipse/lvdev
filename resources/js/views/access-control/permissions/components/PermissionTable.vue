<template>
  <b-table :fields="fields" :items="data" :busy="busy" striped hover responsive>
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(actions)="row" v-if="hasRole(['superadmin'])">
      <div class="btn-actions">
        <b-button variant="primary" size="sm" v-b-modal.permission-edit @click="edit(row)">
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
import Permission from '@/api/permission';
import to from '@/utils/async-await';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import { enableRow, disableRow } from '@/utils/row';
import { hasRole } from '@/utils/role-permission';

export default {
  name: 'PermissionTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Name' },
        { key: 'actions', label: '', class: 'actions' }
      ]
    };
  },
  methods: {
    edit(row) {
      const permission = row.item;
      this.$emit('edit', permission);
    },
    async destroy(row, target) {
      const { index, item } = row;

      const res = await alertConfirm(
        'Delete Permission?',
        'This is irreversible!'
      );

      if (res.value) {
        disableRow(target);
        toastLoader('Deleting Permission...');

        const [err] = await to(Permission.destroy(item.id));
        if (!err) {
          this.$emit('onChange');
          this.data.splice(index, 1);
          toastSuccess('Permission has been deleted successfully');
        }
        enableRow(target);
      }
    },
    hasRole
  }
};
</script>
