<template>
  <content-wrapper>
    <content-header title="Users" parent="User Management">
      <div v-if="hasRole([app.admin])">
        <user-create @store="reloadData" />
        <user-edit :data="user" @update="reloadData" />
        <user-permissions :data="user" />
        <user-password :data="user" v-role="[app.masteradmin]" />
      </div>
    </content-header>
    <content-body>
      <b-row>
        <b-col sm="6">
          <b-button variant="primary" v-b-modal.user-create v-role="[app.admin]">Add User</b-button>
        </b-col>

        <b-col sm="6">
          <b-form id="search-box" class="mt-sm-0 mt-2" @submit.prevent="getUsers">
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

      <div id="filters">
        <b-form-select size="sm" v-model="filter.role" :options="filter.roles" @change="getUsers" />
      </div>

      <b-card class="w-100 mb-2" no-body>
        <b-card-header>
          <b-card-title title="User List" />
        </b-card-header>

        <b-card-body class="p-0">
          <user-table
            :data="users.data"
            :busy="loading"
            :select.sync="actions.selected"
            :edit.sync="user"
            @delete="deleteUser"
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
      <pagination :data="users" @pagination-change-page="getUsers" :limit="2" />
    </content-body>
  </content-wrapper>
</template>

<script>
import { User, Role } from '@/api/access';
import { role } from '@/directives';
import to from '@/utils/async-await';
import { hasRole } from '@/utils/role-permission';
import { alertConfirm, toastLoader, toastSuccess } from '@/utils/alert';
import * as UsersComponents from './components';

export default {
  components: {
    ...UsersComponents,
  },
  directives: { role },
  data() {
    return {
      users: {},
      user: {},
      page: 1,
      loading: true,
      actions: {
        selected: [],
      },
      filter: {
        search: null,
        roles: [{ value: null, text: 'All roles' }],
        role: null,
      },
    };
  },
  methods: {
    async getUsers(page = 1) {
      this.clearTable();
      this.loading = true;
      const query = {
        page,
        search: this.filter.search,
        role: this.filter.role,
      };
      const data = await User.list(query);
      this.page = page;
      this.users = data;
      this.loading = false;
    },
    async reloadData() {
      const res = await User.list({ page: this.page });
      if (res.data.length === 0 && this.page > 1) {
        this.page--;
        this.reloadData();
      }
      this.clearTable();
      this.users = res;
    },
    async getRoles() {
      const [err, res] = await to(Role.list());

      res.data.forEach((role) => {
        const { name: value, name: text } = role;
        this.filter.roles.push({ value, text });
      });
    },
    async deleteUser(user) {
      const id = user.id;
      const res = await alertConfirm('Delete User?', 'This is irreversible!');

      if (res.value) {
        toastLoader('Deleting User...');

        const index = this.users.data.findIndex((user) => user.id == id);
        const user = this.users.data[index];
        user.status = 'deleting';
        this.users.data.splice(index, 1, user);

        const [err] = await to(User.destroy(id));
        if (!err) {
          this.reloadData();
          this.users.data.splice(index, 1);
          toastSuccess('User has been deleted successfully');
        }
      }
    },
    async deleteSelected() {
      if (!this.actions.selected.length) return;

      const res = await alertConfirm(
        'Delete All Selected User/s?',
        'This is irreversible!'
      );

      if (res.value) {
        toastLoader('Deleting User/s...');

        const ids = this.actions.selected;
        console.log(ids);

        this.users.data.map((user, index) => {
          if (ids.includes(user.id)) {
            user.status = 'deleting';
            this.users.data.splice(index, 1, user);
          }
        });

        const [err] = await to(User.massDestroy(ids));
        if (!err) {
          this.reloadData();
          toastSuccess('User/s has been deleted successfully');
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
  created() {
    this.getUsers();
    this.getRoles();
  },
};
</script>
