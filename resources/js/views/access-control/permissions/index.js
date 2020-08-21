import store from '@/store';
const app = store.getters.app;

export default [
  {
    path: 'permissions',
    name: 'permissions',
    component: () => import('./PermissionIndex'),
    meta: { title: 'Permissions', roles: [app.admin] }
  }
];
