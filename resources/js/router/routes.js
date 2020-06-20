import Layout from '@/layout';

import dashboardRoutes from '@/views/dashboard';
import userManagementRoutes from '@/views/user-management';
import accessControlRoutes from '@/views/access-control';

const routes = [
  {
    path: '/app/login',
    name: 'login',
    component: () => import('@/views/auth/Login'),
    meta: { title: 'Login' }
  },
  {
    path: '/app',
    component: Layout,
    redirect: { name: 'dashboard' },
    children: [
      ...dashboardRoutes,
      ...userManagementRoutes,
      ...accessControlRoutes
    ]
  }
];

export default routes;
