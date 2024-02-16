<template>
    <div class="col-8">
        <h1>Login</h1>
        <form @submit.prevent="onSubmit">
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" v-model="email">
            </div>
            <div>
                <label for="password">Hasło</label>
                <input type="password" id="password" v-model="password">
            </div>
            <button type="submit">Zaloguj</button>
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
