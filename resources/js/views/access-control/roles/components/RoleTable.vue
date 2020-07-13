<template>
  <b-table :fields="fields" :items="data" :busy="busy" striped hover responsive>
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(permissions)="data">
      <b-badge
        variant="info"
        v-for="(permission,index) in data.item.permissions"
        :key="index"
      >{{ permission }}</b-badge>
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions" v-if="row.item.id > 2">
        <b-button
          v-role="['superadmin']"
          variant="primary"
          size="sm"
          v-b-modal.role-edit
          @click="edit(row)"
        >
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button
          variant="info"
          size="sm"
          v-role="['admin']"
          v-if="!hasRole(['superadmin'])"
          v-b-modal.role-permissions
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
import Role from '@/api/role';
import to from '@/utils/async-await';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import { enableRow, disableRow } from '@/utils/row';
import { hasRole } from '@/utils/role-permission';
import { role } from '@/directives';

export default {
  name: 'RoleTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  directives: { role },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Name' },
        { key: 'permissions', label: 'Permissions' },
        { key: 'actions', label: '', class: 'actions' }
      ]
    };
  },
  methods: {
    edit(row) {
      const role = row.item;
      this.$emit('edit', role);
    },
    async destroy(row, target) {
      const { index, item } = row;

      const res = await alertConfirm('Delete Role?', 'This is irreversible!');

      if (res.value) {
        disableRow(target);
        toastLoader('Deleting Role...');

        const [err] = await to(Role.destroy(item.id));
        if (!err) {
          this.$emit('onChange');
          this.data.splice(index, 1);
          toastSuccess('Role has been deleted successfully');
        }
        enableRow(target);
      }
    },
    hasRole
  }
};
</script>

<style lang="scss" scoped>
.btn-actions {
  float: right;
}
.badge {
  color: #fff;
  margin-right: 5px;
  font-size: 12px;
}
</style>
