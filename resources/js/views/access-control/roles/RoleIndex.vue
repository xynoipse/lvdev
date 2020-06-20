<template>
  <content-wrapper>
    <content-header title="Roles" parent="User Management">
      <b-button variant="primary">Add Role</b-button>
    </content-header>
    <content-body>
      <b-card no-body>
        <b-card-header>
          <b-card-title title="Role List" />
        </b-card-header>
        <b-card-body class="p-0">
          <role-table :data="data.data" :busy="loading" />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getRoles" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Resource from '@/utils/resource';
import RoleTable from './components/RoleTable';

const Role = new Resource('roles');

export default {
  components: {
    RoleTable
  },
  data() {
    return {
      data: {},
      loading: true
    };
  },
  methods: {
    async getRoles(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await Role.list(query);
      this.data = data;
      this.loading = false;
    }
  },
  mounted() {
    this.getRoles();
  }
};
</script>
