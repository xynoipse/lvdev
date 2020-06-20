<template>
  <component
    :is="tag"
    :class="[
      'dropdown-menu', 
      {'dropdown-header': header}, 
      {'dropdown-footer': footer}
    ]"
  >
    <slot></slot>
  </component>
</template>

<script>
export default {
  name: 'DropdownItem',
  props: {
    tag: { type: String, default: 'a' },
    header: { type: Boolean, default: false },
    footer: { type: Boolean, default: false }
  }
};
</script>
