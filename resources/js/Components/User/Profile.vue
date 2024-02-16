<template>
    <div>
        <h1>Edit profile</h1>
        <form @submit.prevent="onSubmit">
            <div>
                <label for="name">Nazwa</label>
                <input type="text" id="name" v-model="name">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" readonly v-model="email">
            </div>
            <button type="submit">Save</button>
        </form>
        //Todo: Change password feature
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: this.$store.state.user.name,
            email: this.$store.state.user.email,
        };
    },

    methods: {
        onSubmit() {
            axios.put('/users/' + this.$store.state.user.id, { name: this.name })
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
