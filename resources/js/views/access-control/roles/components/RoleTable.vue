<template>
  <b-table
    :fields="fields"
    :items="data"
    :busy="busy"
    :tbody-tr-class="rowClass"
    foot-clone
    show-empty
    striped
    hover
    responsive
  >
    <template v-slot:table-busy>
      <div class="text-center">
        <b-spinner class="align-middle"></b-spinner>
        <strong>Loading...</strong>
      </div>
    </template>

    <template v-slot:emptyfiltered="scope">
      <h4>{{ scope.emptyFilteredText }}</h4>
    </template>

    <template v-slot:head(selected)>
      <b-form-checkbox v-model="allSelected" v-role="[app.superadmin]" @change="toggleAll" />
    </template>

    <template v-slot:cell(selected)="row">
      <b-form-checkbox
        v-model="selected"
        :value="row.item.id"
        v-if="row.item.id > 2"
        v-role="[app.superadmin]"
      />
    </template>

    <template v-slot:cell(permissions)="data">
      <b-badge
        variant="info"
        v-for="(permission,index) in data.item.permissions"
        :key="index"
      >{{ permission }}</b-badge>
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions" v-if="row.item.id > 2">
        <b-button
          v-role="[app.superadmin]"
          variant="primary"
          size="sm"
          v-b-modal.role-edit
          @click="edit(row)"
        >
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button
          variant="info"
          size="sm"
          v-role="[app.admin]"
          v-if="!hasRole([app.superadmin])"
          v-b-modal.role-permissions
          @click="edit(row)"
        >
          <i class="fas fa-pencil-alt"></i>
          Permissions
        </b-button>
        <b-button
          v-role="[app.superadmin]"
          variant="danger"
          size="sm"
          @click="destroy(row, $event.target)"
        >
          <i class="fas fa-trash"></i>
          Delete
        </b-button>
      </div>
    </template>
  </b-table>
</template>

<script>
import { hasRole } from '@/utils/role-permission';
import { role } from '@/directives';

export default {
  name: 'RoleTable',
  props: {
    data: { type: Array },
    busy: { default: true },
  },
  directives: { role },
  data() {
    return {
      fields: [
        { key: 'selected', label: '', class: 'select' },
        { key: 'name', label: 'Name', sortable: true },
        { key: 'permissions', label: 'Permissions' },
        { key: 'actions', label: '', class: 'actions' },
      ],
      selected: [],
      allSelected: false,
    };
  },
  methods: {
    edit(row) {
      const role = row.item;
      this.$emit('update:edit', role);
    },
    destroy(row) {
      const role = row.item;
      this.$emit('delete', role);
    },
    toggleAll(checked) {
      if (!checked) return (this.selected = []);

      this.data.forEach((item) => {
        if (!this.selected.includes(item.id) && item.id > 2) {
          this.selected.push(item.id);
        }
      });
    },
    rowClass(item) {
      if (!item) return;
      if (item.status === 'deleting')
        return 'text-muted table-danger table-disabled';
    },
    hasRole,
  },
  watch: {
    selected(newVal, oldVal) {
      this.$emit('update:select', this.selected);

      this.allSelected = false;
      if (this.data) {
        if (this.data.length > 1 && newVal.length === this.data.length - 1)
          this.allSelected = true;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.badge {
  color: #fff;
  margin-right: 5px;
  font-size: 12px;
}
</style>
