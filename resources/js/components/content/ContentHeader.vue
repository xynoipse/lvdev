<template>
  <div class="content-header">
    <b-container fluid>
      <b-row class="mb-2">
        <b-col sm="6">
          <div class="form-inline">
            <h1 class="text-dark mr-3" v-text="title"></h1>
            <slot></slot>
          </div>
        </b-col>
        <b-col sm="6">
          <b-breadcrumb class="float-sm-right">
            <b-breadcrumb-item v-text="parent"></b-breadcrumb-item>
            <b-breadcrumb-item v-text="title" active></b-breadcrumb-item>
          </b-breadcrumb>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  name: 'ContentHeader',
  props: {
    title: { type: String },
    parent: { type: String }
  }
};
</script>
