import store from '@/store';
const app = store.getters.app;

export default [
  {
    path: 'roles',
    name: 'roles',
    component: () => import('./RoleIndex'),
    meta: { title: 'Roles', roles: [app.admin] }
  }
];
