import store from '@/store';

const app = store.getters.app;
const user = store.getters.user;

export default {
  inserted(el, binding, vnode) {
    const { value } = binding;

    if (value && value instanceof Array && value.length > 0) {
      const requiredRoles = value;
      const roles = user.roles;
      const superadmin = roles.includes(app.superadmin);
      let admin = roles.includes(app.admin);

      if (requiredRoles.includes(app.superadmin)) admin = false

      const hasRole = roles.some(role => {
        return requiredRoles.includes(role);
      });

      if (!superadmin && !admin && !hasRole) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    } else {
      throw new Error(`Roles are required! Example: v-role="['admin', 'user']"`);
    }
  },
};
