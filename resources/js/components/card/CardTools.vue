<template>
  <div :class="['card-tools ml-3', {'float-left': left}]">
    <div class="input-group input-group-sm">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CardTools',
  props: {
    left: { type: Boolean, default: false },
  },
};
</script>
