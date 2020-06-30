import store from '@/store';

export default {
  inserted(el, binding, vnode) {
    const { value } = binding;

    if (value && value instanceof Array && value.length > 0) {
      const roles = store.getters && store.getters.roles;
      const permissions = store.getters && store.getters.permissions;
      const superAdmin = roles.includes('superadmin');
      const admin = roles.includes('admin');

      const requiredPermissions = value;
      const hasPermission = permissions.some(permission => {
        return requiredPermissions.includes(permission);
      });

      if (!superAdmin && !admin && !hasPermission) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Permissions are required! Example: v-permission="['view posts','create posts']"`);
    }
  },
};
