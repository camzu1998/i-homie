<script setup>
    import { BModal, BFormSelect } from 'bootstrap-vue-next';
</script>

<template>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-outline-primary" @click="addRoom()">Add room</button>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody v-if="this.$store.getters.getRoomsCount > 0">
                <tr v-for="room in this.$store.getters.getRooms" :key="room.id">
                    <td>{{ room.id }}</td>
                    <td>{{ room.name }}</td>
                    <td>
                        <button class="btn btn-outline-primary me-2" @click="editRoom(room.id)"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-outline-danger" @click="deleteRoom(room.id)"><i class="fa-regular fa-trash-can"></i> Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center">No rooms found</td>
                </tr>
            </tbody>
        </table>
    </div>
    <BModal v-model="modal" title="Room" :hideFooter="true">
        <form @submit.prevent="onSubmit" >
            <h3>Room Form</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="roomForm.name">
            </div>
            <h3>Assign homie to room</h3>
            <span class="text-muted mb-1">Assign a homie to a room, s/he will receive notifications if the entry concerns this room</span>
            <div class="mb-3">
                <BFormSelect v-model="roomForm.user_id" :options="roomForm.users"/>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </BModal>
</template>

<script>
import {ref} from "vue";

export default {
    mounted() {
        this.fetchRooms();
    },

    data() {
        return {
            modal: ref(false),
            roomForm: {
                id: null,
                name: '',
                user_id: null,
                users: [],
                isEdit: false,
            }
        };
    },

    methods: {
        fetchRooms() {
            axios.get('/api/rooms')
                .then(response => {
                    this.$store.commit('setRooms', response.data.rooms);
                    this.roomForm.users = response.data.users;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        deleteRoom(id) {
            axios.delete(`/api/rooms/${id}`)
                .then(response => {
                    this.$store.commit('setRooms', response.data.rooms);
                    this.$store.dispatch('persist');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        editRoom(id) {
            //Open modal and fetch room data
            axios.get(`/api/rooms/${id}`)
                .then(response => {
                    this.roomForm.id = response.data.room.id;
                    this.roomForm.name = response.data.room.name;
                    this.roomForm.user_id = response.data.room.user_id;
                    this.roomForm.isEdit = true;
                })
                .catch(error => {
                    console.error(error);
                });
            this.modal = true;
        },
        addRoom() {
            this.modal = true;
            this.roomForm.name = '';
            this.roomForm.user_id = null;
            this.roomForm.isEdit = false;
            // this.roomForm.users = response.data.users;
            //Open modal
        },
        onSubmit() {
            //Submit form
            if (this.roomForm.isEdit) {
                axios.put(`/api/rooms/${this.roomForm.id}`, { name: this.roomForm.name, user_id: this.roomForm.user_id })
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setRooms', response.data.rooms);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/api/rooms', { name: this.roomForm.name, user_id: this.roomForm.user_id})
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setRooms', response.data.rooms);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            this.reload();
        },
        reload() {
            this.$forceUpdate();
        }
    },
};
</script>
