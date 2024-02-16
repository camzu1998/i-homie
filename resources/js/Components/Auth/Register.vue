<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="onSubmit">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" v-model="name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" v-model="email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" v-model="password">
            </div>
            <div>
                <label for="password_confirmation">Repeat password</label>
                <input type="password" id="password_confirmation" v-model="password_confirmation">
            </div>
            <button type="submit">Zaloguj</button>
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
        };
    },

    methods: {
        onSubmit() {
            axios.post('/register', { name: this.name, email: this.email, password: this.password, password_confirmation: this.password_confirmation })
                .then(response => {
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
