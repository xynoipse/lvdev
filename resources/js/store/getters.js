const getters = {
  // auth getters
  auth: state => state.auth.auth,
  id: state => state.auth.id,
  name: state => state.auth.name,
  roles: state => state.auth.roles,
  permissions: state => state.auth.permissions,

  // app getters
  sidebar: state => state.app.sidebar,
};

export default getters;
