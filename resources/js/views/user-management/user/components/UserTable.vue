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
      <b-form-checkbox v-model="allSelected" @change="toggleAll" />
    </template>

    <template v-slot:cell(selected)="row">
      <b-form-checkbox v-model="selected" :value="row.item.id" />
    </template>

    <template v-slot:cell(actions)="row">
      <div class="btn-actions" v-role="['admin']">
        <b-button variant="primary" size="sm" v-b-modal.user-edit @click="edit(row)">
          <i class="fas fa-pencil-alt"></i>
          <span>Edit</span>
        </b-button>
        <b-button
          variant="info"
          size="sm"
          v-if="!row.item.role.includes('admin')"
          v-b-modal.user-permissions
          @click="edit(row)"
        >
          <i class="fas fa-pencil-alt"></i>
          <span>Permissions</span>
        </b-button>
        <b-button v-role="['superadmin']" variant="danger" size="sm" @click="destroy(row)">
          <i class="fas fa-trash"></i>
          <span>Delete</span>
        </b-button>
      </div>
    </template>
  </b-table>
</template>

<script>
import { role } from '@/directives';

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
