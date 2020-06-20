<template>
  <li :class="['nav-item', {'dropdown': dropdown}]">
    <slot></slot>
  </li>
</template>

<script>
export default {
  name: 'NavItem',
  props: {
    dropdown: { type: Boolean, default: false }
  }
};
</script>
