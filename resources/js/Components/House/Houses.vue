<script setup>
    import { BModal } from 'bootstrap-vue-next';
</script>

<template>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-outline-primary" @click="addHouse()">Add House</button>
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
            <tbody v-if="this.$store.state.house.houses.length > 0">
                <tr v-for="house in this.$store.state.house.houses" :key="house.id">
                    <td>{{ house.id }}</td>
                    <td>{{ house.name }}</td>
                    <td>{{ house.owner }}</td>
                    <td>
                        <button class="btn btn-outline-primary" @click="editHouse(house.id)">Edit</button>
<!--                        <button class="btn btn-outline-primary" @click="onPickHouse(house.id)">Pick</button>-->
<!--                        <button class="btn btn-outline-primary" @click="onPickHouse(house.id)">Delete</button>-->
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
                users: [],
                isEdit: false,
            }
        };
    },

    methods: {
        fetchHouses() {
            axios.get('/houses')
                .then(response => {
                    this.$store.commit('setHouses', response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        editHouse(id) {
            //Open modal and fetch house data
            axios.get(`/houses/${id}`)
                .then(response => {
                    this.houseForm.id = response.data.house.id;
                    this.houseForm.name = response.data.house.name;
                    this.houseForm.users = response.data.house.users;
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
            this.houseForm.isEdit = false;
            // this.houseForm.users = response.data.users;
            //Open modal
        },
        onSubmit() {
            //Submit form
            if (this.houseForm.isEdit) {
                axios.put(`/houses/${this.houseForm.id}`, { name: this.houseForm.name })
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setHouses', response.data);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/houses', { name: this.houseForm.name })
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
        }
    },
};
</script>
