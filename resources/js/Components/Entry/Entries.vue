<script setup>
    import { BModal, BFormSelect } from 'bootstrap-vue-next';
    import Entry from "./Entry.vue";
</script>

<template>
    <div class="d-md-flex justify-content-md-end" style="height: 75px">
        <button class="btn btn-outline-primary btn-lg" style="height: fit-content" @click="addRoom()"><i class="fa-solid fa-plus"></i> Add entry</button>
    </div>
    <div class="row flex-column">
        <Entry v-for="entry in this.$store.getters.getEntries" :title="entry.title" :description="entry.description" :user="entry.user" :room="entry.room" :date="entry.created_at" :status="entry.is_succeed"/>
    </div>
    <BModal v-model="modal" title="Entry" :hideFooter="true">
        <form @submit.prevent="onSubmit" >
            <h3>Entry Form</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Title</label>
                <input type="text" class="form-control" id="name" v-model="entryForm.title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" v-model="entryForm.description">
            </div>
            <div class="mb-3">
                <BFormSelect v-model="entryForm.status" :options="statuses"/>
            </div>
            <h3>Assign homie to an entry</h3>
            <span class="text-muted mb-1">Assign a homie to an entry, s/he will receive notification</span>
            <div class="mb-3">
                <BFormSelect v-model="entryForm.user_id" :options="entryForm.users"/>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </BModal>
</template>

<script>
import {ref} from "vue";

export default {
    mounted() {
        this.fetchEntries();
    },

    data() {
        return {
            modal: ref(false),
            entryForm: {
                id: null,
                title: '',
                user_id: null,
                users: [],
                isEdit: false,
                status: null,
            },
            statuses: [
                { value: null, text: 'Without status' },
                { value: false, text: 'Not done' },
                { value: true, text: 'Done' }
            ],
        };
    },

    methods: {
        fetchEntries() {
            axios.get('/api/entries')
                .then(response => {
                    this.$store.commit('setEntries', response.data.entries);
                })
                .catch(error => {
                    console.error(error);
                });
        },

        deleteRoom(id) {
            axios.delete(`/api/entries/${id}`)
                .then(response => {
                    this.$store.commit('setEntries', response.data.entries);
                    this.$store.dispatch('persist');
                })
                .catch(error => {
                    console.error(error);
                });
        },

        editRoom(id) {
            //Open modal and fetch entry data
            axios.get(`/api/entries/${id}`)
                .then(response => {
                    this.entryForm.id = response.data.entry.id;
                    this.entryForm.name = response.data.entry.name;
                    this.entryForm.user_id = response.data.entry.user_id;
                    this.entryForm.isEdit = true;
                })
                .catch(error => {
                    console.error(error);
                });
            this.modal = true;
        },
        addRoom() {
            this.modal = true;
            this.entryForm.name = '';
            this.entryForm.user_id = null;
            this.entryForm.isEdit = false;
            // this.entryForm.users = response.data.users;
            //Open modal
        },
        onSubmit() {
            //Submit form
            if (this.entryForm.isEdit) {
                axios.put(`/api/entries/${this.entryForm.id}`, { title: this.entryForm.title, description: this.entryForm.description, user_id: this.entryForm.user_id, is_succeed: this.entryForm.status })
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setEntries', response.data.entries);
                        this.$store.dispatch('persist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/api/entries', { title: this.entryForm.title, description: this.entryForm.description, user_id: this.entryForm.user_id, is_succeed: this.entryForm.status })
                    .then(response => {
                        this.modal = false;
                        this.$store.commit('setEntries', response.data.entries);
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
