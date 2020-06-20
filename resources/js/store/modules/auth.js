import { login, logout, auth } from '@/api/auth';
import { isAuth, setAuth, removeAuth } from '@/utils/auth';
import to from '@/utils/async-await';

const state = {
  auth: false,
  id: null,
  name: null,
  roles: [],
};

const mutations = {
  SET_AUTH: (state, auth) => {
    state.auth = auth;
  },
  SET_ID: (state, id) => {
    state.id = id;
  },
  SET_NAME: (state, name) => {
    state.name = name;
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles;
  },
};

const actions = {
  // login
  login({ commit }, auth) {
    const { email, password } = auth;
    return new Promise(async (resolve, reject) => {
      const [err] = await to(login({ email: email.trim(), password }));
      if (err) return reject(err);

      setAuth('1');
      commit('SET_AUTH', isAuth());
      resolve();
    });
  },

  // get user
  user({ commit }) {
    return new Promise(async (resolve, reject) => {
      const [err, res] = await to(auth());
      if (err) return reject(err);

      const { data } = res;
      if (!data) return reject('Please login again.');
      const { id, name, role } = data;
      commit('SET_AUTH', isAuth());
      commit('SET_ID', id);
      commit('SET_NAME', name);
      commit('SET_ROLES', role);

      resolve(data);
    });
  },

  // logout
  logout({ commit }) {
    return new Promise(async (resolve, reject) => {
      const [err] = await to(logout());
      if (err) return reject(err);

      commit('SET_AUTH', false);
      commit('SET_ID', null);
      removeAuth();
      resolve();
    });
  },

  // remove auth
  resetAuth({ commit }) {
    return new Promise(resolve => {
      commit('SET_AUTH', false);
      removeAuth();
      resolve();
    });
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
