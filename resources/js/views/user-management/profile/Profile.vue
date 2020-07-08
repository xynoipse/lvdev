<template>
  <content-wrapper>
    <content-header title="User Profile" parent="User Management" />
    <content-body>
      <b-row>
        <b-col md="3">
          <profile-info />
        </b-col>
        <b-col md="9">
          <profile-tab />
        </b-col>
      </b-row>
    </content-body>
  </content-wrapper>
</template>

<script>
import * as ProfileComponents from './components';

export default {
  components: {
    ...ProfileComponents
  }
};
</script>
