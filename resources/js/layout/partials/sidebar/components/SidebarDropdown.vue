<template>
  <li class="nav-item has-treeview" :class="{ 'menu-open': menuActive }">
    <a href="#" class="nav-link" :class="{ active: menuActive }">
      <i :class="['nav-icon', icon]"></i>
      <p>
        {{ text }}
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <b-nav class="nav-treeview" v-show="menuActive">
      <slot></slot>
    </b-nav>
  </li>
</template>

<script>
export default {
  name: 'SidebarDropdown',
  props: {
    text: { type: String, required: true },
    icon: { type: String, default: 'fas fa-thumbtack' }
  },
  data() {
    return {
      items: []
    };
  },
  computed: {
    menuActive() {
      const obj = this.items;
      let menuStatus = false;
      Object.values(obj).forEach(value => {
        if (this.$route.name.includes(value)) {
          menuStatus = true;
        }
      });
      return menuStatus;
    }
  },
  mounted() {
    const obj = this.$children;
    Object.values(obj).forEach(value => {
      this.items.push(value.to.name);
    });
  }
};
</script>
