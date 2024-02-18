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
    actions: {
        housesFetched({commit}, options) {
            commit('setHouses', options);
        },
    }
};

export default houseStore;
