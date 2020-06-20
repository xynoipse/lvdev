import Cookies from 'js-cookie';

const state = {
  sidebar: {
    status: Cookies.get('sidebarStatus') ? !!+Cookies.get('sidebarStatus') : true,
    treeview: true
  },
};

const mutations = {
  TOGGLE_SIDEBAR: state => {
    state.sidebar.status = !state.sidebar.status;
    if (state.sidebar.status) {
      Cookies.set('sidebarStatus', 1);
    } else {
      Cookies.set('sidebarStatus', 0);
    }
  },
  SET_TREEVIEW: (state, treeview) => state.sidebar.treeview = treeview,
};

const actions = {
  toggleSidebar({ commit }) {
    commit('TOGGLE_SIDEBAR');
  },
  setTreeview({ commit }, treeview) {
    commit('SET_TREEVIEW', treeview);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
