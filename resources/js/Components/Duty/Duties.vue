<script setup>
    import { BModal, BFormSelect, BFormInput } from 'bootstrap-vue-next';
</script>

<template>
    <div class="d-md-flex justify-content-md-end" style="height: 75px">
        <button class="btn btn-outline-primary btn-lg" style="height: fit-content" @click="addDuty()"><i class="fa-solid fa-plus"></i> Add duty</button>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Frequency</th>
                    <th scope="col">User</th>
                    <th scope="col">Room</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody v-if="this.$store.getters.getDutiesCount > 0">
                <tr v-for="duty in this.$store.getters.getDuties" :key="duty.id">
                    <td>{{ duty.id }}</td>
                    <td>{{ duty.name }}</td>
                    <td class="text-success" v-if="duty.status == 'active'">
                        <i class="fa-solid fa-check"></i> {{ duty.status }}
                    </td>
                    <td class="text-danger" v-else>
                        <i class="fa-solid fa-ban"></i> {{ duty.status }}
                    </td>
                    <td>{{ duty.frequency }}</td>
                    <td>{{ duty.user_id ? duty.user.name : 'All homies' }}</td>
                    <td>{{ duty.room_id ? duty.room.name : 'All rooms' }}</td>
                    <td>
                        <button class="btn btn-outline-primary me-2" @click="editDuty(duty.id)"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-outline-danger" @click="deleteDuty(duty.id)"><i class="fa-regular fa-trash-can"></i> Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center">No duties found</td>
                </tr>
            </tbody>
        </table>
    </div>
    <BModal v-model="modal" title="Duty" :hideFooter="true">
        <form @submit.prevent="onSubmit" id="dutyForm">
            <h3>Duty Form</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="dutyForm.name">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" v-model="dutyForm.description">
            </div>
            <div class="mb-3">
                <label for="room" class="form-label">Room</label>
                <BFormSelect v-model="dutyForm.room_id" :options="defaults.rooms" id="room"/>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <BFormSelect v-model="dutyForm.status" :options="defaults.statuses" id="status"/>
            </div>
            <div class="mb-3">
                <label for="frequency" class="form-label">Frequency</label>
                <BFormSelect v-model="dutyForm.frequency" :options="defaults.frequencies" id="frequency"/>
            </div>
            <div class="mb-3">
                <label for="date_start" class="form-label">Start date</label>
                <BFormInput v-model="dutyForm.start_date" :type="'date'" id="date_start"/>
            </div>
            <div class="mb-3">
                <label for="date_end" class="form-label">End date</label>
                <BFormInput v-model="dutyForm.end_date" :type="'date'" id="date_end"/>
            </div>

            <h3>Assign homie to duty</h3>
            <span class="text-muted mb-1">Assign a homie to a duty, s/he will receive notifications if the entry concerns this duty or when duty is comming to be executed.</span>
            <div class="mb-3">
                <label for="user" class="form-label">Description</label>
                <BFormSelect v-model="dutyForm.user_id" :options="defaults.users" id="user"/>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </BModal>
</template>

<script>
import {ref} from "vue";

export default {
    mounted() {
        this.fetchDuties();
    },

    data() {
        return {
            modal: ref(false),
            dutyForm: {
                id: null,
                name: '',
                user_id: null,
                frequency: 'daily',
                status: 'active',
                isEdit: false,
                room_id: null,
                description: null,
                start_date: '',
                end_date: null
            },
            defaults: {
                users: [],
                rooms: this.$store.getters.getRooms.map(room => ({
                    value: room.id,
                    text: room.name
                })),
                statuses: [
                    { value: 'active', text: 'Active' },
                    { value: 'inactive', text: 'Inactive' },
                    { value: 'archived', text: 'Archived' }
                ],
                frequencies: [
                    { value: 'daily', text: 'Daily' },
                    { value: 'weekly', text: 'Weekly' },
                    { value: 'monthly', text: 'Monthly' },
                    { value: 'yearly', text: 'Yearly' }
                ]
            }
        };
    },

    methods: {
        fetchDuties() {
            axios.get('/api/duties')
                .then(response => {
                    this.$store.commit('setDuties', response.data.duties);
                    this.defaults.users = response.data.users;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        deleteDuty(id) {
            axios.delete(`/api/duties/${id}`)
                .then(response => {
                    this.$store.commit('setDuties', response.data.duties);
                    this.$store.dispatch('persist');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        editDuty(id) {
            //Open modal and fetch duty data
            axios.get(`/api/duties/${id}`)
                .then(response => {
                    this.dutyForm.id = response.data.duty.id;
                    this.dutyForm.name = response.data.duty.name;
                    this.dutyForm.user_id = response.data.duty.user_id;
                    this.dutyForm.frequency = response.data.duty.frequency;
                    this.dutyForm.status = response.data.duty.status;
                    this.dutyForm.room_id = response.data.duty.room_id;
                    this.dutyForm.description = response.data.duty.description;
                    this.dutyForm.start_date = response.data.duty.start_date;
                    this.dutyForm.end_date = response.data.duty.end_date;
                    this.dutyForm.isEdit = true;
                })
                .catch(error => {
                    console.error(error);
                });
            this.modal = true;
        },
        addDuty() {
            this.modal = true;
            this.dutyForm.name = '';
            this.dutyForm.user_id = null;
            this.dutyForm.frequency = 'daily';
            this.dutyForm.status = 'active';
            this.dutyForm.room_id = null;
            this.dutyForm.description = null;
            this.dutyForm.start_date = '';
            this.dutyForm.end_date = null;
            this.dutyForm.isEdit = false;
            // this.dutyForm.users = response.data.users;
            //Open modal
        },
        onSubmit() {
            //Submit form
            if (this.dutyForm.isEdit) {
                axios.put(`/api/duties/${this.dutyForm.id}`, this.dutyForm)
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setDuties', response.data.duties);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/api/duties', this.dutyForm)
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setDuties', response.data.duties);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    },
};
</script>
