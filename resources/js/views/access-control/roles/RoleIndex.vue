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
      <b-card no-body>
        <b-card-header>
          <b-card-title title="Role List" />
        </b-card-header>
        <b-card-body class="p-0">
          <role-table :data="data.data" :busy="loading" @onChange="reloadData" @edit="editRole" />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getRoles" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Role from '@/api/role';
import { hasRole } from '@/utils/role-permission';
import { role } from '@/directives';
import * as RolesComponents from './components';

export default {
  components: {
    ...RolesComponents
  },
  directives: { role },
  data() {
    return {
      data: {},
      role: {},
      page: 1,
      loading: true
    };
  },
  methods: {
    async getRoles(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await Role.list(query);
      this.page = page;
      this.data = data;
      this.loading = false;
    },
    async reloadData() {
      const res = await Role.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.data = res;
    },
    editRole(e) {
      this.role = e;
    },
    hasRole
  },
  mounted() {
    this.getRoles();
  }
};
</script>
