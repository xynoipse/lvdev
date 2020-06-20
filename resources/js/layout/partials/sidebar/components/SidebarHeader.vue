<template>
  <li class="nav-header">{{ text }}</li>
</template>

<script>
export default {
  name: 'SidebarHeader',
  props: {
    text: { type: String, required: true }
  }
};
</script>
