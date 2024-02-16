<template>
    <li class="nav-item fon">
        <button class="nav-link btn btn-outline-danger" type="submit" form="logout-form">Logout</button>
    </li>
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
                    this.$router.push('/login');
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>
