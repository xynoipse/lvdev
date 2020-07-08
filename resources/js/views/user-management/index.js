import userRoutes from './user';
import profileRoutes from './profile';

const userManagementRoutes = [];
export default userManagementRoutes.concat(
  userRoutes,
  profileRoutes
);
