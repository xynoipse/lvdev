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
      <b-form-checkbox v-model="allSelected" v-role="[app.masteradmin]" @change="toggleAll" />
    </template>

    <template v-slot:cell(selected)="row">
      <b-form-checkbox v-model="selected" :value="row.item.id" v-role="[app.masteradmin]" />
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions" v-role="[app.admin]">
        <b-button variant="primary" size="sm" v-b-modal.user-edit @click="edit(row)">
          <i class="fas fa-pencil-alt"></i>
          <span>Edit</span>
        </b-button>

        <b-button v-role="[app.masteradmin]" variant="danger" size="sm" @click="destroy(row)">
          <i class="fas fa-trash"></i>
          <span>Delete</span>
        </b-button>

        <b-dropdown text="More" size="sm" v-if="showMoreButton(row)">
          <b-dropdown-item
            v-if="showUpdatePermission(row)"
            v-b-modal.user-permissions
            @click="edit(row)"
          >Update Permissions</b-dropdown-item>

          <b-dropdown-item
            v-role="[app.masteradmin]"
            v-b-modal.user-password
            @click="edit(row)"
          >Change Password</b-dropdown-item>
        </b-dropdown>
      </div>
    </template>
  </b-table>
</template>

<script>
import { role } from '@/directives';
import { hasRole } from '@/utils/role-permission';

export default {
  name: 'UserTable',
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
        { key: 'email', label: 'Email', sortable: true },
        { key: 'role[0]', label: 'Role' },
        { key: 'actions', label: '', class: 'actions' },
      ],
      selected: [],
      allSelected: false,
    };
  },
  methods: {
    edit(row) {
      const user = row.item;
      this.$emit('update:edit', user);
    },
    destroy(row) {
      const user = row.item;
      this.$emit('delete', user);
    },
    toggleAll(checked) {
      if (!checked) return (this.selected = []);

      this.data.forEach((item) => {
        if (!this.selected.includes(item.id)) {
          this.selected.push(item.id);
        }
      });
    },
    rowClass(item) {
      if (!item) return;
      if (item.status === 'deleting')
        return 'text-muted table-danger table-disabled';
    },
    showUpdatePermission(row) {
      return !row.item.role.includes(this.app.admin);
    },
    showMoreButton(row) {
      return this.showUpdatePermission(row) || hasRole([this.app.masteradmin]);
    },
    hasRole,
  },
  mounted() {
    if (!hasRole([this.app.masteradmin])) this.fields.shift();
  },
  watch: {
    selected(newVal, oldVal) {
      this.$emit('update:select', this.selected);

      this.allSelected = false;
      if (this.data) {
        if (this.data.length && newVal.length === this.data.length)
          this.allSelected = true;
      }
    },
  },
};
</script>
