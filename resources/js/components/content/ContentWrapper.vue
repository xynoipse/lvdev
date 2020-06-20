<template>
  <div class="content-wrapper">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'ContentWrapper'
};
</script>

<style scoped>
.content-wrapper {
  min-height: calc(100vh - (6.3rem + 2px));
}
</style>
