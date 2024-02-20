const dutyStore = {
    state: () => ({
            duties: null,
    }),
    mutations: {
        setDuties(state, options) {
            state.houses = options.houses
            state.pickedHouse = options.pickedHouse;
        },
        removeDuties(state) {
            state.houses = null;
            state.pickedHouse = null;
        },
    },
    getters: {
        getDuties(state) {
            return state.houses;
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
