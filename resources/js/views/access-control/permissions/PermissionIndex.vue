<template>
  <content-wrapper v-role="[app.admin]">
    <content-header title="Permissions" parent="User Management">
      <div v-if="hasRole([app.masteradmin])">
        <permission-create @store="reloadData" />
        <permission-edit :data="permission" @update="reloadData" />
      </div>
    </content-header>
    <content-body>
      <b-row>
        <b-col sm="6">
          <b-button
            variant="primary"
            v-b-modal.permission-create
            v-role="[app.masteradmin]"
          >Add Permission</b-button>
        </b-col>

        <b-col sm="6">
          <b-form id="search-box" class="mt-sm-0 mt-2" @submit.prevent="getPermissions">
            <b-input-group>
              <b-form-input v-model="filter.search" placeholder="Search" />
              <b-input-group-append>
                <b-button type="submit" variant="default">
                  <i class="fas fa-search"></i>
                </b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form>
        </b-col>
      </b-row>

      <div id="filters"></div>

      <b-card class="w-100 mb-2" no-body>
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

      <b-button
        size="sm"
        variant="danger"
        :disabled="!actions.selected.length"
        v-role="[app.masteradmin]"
        @click="deleteSelected"
      >
        <i class="fas fa-trash"></i>
        <span>Delete Selected</span>
      </b-button>

      <pagination :data="permissions" @pagination-change-page="getPermissions" :limit="2" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Permission from '@/api/access/permission';
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
      const res = await Permission.list({ page: this.page });
      if (res.data.length === 0 && this.page > 1) {
        this.page--;
        this.reloadData();
      }
      this.clearTable();
      this.permissions = res;
    },
    async deletePermission(permission) {
      const id = permission.id;

      const res = await alertConfirm(
        'Delete Permission?',
        'This is irreversible!'
      );

      if (res.value) {
        toastLoader('Deleting Permission...');

        const index = this.permissions.data.findIndex(
          (permission) => permission.id == id
        );
        const permission = this.permissions.data[index];
        permission.status = 'deleting';
        this.permissions.data.splice(index, 1, permission);

        const [err] = await to(Permission.destroy(id));
        if (!err) {
          this.reloadData();
          this.permissions.data.splice(index, 1);
          toastSuccess('Permission has been deleted successfully');
        }
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

        const ids = this.actions.selected;
        console.log(ids);

        this.permissions.data.map((permission, index) => {
          if (ids.includes(permission.id)) {
            permission.status = 'deleting';
            this.permissions.data.splice(index, 1, permission);
          }
        });

        const [err] = await to(Permission.massDestroy(ids));
        if (!err) {
          this.reloadData();
          toastSuccess('Permission/s has been deleted successfully');
        }
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
