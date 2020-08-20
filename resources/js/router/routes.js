import Layout from '@/layout';

import dashboard from '@/views/dashboard';
import userManagement from '@/views/user-management';
import accessControl from '@/views/access-control';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/auth/Login'),
    meta: { title: 'Login' }
  },
  {
    path: '/',
    component: Layout,
    redirect: { name: 'dashboard' },
    children: [
      ...dashboard,
      ...userManagement,
      ...accessControl
    ]
  }
];

export default routes;
