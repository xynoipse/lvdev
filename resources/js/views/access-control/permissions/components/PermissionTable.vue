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

    <template v-slot:cell(actions)="row" v-if="hasRole([app.masteradmin])">
      <div class="btn-actions">
        <b-button variant="primary" size="sm" v-b-modal.permission-edit @click="edit(row)">
          <i class="fas fa-pencil-alt"></i>
          Edit
        </b-button>
        <b-button variant="danger" size="sm" @click="destroy(row, $event.target)">
          <i class="fas fa-trash"></i>
          Delete
        </b-button>
      </div>
    </template>
  </b-table>
</template>

<script>
import { role } from '@/directives';
import { hasRole } from '@/utils/role-permission';

export default {
  name: 'PermissionTable',
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
        { key: 'actions', label: '', class: 'actions' },
      ],
      selected: [],
      allSelected: false,
    };
  },
  methods: {
    edit(row) {
      const permission = row.item;
      this.$emit('update:edit', permission);
    },
    destroy(row) {
      const permission = row.item;
      this.$emit('delete', permission);
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
