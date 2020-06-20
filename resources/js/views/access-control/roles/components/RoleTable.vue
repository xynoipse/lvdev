<template>
  <b-table striped hover :fields="fields" :items="data" :busy="busy">
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:cell(permissions)="data">
      <b-badge
        variant="info"
        v-for="(permission,index) in data.item.permissions"
        :key="index"
      >{{ permission }}</b-badge>
    </template>

    <template v-slot:cell(actions)>
      <div class="btn-actions">
        <b-button variant="primary" size="sm" href="#">
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button variant="danger" size="sm" href="#">
          <i class="fas fa-trash"></i>
          Delete
        </b-button>
      </div>
    </template>
  </b-table>
</template>

<script>
export default {
  name: 'RoleTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Name' },
        { key: 'permissions', label: 'Permissions' },
        { key: 'actions', label: '' }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.btn-actions {
  float: right;
}
.badge {
  color: #fff;
  margin-right: 5px;
  font-size: 12px;
}
</style>
