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
      <b-card no-body>
        <b-card-header>
          <b-card-title title="User List" />
        </b-card-header>
        <b-card-body class="p-0">
          <user-table :data="data.data" :busy="loading" @onChange="reloadData" @edit="editUser" />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getUsers" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import User from '@/api/user';
import { role } from '@/directives';
import * as UsersComponents from './components';

export default {
  components: {
    ...UsersComponents
  },
  directives: { role },
  data() {
    return {
      data: {},
      user: {},
      page: 1,
      loading: true
    };
  },
  methods: {
    async getUsers(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await User.list(query);
      this.page = page;
      this.data = data;
      this.loading = false;
    },
    async reloadData() {
      const res = await User.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.data = res;
    },
    editUser(e) {
      this.user = e;
    }
  },
  created() {
    this.getUsers();
  }
};
</script>
