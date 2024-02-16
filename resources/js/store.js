import { createStore } from 'vuex';
import VuexPersistence from 'vuex-persist'

const persist = new VuexPersistence({
    key: 'vuex',
    storage: window.localStorage,
});

const store = createStore({
    state: {
            isLoggedIn: false,
            user: null,
    },
    mutations: {
        setUser(state, user) {
            state.user = Object.assign({}, state.user, user);
            state.isLoggedIn = !!user;
        },
        removeUser(state) {
            state.user = null;
            state.isLoggedIn = false;
        },
    },
    actions: {
        userLoggedIn({commit}, user) {
            commit('setUser', user);
        },
    },
    plugins: [
        persist.plugin,
    ],
});

export default store;
