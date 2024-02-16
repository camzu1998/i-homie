<template>
    <button class="nav-link text-danger" type="submit" form="logout-form">Logout</button>
    <form @submit.prevent="onSubmit" id="logout-form"></form>
</template>

<script>
export default {
    methods: {
        onSubmit() {
            axios.post('/logout')
                .then(response => {

                    this.$store.commit('removeUser');
                    this.$store.dispatch('persist');
                    this.$router.push('/');
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>
