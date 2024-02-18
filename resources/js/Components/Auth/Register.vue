<script setup>
    import { BFormSelect } from 'bootstrap-vue-next';
</script>

<template>
    <div class="col-8 card">
        <form @submit.prevent="onSubmit" class="card-body">
            <h1 class="card-title">Register</h1>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" v-model="name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" v-model="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" v-model="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Repeat password</label>
                <input type="password" id="password_confirmation" v-model="password_confirmation" class="form-control">
            </div>
            <div class="mb-3">
                <BFormSelect v-model="createHouse" :options="houseOptions" />
            </div>
            <div class="mb-3" v-if="createHouse">
                <label for="house" class="form-label">House name</label>
                <input type="text" id="house" v-model="house" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-success">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            house: '',
            createHouse: true,
            houseOptions: [
                { value: true, text: 'Create new house' },
                { value: false, text: 'Join existing house' },
            ],
        };
    },

    methods: {
        onSubmit() {
            axios.post('/register', { name: this.name, email: this.email, password: this.password, password_confirmation: this.password_confirmation, house: this.house})
                .then(response => {
                    this.$router.push('/login');
                })
                .catch(error => {
                    //Todo: Show error message
                    console.error(error);
                });
        },
    },
};
</script>
