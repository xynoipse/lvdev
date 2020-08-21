import store from '@/store';
const app = store.getters.app;

export default [
  {
    path: 'users',
    name: 'users',
    component: () => import('./UserIndex'),
    meta: { title: 'All Users', roles: [app.admin] }
  }
];
