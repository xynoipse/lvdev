import rolesRoutes from './roles';
import permissionsRoutes from './permissions';

const accessControlRoutes = [];
export default accessControlRoutes.concat(
  rolesRoutes,
  permissionsRoutes
);
