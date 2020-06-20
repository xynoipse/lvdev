<template>
  <b-table striped hover :fields="fields" :items="data" :busy="busy">
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
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
  name: 'PermissionsTable',
  props: {
    data: { type: Array },
    busy: { default: true }
  },
  data() {
    return {
      fields: [
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Name' },
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
</style>
