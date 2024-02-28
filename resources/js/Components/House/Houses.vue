<script setup>
    import { BModal } from 'bootstrap-vue-next';
    import Repeater from "../Partials/Form/Repeater.vue";
</script>

<template>
    <div class="d-md-flex justify-content-md-end" style="height: 75px">
        <button class="btn btn-outline-primary btn-lg" style="height: fit-content" @click="addHouse()"><i class="fa-solid fa-plus"></i> Add House</button>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody v-if="this.$store.getters.getHousesCount > 0">
                <tr v-for="house in this.$store.getters.getHouses" :key="house.id">
                    <td>{{ house.id }}</td>
                    <td>{{ house.name }}</td>
                    <td>{{ house.owner }}</td>
                    <td>
                        <button class="btn btn-outline-primary me-2" @click="editHouse(house.id)"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-outline-danger" @click="deleteHouse(house.id)"><i class="fa-regular fa-trash-can"></i> Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center">No houses found</td>
                </tr>
            </tbody>
        </table>
    </div>
    <BModal v-model="modal" title="House" :hideFooter="true">
        <form @submit.prevent="onSubmit" >
            <h3>House Form</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="houseForm.name">
            </div>
            <h3>Invite people to your house</h3>
            <span class="text-muted mb-1">Invite people to your house by his nickname's</span>
            <div class="mb-3">
                <Repeater :fields="houseForm.users" />
                <!-- Repeater input for invited users nickname -->
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </BModal>
</template>

<script>
import {ref} from "vue";

export default {
    mounted() {
        this.fetchHouses();
    },

    data() {
        return {
            modal: ref(false),
            houseForm: {
                id: null,
                name: '',
                users: [{ value: '' }],
                isEdit: false,
            }
        };
    },

    methods: {
        fetchHouses() {
            axios.get('/api/houses')
                .then(response => {
                    this.$store.commit('setHouses', response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        deleteHouse(id) {
            axios.delete(`/api/houses/${id}`)
                .then(response => {
                    this.$store.commit('setHouses', response.data);
                    this.$store.dispatch('persist');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        editHouse(id) {
            //Open modal and fetch house data
            axios.get(`/api/houses/${id}`)
                .then(response => {
                    this.houseForm.id = response.data.house.id;
                    this.houseForm.name = response.data.house.name;
                    this.houseForm.users = response.data.users;
                    this.houseForm.isEdit = true;
                })
                .catch(error => {
                    console.error(error);
                });
            this.modal = true;
        },
        addHouse() {
            this.modal = true;
            this.houseForm.name = '';
            this.houseForm.users = [{ value: '' }];
            this.houseForm.isEdit = false;
            // this.houseForm.users = response.data.users;
            //Open modal
        },
        onSubmit() {
            //Transform request data
            const users = this.houseForm.users.map(user => user.value);

            const transformedRequestData = {
                name: this.houseForm.name,
                users: users,
            };
            //Submit form
            if (this.houseForm.isEdit) {
                axios.put(`/api/houses/${this.houseForm.id}`, transformedRequestData)
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setHouses', response.data);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/api/houses', transformedRequestData)
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setHouses', response.data);
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
        },
    },
};
</script>
