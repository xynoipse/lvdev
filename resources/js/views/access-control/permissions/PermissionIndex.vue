<template>
  <content-wrapper v-role="['admin']">
    <content-header title="Permissions" parent="User Management">
      <div v-if="hasRole(['superadmin'])">
        <b-button variant="primary" v-b-modal.permission-create>Add Permission</b-button>
        <permission-create @store="reloadData" />
        <permission-edit :data="permission" @update="reloadData" />
      </div>
    </content-header>
    <content-body>
      <b-form id="search-box" @submit.prevent="getPermissions">
        <b-input-group>
          <b-form-input v-model="filter.search" placeholder="Search" />
          <b-input-group-append>
            <b-button type="submit" variant="default">
              <i class="fas fa-search"></i>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-form>

      <div id="table-nav">
        <b-button
          variant="danger"
          :disabled="!actions.selected.length"
          v-role="['superadmin']"
          @click="deleteSelected"
        >
          <i class="fas fa-trash"></i>
          <span>Delete Selected</span>
        </b-button>
      </div>

      <b-card class="w-100" no-body>
        <b-card-header>
          <b-card-title title="Permission List" />
        </b-card-header>

        <b-card-body class="p-0">
          <permission-table
            :data="permissions.data"
            :busy="loading"
            :select.sync="actions.selected"
            :edit.sync="permission"
            @delete="deletePermission"
            ref="table"
          />
        </b-card-body>
      </b-card>
      <pagination
        :data="permissions"
        @pagination-change-page="getPermissions"
        :limit="4"
        align="center"
      />
    </content-body>
  </content-wrapper>
</template>

<script>
import Permission from '@/api/permission';
import { role } from '@/directives';
import to from '@/utils/async-await';
import { hasRole } from '@/utils/role-permission';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import * as PermissionsComponents from './components';

export default {
  components: {
    ...PermissionsComponents,
  },
  directives: { role },
  data() {
    return {
      permissions: {},
      permission: {},
      page: 1,
      loading: true,
      actions: {
        selected: [],
      },
      filter: {
        search: null,
      },
    };
  },
  methods: {
    async getPermissions(page = 1) {
      this.clearTable();
      this.loading = true;
      const query = { page, search: this.filter.search };
      const data = await Permission.list(query);
      this.page = page;
      this.permissions = data;
      this.loading = false;
    },
    async reloadData() {
      this.clearTable();
      const res = await Permission.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.permissions = res;
    },
    async deletePermission(permission) {
      const res = await alertConfirm(
        'Delete Permission?',
        'This is irreversible!'
      );

      if (res.value) {
        toastLoader('Deleting Permission...');

        let permissions = this.permissions.data;
        Object.values(permissions).forEach(async (item, index) => {
          if (item.id === permission.id) {
            item.status = 'deleting';
            this.permissions.data.splice(index, 1, item);

            const [err] = await to(Permission.destroy(permission.id));
            if (!err) {
              this.reloadData();
              this.permissions.data.splice(index, 1);
              toastSuccess('Permission has been deleted successfully');
            }
          }
        });
      }
    },
    async deleteSelected() {
      if (!this.actions.selected.length) return;

      const res = await alertConfirm(
        'Delete All Selected Permission/s?',
        'This is irreversible!'
      );

      if (res.value) {
        toastLoader('Deleting Permission/s...');

        let permissions = this.permissions.data;
        await Object.values(permissions).forEach(async (permission, index) => {
          if (this.actions.selected.includes(permission.id)) {
            permission.status = 'deleting';
            this.permissions.data.splice(index, 1, permission);

            const [err] = await to(Permission.destroy(permission.id));
            if (!err) {
              this.permissions.data.splice(index, 1);
              this.actions.selected.shift();
            }
            if (!this.actions.selected.length) {
              this.reloadData();
              toastSuccess('Permission/s has been deleted successfully');
            }
          }
        });
      }
    },
    clearTable() {
      this.actions.selected = [];
      if (this.$refs.table) {
        this.$refs.table.allSelected = false;
        this.$refs.table.selected = [];
      }
    },
    hasRole,
  },
  mounted() {
    this.getPermissions();
  },
};
</script>
