const roomStore = {
    state: () => ({
            rooms: [],
    }),
    mutations: {
        setRooms(state, rooms) {
            state.rooms = rooms || [];
        },
        removeRooms(state) {
            state.rooms = [];
        },
    },
    getters: {
        getRooms(state) {
            return state.rooms;
        },

        getRoomsCount(state, getters) {
            return getters.getRooms.length;
        }
    },
    actions: {
        roomsFetched({commit}, options) {
            commit('setRooms', options);
        },
    }
};

export default roomStore;
