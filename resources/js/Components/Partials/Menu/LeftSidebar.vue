<script setup>

import routes from "../../../routes.js";
import Menu from "../../Menu.vue";
</script>

<template>
    <div class="left-sidebar">
        <h1>Sidebar</h1>
        <Menu :routes="routes" :sidebar="true"/>
    </div>
</template>

<style scoped>

</style>
