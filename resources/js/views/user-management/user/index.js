export default [
  {
    path: 'users',
    name: 'users',
    component: () => import('./UserIndex'),
    meta: { title: 'All Users' }
  }
];
