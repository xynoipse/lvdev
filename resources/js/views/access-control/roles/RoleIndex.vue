<template>
  <content-wrapper v-role="['admin']">
    <content-header title="Roles" parent="Access Control">
      <div v-if="hasRole(['superadmin'])">
        <b-button variant="primary" v-b-modal.role-create>Add Role</b-button>
        <role-create @store="reloadData" />
        <role-edit :data="role" @update="reloadData" />
      </div>
      <role-permissions :data="role" @update="reloadData" />
    </content-header>
    <content-body>
      <b-form id="search-box" @submit.prevent="getRoles">
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
          <b-card-title title="Role List" />
        </b-card-header>

        <b-card-body class="p-0">
          <role-table
            :data="roles.data"
            :busy="loading"
            :select.sync="actions.selected"
            :edit.sync="role"
            @delete="deleteRole"
            ref="table"
          />
        </b-card-body>
      </b-card>

      <pagination :data="roles" @pagination-change-page="getRoles" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Role from '@/api/role';
import { role } from '@/directives';
import to from '@/utils/async-await';
import { hasRole } from '@/utils/role-permission';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import * as RolesComponents from './components';

export default {
  components: {
    ...RolesComponents,
  },
  directives: { role },
  data() {
    return {
      roles: {},
      role: {},
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
    async getRoles(page = 1) {
      this.clearTable();
      this.loading = true;
      const query = { page, search: this.filter.search };
      const data = await Role.list(query);
      this.page = page;
      this.roles = data;
      this.loading = false;
    },
    async reloadData() {
      this.clearTable();
      const res = await Role.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.roles = res;
    },
    async deleteRole(role) {
      const res = await alertConfirm('Delete Role?', 'This is irreversible!');

      if (res.value) {
        toastLoader('Deleting Role...');

        let roles = this.roles.data;
        Object.values(roles).forEach(async (item, index) => {
          if (item.id === role.id) {
            item.status = 'deleting';
            this.roles.data.splice(index, 1, item);

            const [err] = await to(Role.destroy(role.id));
            if (!err) {
              this.reloadData();
              this.roles.data.splice(index, 1);
              toastSuccess('Role has been deleted successfully');
            }
          }
        });
      }
    },
    async deleteSelected() {
      if (!this.actions.selected.length) return;

      const res = await alertConfirm(
        'Delete All Selected Role/s?',
        'This is irreversible!'
      );

      if (res.value) {
        toastLoader('Deleting Role/s...');

        let roles = this.roles.data;
        await Object.values(roles).forEach(async (role, index) => {
          if (this.actions.selected.includes(role.id)) {
            role.status = 'deleting';
            this.roles.data.splice(index, 1, role);

            const [err] = await to(Role.destroy(role.id));
            if (!err) {
              this.roles.data.splice(index, 1);
              this.actions.selected.shift();
            }
            if (!this.actions.selected.length) {
              this.reloadData();
              toastSuccess('Role/s has been deleted successfully');
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
    this.getRoles();
  },
};
</script>
