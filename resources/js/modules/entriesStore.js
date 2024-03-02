const entryStore = {
    state: () => ({
            entries: [],
    }),
    mutations: {
        setEntries(state, entries) {
            state.entries = entries || [];
        },
        removeEntries(state) {
            state.entries = [];
        },
    },
    getters: {
        getEntries(state) {
            return state.entries;
        },

        getEntriesCount(state, getters) {
            return getters.getEntries.length;
        }
    },
    actions: {
        entriesFetched({commit}, options) {
            commit('setEntries', options);
        },
    }
};

export default entryStore;
