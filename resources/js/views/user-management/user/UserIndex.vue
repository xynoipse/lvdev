<template>
  <content-wrapper>
    <content-header title="Users" parent="User Management">
      <div v-role="['admin']">
        <b-button variant="primary" v-b-modal.user-create>Add User</b-button>
        <user-create @store="reloadData" />
        <user-edit :data="user" @update="reloadData" />
        <user-permissions :data="user" />
      </div>
    </content-header>
    <content-body>
      <b-form id="search-box" @submit.prevent="getUsers">
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

        <b-form-select v-model="filter.role" :options="filter.roles" @change="getUsers" />
      </div>

      <b-card class="w-100" no-body>
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

      <pagination :data="users" @pagination-change-page="getUsers" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import { User, Role } from '@/api';
import { role } from '@/directives';
import to from '@/utils/async-await';
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
        roles: [{ value: null, text: 'All Roles' }],
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
      this.clearTable();
      const res = await User.list({ page: this.page });
      if (res.data.length === 0 && this.page > 1) {
        this.page--;
        this.reloadData();
      }
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
      const res = await alertConfirm('Delete User?', 'This is irreversible!');
      if (res.value) {
        toastLoader('Deleting User...');

        let users = this.users.data;
        Object.values(users).forEach(async (item, index) => {
          if (item.id === user.id) {
            item.status = 'deleting';
            this.users.data.splice(index, 1, item);

            const [err] = await to(User.destroy(user.id));
            if (!err) {
              this.reloadData();
              this.users.data.splice(index, 1);
              toastSuccess('User has been deleted successfully');
            }
          }
        });
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

        let users = this.users.data;
        await Object.values(users).forEach(async (user, index) => {
          if (this.actions.selected.includes(user.id)) {
            user.status = 'deleting';
            this.users.data.splice(index, 1, user);

            const [err] = await to(User.destroy(user.id));
            if (!err) {
              this.users.data.splice(index, 1);
              this.actions.selected.shift();
            }
            if (!this.actions.selected.length) {
              this.reloadData();
              toastSuccess('User/s has been deleted successfully');
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
  },
  created() {
    this.getUsers();
    this.getRoles();
  },
};
</script>
