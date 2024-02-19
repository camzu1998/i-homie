<script setup>

import routes from "../../../routes.js";
import Menu from "../../Menu.vue";
import {BFormSelect} from "bootstrap-vue-next";
</script>

<script>
 export default {
     computed: {
         houseOptions() {
             return this.$store.state.house.houses.map(house => ({
                 value: house.id,
                 text: house.name
             }));
         }
     },
     data() {
         return {
             pickedHouse: this.$store.state.house.pickedHouse,
         };
     },
     watch: {
         pickedHouse(newValue, oldValue) {
             // Kod do wykonania, gdy wartość createHouse się zmieni
             this.$store.commit('setHouses',
                 {
                     houses: this.$store.state.house.houses,
                     pickedHouse: newValue
                 }
             );
             this.$store.dispatch('persist');
             //Todo: Add a toast
             //Todo: put the new pickedHouse in database
             //Todo: Fetch new dutys
             console.log(`Wartość pickedHouse zmieniła się z ${oldValue} na ${newValue}`);
         },
     }
 };
</script>

<template>
    <div class="left-sidebar">
        <div class="mb-3">
            <div class="form-floating">
                <BFormSelect v-model="pickedHouse" :options="houseOptions" id="houseSelect"/>
                <label for="houseSelect">Pick a house</label>
            </div>
        </div>
        <h1>Sidebar</h1>
        <Menu :routes="routes" :sidebar="true"/>
    </div>
</template>
