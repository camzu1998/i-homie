<script setup>

import Menu from './Components/Menu.vue'
import routes from './routes';

</script>

<template>
    <Menu :routes="routes"/>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-2">
                <router-view class="view left-sidebar col-2" name="LeftSidebar"></router-view>
            </div>
            <div class="col-8">
                <router-view class="view main-content col-8"></router-view>
            </div>
            <div class="col-2">
                <router-view class="view right-sidebar col-2" name="RightSidebar"></router-view>
            </div>
        </div>
    </div>
</template>
