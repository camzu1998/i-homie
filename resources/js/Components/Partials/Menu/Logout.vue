<template>
    <li class="nav-item d-flex justify-content-center">
        <button class="nav-link btn btn-outline-danger w-25" type="submit" form="logout-form"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
    </li>
    <form @submit.prevent="onSubmit" id="logout-form"></form>
</template>

<script>
export default {
    methods: {
        onSubmit() {
            axios.post('/logout')
                .then(response => {

                    this.$store.dispatch('removeAllUserData');
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
