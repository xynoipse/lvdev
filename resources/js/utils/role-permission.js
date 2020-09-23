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
    let admin = roles.includes(app.admin);

    if (requiredRoles.includes(app.masteradmin)) admin = user.id === 1 && admin;

    const hasRole = roles.some(role => {
      return requiredRoles.includes(role);
    });

    return admin || hasRole;
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
    const admin = roles.includes(app.admin);

    const hasPermission = permissions.some(permission => {
      return requiredPermissions.includes(permission);
    });

    return admin || hasPermission;
  } else {
    console.error(`Need permissions! Like hasPermission(['view posts', 'create posts'])`);
    return false;
  }
}

function getUserAccess(user) {
  const roles = user.roles.map(role => role.toLowerCase());
  const permissions = user.permissions.map(permission => permission.toLowerCase());

  return [roles, permissions];
}
