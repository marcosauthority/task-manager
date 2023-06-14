import { createStore } from 'vuex'

const store = createStore({
  state: {
    token: localStorage.getItem('token') || null,
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token);
    },
    clearToken(state) {
      state.token = null;
      localStorage.removeItem('token');
    },
  },
  actions: {
    logout({ commit }) {
      commit('clearToken');
      router.push({ name: 'Login' });
    },
  },
  getters: {
    token: state => state.token,
  },
})

export default store
