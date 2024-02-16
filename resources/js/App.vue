<script setup>

import Menu from './Components/Menu.vue'
import routes from './routes';

</script>

<template>
    <Menu :routes="routes"/>
    <div class="container">
        <router-view></router-view>
    </div>
</template>
