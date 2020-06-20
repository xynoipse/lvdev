<template>
  <div class="sidebar">
    <nav class="mt-2">
      <b-nav pills class="nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu">
        <slot></slot>
      </b-nav>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'SidebarContainer'
};
</script>
