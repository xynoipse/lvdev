<template>
  <li class="nav-item">
    <router-link :to="to" class="nav-link" :exact="exact">
      <i :class="['nav-icon', icon]"></i>
      <p>{{ text }}</p>
    </router-link>
  </li>
</template>

<script>
export default {
  name: 'SidebarItem',
  props: {
    text: { type: String, required: true },
    to: { type: Object, required: true },
    icon: { type: String, default: 'fas fa-thumbtack' },
    exact: { type: Boolean, default: false }
  }
};
</script>
