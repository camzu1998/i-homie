<template>
    <div class="col-8 card">
        <form @submit.prevent="onSubmit" class="card-body">
            <h1 class="card-title">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" v-model="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Hasło</label>
                <input type="password" id="password" v-model="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-primary">Zaloguj</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },

    methods: {
        onSubmit() {
            axios.post('/login', { email: this.email, password: this.password })
                .then(response => {
                    const user = response.data.user;
                    this.$store.commit('setUser', user);
                    this.$store.dispatch('persist');
                    this.$router.push('/');
                })
                .catch(error => {
                    //Todo: Show error message
                    console.error(error);
                });
        },
    },
};
</script>
