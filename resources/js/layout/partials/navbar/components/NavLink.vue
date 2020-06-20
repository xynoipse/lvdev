<template>
  <a href="#" :class="['nav-link', {'dropdown-toggle': dropdown}]" @click="$emit('click')">
    <slot></slot>
  </a>
</template>

<script>
export default {
  name: 'NavLink',
  props: {
    dropdown: { type: Boolean, default: false }
  }
};
</script>
