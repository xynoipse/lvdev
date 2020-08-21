import store from '@/store';

const app = store.getters.app;
const user = store.getters.user;

export default {
  inserted(el, binding, vnode) {
    const { value } = binding;

    if (value && value instanceof Array && value.length > 0) {
      const requiredPermissions = value;
      const roles = user.roles;
      const permissions = user.permissions;
      const superadmin = roles.includes(app.superadmin);
      const admin = roles.includes(app.admin);

      const hasPermission = permissions.some(permission => {
        return requiredPermissions.includes(permission);
      });

      if (!superadmin && !admin && !hasPermission) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Permissions are required! Example: v-permission="['view posts', 'create posts']"`);
    }
  },
};
