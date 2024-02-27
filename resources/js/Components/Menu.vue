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
    console.log(props.routes);
    const sidebarClass = 'w-100';
</script>

<template>
    <div class="flex w-100 nav-justified" v-if="!props.sidebar">
        <ul class="nav">
            <MenuLink
                v-for="route in props.routes.slice(0, 3)"
                :href="route.path"
                :name="route.name"
                :active="route.path === this.$route.path ? 'active' : ''"
                :hidden="route.meta.sidebar || (route.meta.auth && !this.$store.state.isLoggedIn) || (!route.meta.auth && this.$store.state.isLoggedIn)"
            />
            <li class="nav-item" v-if="this.$store.state.isLoggedIn">
                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2 row">
                        <div class="col-6">
                            <a class="nav-link fs-5 me-2" aria-current="page" href="#"><i class="fa-regular fa-envelope"></i></a>
                        </div>
                        <div class="col-6">
                            <a class="nav-link fs-5 text-info" aria-current="page" href="/profile"><i class="fa-regular fa-user"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <Logout v-if="this.$store.state.isLoggedIn" />
        </ul>
    </div>
    <div class="flex flex-column" v-if="props.sidebar">
        <ul class="nav">
            <MenuLink
                v-for="route in props.routes"
                :href="route.path"
                :name="route.name"
                :active="route.path === this.$route.path ? 'active' : ''"
                :hidden="!route.meta.sidebar"
                :sidebar="sidebarClass"
                :icon="route.meta.icon"
            />
        </ul>
    </div>
</template>

<style scoped>

</style>
