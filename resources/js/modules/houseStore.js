const houseStore = {
    state: () => ({
            houses: null,
            pickedHouse: null,
    }),
    mutations: {
        setHouses(state, options) {
            state.houses = options.houses
            state.pickedHouse = options.pickedHouse;
        },
        removeHouses(state) {
            state.houses = null;
            state.pickedHouse = null;
        },
    },
    getters: {
        getHouses(state) {
            return state.houses;
        },

        getHousesCount(state, getters) {
            return getters.getHouses.length;
        }
    },
    actions: {
        housesFetched({commit}, options) {
            commit('setHouses', options);
        },
    }
};

export default houseStore;
