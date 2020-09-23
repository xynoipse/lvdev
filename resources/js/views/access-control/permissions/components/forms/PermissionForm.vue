<template>
  <div id="permission-form">
    <b-form-group label="Permission Name" label-for="name">
      <b-form-input
        id="name"
        autocomplete="name"
        placeholder="Permission Name"
        v-model="permission.name"
        :class="{ 'is-invalid': errors.name }"
        @input="clearErrors('name')"
        autofocus
      />
      <span v-if="errors.name" class="invalid-feedback" role="alert">
        <strong v-text="errors.name[0]"></strong>
      </span>
    </b-form-group>

    <b-overlay :show="loading" no-wrap />
  </div>
</template>

<script>
import Permission from '@/api/access/permission';
import to from '@/utils/async-await';

export default {
  name: 'PermissionForm',
  props: {
    data: { type: Object },
  },
  data() {
    return {
      permission: {
        name: null,
      },
      loading: true,
      errors: {},
    };
  },
  methods: {
    async getPermission() {
      const id = this.data ? this.data.id : null;

      if (id) {
        let [err, res] = await to(Permission.get(id));
        const { name } = res.data;
        this.permission.name = name;
      }

      this.toggleLoading();
    },
    toggleLoading() {
      this.loading = !this.loading;
    },
    clearInput() {
      Object.keys(this.permission).forEach((key) => {
        this.permission[key] = null;
      });
    },
    clearErrors(field = null) {
      if (field) return (this.errors[field] = null);
      this.errors = {};
    },
  },
  mounted() {
    this.getPermission();
  },
};
</script>
