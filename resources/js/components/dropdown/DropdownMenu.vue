<template>
  <component :is="tag" :class="['dropdown-menu', {'dropdown-menu-right': right}]">
    <slot></slot>
  </component>
</template>

<script>
export default {
  name: 'DropdownMenu',
  props: {
    tag: { type: String, default: 'div' },
    right: { type: Boolean, default: false }
  }
};
</script>
