<script setup>

import routes from "../../../routes.js";
import Menu from "../../Menu.vue";
import {BFormSelect, BToast} from "bootstrap-vue-next";
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
             toast: {
                 title: 'BootstrapVue',
                 content: 'Hello, world! This is a toast message.',
                 variant: 'bg-success',
                 active: false
             }
         };
     },
     watch: {
         pickedHouse(newValue, oldValue) {
             this.$store.dispatch('persist');
             axios.put('/api/houses/' + newValue + '/set')
                 .then(response => {
                     //Toast message
                     this.toast.title = 'House changed';
                     this.toast.content = 'House changed successfully';
                     this.toast.active = true;

                     this.$store.commit('setHouses',
                         {
                             houses: response.data.houses,
                             pickedHouse: response.data.pickedHouse
                         }
                     );
                     this.$store.commit('setRooms', response.data.rooms);
                     this.$store.commit('setDuties', response.data.duties);

                 })
                 .catch(error => {
                     console.error(error);
                 });
             //Todo: Fetch new duties and rooms
             console.log(`Wartość pickedHouse zmieniła się z ${oldValue} na ${newValue}`);
         },
     }
 };
</script>

<template>
    <BToast v-model="toast.active" :title="toast.title" :toastClass="toast.variant" :class="'toast-container position-fixed top-0 end-0'">
        {{ toast.content }}
    </BToast>
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
