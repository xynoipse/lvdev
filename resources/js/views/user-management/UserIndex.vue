<template>
  <content-wrapper>
    <content-header title="Users" parent="User Management">
      <b-button variant="primary" v-b-modal.user-create>Add User</b-button>
    </content-header>
    <content-body>
      <b-card no-body>
        <b-card-header>
          <b-card-title title="User List" />
        </b-card-header>
        <b-card-body class="p-0">
          <user-table :data="data.data" :busy="loading" @onChange="reloadData" />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getUsers" :limit="4" align="center" />
      <user-create />
    </content-body>
  </content-wrapper>
</template>

<script>
import UserResource from '@/api/user';
import * as UsersComponents from './components';

export default {
  components: {
    ...UsersComponents
  },
  data() {
    return {
      data: {},
      page: 1,
      loading: true
    };
  },
  methods: {
    async getUsers(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await UserResource.list(query);
      this.page = page;
      this.data = data;
      this.loading = false;
    },
    async reloadData() {
      const res = await UserResource.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.data = res;
    }
  },
  created() {
    this.getUsers();
  }
};
</script>
