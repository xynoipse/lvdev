import store from '@/store';

const app = store.getters.app;
const user = store.getters.user;

/**
 * @param {Array} value
 * @returns {Boolean}
 */
export function hasRole(value) {
  if (value && value instanceof Array && value.length > 0) {
    const requiredRoles = value;
    const [roles] = getUserAccess(user);
    let [superadmin, admin] = isRoleAdmin(roles);

    if (requiredRoles.includes(app.superadmin)) admin = false;
    if (superadmin || admin) return true;

    const hasRole = roles.some(role => {
      return requiredRoles.includes(role);
    });

    return hasRole;
  } else {
    console.error(`Need roles! Like hasRole(['admin', 'user'])`);
    return false;
  }
}

/**
 * @param {Array} value
 * @returns {Boolean}
 */
export function hasPermission(value) {
  if (value && value instanceof Array && value.length > 0) {
    const requiredPermissions = value;
    const [roles, permissions] = getUserAccess(user);
    const [superadmin, admin] = isRoleAdmin(roles);

    if (superadmin || admin) return true;

    const hasPermission = permissions.some(permission => {
      return requiredPermissions.includes(permission);
    });

    return hasPermission;
  } else {
    console.error(`Need permissions! Like hasPermission(['view posts', 'create posts'])`);
    return false;
  }
}

function getUserAccess(user) {
  const roles = user.roles;
  const permissions = user.permissions;

  return [roles, permissions];
}

function isRoleAdmin(roles) {
  const superadmin = roles.includes(app.superadmin);
  const admin = roles.includes(app.admin);

  return [superadmin, admin];
}
