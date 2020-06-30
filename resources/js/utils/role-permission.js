import store from '@/store';

/**
 * @param {Array} value
 * @returns {Boolean}
 */
export function hasRole(value) {
  if (value && value instanceof Array && value.length > 0) {
    const roles = store.getters && store.getters.roles;
    const superAdmin = roles.includes('superadmin');
    let admin = roles.includes('admin');

    const requiredRoles = value;
    const hasRole = roles.some(role => {
      return requiredRoles.includes(role);
    });

    if (requiredRoles.includes('superadmin')) admin = false;

    if (superAdmin || admin) return true;

    return hasRole;
  } else {
    console.error(`Need roles! Like hasRole(['admin','user'])`);
    return false;
  }
}

/**
 * @param {Array} value
 * @returns {Boolean}
 */
export function hasPermission(value) {
  if (value && value instanceof Array && value.length > 0) {
    const roles = store.getters && store.getters.roles;
    const permissions = store.getters && store.getters.permissions;
    const superAdmin = roles.includes('superadmin');
    const admin = roles.includes('admin');

    const requiredPermissions = value;
    const hasPermission = permissions.some(permission => {
      return requiredPermissions.includes(permission);
    });

    if (superAdmin || admin) return true;

    return hasPermission;
  } else {
    console.error(`Need permissions! Like hasPermission(['view posts','create posts'])`);
    return false;
  }
}
