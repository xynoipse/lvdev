<template>
  <content-wrapper v-role="['admin']">
    <content-header title="Permissions" parent="User Management">
      <div v-if="hasRole(['superadmin'])">
        <b-button variant="primary" v-b-modal.permission-create>Add Permission</b-button>
        <permission-create @store="reloadData" />
        <permission-edit :data="permission" @update="reloadData" />
      </div>
    </content-header>
    <content-body>
      <b-card no-body>
        <b-card-header>
          <b-card-title title="Permission List" />
        </b-card-header>
        <b-card-body class="p-0">
          <permission-table
            :data="data.data"
            :busy="loading"
            @onChange="reloadData"
            @edit="editPermission"
          />
        </b-card-body>
      </b-card>
      <pagination :data="data" @pagination-change-page="getPermissions" :limit="4" align="center" />
    </content-body>
  </content-wrapper>
</template>

<script>
import Permission from '@/api/permission';
import { hasRole } from '@/utils/role-permission';
import { role } from '@/directives';
import * as PermissionsComponents from './components';

export default {
  components: {
    ...PermissionsComponents
  },
  directives: { role },
  data() {
    return {
      data: {},
      permission: {},
      page: 1,
      loading: true
    };
  },
  methods: {
    async getPermissions(page = 1) {
      this.loading = true;
      const query = { page };
      const data = await Permission.list(query);
      this.page = page;
      this.data = data;
      this.loading = false;
    },
    async reloadData() {
      const res = await Permission.list({ page: this.page });
      if (res.data.length === 0) {
        this.page--;
        this.reloadData();
      }
      this.data = res;
    },
    editPermission(e) {
      this.permission = e;
    },
    hasRole
  },
  mounted() {
    this.getPermissions();
  }
};
</script>
