<script setup>
    import MenuLink from './Partials/Menu/MenuLink.vue';
    import Logout from "./Partials/Menu/Logout.vue";

    const props = defineProps({
        routes: {
            type: Array,
            required: true,
        },
        sidebar: {
            type: Boolean,
            required: false, // Adjust as needed
            default: false,
        }
    });
</script>

<template>
    <div class="flex w-100 nav-justified" v-if="!sidebar">
        <ul class="nav">
            <MenuLink
                v-for="route in props.routes"
                :href="route.path"
                :name="route.name"
                :active="route.path === this.$route.path ? 'active' : ''"
                :hidden="route.meta.sidebar || (route.meta.auth && !this.$store.state.isLoggedIn) || (!route.meta.auth && this.$store.state.isLoggedIn)"
            />
            <Logout v-if="this.$store.state.isLoggedIn" />
        </ul>
    </div>
    <div class="flex flex-column" v-if="sidebar">
        <ul class="nav">
            <MenuLink
                v-for="route in props.routes"
                :href="route.path"
                :name="route.name"
                :active="route.path === this.$route.path ? 'active' : ''"
                :hidden="!route.meta.sidebar"
            />
        </ul>
    </div>
</template>

<style scoped>

</style>
