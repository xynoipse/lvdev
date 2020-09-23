<template>
  <content-wrapper v-role="[app.admin]">
    <content-header title="Roles" parent="Access Control">
      <div v-if="hasRole([app.masteradmin])">
        <role-create @store="reloadData" />
        <role-edit :data="role" @update="reloadData" />
      </div>
      <role-permissions :data="role" @update="reloadData" />
    </content-header>
    <content-body>
      <b-row>
        <b-col sm="6">
          <b-button variant="primary" v-b-modal.role-create v-role="[app.masteradmin]">Add Role</b-button>
        </b-col>

        <b-col sm="6">
          <b-form id="search-box" class="mt-sm-0 mt-2" @submit.prevent="getRoles">
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

      <pagination :data="roles" @pagination-change-page="getRoles" :limit="2" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Role from '@/api/access/role';
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
      const res = await Role.list({ page: this.page });
      if (res.data.length === 0 && this.page > 1) {
        this.page--;
        this.reloadData();
      }
      this.clearTable();
      this.roles = res;
    },
    async deleteRole(role) {
      const id = role.id;
      const res = await alertConfirm('Delete Role?', 'This is irreversible!');

      if (res.value) {
        toastLoader('Deleting Role...');

        const index = this.roles.data.findIndex((role) => role.id == id);
        const role = this.roles.data[index];
        role.status = 'deleting';
        this.roles.data.splice(index, 1, role);

        const [err] = await to(Role.destroy(id));
        if (!err) {
          this.reloadData();
          this.roles.data.splice(index, 1);
          toastSuccess('Role has been deleted successfully');
        }
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

        const ids = this.actions.selected;
        console.log(ids);

        this.roles.data.map((role, index) => {
          if (ids.includes(role.id)) {
            role.status = 'deleting';
            this.roles.data.splice(index, 1, role);
          }
        });

        const [err] = await to(Role.massDestroy(ids));
        if (!err) {
          this.reloadData();
          toastSuccess('Role/s has been deleted successfully');
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
    this.getRoles();
  },
};
</script>
