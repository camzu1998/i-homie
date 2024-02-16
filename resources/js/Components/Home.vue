<script setup>
    import LoginForm from "./Auth/LoginForm.vue";
</script>
<template>
    Home
    <LoginForm v-if="!this.$store.state.isLoggedIn"/>
</template>
