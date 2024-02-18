import { createStore, createLogger } from 'vuex';
import VuexPersistence from 'vuex-persist'
import houseStore from './modules/houseStore';

const persist = new VuexPersistence({
    key: 'vuex',
    storage: window.localStorage,
});

const debug = process.env.NODE_ENV !== 'production';


const store = createStore({
    modules: {
        house: houseStore
    },
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
    strict: debug,
    plugins: [
        persist.plugin,
        createLogger()
    ],
});

export default store;
