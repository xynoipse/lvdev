import store from '@/store';

export default {
  inserted(el, binding, vnode) {
    const { value } = binding;

    if (value && value instanceof Array && value.length > 0) {
      const roles = store.getters && store.getters.roles;
      const superAdmin = roles.includes('superadmin');
      let admin = roles.includes('admin');

      const requiredRoles = value;
      const hasRole = roles.some(role => {
        return requiredRoles.includes(role);
      });

      if (requiredRoles.includes('superadmin')) admin = false

      if (!superAdmin && !admin && !hasRole) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Roles are required! Example: v-role="['admin','user']"`);
    }
  },
};
