<template>
  <content-wrapper>
    <content-header title="Permissions" parent="User Management">
      <b-button variant="primary">Add Permission</b-button>
    </content-header>
    <content-body>
      <b-card no-body>
        <b-card-header>
          <b-card-title title="Permission List" />
        </b-card-header>
        <b-card-body class="p-0">
          <permission-table :data="data.data" :busy="loading" />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getPermissions" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Resource from '@/utils/resource';
import PermissionTable from './components/PermissionTable';

const Permission = new Resource('permissions');

export default {
  components: {
    PermissionTable
  },
  data() {
    return {
      data: {},
      loading: true
    };
  },
  methods: {
    async getPermissions(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await Permission.list(query);
      this.data = data;
      this.loading = false;
    }
  },
  mounted() {
    this.getPermissions();
  }
};
</script>
