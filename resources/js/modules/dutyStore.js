const dutyStore = {
    state: () => ({
            duties: null,
    }),
    mutations: {
        setDuties(state, duties) {
            state.duties = duties
        },
        removeDuties(state) {
            state.duties = null;
        },
    },
    getters: {
        getDuties(state) {
            return state.duties ?? [];
        },

        getDutiesCount(state, getters) {
            return getters.getDuties.length;
        }
    },
    actions: {
        dutiesFetched({commit}, options) {
            commit('setDuties', options);
        },
    }
};

export default dutyStore;
