<template>
  <li :class="['user-header', `bg-${variant}`]">
    <slot></slot>
  </li>
</template>

<script>
export default {
  name: 'UserHeader',
  props: {
    variant: { type: String, default: 'primary' }
  }
};
</script>
